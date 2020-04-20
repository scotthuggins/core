<?php
//append the form data to the session
//GET VALUES:
// entity_name ex: company
// form_name ex: entity_entity_link OR delete
// 
// RETURNS:
// HTML



if (isset($this->get['entity_name'])
	&& isset($this->get['form_name'])){
	
	//$form_name = $session->api_request['form_name']."_form";
	$form_name = $this->get['form_name'];
	
	//Get the link, unlink or add subpart
	$req = explode("_",$this->get['form_name']);
	$request = $req[count($var) -1];
	
	
	if(($this->get['form_name'] == 'entity_entity_link')
	|| ($this->get['form_name'] == 'entity_entity_unlink')
	|| ($this->get['form_name'] == 'entity_entity_add')
	&& isset($this->get['parent_entity'])
	&& isset($this->get['child_entity'])
	){
		//If we are a link, unlink or add form
		$parent = $this->get['parent_entity'];
		$child = $this->get['child_entity'];
				
		//make the path
		$path = dirname(dirname(__FILE__)) . "view/forms/" . baseEntity::createNodeName($parent, $child) . "_" . $request;
		if (file_exists($path )){
			include($path);
		}	
		//use the parent and child for these types
		//return writer::$form_name($session->api_request['parent_entity'],$session->api_request['child_entity']);
	} else {
		
		//All other forms
		$path = dirname(dirname(__FILE__)) . "view/forms/" . $this->get['entity_name'] . "_" . $request;
		if (file_exists($path )){
			include($path);
		}	
		//return writer::$form_name($session->api_request['entity_name'],FALSE);
	}	
}


?>