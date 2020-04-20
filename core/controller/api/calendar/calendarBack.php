<?php

if(isset($this->get['entity_name'])
	&& isset($this->get['entity_id'])){
	
	$_{$this->get['entity_name']} = new $this->get['entity_name']();
	$_{$this->get['entity_name']}->open($this->get['entity_id']);
	$mode = $_{$this->get['entity_name']}->mode;
	$func = 'SetCalendarTimeLast'.$mode; //calls $entity->SetCalendarTimeLast(day/week/month);
	$_{$this->get['entity_name']}->$func();
	$_{$this->get['entity_name']}->save();
	${$this->get['entity_name']}->open($this->get['entity_id']);
	
}
	
?>