
 <?php

class purchase extends baseEntity{
		
	//Special property names are used to auto determine forms, data types and other params
	//	 they are ending in:
	// Date - Uses a three part form ex: public startingDate
	// File - Uses a file input for forms
	// Month - Will use month selection in forms
	// Year	- Will use Year selection in forms
	
	
	public $createdDate;
	public $startDate;
	public $endDate;
	public $PoNumber;
	public $statusColor;
	
	//Always place the config last before the base constructor
	
	public $config;
	
	public function __construct(){
		
		
		$this->isLoggedIn = FALSE;	
		
		//Preset default values for all properties. 
		$this->createdDate = time(); //Always a float
		$this->startDate = time(); //Always an int
		$this->endDate = time(); // Text or dynamic data type.
		$this->PoNumber = NULL;
		$this->statusColor = NULL; 
		
		
		
		//NOT IMPLEMENTED
		//Config Property used for indicating this property should be unique in the database
		//id is always unique, it doesn't need to be included here
		$this->config['uniqueProperties'] = array('name');
		
		
		//only see thiers set as true or false allows users to only entities in collections
		//that belong to them. Usful example might include, media object and orders where
		//we would only want a user to see the entites that belong to them
		//Note: the "see all entities" overrides this option
		$this->config['onlySeeTheirs'] = true;
		
		//Config Property used for heading Lists, Search Results, and more ... it's always visible
		$this->config['primaryIDProperty'] = 'name';
		
		//Config Propery used for extending the primaryIDProperty, may be more than one existing property name
		$this->config['primaryViewProperties'] = array(
			'name',
			'PoNumber',
			'startDate',
			'endDate',
			'createdDate'
			
		);
		
		$this->config['useCalendar'] = true;
		$this->config['calendarStartDateProperty'] = 'startDate';
		$this->config['calendarEndDateProperty'] = 'endDate';
		
		//NEW CONFIG property used for created internal map of objects
		$this->config['associations']['belongsTo'] = array('user');
		$this->config['associations']['has'] = array('product');
		
		
		$this->config['altPublicName'] = 'order';
		
		//OLD Config Property used for creating the internal map of objects.
		//$this->config['associations'] = array(
		//	'user'=>'belongsTo',
		//	'product'=>'has'
		//);	
		
		//Must always be last in the base contructor method
		parent::__construct();
		
	}
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		
	}
	
	public function init(){
		global $hooks;
		//Add Hook Actions in init()
		//For hooks functionality see /core/utility/php-hooks-master/src/voku/helper/hooks.php
		//For hook actions see /core/TODO.php
		$hooks->add_action('test_call', array($this, 'object_function'));
	}
	
	//example of a hooked function from the init method
	public function object_function(){}
	
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

?>