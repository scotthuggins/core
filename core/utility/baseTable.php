<?php

/*
 
 CREATE A NEW TABLE
 $users = new users($connx,"user");

 SET MAX PAGES FOR THE SELECTED STATEMENT	
 $users->SetPageMax(5);

 MOVE A PAGE UP IN THE TABLE
 $users->SetPageUp();
 
 MOVE A PAGE DOWN IN THE TABLE
 $users->SetPageDown();
 
 SET A NEW STATEMENT FOR THE TABLE
 $users->SetSTMTSql(" SELECT * FROM $users->entity ");

 OPEN THE ENTITIES AFTER STATEMENT IS SELECTED
 $users->OpenEntities();
 $users->SetSTMTSql(" SELECT * FROM $users->entity WHERE name_first = 'Name first' ");
 $users->OpenEntities();
 * 
 * NOTE: When selecting specific collumns, you must include the id col
*/


class baseTable extends db{
	
	
	public $entities;
	public $entity; 
	public $connx;	
	public $page_max = 24;
	public $page_count;
	public $page_current = 1;
	public $stmt_limit;
	public $stmt_sql;
	
	//public $calendar_time;
	//public $calendar_view_start;
	//public $calendar_view_end;
	//public $calendar_entities;
	public $calendar_stmt_sql;
	
	public $config;
		
	public function __construct(){
		
		//define some default things about a table
		$this->entities = array();
		$this->calendar_entities = array();
		$this->entity = inflector::singularize(get_called_class());
		
		
		//$this->page_max = 20;
		//$this->page_current = 1;
		$this->stmt_sql = "SELECT * FROM " . $this->entity ;
		$this->SetSTMTLimit();
		
		//open singular version and copy some configs;
		$entity_name = $this->entity;
		$single = new $entity_name();
		$this->config = $single->config;
		unset($single);
		
		//Set up our connection
		$connx = db::getConnection(DBHOST,DBUSER,DBPASSWORD,baseEntity::getOrigin($this->entity));
		$this->SetConnection($connx);
		$this->connx = $connx;
		
		$this->createTable($this->entity);
	}

	/**
	 * Opens and sets Entities on object from the Set SQL statement
	 */
	
