<?php
class baseEntityNode extends baseEntity{
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * @param PDO object $connx
	 * 
	 */
	
	
	public function __construct(){
		parent::__construct();
			
		$class_name = get_called_class();
		
		$class_array = explode("_",$class_name);
		
		$this->{$class_array[0].'_id'} = 0;
		$this->{$class_array[1].'_id'} = 0;
		
		if(DEVELOPMENT){
			//Calling this should not create a table, since it should already be created in the parents constructor,
			//but ensures that all the cols are created at run time
		
			$this->createTable($class_name);
		}
		
	}
		
		
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Opens an entity object, Sets $this->is_open to true
	 * 
	 * @param string $parent_entity The entity parent to look for
	 * @param int $parent_id The Parent entity ID to look for
	 * @param string $child_entity the entity child to look for
	 * @param int $child_id The Child entity ID to look for
	 * 
	 */
	public function OpenByCompositeId($parent_id,$parent_entity,$child_id,$child_entity){
		//$this->Close();			
		
		$class_name = get_called_class();
		$sql = "SELECT * FROM $class_name WHERE (".$parent_entity."_id = '".$parent_id."') and (".$child_entity."_id = '".$child_id."')";	
				
		try {
	    	$stmt = $this->executeSQL($sql);
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
		}
		catch(Exception $e) {
		    trigger_error($e->getMessage());
		}
	}
}

 
?>