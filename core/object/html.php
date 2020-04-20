<?php
/*
class html extends baseEntity {
    public $tag;
	public $attributes;
	public $text;
	public $class;
	private $recursive_array;
	
	public function __construct($connx){
		parent::__construct($connx);
		$this->attributes = array();
		$this->text = "";
		$this->class = array();
		
	}
	
	//Contructs a HTML Element object
	public function createElement($tag,$text="",$attributes="",$recursive_array=NULL){
		$this->tag = $tag;
		$this->attributes = $attributes;
		$this->text = $text;
		$this->recursive_array = $recursive_array;
	}
	
	public function setClass($class_name){
		if(!in_array($class_name,$this->class)){
			array_push($this->class,$class_name);	
		}
	}
	
	public function removeClass($class_name){
		foreach($this->class as $k=>$v){
			if ($v == $class_name){
				unset($this->class[$k]);
			}
		}
		array_values($this->class);
	}
	
	public function setAttribute($attribute_name,$attribute_value=""){
		$this->attributes[$attribute_name] = $attribute_value;
	}
	
	public function removeAttribute($attribute_name){
		$this->attributes[$attribute_name] = '';
	}
	
	
	public function render(){
		
		echo '<'.$this->tag.' '.$this->attributes.'>'.$this->text;	
		
		echo '</'.$this->tag.'>';
	}
	
	
	
}


*/

?>