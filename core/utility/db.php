<?php

class db{
	
	public function __construct(){
		
	}
	
	
	public function createDatabase($name){
		if(is_object($name)){
			$name = get_class($name);
		}
		
		$dbname = COMPANYDBPREFIX."c_".$name;
		$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
		$this->executeSQL($sql);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 *	Assigns a user to an existing Database
	 *
	 * @param string $name The name of the table to create
	 */	
	public function assignDefaultUserToCompanyDB($name){
		$dbname = COMPANYDBPREFIX."c_".$name;
		$dbuser = DBUSER;
		$dbhost = DBHOST;
		$sql = "GRANT ALL PRIVILEGES ON $dbname.* To $dbuser@$dbhost";
	}
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 *	Creates a standard table for our structure with id = INT NOT NULL AUTO_INC and PRIMARY KEYS
	 *
	 * @param string $name The name of the table to create
	 */	
	public function createTable($name){
		timer('createTable');
		$sql = "CREATE TABLE IF NOT EXISTS $name (
				id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id)
				)";
		
		$this->executeSQL($sql);
		timer('createTable',FALSE);
	}
//++++++++++++++++++++++++++++++++++++++++++
	/**
	 * @param string $sql Used for SELECTS, UPDATES
	 * 
	 * @throws error returned from DB
	 */
	public function executeSql($sql){
		timer('executeSql');
		
		$sql_word = explode(" ",$sql,10);
		
		//if the statement is insert attempt to ensure all fields of this exists first
		//Only attempt to create colums if we are in dev mode
		// TODO: What do we do here when we are updating? How will old tables create new cols?
		 
		if(DEVELOPMENT){
			
			$class_name = get_called_class();
			
			foreach(get_object_vars($this) as $property=>$value){
				//determine type and set $settype to proper string for proper create col.	
				$type = gettype($value);
				
				//data to ignore, do not create the cols!
				if ( in_array($property, baseEntity::getDBIgnoreList())){ continue;	}
				elseif ($type == "boolean"){ $set_type = 'BOOL'; }
				elseif(substr($property,-4)=='Date'){ $set_type = "TIMESTAMP"; }
				elseif(substr($property,-5)=='Image'){ $set_type = "TEXT"; }
				elseif(is_numeric($value)){
					if($property == "ccNumber"){$set_type = 'TEXT';}
					elseif(is_float($value)){$set_type = "FLOAT" ;}
					elseif(is_int($value)){$set_type = "INT(20)";}
					else{$set_type = "INT(10)";}
				}
				elseif(!isset($set_type) && $type == "string"){$set_type = 'TEXT';}
				elseif(!isset($set_type) && $type == "NULL"){$set_type = 'TEXT';}
				elseif(!isset($set_type) && ($type == "object") || ($type == "array")){$set_type = 'BLOB';}
				else{trigger_error('SET_TYPE could not be determined for:'. $property.'Type: '.$type."  value: ".$value);}
				
				if(!isset($set_type)){
					trigger_error('SET_TYPE could not be determined for:'. $property.'Type: '.$type."  value: ".$value);
				}
				
				$sql_alter = "
					ALTER TABLE `$class_name` ADD `$property` $set_type NULL ;
				";
				
				//Create columns that don't exist
				$stmt = $this->connx->prepare($sql_alter);
				try{$stmt->execute();}
				catch(Exception $e){
					//trigger_error($type ." ".$property .' '.$set_type." ".$class_name);
				}
				unset($set_type);
				unset($value);
				unset($type);
			}
		}
		unset($e);
				
		// Prepare statement
    	$stmt = $this->connx->prepare($sql);
		try{$stmt->execute();}
		catch(Exception $e){
			trigger_error($e->getMessage());
			trigger_error($sql);
			print_r($this);	
			//echo get_called_class();
			return FALSE;
		}
		timer('executeSql',FALSE);
		//If the statement is insert
		if($sql_word[0] == 'INSERT'){
			return intval($this->connx->lastInsertId());
		}
		if($sql_word[0] == 'SELECT'){
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt;
		}	
	}
