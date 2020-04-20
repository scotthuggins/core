<?php
//parse the map and serialize all entities and tables

foreach($global_objects as $object){
	$_SESSION[get_class($object)] = serialize($object);
}
/*
 
 foreach($map->all_dir as $varName){
	
	//echo $varName . '<br>';
	$$varName = $global_objects[$varName];
	//get every entity and table and serialize them;
	if (isset($$varName)
	 && !empty($$varName)
	 && is_object($$varName)){
			$_SESSION[$varName] = serialize($$varName);
	}
}
*/
