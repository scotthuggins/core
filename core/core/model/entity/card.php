<?php



class card extends baseEntity{
	public $name;
	public $expMonth;
	public $expYear;
	public $ccNumber;
	public $billingNameFirst;
	public $billingNameLast;
	public $billingAddressLine1;
	public $billingAddressLine2;
	public $billingZip;
	public $billingState;
	public $cardType;
	public $cvv;
	public $isDefault;
	
	

		
	public function __construct(){
		$this->name = "default card name";
		$this->expMonth = 00;
		$this->expYear = 0000;
		$this->ccNumber = 000000000000;
		$this->billingNameFirst = 'first Name';
		$this->billingNameLast = 'last name';
		$this->billingAddressLine1 = 'address line one';
		$this->billingAddressLine2 = 'address line two';
		$this->billingZip = 00000;
		$this->billingState = "XX";
		$this->cardType = 'XXXX';
		$this->cvv = 0000;
		$this->isDefault = TRUE;
		$this->config['associations']['belongsTo'] = array('user','company');
		$this->config['associations']['has'] = array();
		$this->config['uniqueProperties'] = array('name');
		$this->config['primaryIDProperty'] = 'name';
		$this->config['primaryViewProperties'] = array('name');
		parent::__construct();
	}
	
	public function init(){
		global $hooks;
		
		$hooks->add_action('test_call', array($this, 'test_function'));
		
	}
	
	
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		if(!$v->notBlank($data['name']))
			{SetError('Name was left blank');}
		if(!$v->notBlank($data['billingNameFirst']))
			{SetError('Billing Name First was left blank');}
		if(!$v->notBlank($data['billingNameLast']))
			{SetError('Billing Name Last was left blank');}
		if(!$v->notBlank($data['billingAddressLine1']))
			{SetError('Address Line 1 was left blank');}
		if(!$v->notBlank($data['billingAddressLine2']))
			{SetError('Address Line 2 was left blank');}
		if(!$v->isInteger($data['billingZip']))
			{SetError('Billing Zip Was not valid');}
		if(!$v->lengthBetween($data['billingZip'], 5, 5))
			{SetError('Billing Zip must be 5 characters long');}
		if(!$v->isInteger($data['expYear']))
			{SetError('Experation Year was not valid');}
		if(!$v->lengthBetween($data['expYear'], 4, 4))
			{SetError('Experation Year must be 4 characters long');}
		if(!$v->isInteger($data['expMonth']))
			{SetError('Experation Month was not valid');}
		if(!$v->lengthBetween($data['expMonth'], 2, 2))
			{SetError('Experation Month must be 4 characters long');}
		if(!$v->isInteger($data['cvv']))
			{SetError('CVV was not valid');}
		if(!$v->inList($data['cardType'], $this->getCardTypes()))
			{SetError('Card Type was not valid');}
		if(!$v->cc($data['ccNumber'],'all'))
			{SetError('CC Number is not valid');}
			
	}
	
	
	
	public function getCardTypes(){
		$cards = array('Visa','Mastercard','AMEX','Discover');
		return $cards;
		
		
	}
	
	public function test_function($args){
		echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>TEST WORKED';
		foreach($args as $arg){
			print_r($arg);
		}
		
		
	}
}

?>