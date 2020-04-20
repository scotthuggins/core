<?php
class product_store extends baseEntityNode{
	
		
	public function __construct(){
		$this->price_rent = 0.00;
		$this->price_buy = 0.00;
		$this->qty_rent = 0;
		$this->qty_buy = 0;
		$this->product_id = 0;
		$this->store_id = 0;
		$this->config['primaryViewProperties'] = array('price_rent','qty_rent');
		parent::__construct();
		
	}	

	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		
	}
}
?>