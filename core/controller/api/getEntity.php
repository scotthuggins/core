<?php
//append the form data to the session

if(isset($this->get['entity_name'])
	&& isset($this->get['entity_id'])){
	
	$_{$this->get['entity_name']} = new $this->get['entity_name']();
	$_{$this->get['entity_name']}->open($this->get['entity_id']);
	$myJSON = json_encode($_{$this->get['entity_name']});

	echo $myJSON;
	
}


?>