<?php
class product extends baseEntity{
	public $desc_short;
	public $desc_long;
	//public $price_rent;
	//public $price_buy;
	//public $dim_x;
	//public $dim_y;
	//public $dim_z;
	//public $weight;
	//public $weight_shipping;
	//public $make;
	//public $model;
	//public $case_qty;
	public $isActive;
	
	

		
	public function __construct(){
			
		$this->desc_short = NULL;
		$this->desc_long = NULL;
		//$this->dim_x = 00;
		//$this->dim_y = 00;
		//$this->dim_z = 00;
		//$this->weight = 00.00;
		//$this->weight_shipping = 00.00;
		//$this->case_qty = 0;
		//$this->make = NULL;
		//$this->model= NULL;
		//$this->price_rent = 00.00;
		//$this->price_buy = 00.00;
		$this->isActive = TRUE;
		$this->config['primaryViewProperties'] = array('name','desc_short');
		$this->config['primaryIDProperty'] = 'name';
		//$this->config['associations']= array(
		//	'category'=>'has',
		//	'media'=>'has',
		//	'store'=>'belongsTo',
		//	'company'=>'belongsTo'
		//);	
		
		
		$this->config['associations']['belongsTo'] = array('store','company','purchase');
		$this->config['associations']['has'] = array('category','media');
		
		parent::__construct();
		
	}
	public function init(){
		global $hooks;	
		
		
		
		$hooks->add_action('product_table_viewport', array($this, 'productMedia'));
		$hooks->add_action('product_tile_viewport', array($this, 'productMedia'));
		
	}
	
	
	public static function productMedia($entity){
		global $hooks;
		global $user;
		include(dirname(dirname(dirname(dirname(__FILE__))))."/core/view/default/write_media_module_dynamic.php");
		
		
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