<?php

class company extends baseEntity{
	
	public $phone;
	public $email;
	public $logoImage;
	public $foundedDate;
	public $isLoggedIn;
	public $config;
	
	public function __construct(){
		$this->isLoggedIn = FALSE;	
		$this->config['primaryIDProperty'] = 'name';
		$this->config['primaryViewProperties'] = array(
			'foundedDate',
			'phone',
			'email',
			'name'
		);
		
		//$this->config['associations'] = array(
		//	
		//	'store'=>'has',
		//	'card'=>'has',
		//	'user'=>'belongsTo',
		//	'user'=>'has',
		//	'product'=>'has'
		//);
		
		
		$this->config['associations']['belongsTo'] = array('user');
		$this->config['associations']['has'] = array('store','card','user','product');
			
			
		parent::__construct();
	}
	
	public function init(){
		global $hooks;
		
		//Hook creating a database after we create a new company
		$hooks->add_action('company_create_post', array($this, 'createDb'));
	}
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		/*
		if(!$v->email($data['email']))
			{SetError('Email address is not valid');}
		
		if(!$v->notBlank($data['phone']))
			{SetError('Phone Number was left blank');}
		if(!$v->numeric($data['phone']))
			{SetError('Phone Number must be numeric');}
		 * 
		 */
	}
	
	//Called when we create a new company
	public function createDb($company){
		
		$this->createDatabase($company->id);
	}
	
	
}

?>