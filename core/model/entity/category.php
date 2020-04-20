<?php
class category extends baseEntity{
	
		
	public function __construct(){
		$this->config['primaryViewProperties'] = array('name');
		$this->config['primaryIDProperty'] = 'name';
		//$this->config['associations']= array(
		//	'product'=>'belongsTo',
		//	'category'=>'has',
		//	'category'=>'belongsTo'
		//);	
		
		
		$this->config['associations']['belongsTo'] = array('product','category');
		$this->config['associations']['has'] = array('category');
		
			
		parent::__construct();
		
	}
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		if(!$v->notBlank($data['name']))
			{SetError('Name was left blank');}
				
	}
	
	public function traceParents(){
		
	}
	
}
?>