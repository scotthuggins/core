<?php
class role extends baseEntity{
	
	
	
	public function __construct(){
		$this->config['primaryIDProperty'] = 'name';
		$this->config['primaryViewProperties'] = array('name');
		
		//$this->config['associations']= array(
		//	'permission'=>'has',
		//	'user'=>'belongsTo'
		//);
		
		
		$this->config['associations']['belongsTo'] = array('user');
		$this->config['associations']['has'] = array('permission');
			
		parent::__construct();
		
	}
	
	
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		if(!$v->notBlank($data['name']))
			{SetError('Name was left blank');}
		
		
	}
	
	//Create a guest role if it doens't exist and add all guest permissions
	//defined in config.php
	
	public function createGuestRole(){
		global $default_guest_roles;
		$role = new role();
		$role->OpenByName("Guest");
		
		//open a permission obect to work with below
		$permission = new permission();
		
		//if the role doesn't exist...
		if(!$role->is_open){
			//give it a name
			$role->name = "Guest";
		}	
		//for every guest-permission in config...
		foreach($default_guest_roles as $permission_name){
				
			//Attempt to open the permission	
			$permission->OpenByName($permission_name);
			
			//if it exists
			if($permission->is_open){
				
				//add the permission to the guest role
				$role->setHas($permission->id,"permission");
			}
		}
	
		//save the role after modifications
		$role->Save();	
	}
}
?>