//+++++++++++++++++++++++++++++++++++++++++++
	private function createColumn($col_name,$set_type){
		timer('createColumn');
		$class_name = get_called_class();
		$sql = "
  				ALTER TABLE `$class_name` ADD `$col_name` $set_type NULL ;
				";
				
		$this->executeSql($sql);
		timer('createColumn',FALSE);
	}
//+++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Sets a connection object
	 */
	public function SetConnection(PDO $connx){
		if(is_a($connx,"PDO")){	$this->connx = $connx;}
	}
//++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Return the default connection the same as config would do
	 * @return PDO object
	 */
	public static function getConnection($dbhost,$dbuser,$dbpass,$dbname){
			
		static $connx;
		static $co_connx;
		static $company_dbname;
		timer('getConnection');
			
		//connect to the core database
		if($dbname == COREDBNAME 
			&& isset($connx)){
			timer('getConnection',FALSE);	
			return $connx;	
		}
		if($dbname == COREDBNAME 
			&& !isset($connx)){
			//connect to a database
			try {
				timer('setNewConnx');
			    $connx = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass, array(PDO::ATTR_PERSISTENT => true));
			    $connx->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			    $connx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				timer('setNewConnx',FALSE);
			}
			catch(PDOException $e){echo "Connection failed: " . $e->getMessage();}
			timer('getConnection',FALSE);
			return $connx; 
		}
		
		//if the company dbname is notset, lets create a new connection and store as static
		//if the company dbname is set and same as the one being passed, let's pass the static company connection
		//if the company dbnam is different, lets drop the current company connection and create a new one

		if($dbname != COREDBNAME){
			//echo "attempted connection to: ". $dbname . "<br>";
			//if the company dbname is notset, lets create a new connection and store as static		
			if(!isset($co_connx))
			{
				//create new connect and store name and connection as static
				$company_dbname = $dbname;
				try {
					timer('newCoConnx1');
				    $co_connx = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass, array(PDO::ATTR_PERSISTENT => true));
					$connx->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				    $co_connx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					timer('newCoConnx1',FALSE);
				}
				catch(PDOException $e){echo "Connection failed: " . $e->getMessage();}
				timer('getConnection',FALSE);
				return $co_connx; //create new connect and store name and connection as static
			}
			//if the company dbname is set and same as the one being passed, let's pass the static company connection
			if(isset($co_connx) && ($dbname == $company_dbname)){
				//return current connection
				timer('getConnection',FALSE);
				return $co_connx;
			}
			//if the company dbnam is different, lets drop the current company connection and create a new one
			if(isset($co_connx) && ($dbname != $company_dbname)){
				//destroy the current connection	
				$co_connx = NULL;
				//create new connect and store name and connection as static
				$company_dbname = $dbname;
				try {
					timer('newCoConnx2');
					
				    $co_connx = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass, array(PDO::ATTR_PERSISTENT => true));
					$connx->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				    $co_connx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					timer('newCoConnx2');
				}
				
				catch(PDOException $e){echo "Connection failed: " . $e->getMessage();}
				timer('getConnection',FALSE);
				return $co_connx; //create new connect and store name and connection as static	
			}
		}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Used for session management, returns an array of all properties to keep in the session,
	 * It removes the DB Connection and additional entities
	 * 
	 * @return array Associative array of properties of this
	 */
	public function __sleep(){
		$vars = get_class_vars(get_called_class());
		
		$return = array();
		foreach($vars as $k=>$v)
		{
			//These properties do not need to be serialized
			if($k == 'connx' || $k == 'entities'){
				continue;	
			}
			else{array_push($return,$k);}
		}
		$return = array_values($return);
		return $return;
	}
}

function get_calling_class() {
	
	timer('get_calling_class');
    //get the trace
    $trace = debug_backtrace();

    // Get the class that is asking for who awoke it
    $class = $trace[1]['class'];

    // +1 to i cos we have to account for calling this function
    for ( $i=1; $i<count( $trace ); $i++ ) {
        if ( isset( $trace[$i] ) ) // is it set?
             if ( $class != $trace[$i]['class'] ) // is it a different class
             {
             	timer('get_calling_class',FALSE);
             	return $trace[$i]['class'];
             }    
    }
}
?>