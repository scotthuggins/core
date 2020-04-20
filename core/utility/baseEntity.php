<?php
class baseEntity extends db{

	public $id; //Unique Number that is used in the Primary Key Of Project table
	public $user_id; //used as the id of the user that created the entity
	public $name;
	public $belongs_to; //array of entities this one belongs to 
	public $belongs_to_many; //boolean value allowing this
	public $has; //array of entites that belong to this one
	public $has_many; //boolean value allowing this one to have many children
	public $is_deleted;
	public $class_name;
	public $isLoggedIn;
	public $getFormIgnoreList;
	public $getDBIgnoreList;
	public $config; //
	
	//Sets parent/child relationships to other entities
	//$config['associations] = array(
	//							'user'=>'belongsTo',
	//							'company'=>'belongsTo')
	//
	//$config['primaryIDProperty'] = property name that should be used as an alternative to internal id, such as "store_number"
	//							This property will be used to select the entity while performing actions like delete
	//
	//$config['login'] = BOOL should this entity get a login form?
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * contrust a baseEntity and make a connection if logged into a company
	 * 
	 */
	public function __construct(){
			
		global $map;
			
		timer('__construct');
		$this->id = NULL;
		$this->user_id = NULL;
		$this->name = "";
		$this->belongs_to = array();
		$this->belongs_to_many = TRUE;
		$this->has = array();
		$this->has_many = TRUE;
		$this->is_open = FALSE;
		$this->is_deleted = FALSE;
		$class_name = get_called_class();
		$this->class_name = $class_name;
		
		//echo $class_name;
		
		
		//Set up a connection for the entity
		$set_connection = false;
		//if we are not a core class, we avoid placing a connection unless logged into a company
		if ((in_array($class_name, $map->company_dir) && company::isSessionLoggedIn())
			|| in_array($class_name, $map->core_dir)
		){
			$set_connection = true;		
		}
		
		
		
		//Set a connection if we are logged in...
		if ($set_connection){
			//Set up our connection
			$connx = db::getConnection(DBHOST,DBUSER,DBPASSWORD,baseEntity::getOrigin(get_called_class()));
			$this->SetConnection($connx);
			$this->connx = $connx;
		
			if(DEVELOPMENT){
				// TODO: create tables from structures in a cron job or other solution needed when we create a new company.
				$this->CreateTable($class_name);
			}
		}
		timer('__construct',FALSE);
	}
//+++++++++++++++++++++++++++++++++++	
	public function login($password=''){
		timer('login');
		$this->isLoggedIn = TRUE;
		//Set in the session so we can
		session::write('is'.get_called_class().'LoggedIn',1);
		session::write(get_called_class().'Name',$this->name);
		session::write(get_called_class().'Id',$this->id);
		timer('login',FALSE);
	}
	/**
	 * Logs out a company profile
	 */
	public function logout(){
		timer('logout');
		$this->isLoggedIn = FALSE;
		session::write('is'.get_called_class().'LoggedIn',0);
		session::write(get_called_class().'Name','');
		session::write(get_called_class().'Id','');
		timer('logout',FALSE);
	}
	/**
	 * @return Bool Returns true if a company is logged in
	 */
	public function isLoggedIn(){
		return $this->isLoggedIn;
	}
	
	static public function getLoggedInName($class = null){
			
		//get the called class by default
		if(!isset($class)){
			$class = get_called_class();
		}
		
		$entityName = session::read($class.'Name');
		
		if (!empty($entityName)) {
			return $entityName;
		} else {
			return false;
		}
	}
	
	static public function getLoggedInId($class = null){
		//get the called class by default
		if(!isset($class)){
			$class = get_called_class();
		}
		$entityID = session::read($class.'Id');
		if(!empty($entityID)){return $entityID;}
		else{return false;}
	}
	
