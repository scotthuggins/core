<?php
class permission extends baseEntity{
	
	public $description;
		
	public function __construct(){
		$this->config['primaryIDProperty'] = 'name';
		$this->config['primaryViewProperties'] = array('name','description');
		
		//$this->config['associations']= array(
		//	'role'=>'belongsTo'
		//);
		
		
		$this->config['associations']['belongsTo'] = array('role');
		$this->config['associations']['has'] = array();
		
	
		parent::__construct();
		
	}	
	
	
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		if(!$v->notBlank($data['name']))
			{SetError('Name was left blank');}
	}
	public static function stripAdmin(){
		$role = new role();
		$role->OpenByName("Admin");
		if($role->is_open){
			foreach($role->getHasByEntity('permission') as $permission){
				$role->removeHas($permission->id,'permission');
			}
		}
		$role->save();
		
	}
	
	
	//Used for creating permission from the write executor
	public static function create_permission($entity_name,$action = NULL){
			
		if(!isset($entity_name)){return;}	//prevent ghosts with no name
		if(isset($action)){	
			$permission_name = $entity_name."_".$action;
			$description = 	$entity_name . " ". $action;
		}
		else{
			$permission_name = $entity_name;
			$description = $entity_name;
		}
		$permission = new permission();
		$permission->OpenByName($permission_name);
		
		if(!$permission->is_open){
			$permission->name = $permission_name;
			$permission->description = $description;
			$permission->save();
		}
		
		//always add a new permission to the admin rol
		$role = new role();
		$role->OpenByName("Admin");
		if(!$role->is_open){
			//if the role doesn't exist give it a name for it to same
			$role->name = 'Admin';
		}
		$role->setHas($permission->id,'permission');
		$role->Save();
	}
}
?>