<?php

class user extends baseEntity{
	
	public $username;
	public $nameCompany;
	public $nameFirst;
	public $nameLast;
	public $phone;
	public $email;
	public $avatarImage;
	public $joinDate;
	public $lastLoginDate;
	public $password;
	public $isLoggedIn;
	
	public function __construct($loadPermissions = false){
		
		$this->config['primaryViewProperties'] = array(
			'nameFirst',
			'nameLast',
			'email'
			
		);
		
		$this->config['primaryIDProperty'] = 'username';
		
		//$this->config['associations']= array(
		//	'company'=>'has',
		//	'role'=>'has',
		//	'card'=>'has',
		//	'media' => 'has'
		//);
		
		
		$this->config['associations']['belongsTo'] = array();
		$this->config['associations']['has'] = array('company','role','card','media','purchase');
		
		
		parent::__construct();
		
		timer('permissions_construct');
		
		$this->loadPermissions();
		timer('permissions_construct',false);
		$this->isLoggedIn = FALSE;
	}
	
	public function init(){
		global $hooks;	
		timer('permissions');
		$this->loadPermissions();
		timer('permissions',false);
		
		$hooks->add_action('user_actions', array(&$this, 'userActions'));
		$hooks->add_action('user_table_viewport', array($this, 'userMedia'));
		$hooks->add_action('user_tile_viewport', array($this, 'userMedia'));
		
	}
	
	public static function userActions(){
		
		include(dirname(dirname(dirname(dirname(__FILE__))))."/view/user_modules/user_actions.php");
		
		
	}
	
	public static function userMedia($entity){
		global $hooks;
		global $user;
		include(dirname(dirname(dirname(dirname(__FILE__))))."/view/default/write_media_module_dynamic.php");
		
		
	}
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		/*
		if(!$v->notBlank($data['nameFirst']))
			{SetError('First Name was left blank');}
		
		if(!$v->notBlank($data['nameLast']))
			{SetError('Last Name was left blank');}
		
		if(!$v->email($data['email']))
			{SetError('Email address is not valid');}
		
		if(!$v->notBlank($data['phone']))
			{SetError('Phone Number was left blank');}
		if(!$v->numeric($data['phone']))
			{SetError('Phone Number must be numeric');}
		
		if(!$v->notBlank($data['password1']))
			{SetError('Password was left blank');}
		
		if(!$v->notBlank($data['password2']))
			{SetError('Password compare was left blank');}
		
		if(!$v->comparison($data['password1'], 'equalto', $data['password2']))
			{SetError('Passwords do not match');}
		 */
	}
	
	
	
	public function login($password=""){
		if($this->password == hasher::hash($password)){
			parent::login();	
			$this->loadUserPermissions();	
			$this->isLoggedIn = TRUE;
			
		}
	}
	
	public function loadPermissions(){
		
		//if the permissions are already set pre
		if (isset($this->permissions) && !empty($this->permissions)){
			//return;
		}
		
		//if they are init as array
		if (!isset($this->permissions) || empty($this->permissions)){
			$this->permissions = array();
		}
		$this->loadGuestPermissions();
	}
	
	public function loadUserPermissions(){
		//Add the users permissions
		foreach($this->getHasByEntity("role") as $role){
			foreach($role->getHasByEntity("permission") as $permission){
				
				array_push($this->permissions,$permission->name);
			}
		}
		
		//make sure all permissions are unique since
		//roles can share permissions
		$this->permissions = array_unique($this->permissions);
	}
	
	public function loadGuestPermissions(){
		//add guest permissions	
		$role = new role();
		$role->OpenByName('Guest');
		foreach($role->getHasByEntity("permission") as $permission){
			array_push($this->permissions,$permission->name);
		}
		
		//make sure all permissions are unique since
		//roles can share permissions
		$this->permissions = array_unique($this->permissions);
	}
	
	
	public function hasPermission($permission_name){
		return true;
		//remove possible ending of _api to allow permission names to work
		//for api and non-api controllers
		$permission_name = rightTrim($permission_name, '_api');
		
		//make sure that this->permission exists as an array and will
		//return false if called before permissions are loaded
		if (!isset($this->permissions) || !is_array($this->permissions)){
			$this->permissions = array();
		}
		if (in_array($permission_name,$this->permissions))
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Creates the admin user if they don't exist
	 * 
	 * 
	 * 
	 */
	public function createRootUser(){
		
		$_user = new user();
		$_user->OpenByName('Admin');
		
		//If the user doesn't exist, because otherwise we could open them
		if (!$_user->is_open){
		
			//Create and set default properties
			$_user = new user();
			$_user->name = 'Admin';
			$_user->username = 'Admin';
			$_user->nameFirst = 'Admin';
			$_user->nameLast = 'Admin';
			$_user->nameCompany = '';
			$_user->phone = '';
			$_user->email = 'none';
			$_user->password = hasher::hash(ADMIN_PASSWORD);
			$_user->setHasMany(TRUE);
			$_user->setBelongsToMany(TRUE);
			$user_id = $_user->save();
		}
	}
	
	/**
	 * Adds the admin role to the admin user
	 * 
	 * 
	 */
	public function addAdminRole(){
		$role = new role();
		$role->OpenByName('Admin');
		
		$user = new user();
		$user->OpenByName('Admin');
		
		//The admin doesn't exist, so create it
		if (!$user->is_open){
			$user->createRootUser();
			$user = new user();
			$user->OpenByName('Admin');
		}
		$role->setBelongsTo($user->id, 'user');
		
	}
	
	
	
	
}

?>