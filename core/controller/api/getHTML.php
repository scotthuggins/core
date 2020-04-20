<?php
//append the form data to the session
//GET VALUES:
// entity_name ex: company
// entity_id
// function_name (the function to call from html_helper)
// 
// RETURNS:
// HTML
if (isset($this->get['current_entity_name'])){
	$this->get['entity_name'] = $this->get['current_entity_name'];
}




if (isset($this->get['entity_name'])
	&& isset($this->get['function_name'])){
	
	$function_name = $this->get['function_name'];

	//used when passing addional child_entity_name params
	if (isset($this->get['child_entity_name'])){
			
		$entity_name =	$this->get['entity_name'];
		$entity_id = $this->get['entity_id'];
		$child_entity_name = $this->get['child_entity_name'];
		
	} else {
			
		$entity_name =	$this->get['entity_name'];
		$plur = inflector::pluralize($entity_name);
		$entities = ${$plur};
		$plur_entity = $plur;
		if(isset($this->get['entity_id'])){
			$entity_id = $this->get['entity_id'];
		}
		
	}	
	$entity_object = ${$this->get['entity_name']};
	
	if(isset($this->get['entity_id'])){
		$entity_object->open($this->get['entity_id']);
	}
	
	if(file_exists(dirname(dirname(dirname(__FILE__))).'/view/default/'.$function_name . '.php')){
		
		include (dirname(dirname(dirname(__FILE__))).'/view/default/'.$function_name . '.php');
	}
	if(file_exists(dirname(dirname(dirname(__FILE__))).'/view/'.$function_name . '.php')){
		
		$entity = $entity_object;
		include (dirname(dirname(dirname(__FILE__))).'/view/'.$function_name . '.php');
	}
}


?>