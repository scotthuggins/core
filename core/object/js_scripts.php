<?php
class js_scripts extends baseTable {
    
	public $functions_array;

	public function __construct($connx){
		parent::__construct($connx,'js_script');
		$this->functions_array = array();
	}
	
	//expects an html id, gathers script functions associated to this HTML id and all it's children
	public function gatherFunctionsFromHTML($id){
		$html = New html();
		$html->Open($id);
		
		
		//get and render	
		foreach($html->getHas() as $k){
			if($k['entity'] == 'js_script'){
				$js = New js_script();
				$js->open($k['child_id']);
				
				$this->setFunctionCollection($js->name);
			}
			//recursivly get html children and render thier scripts
			if($k['entity'] == 'html'){
				$this->gatherFunctionsFromHTML($k['child_id']);
			}
		}	
	}
	
	//accepts function definitions that will need to be reset for drag and drop
	//These functions need to be redifined when the DOM is updated
	//Ex input: thisFunctionName()
	//Ex input: thisFunctionName($('.firmed').draggable( "option", "disabled", true ))
	public function setFunctionCollection($function_definition){
		if(!in_array($function_definition,$this->functions_array)){			
			array_push($this->functions_array,$function_definition);
		}	
	}
	
	//unsets the functions definition array
	public function unsetFunctionCollection(){
		unset($this->functions_array);
		$this->functions_array = array();
	}
	
	//Renders a script to the page will all function definitions in the collection
	public function renderFunctionCollection(){
		echo 'functin define_js_script_functions(){';
		foreach($this->functions_array as $function){
			echo $function.';';
		}		
		echo '};';
	}
}
?>