<?php
class product_purchase extends baseEntityNode{
	
		
	public function __construct(){
		$this->quantity = 0.00;
		$this->config['primaryViewProperties'] = array('quantity');
		parent::__construct();
		
	}	

	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		
	}
}
?>