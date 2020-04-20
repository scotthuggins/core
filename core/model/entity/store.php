<?php

class store extends baseEntity{
	
	public $store_number;
	
	public function __construct(){
	
		//$this->store_number = 1;
		$this->config['primaryIDProperty'] = 'store_number';
		
		//$this->config['associations']= array(
		//	'product'=>'has',
		//	'company'=>'belongsTo'
			
		//);	
		
		
		$this->config['associations']['belongsTo'] = array('company');
		$this->config['associations']['has'] = array('product');
		
		
		$this->config['primaryViewProperties'] = array(
			'name',
			'store_number'
		);	
	
		if(company::isSessionLoggedIn()){
			parent::__construct();
		}
	}
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
	}
}		
?>