	public function OpenEntities($noLimit = FALSE){
			
		$this->CloseEntities();
		
		// Recaluclate pages from our statement
		$this->CountPages($this->buildSTMT(true));
		//echo $this->buildSTMT($noLimit);
		//print_r($this);
		$stmt = $this->executeSql($this->buildSTMT($noLimit));
	
		if ($stmt->rowcount() > 0){
	    	foreach($stmt->fetchAll() as $v) {
		    	$class_name = $this->entity;
		    	$entity = new $class_name();
				$entity->OpenFromSTMT($v);
				
				array_push($this->entities,$entity);
		    }
		}		
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Opens and sets Calendar Entities on object from the Set SQL statement
	 */
	
	public function OpenCalendarEntities($noLimit = FALSE){
			
		$this->CloseCalendarEntities();
		
		$stmt = $this->executeSql($this->buildCalendarSTMT($noLimit));
		//print_r($stmt);
		if ($stmt->rowcount() > 0){
	    	foreach($stmt->fetchAll() as $v) {
		    	$class_name = $this->entity;
		    	$entity = new $class_name();
				$entity->OpenFromSTMT($v);
				
				array_push($this->calendar_entities,$entity);
		    }
		}
			
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	private function buildCalendarSTMT($noLimit = false){
		
		//modifier is blank by default
		$modifier = '';
			
		//only modify the sql if logged in user is the only one to see it.
		if(isset($this->config['onlySeeTheirs']) && $this->config['onlySeeTheirs']){
				
			//only modify the sql if we are logged in	
			if (baseEntity::isSessionLoggedIn('user')){
				$user_id = baseEntity::getLoggedInId('user');
			} else {
				$user_id = 'NULL';
			}
			//Set proper SQL if we already have a WHERE condition
			if( !strpos($this->calendar_stmt_sql,'WHERE')){
				$modifier =  " AND user_id = '" . $user_id . "'";
			} 
			else {
				$modifier = " AND user_id = '" . $user_id . "'";
			}
		}
		//echo $this->calendar_stmt_sql . $modifier;
		return	$this->calendar_stmt_sql . $modifier;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Unsets the Calendar entites on the objects
	 * 
	 */	
	
	public function CloseCalendarEntities(){
		unset($this->calendar_entities);
		$this->calendar_entities = array();
	}		
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	private function buildSTMT($noLimit = false){
		
		//modifier is blank by default
		$modifier = '';
			
		//only modify the sql if logged in user is the only one to see it.
		if(isset($this->config['onlySeeTheirs']) && $this->config['onlySeeTheirs']){
				
			//only modify the sql if we are logged in	
			if (baseEntity::isSessionLoggedIn('user')){
				$user_id = baseEntity::getLoggedInId('user');
			} else {
				$user_id = 'NULL';
			}
			//Set proper SQL if we already have a WHERE condition
			if( !strpos($this->stmt_sql,'WHERE')){
					$modifier =  " WHERE user_id = '" . $user_id . "'";
			} 
			else {
				$modifier = " AND user_id = '" . $user_id . "'";
			}
		}

		//build the SQL statment and return.
		//Having a limit is the default 
		if ($noLimit == false){
			$stmt = $this->stmt_sql . $modifier . $this->stmt_limit;
		} else {
			$stmt = $this->stmt_sql . $modifier;
		}
		return $stmt;
		
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Unsets the entites on the objects
	 * 
	 */	
	public function CloseEntities(){
		unset($this->entities);
		$this->entities = array();
	}

	
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Sets the max number of Entities for pagination
	 * 
	 * @param int $pages The number of pages to allow
	 */
	public function SetPageMax($pages){
		if (is_int($pages)){
			$this->page_max = $pages;
			$this->SetSTMTLimit();
		}
		else{trigger_error("Value passed was not an INT");}	
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Moves up a page in the pagination selection
	 * 
	 */
	public function SetPageUp(){
		$this->page_current++;
		$this->SetSTMTLimit();
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Move down a page in the pagination selection
	 * 
	 */	
	public function SetPageDown(){
		$this->page_current--;
		$this->SetSTMTLimit();
	}

//+++++++++++++++++++++++++++++++++++++++++  
 	/* Move down a page in the pagination selection
	 * 
	 */	
	public function SetPage($page){
		
		$this->page_current = $page;
		$this->SetSTMTLimit();
	}	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Recalculates the Limit used in queries
	 * 
	 */
	
	private function SetSTMTLimit(){
		$offset = $this->page_max * $this->page_current - $this->page_max;
		$this->stmt_limit = ' LIMIT ' .$offset. ' , ' .$this->page_max;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Sets a SQL statement on the table oject
	 * 
	 * @param string $sql The sql statment to set on the table object, $this->OpenEntities() will execute the currently set statement.
	 */
	public function SetSTMTSql($sql){
		unset($this->stmt_sql);
		$this->stmt_sql = $sql;
		$this->CountPages();
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Set a Calendar Statement on the table object
	 * @param date property The property to look for
	 * @param date calendar_view_start The beginning of the time frame to search in
	 * @param date calendar_view_end The end of the time frame to search in
	 */
	 public function setCalendarSTMTSql($property_name,$calendar_view_start,$calendar_view_end){
//set calendar sql statement after config has been loaded
		
		$this->calendar_stmt_sql = "SELECT * FROM ". $this->entity ." 
		WHERE CAST(".$property_name." as DATE) BETWEEN '". $calendar_view_start."' AND '". $calendar_view_end . "'
		";
		
		//SQL Options when entities might be starting before the range and ending after
//		$this->calendar_stmt_sql = "SELECT * FROM ". $this->entity ." 
//		WHERE CAST(".$property_name." as DATE) BETWEEN '". $calendar_view_start."' AND '". $calendar_view_end . "'
//		
//		OR (CAST(".$property_name." as DATE) <= '". $calendar_view_start."' 
//			AND CAST(".$property_name." as DATE) >= '". $calendar_view_end . "'
//		)
		
//		";
	}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Sets a SQL statement on the table oject
	 * 
	 * @param string $sql The sql statment to set on the table object, $this->OpenEntities() will execute the currently set statement.
	 */
	public function SetSTMTSqlNoLimit($sql){
		unset($this->stmt_sql);
		$this->stmt_sql = $sql;
		$this->CountPages();
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	private function CountPages($sql = null){
		//total page count calculated from no limit query.
		if(!isset($sql)){$sql = $this->stmt_sql;}
		
		$stmt = $this->executeSql($sql);
		if ($stmt->rowcount() > 0){
	    	$this->page_count = ceil($stmt->rowcount()/$this->page_max);
		}
		if($this->page_count <= 1){$this->page_count = 1;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Sets a PDO connection object of the table
	 * 
	 * @param PDO Object $connx The connection object to set
	 * 
	 */
	public function SetConnection(PDO $connx){
		if(is_a($connx,"PDO")){	$this->connx = $connx;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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
			if ($k == 'connx' || $k == 'entities'){
				continue;	
			} else {
				array_push($return,$k);
			}
		}
		
		
		return array_values($return);
		
		
	}
}
?>