	static public function isSessionLoggedIn($class = null){
			
		//get the called class by default
		if(!isset($class)){
			$class = get_called_class();
		}
		
		$entityIn = session::read('is' . $class . 'LoggedIn');
		if(!empty($entityIn)){return $entityIn;}
		else{return FALSE;}
	}		
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Opens an entity object, Sets $this->is_open to true
	 * 
	 * @param int $id id of entity to open
	 * @param bool $allow_deleted OPTIONAL, defaults to FALSE. Set to true to open entities that have been marked as deleted
	 */
	public function Open($id,$allow_deleted=FALSE){
		timer('open');	
			
		//$this->Close();			
		
		$class_name = get_called_class();
		
		//echo "called class in OPEN:" .$class_name;
		if($allow_deleted){
			//future use
		} else {
			$sql = "SELECT * FROM $class_name WHERE id = '$id'";
		}	
				
		//Normal use
		$stmt = $this->executeSql($sql);	
		
		if ($stmt->rowCount() > 0){
			
	    	foreach($stmt->fetch() as $key=>$value) {
	    		//echo $key." = ". $value ."<br>";
				$serialized = @unserialize($value);
				////if the value is serialized...
				if($serialized !== FALSE ){
					$this->$key = unserialize($value); //attempt to unserialize all data, ignoring errors with "@"	
				}
				//if the value is unset, but the key is an array, we must keep it an array
				else if (is_array($this->$key) && (empty($this->$key) || !isset($value) || $value = NULL)){
					$this->$key = array();
				}
				else{$this->$key = $value;}					
	    	}
	    	$this->is_open = TRUE;
		}
		
		$this->OpenPostCall();	
		
		
		timer('open',FALSE);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/** Opens an Entity from STMT fetchAll array
	 * 
	 * @param array $stmt_array expects an array from fetchAll() from an entity table
	 * 
	 */
	public function OpenFromSTMT($stmt_array){
		timer('OpenFromSTMT');
		foreach($stmt_array as $key=>$value) {
	    		//echo $key." = ". $value ."<br>";
				$serialized = @unserialize($value);
				////if the value is serialized...
				if($serialized !== FALSE ){
					$this->$key = unserialize($value); //attempt to unserialize all data, ignoring errors with "@"	
				}
				//if the value is unset, but the key is an array, we must keep it an array
				else if (is_array($this->$key) && (empty($this->$key) || !isset($value) || $value = NULL)){
					$this->$key = array();
				}
				else{$this->$key = $value;}					
	    }
	    $this->is_open = TRUE;
		$this->OpenPostCall();	
		timer('OpenFromSTMT',FALSE);
	}




//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Opens an Entity by its unique name
	 * 
	 * @param string $name the name of the entity to open
	 * 
	 */
	
	public function OpenByName($name){
		//$this->Close();			
		timer('OpenByName');
		$class_name = get_called_class();
		$sql = "SELECT * FROM $class_name WHERE name = '$name'";	
		
		$stmt = $this->executeSql($sql);	
	    if($stmt->rowCount() > 0){
			foreach($stmt->fetch() as $key=>$value) {
	    		//echo $key." = ". $value ."<br>";
				$serialized = @unserialize($value);
				////if the value is serialized...
				if($serialized !== FALSE ){
					$this->$key = unserialize($value); //attempt to unserialize all data, ignoring errors with "@"	
				}
				//if the value is unset, but the key is an array, we must keep it an array
				else if (is_array($this->$key) && (empty($this->$key) || !isset($value) || $value = NULL)){
					$this->$key = array();
				}
				else{$this->$key = $value;}					
	    	}
	    	$this->is_open = TRUE;
		}
		$this->OpenPostCall();
		timer('OpenByName',FALSE);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	private function OpenPostCall(){
		//added 8.15.18 to ensure the JSON objects could have this property, seems like the construct function doesn't set the value
		$this->class_name = get_called_class();
		//added 10.30.18 to ensure the JSON object could have these two properties
		$this->getFormIgnoreList = $this->getFormIgnoreList();
		$this->getDBIgnoreList = $this->getDBIgnoreList();
	}	
	
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/*
	 * Closes an entity, unsets all attributes except for the DB connection
	 */ 
	
	public function Close(){
		$prop = get_object_vars($this);
				
		foreach($prop as $k=>$v){
			if($k=="assocations" || $k=="is_open"||$k=="connx"){continue;}
			unset($this->$k);
		}
		$this->id = NULL;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/*
	 * Sets the is_deleted property to TRUE
	 * All properties will remain set, the object will not be deleted for databases
	 * 
	 */
	
	public function Delete(){
		
		//OLD WAY USED TO DELETE THE ACTUAL RECORDS, now we just mark as deleted	
		$class_name = get_called_class();
		$sql = "DELETE from $class_name WHERE id = $this->id";
		$this->executeSql($sql);
			
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Saves the entity to the DB, a new ID will be assigned if it does not exist yet 
	 */
	
	
	public function Save(){
	//Saves all data to the datebase
		timer('Save');
		$class_name = get_called_class();
		
		
		//if not null then update existing record by id
		if(isset($this->id) && is_numeric($this->id)){
			$cnt=0;	
			$properties = get_object_vars($this);
			
			foreach($properties as $k=>$v){
				if( $k=="assocations" || $k=="is_open"||$k=="connx"||$k=="dbuser"||$k=="dbhost"||$k=="dbname"||$k=="dbpass"){continue;}	
				if(in_array($k,baseEntity::getDBIgnoreList())){continue;}
				
				
				
				
				if(is_array($v)){$v = serialize($v);}//serialize arrays
				$cnt++;
				if ($cnt == 1){
					if ($v == NULL){$data = $k. "=NULL" ;}
					else{$data = $k. "='" .$v."'" ;}
				}
				else{
					if ($v == NULL){$data = $data. "," .$k. "=NULL" ; }	
					else {$data = $data. "," .$k. "='" .$v."'" ; }				
				}
			}
			
			$sql = "UPDATE $class_name SET $data WHERE id = $this->id";
			//echo $sql;
			$this->executeSql($sql);
		}
		//Otherwise create a new record
		else{
			
			// Get the user id from the session if it exists
			// Only get the session user_id when we are first recording
			// an entity to the db, if not session loged in, user_id
			// should remain NULL from __construct()
			if( baseEntity::isSessionLoggedIn('user')){
				$this->user_id = baseEntity::getLoggedInId('user');
			}
			
			$properties = get_object_vars($this);
			$cnt = 0;
			
			//build list that will insert
			foreach($properties as $k=>$v){
				if($k=="is_open" || $k == "connx"){continue;}
				if(in_array($k,baseEntity::getDBIgnoreList())){continue;}
				if(is_array($v)){$v = serialize($v);} //serialize arrays
				if ($cnt == 0){
					//added 1.6.19 to allow default numeric values to the db immediately
					if(is_numeric($v)){
						$_collist = $k;
						$_fieldlist = "'".$v."'";
					}		
						
					elseif ($v == NULL){
						$_collist = $k;
						$_fieldlist = "NULL";
					}
					else{
						$_collist = $k;
						$_fieldlist = "'".$v."'";
					}
				}
				else{
					//added 1.6.19 to allow default numeric values to the db immediately
					if(is_numeric($v)){
						$_collist = $_collist .",". $k;
						$_fieldlist = $_fieldlist .",'". $v."'";	
					}	
						
					elseif($v == NULL){
						$_collist = $_collist .",". $k;
						$_fieldlist = $_fieldlist .",NULL";
					}
					else{
						$_collist = $_collist .",". $k;
						$_fieldlist = $_fieldlist .",'". $v."'";	
					}
				}
				$cnt++;
			}		
			$sql = "INSERT INTO $class_name ($_collist) VALUES ($_fieldlist)";
	    	$this->id =	$this->executeSql($sql);
	    	//it must be open
			$this->is_open = TRUE;
			
			
		}
		timer('Save',FALSE);
		return $this->id;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 *  Allows an entity to belong to more than a 1:1 relationship to Parents
	 * @param $boolean
	 */
	public function setBelongsToMany($bool){
		if(is_bool($bool)){
			$this->belongs_to_many = $bool;
		}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Allows an Entity to have more than 1:1 relationship to Children
	 * @param $boolean
	 */
	public function setHasMany($bool){
		if(is_bool($bool)){
			$this->has_many = $bool;
		}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Adds a Parent Entity, If BelongsToMany is TRUE, many are allowed, otherwise the current parent is overwritten
	 *
	 * @param string $parent_id The ID of the parent to associate
	 * @param string $entity the singular type of the entity to associate EX: 'user'
	 * 
	 */	
	public function setBelongsTo($parent_id,$entity){
		timer('setBelongsTo');	
			
		if(!isset($parent_id)||!isset($entity)){
			trigger_error('The parent id or entity was not set.');
			return;
		}	
			
		//An entity cannot belong to itself
		if($this->id == $parent_id && get_called_class() == $entity){
			trigger_error('An entity cannot belong to itself');
			return;
		}
		//Save the object if we have no id to ensure no errors occure below
		if($this->id == "" || !isset($this->id) || empty($this->id)){$this->save(); }
		
		$parent_class = $entity;
		$parent = New $parent_class();
		$parent->open($parent_id);
		//If the child does not already belong... to prevent recursion
		
		if(!$parent->has($this->id,get_called_class(),$this->getOrigin(get_called_class()))){
				
			$child = array();
			$child['child_id'] = $this->id;
			$child['entity'] = get_called_class();
			$child['dbname'] = $this->getOrigin(get_called_class());
			
			//if we allow this entity to belong to many
			if($parent->has_many){
				//just push it
				array_push($parent->has,$child);
			}
			//otherwise if we have 1 or fewer
			else{
				//detroy and push parent
				unset($parent->has);
				$parent->has = array();
				array_push($parent->has,$child);
			}
			//make the multi-dim array unique
			$parent->has = array_map("unserialize", array_unique(array_map("serialize", $parent->has)));
			$parent->save();
		}
		unset($parent);
				//Create the sub array to push below
		$parent = array();
		$parent['parent_id'] = $parent_id;
		$parent['entity'] = $entity;
		$parent['dbname'] = $this->getOrigin($entity);
		
		//if we allow this entity to belong to many
		if($this->belongs_to_many){
			//just push it	
			array_push($this->belongs_to,$parent);
		}
		//otherwise if we have 1 or fewer
		else{
			//detroy and push parent
			unset($this->belongs_to);
			$this->belongs_to = array();
			array_push($this->belongs_to,$parent);
		}
		//make the multi-dim array unique
		$this->belongs_to = array_map("unserialize", array_unique(array_map("serialize", $this->belongs_to)));
		$this->save();
		
		//Check if this association has a middle node and create connections
		if($this->hasNode(get_called_class(),$entity)){
			$entityNodeName = $this->createNodeName(get_called_class(),$entity);
			// TODO: Does the entity get the correct connection here?
			$entityNode = new $entityNodeName();
			//attempt to open if there is an existing node
			$entityNode->openByCompositeId($parent_id,$entity,$this->id,get_called_class());
			//If the entity node not set to open from above line, then assign the connecting ids and save it
			if(!$entityNode->is_open){
				$entityNode->{$entity.'_id'} = $parent_id;
				$entityNode->{get_called_class().'_id'} = $this->id;
				$entityNode->save();
			}
		}
		timer('setBelongsTo',FALSE);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Adds a Child Entity, If has_many is TRUE, many are allowed, otherwise the current child is overwritten
	 *
	 * @param string $child_id The ID of the child to associate
	 * @param string $entity the singular type of the entity to associate EX: 'user'
	 * 
	 */	
	public function setHas($child_id,$entity){
		
		
		timer('setHas');
		if(!isset($child_id)||!isset($entity)){
			trigger_error('The child id or entity was not set.');
			return;
		}	
			
		//An entity cannot belong to itself
		if($this->id == $child_id && get_called_class() == $entity){
			trigger_error('An entity cannot be a child to itself.');
			return;
		}
		
		//Save the object if we have no id to ensure no errors occure below
		if($this->id == "" || !isset($this->id) || empty($this->id)){$this->save(); }
		
		$child_class = $entity;
		$child = New $child_class();
		$child->open($child_id);
		//If the child does not already belong... to prevent recursion
		if(!$child->belongsTo($this->id,get_called_class(),$this->getOrigin(get_called_class()))){
			//Create the sub array to push below
			$parent = array();
			$parent['parent_id'] = $this->id;
			$parent['entity'] = get_called_class();
			$parent['dbname'] = $this->getOrigin(get_called_class());
			
			//if we allow this entity to belong to many
			if($child->belongs_to_many){
				//just push it	
				array_push($child->belongs_to,$parent);
			}
			//otherwise if we have 1 or fewer
			else{
				//detroy and push parent
				unset($child->belongs_to);
				$child->belongs_to = array();
				array_push($child->belongs_to,$parent);
			}
			//make the multi-dim array unique
			$child->belongs_to = array_map("unserialize", array_unique(array_map("serialize", $child->belongs_to)));
			$child->save();
			
		}
		unset($child);
		//Create the sub array to push below
		$child = array();
		$child['child_id'] = $child_id;
		$child['entity'] = $entity;
		$child['dbname'] = $this->getOrigin($entity);
		
		//if we allow this entity to belong to many
		if($this->has_many){
			//just push it
			array_push($this->has,$child);
		}
		//otherwise if we have 1 or fewer
		else{
			//detroy and push parent
			unset($this->has);
			$this->has = array();
			array_push($this->has,$child);
		}
		$this->has = array_map("unserialize", array_unique(array_map("serialize", $this->has)));
		
		$this->save();
		
		//Check if this association has a middle node and create connections
		if($this->hasNode(get_called_class(),$entity)){
			$entityNodeName = $this->createNodeName(get_called_class(),$entity);
			$entityNode = new $entityNodeName($this->connx);
			//attempt to open if there is an existing node
			$entityNode->openByCompositeId($this->id,get_called_class(),$child_id,$entity);
			//If the entity node not set to open from above line, then assign the connecting ids and save it
			if(!$entityNode->is_open){
				$entityNode->{$entity.'_id'} = $child_id;
				$entityNode->{get_called_class().'_id'} = $this->id;
				$entityNode->save();
			}
		}
		timer('setHas');
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Removes a Parent entity from this
	 * 
	 * @param int $parent_id The parent id
	 * @param string $entity The singular entity to remove, EX: 'user'
	 */
	public function removeBelongsTo($parent_id,$entity){
		
		timer('removeBelongsTo');
		//let the parent know this is no longer a child
		$parent = New $entity();
		$parent->open($parent_id);
		
		foreach($parent->has as $k=>$v){
			if($v['child_id'] == $this->id 
			&& $v['entity'] == get_called_class()
			&& $v['dbname'] == $this->getOrigin(get_called_class())){
				//remove the array
				unset($parent->has[$k]);
			}
		}
		$parent->has = array_values($parent->has);
		$parent->save();
		//remove the parent from this entity	
		foreach($this->belongs_to as $k=>$v){
			if($v['parent_id'] == $parent_id 
			&& $v['entity'] == $entity
			&& $v['dbname'] == $this->getOrigin($entity)){
				//remove the array
				unset($this->belongs_to[$k]);
			}
		}
		$this->belongs_to = array_values($this->belongs_to);
		$this->save();
		
		//Check if this association has a middle node and create connections
		if($this->hasNode(get_class($this),$entity)){
			$entityNodeName = $this->createNodeName(get_class($this),$entity);
			$entityNode = new $entityNodeName();
			//attempt to open if there is an existing node
			$entityNode->openByCompositeId($parent_id,$entity,$this->id,get_class($this));
			//If the entity node not set to open from above line, then assign the connecting ids and save it
			if(!$entityNode->is_open){
				$entityNode->delete();
				$entityNode->save();
			}
		}
		timer('removeBelongsTo',FALSE);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Removes a Child entity from this
	 * 
	 * @param int $child_id The child id
	 * @param string $entity The singular entity to remove, EX: 'user'
	 */
	public function removeHas($child_id,$entity,$dbname='core'){
		timer('removeHas');
		//Let the child know to remove this as a parent
		$child = New $entity();
		$child->open($child_id);
		
		foreach($child->belongs_to as $k=>$v){
			
			if($v['parent_id'] == $this->id
			&& $v['entity'] == get_called_class()
			&& $v['dbname'] == $this->getOrigin(get_called_class())){
				//remove the array
				unset($child->belongs_to[$k]);
			}
		}
		$child->belongs_to = array_values($child->belongs_to);
		$child->save();	
		
		//remove the for has	
		foreach($this->has as $k=>$v){
			if($v['child_id'] == $child_id 
			&& $v['entity'] == $entity
			&& $v['dbname'] == $dbname){
				//remove the array
				unset($this->has[$k]);
			}
		}
		$this->has = array_values($this->has);
		$this->save();
		
		//Check if this association has a middle node and create connections
		if($this->hasNode(get_class($this),$entity)){
			$entityNodeName = $this->createNodeName(get_class($this),$entity);
			$entityNode = new $entityNodeName();
			//attempt to open if there is an existing node
			$entityNode->openByCompositeId($this->id,get_class($this),$child_id,$entity);
			//If the entity node not set to open from above line, then assign the connecting ids and save it
			if(!$entityNode->is_open){
				$entityNode->delete();
				$entityNode->save();
			}
		}
		timer('removeHas',FALSE);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Returns boolean value whether this belongs to the parent entity
	 * @param INT $parent_id The parent id to check
	 * @param string $entity The singular type of of entity to check. EX: 'user'
	 * @return bool Returns true if this belongs to the parent_id/entity pair
	 * 
	 */
	public function belongsTo($parent_id,$entity,$dbname='core'){
		foreach($this->belongs_to as $k){
				if($k['parent_id'] == $parent_id 
				&& $k['entity'] == $entity
				&& $k['dbname'] == $dbname)
				{return TRUE;}
		}
		return FALSE;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Returns boolean value whether this has the child entity
	 * @param INT $child_id The child id to check
	 * @param string $entity The singular type of of entity to check. EX: 'user'
	 * @return bool Returns true if this has the child_id/entity pair
	 * 
	 */
	public function has($child_id,$entity,$dbname='core'){
		foreach($this->has as $k){
				if($k['child_id'] == $child_id 
				&& $k['entity'] == $entity
				&& $k['dbname'] == $dbname)
				{return TRUE;}
		}
		return FALSE;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Returns Associative array of the children entities
	 * Array['child_id]
	 * Array['entity']
	 * 
	 * @return array associative array of child_id/entity pairs
	 */
	public function getHas(){
		if(empty($this->has) || !isset($this->has) || ($this->has == NULL)){return array();}
		else{return $this->has;}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Returns Associative array of the parent objects matching entity type
	 * Array['parent_id]
	 * Array['entity']
	 * 
	 * @return array associative array of parent_id/entity pairs
	 */
	public function getBelongsTo(){
		if(empty($this->belongs_to) || !isset($this->belongs_to) || ($this->belongs_to == NULL)){return array();}
		else{return $this->belongs_to;}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Returns an associative array of child objects matching entity type
	 * 
	 * @param string $entity_seach The singular value of the entity type to return
	 * @return array Associative array of child_id/entity objects This has
	 */
	public function getHasByEntity($entity_search){
		timer('getHasByEntity');	
		$return = array();	
		
		if(empty($this->has)){
			timer('getHasByEntity',FALSE);	
			return $return;
		}
		
		$in = '';
		$class_name = $entity_search;
		
		$cnt = 0;
		foreach($this->has as $has){
			if ($has['entity'] == $entity_search){
				if ($cnt == 0){
					//on the first iteration find if entity is in the parents database
					if($this->class_name != $has['dbname']){
						$foreign_source = TRUE;
						
					}
		 			$cnt++;
					$in = "'" .$has['child_id']."'" ;
				}
				else{
					$in = $in . ",'".$has['child_id']."'" ;				
				}
			}
		}
		
		if($in == ''){return $return;}
		
		$sql = "SELECT * FROM $class_name WHERE id IN ($in)";
		
		//if the entities are foriegn, create a new object to run sql on its db, otherwise we can use this entities connection.
		if($foreign_source){
			$foreign_obj = new $class_name();
			$stmt = $foreign_obj->executeSql($sql);
		}
		else{
			$stmt = $this->executeSql($sql);
		}
		
		if($stmt->rowcount() > 0){
	    	foreach($stmt->fetchAll() as $v) {
	    		$child_obj = new $class_name();
				$child_obj->OpenFromSTMT($v);
					
				array_push($return,$child_obj);
			}	
		}

		timer('getHasByEntity',FALSE);
		return $return;	
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Returns an associative array of all entities of a type
	 * 
	 * @param string $entity_seach The singular value of the entity type to return
	 * @return array Associative array of parent_id/entity objects this Belongs To
	 */
	public function getBelongsToByEntity($entity_search){
		timer('getBelongsToByEntity');	
		$return = array();
		if(empty($this->belongs_to)){timer('getBelongsToByEntity',FALSE); return  $return;}
		
		$in = '';
		$class_name = $entity_search;
		
		$cnt = 0;
		foreach($this->belongs_to as $belongs_to){
			if ($belongs_to['entity'] == $entity_search){
				
				if ($cnt == 0){
					//on the first iteration find if entity is in the parents database
					if($this->class_name != $belongs_to['dbname']){
						$foreign_source = TRUE;
						
					}
		 			$cnt++;
					$in = "'" .$belongs_to['parent_id']."'" ;
				}
				else{
					$in = $in . ",'".$belongs_to['parent_id']."'" ;				
				}
			}
		}
		
		if($in == ''){
			timer('getBelongsToByEntity',FALSE);
			return $return;
		}
		
		$sql = "SELECT * FROM $class_name WHERE id IN ($in)";
		//if the entities are foriegn, create a new object to run sql on its db, otherwise we can use this entities connection.
		if($foreign_source){
			$foreign_obj = new $class_name();
			$stmt = $foreign_obj->executeSql($sql);
		}
		else{
			$stmt = $this->executeSql($sql);
		}
		
		if($stmt->rowcount() > 0){
	    	foreach($stmt->fetchAll() as $v) {
	    		$parent_obj = new $class_name();
				$parent_obj->OpenFromSTMT($v);
					
				array_push($return,$parent_obj);
			}	
		}
		
		timer('getBelongsToByEntity',FALSE);
		return $return;	
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Returns a count of children of the entity_search type
	 * @param string $entity_seach The singular value of the entity type to count
	 * @return int count of the entity types belonging to $this
	 * 
	 */	
	 public function countBelongsToByEntity($entity_search){
	 	$return = 0;
		foreach($this->belongs_to as $belongs_to){
			if ($belongs_to['entity'] == $entity_search){
				$return++;
			}
		}
		return $return;
	 }
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Returns a count of children of the entity_search type
	 * @param string $entity_seach The singular value of the entity type to count
	 * @return int count of the entity types belonging to $this
	 * 
	 */	
	 public function countHasByEntity($entity_search){
	 	$return = 0;
		foreach($this->has as $has){
			if ($has['entity'] == $entity_search){
				$return++;
			}
		}
		return $return;
	 }

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Detects if there is a connecting node object between two entities
	 * @param string $entity_1 The string of the entity to check
	 * @param string $entity_2 The string of the entity to check
	 * @return bool Returns true if there is a defined entity node object for these entitys
	 */	
	static public function hasNode($entity_1,$entity_2){
		timer('hasNode');	
		//Build the array and add the entity names	
		$entity_array = array();
		array_push($entity_array,$entity_1);
		array_push($entity_array,$entity_2);
		//Order Alpha and see if the class exists
		sort($entity_array);
		timer('hasNode',FALSE);
		
		if(class_exists($entity_array[0].'_'.$entity_array[1])){return TRUE;}
		else{return FALSE;}
	}	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Create a node name from two entities, placing them in alpha order
	 * @param string $entity_1 The string of the entity to check
	 * @param string $entity_2 The string of the entity to check
	 * @return string Returns string of defined entity node object for these entitys
	 */	
	public static function createNodeName($entity_1,$entity_2){
		timer('createNodeName');	
		//Build the array and add the entity names	
		$entity_array = array();
		array_push($entity_array,$entity_1);
		array_push($entity_array,$entity_2);
		//Order Alpha and see if the class exists
		sort($entity_array);
		
		timer('createNodeName',FALSE);
		//Build and return the node name
		return $entity_array[0].'_'.$entity_array[1];
			
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Connects two entities 
	 * 
	 * Connecting a node will notify it's parent and child of the association
	 * @param int $parent_id The id of the parent entity
	 * @param string $parent_entity The entity of the parent
	 * @param int $child_id The id of the child entity 
	 * @param sting $child_entity The entity of the parent
	 */
	public function connectNode($parent_id,$parent_entity,$child_id,$child_entity){
		timer('connectNode');	
			
		//public function setBelongsTo($parent_id,$entity){
		if(!isset($parent_id)||!isset($child_id)){
			trigger_error('The parent id or entity was not set.');
			return;
		}
		if(!is_int($parent_id)||!is_int($child_id)){
			trigger_error('One of the IDs passed to this function was not an integer');
			return;
		}	
		
		$class_name = explode("_",get_called_class());
		if(		($parent_entity != $class_name[0] || $parent_entity != $class_name[1])
			|| 	($child_entity != $class_name[0] || $child_entity != $class_name[1])){
			trigger_error("The parent entity does not match either the Leading or Trailing name of this node");
			return;
		}
		
		//Connect the parent to the child
		$parent_class = $parent_entity;
		$parent = New $parent_class();
		$parent->open($parent_id);
		//If the child does not already belong... to prevent recursion
		if(!$parent->has($child_id,$child_id)){
			$child = array();
			$child['child_id'] = $child_id;
			$child['entity'] = $child_entity;
			
			//if we allow this entity to belong to many
			if($parent->has_many){
				//just push it
				array_push($parent->has,$child);
			}
			//otherwise if we have 1 or fewer
			else{
				//detroy and push parent
				unset($parent->has);
				$parent->has = array();
				array_push($parent->has,$child);
			}
			$parent->has = array_map("unserialize", array_unique(array_map("serialize", $parent->has)));
			$parent->save();
		}
		//+++++++++++++++++++++++
		//connect the child to the parent
		//$child_class = get_called_class();
		$child_class = $child_entity;
		$child = New $child_class();
		$child->open($child_id);
		//If the child does not already belong... to prevent recursion
		if(!$child->belongsTo($parent_id,$parent_entity)){
			//Create the sub array to push below
			$parent = array();
			$parent['parent_id'] = $parent_id;
			$parent['entity'] = $parent_entity;
			
		//	print_r($parent);
			//if we allow this entity to belong to many
			if($child->belongs_to_many){
				//just push it	
				array_push($child->belongs_to,$parent);
			}
			//otherwise if we have 1 or fewer
			else{
				//detroy and push parent
				unset($child->belongs_to);
				$child->belongs_to = array();
				array_push($child->belongs_to,$parent);
			}
			//make the multi-dim array unique
			$child->belongs_to = array_map("unserialize", array_unique(array_map("serialize", $child->belongs_to)));
		//  print_r($child);
			$child->save();
		}
		
		//Set this data on this object
		$this->{$child_entity.'_id'} = $child_id;
		$this->{$parent_entity.'_id'} = $parent_id;
		
		timer('connectNode',FALSE);
		
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 
	 * 
	 * 
	 */
	public function setPropertiesFromArray($input_array){
		timer('setPropertiesFromArray');
		//Gather the names of properies from this
		$properties = array();
		$ass_properties = get_object_vars($this);
		
		//for each property for this, push to non associative array
		foreach($ass_properties as $k=>$v){
				
			array_push($properties,$k);
			//if this has a date property, get the values from the input array 
			//if they exist and set the properties on this using mktime()
			if(substr($k,-4)=='Date'){
				$input_array[$k] = date(DATE_FORMAT,mktime(0,0,0,
				$input_array[$k.'_month'],
				$input_array[$k.'_day'],
				$input_array[$k.'_year']));
			}
			
		} 
		//check if in the objects properties and add if so, otherwise ignore;
		foreach($input_array as $k=>$v){
			
			if(in_array($k,$properties)){
				$this->{$k} = $v;
			}
			
		}
		
		
		timer('setPropertiesFromArray',FALSE);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Sets a name for This
	 * 
	 * @param string $name The name to set, it should be unique
	 */
	public function setName($name){
		$this->name = $name;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Get the public name, used for display. May be different than the entity name.
	 * Public Names may be used as a work around for restricted entity name, such as
	 * an entity name "order" is a reserved SQL word
	 * 
	 */
	 public function getPublicName(){
	 	
	 	if(isset($this->config['altPublicName'])){
	 		 return $this->config['altPublicName']; 
		} else {
			return get_called_class();
		}
		
	 }
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Removes the name currently set on This
	 */
	public function removeName(){
		$this->name = "";
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 *  Returns true if the entity is a node
	 */	
	public function isNode(){
		if(strchr(get_called_class(), '_')){return TRUE;}
		else{return FALSE;}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function isNodeStatic($class_name){
		if(strchr($class_name, '_')){return TRUE;}
		else{return FALSE;}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//returns the parent entity name from two given entities
	
	public static function getParent($entity_a,$entity_b){
		$entity_1 = new $entity_a();
		$entity_2 = new $entity_b();
		
		
		//if the relationship is recursive
		if (in_array($entity_a,$entity_2->config['associations']['has'])
			&& in_array($entity_b,$entity_1->config['associations']['has'])){
				return false;
			}
		
		//if B is the parent
		if (in_array($entity_a,$entity_2->config['associations']['has'])){
			return $entity_b;	
		}
		
		//if A is the parent
		if (in_array($entity_b,$entity_1->config['associations']['has'])){
			return $entity_a;	
		}
		
		else {trigger_error('the parent could not be determined.');}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//returns the child from two given intities	
	public static function getChild($entity_a,$entity_b){
		$entity_1 = new $entity_a();
		$entity_2 = new $entity_b();
		
		print_r($entity_1);
				print_r($entity_2);
		//if the relationship is recursive
		if (in_array($entity_a,$entity_2->config['associations']['has'])
			&& in_array($entity_b,$entity_1->config['associations']['has'])){
				
				return false;
			}
		
		//if a is the child
		if (in_array($entity_a,$entity_2->config['associations']['belongsTo'])){
			return $entity_b;	
		}
		
		//if b is the child
		if (in_array($entity_b,$entity_1->config['associations']['belongsTo'])){
			return $entity_a;	
		}
		
		else {trigger_error('the child could not be determined.');}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Get object origin
	 * @param sting $class_name The name of the class to get the database origin of
	 * @return string returns 'core' if this object is a core object, 
	 * or the name of the company DB this object comes from. Else returns false,
	 * likely because there is no company logged in.
	 * 
	 * 
	 */
	public static function getOrigin($class_name){
		global $map;
		
		timer('GetOrigin');	
		//if the class is in the core
		if (in_array($class_name,$map->core_dir)){
			return COREDBNAME;
		}
		if (in_array($class_name,$map->company_dir)
			&& company::isSessionLoggedIn()){
			$company_id = company::getLoggedInId();
			timer('GetOrigin',FALSE);
			return COMPANYDBPREFIX.'c_'.$company_id;
		} else {
			trigger_error("The origin of object could not be determined. Object:".get_class());
			return FALSE;
		}
			
			
			
			
		
		//echo 'getFilePath: '. dirname(dirname(__FILE__)) . '<br>';
		if(file_exists(dirname(dirname(__FILE__))."/entity/".$class_name.".php")
		|| file_exists(dirname(dirname(__FILE__))."/table/".$class_name.".php")){
			timer('GetOrigin',FALSE);
			return COREDBNAME;
		}
		if(file_exists(dirname(dirname(dirname(dirname(__FILE__)))).'/model/entity/'.$class_name.".php")
			|| file_exists(dirname(dirname(dirname(dirname(__FILE__)))).'/model/table/'.$class_name.".php")
			&& company::isSessionLoggedIn())
		{
			$company_id = company::getLoggedInId();
			timer('GetOrigin',FALSE);
			return COMPANYDBPREFIX.'c_'.$company_id;
		}
		else{
			trigger_error("The origin of object could not be determined. Object:".get_class());
			timer('GetOrigin',FALSE);
			return FALSE;
		}
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * @return bool Returns true if this has a property ending with special field name ex, ending in File, Date etc.
	 * 
	 */	
	public function hasSpecialProperty($sub_string, $object ){
		if(!isset($object)){$object = $this;}
		
		foreach($object as $property=>$v){
			if(substr($property,-strlen($sub_string)) == $sub_string){return TRUE;}
		}	
		return FALSE;
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/*
	 * 
	 * @return array of property names that have a special property ending with $sub_string
	 * 
	 * 
	 */
	 public function getSpecialProperties($sub_string, $object){
	 	
	 	if(!isset($object)){$object = $this;}
		
		$r = array();
		
		foreach($object as $property=>$v){
			
			if(substr($property,-strlen($sub_string)) == $sub_string){
				array_push($r,$property);
			}
		}	
		return $r;
	 } 
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 
	 * @return array array of base object properties to ingore in fields 
	 */	
	public static function getFormIgnoreList(){
		return array('user_id','is_deleted','is_unique','connx','config','isLoggedIn','is_open','belongs_to_many','belongs_to','has','has_many','class_name','getFormIgnoreList','getDBIgnoreList','isActive');
	}
	public static function getDBIgnoreList(){
		$arr2 = array();
		foreach(get_class_vars('baseTable') as $property => $v){
			array_push($arr2,$property);
		}
		
		$arr1 = array('is_unique','connx','config','isLoggedIn','is_open','getFormIgnoreList','getDBIgnoreList','permissions','class_name');
		//get all the baseTable properties and ignore those too.
		return array_merge($arr1,$arr2);
	}
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/**
	 * Used for session management, returns an array of all properties to keep in the session,
	 * It removes the DB Connection and additional entities
	 * 
	 * @return array Associative array of properties of this
	 */
	public function __sleep(){
		//$vars = get_class_vars(get_called_class());
		$vars = get_object_vars($this);
		//if($this->class_name == 'user'){
		//	print_r($vars);
		//}
		
		$return = array();
		foreach($vars as $k=>$v)
		{
			//These properties do not need to be serialized
			if($k == 'connx' || $k == 'entities'){
				continue;	
			}
			else{array_push($return,$k);}
		}
		//print_r($return);
		$return = array_values($return);
		return $return;
	}
//****************************************************
//
// HIGH LEVEL CALLS
//
//****************************************************
	
	//public static function create(){}
	//public function add(){}
	//public function link(){}
	//public function unlink(){}
	//public function delete(){}
	//public function edit(){}
	//public function search(){}
	//public function remove(){}




}
	

?>