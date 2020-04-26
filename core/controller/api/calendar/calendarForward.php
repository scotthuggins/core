<?php

if(isset($this->get['entity_name'])
	&& isset($this->get['entity_id'])){
	
	$_{$this->get['entity_name']} = new $this->get['entity_name']();
	$_{$this->get['entity_name']}->open($this->get['entity_id']);
	$mode = $_{$this->get['entity_name']}->mode;
	
	$func = 'SetCalendarTimeNext'.$mode;
	$_{$this->get['entity_name']}->$func(); //calls $entity->SetCalendarTimeNext(day/week/month);
	$_{$this->get['entity_name']}->save();
	${$this->get['entity_name']}->open($this->get['entity_id']);
	
}
	
?>