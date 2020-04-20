<?php
class company_user extends baseEntityNode{
	
	public $company_id;
	public $user_id;
	public $wage;
	
		
	public function __construct(){
		$this->company_id = 0;
		$this->user_id = 0;
		$this->wage = 00.00;
		$this->config['primaryViewProperties'] = array('wage');
		parent::__construct();
		
	}	

	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		if(!$v->notBlank($data['name']))
			{SetError('Name was left blank');}
	}
}
?>