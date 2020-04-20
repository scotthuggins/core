<?php

class api_helper{
//
	public static function entity_create($entity_name){
		
		$code = '<?php
if($user->hasPermission("'.$entity_name.'_create")){
	$session->form = clean_array($connx,$_POST);
	$_'.inflector::pluralize($entity_name).' = new '.inflector::pluralize($entity_name).'();
	$_'.inflector::pluralize($entity_name).'->SetSTMTSql("SELECT * FROM '.$entity_name.' WHERE name = \'".$session->form[\'name\']."\'");    
	$_'.inflector::pluralize($entity_name).'->OpenEntities();
	if(isset($_'.inflector::pluralize($entity_name).'->entities[0])){SetError(\'The '.$entity_name.' "\'.$session->form[\'name\'].\'" already exists\');}
	$hooks->do_action("'.$entity_name.'_create_pre");
	$'.$entity_name.'->validate($session->form);';
	
	$code = $code . '
	if(!GetIsError()){
		$'.$entity_name.' = New '.$entity_name.'();';
		
		if($entity_name == 'media'){
			$code = $code . '$media->upload();';
		}
		
		$code = $code . '
		$hooks->do_action("'.$entity_name.'_create_mid");
		$'.$entity_name.'->setPropertiesFromArray($session->form);
		
		$'.$entity_name.'->setBelongsToMany(TRUE); // allow to belong to many users
		$'.$entity_name.'->setHasMany(TRUE); // allow to have many permissions
		
		//Find the relationships of the entity being created, then create links for
		//each entity that is open
		//re-open entities to see changes live in the session
		
		//we need to prevent acting on objects in the company domain when a company is not open
		foreach($'.$entity_name.'->config[\'associations\'] as $name => $relationship){
			if(isset(${$name}->id)){
				//We only want to look link to the open entity that we can belong to. 	
				if($relationship == "has"){
					$'.$entity_name.'->setHas(${$name}->id,$name);
					${$name}->open(${$name}->id);
				}
				if($relationship == "belongsTo"){
					$'.$entity_name.'->setBelongsTo(${$name}->id,$name);
					${$name}->open(${$name}->id);
				}
			}
		}
		
		$entity_id = $'.$entity_name.'->save();
		$hooks->do_action("'.$entity_name.'_create_post",$entity_id);
		
		';
		
		//if($entity_name == "company"){
		//	$code = $code . '
		//	$db->createDatabase($entity_id);
		//	';
		//}
		$code = $code .'
	}
	echo json_encode($'.$entity_name.');
	unset($_'.inflector::pluralize($entity_name).');	
}
?>';
		return $code;

	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_delete($entity_name){
		$code = '
<?php
if($user->hasPermission("'.$entity_name.'_delete")){
	//append the form data to the session
	$session->form = clean_array($connx,$_GET);
	$_'.$entity_name.' = New '.$entity_name.'();
	$_'.$entity_name.'->open($session->form[\''.$entity_name.'_id\']);
	$hooks->do_action("'.$entity_name.'_delete_pre",$'.$entity_name.');
	
	//remove all child links
	foreach($_'.$entity_name.'->has as $child){
		$_'.$entity_name.'->removeHas($child["id"],$child["entity"],$child["dbname"]);
	}
	//remove all parent links
	foreach($_'.$entity_name.'->belongs_to as $parent){
		$_'.$entity_name.'->removeBelongsTo($parent["id"],$parent["entity"],$parent["dbname"]);
	}
	$hooks->do_action("'.$entity_name.'_delete_post",$'.$entity_name.');
	$_'.$entity_name.'->delete();
	echo json_encode($'.$entity_name.');
	unset($_'.$entity_name.');
}
?>';
		return $code;

	}
//*****************************************************************************
	public static function entity_remove($entity_name){
		$code = '
<?php
if($user->hasPermission("'.$entity_name.'_remove")){
	//append the form data to the session
	$session->form = clean_array($connx,$_POST);
	$_'.$entity_name.' = New '.$entity_name.'();
	$_'.$entity_name.'->open($session->form[\''.$entity_name.'_id\']);
	$_'.$entity_name.'->remove();
	$hooks->do_action("'.$entity_name.'_remove");
	echo json_encode($'.$entity_name.');
	unset($_'.$entity_name.');
}
?>';
		return $code;

	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function entity_entity_link($parent_entity,$child_entity){
		$code = '
<?php
if($user->hasPermission("'.baseEntity::createNodeName($parent_entity, $child_entity).'_link")){
	//append the form data to the session
	$session->form = clean_array($connx,$_GET);
	$_'.$parent_entity.' = new '.$parent_entity.'();
	$_'.$parent_entity.'->Open($session->form[\''.$parent_entity.'_id\']);
	$hooks->do_action("'.baseEntity::createNodeName($parent_entity,$child_entity).'_link_pre");
	$_'.$parent_entity.'->setHas($session->form[\''.$child_entity.'_id\'],\''.$child_entity.'\');
	$_'.$parent_entity.'->save();
	$'.$parent_entity.'->Open($session->form[\''.$parent_entity.'_id\']);
	$hooks->do_action("'.baseEntity::createNodeName($parent_entity,$child_entity).'_link_post");
	echo json_encode($'.$parent_entity.');
	//header (\'location: \'.$_SERVER[\'HTTP_REFERER\']);
}
?>		
		';
		return $code;

	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_entity_unlink($parent_entity,$child_entity){
		
		$code = '
<?php
if($user->hasPermission("'.baseEntity::createNodeName($parent_entity, $child_entity).'_unlink")){
	//append the form data to the session
	$session->form = clean_array($connx,$_GET);
	$_'.$parent_entity.' = new '.$parent_entity.'();
	$_'.$parent_entity.'->Open($session->form[\''.$parent_entity.'_id\']);
	$hooks->do_action("'.baseEntity::createNodeName($parent_entity,$child_entity).'_unlink_pre");
	$_'.$parent_entity.'->removeHas($session->form[\''.$child_entity.'_id\'],\''.$child_entity.'\',baseEntity::getOrigin(\''.$child_entity.'\'));
	$hooks->do_action("'.baseEntity::createNodeName($parent_entity,$child_entity).'_unlink_post");
	$_'.$parent_entity.'->save();
	$'.$parent_entity.'->Open($session->form[\''.$parent_entity.'_id\']);
	echo json_encode($'.$parent_entity.');
}
?>		
		';
		return $code;
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_entity_add($parent_entity,$child_entity){
		$code = '
		<?php
if($user->hasPermission("'.baseEntity::createNodeName($parent_entity, $child_entity).'_add")){
	$session->form = clean_array($connx,$_POST);
	$'.$child_entity.'->validate($session->form);
	if(!'.$parent_entity.'::isLoggedIn()){
		SetError("No '.$parent_entity.' is logged in");
	}
	if(!GetIsError()){
		$'.$child_entity.' = New '.$child_entity.'();
		$'.$child_entity.'->setPropertiesFromArray($session->form);
		$'.$child_entity.'->setBelongsToMany(TRUE); // allow a role to belone to many users
		$'.$child_entity.'->setHasMany(TRUE); // allow to have many permissions
		$'.$child_entity.'->save();
		$hooks->do_action("'.baseEntity::createNodeName($parent_entity,$child_entity).'_add_pre",$'.$child_entity.');
		$'.$child_entity.'->setBelongsTo($'.$parent_entity.'->id, \''.$parent_entity.'\');
		$hooks->do_action("'.baseEntity::createNodeName($parent_entity,$child_entity).'_add_post",$'.$child_entity.');
		$'.$parent_entity.'->open($'.$parent_entity.'->id);
	}	
	echo json_encode($'.$child_entity.');
}
?>';
		return $code;
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public static function entity_entity_edit($parent_entity,$child_entity){
				$entity_name = baseEntity::createNodeName($parent_entity, $child_entity);	
				$code = '<?php
if($user->hasPermission("'.baseEntity::createNodeName($parent_entity, $child_entity).'_edit")){				
	$session->form = clean_array($connx,$_GET);
	$'.$entity_name.'->validate($session->form);
	if(!GetIsError()){
		$_'.$entity_name.' = New '.$entity_name.'();
		$_'.$entity_name.'->OpenByCompositeId($session->form["'.$parent_entity.'_id"],"'.$parent_entity.'",$session->form["'.$child_entity.'_id"],"'.$child_entity.'");
		$_'.$entity_name.'->setPropertiesFromArray($session->form);
		$hooks->do_action("'.baseEntity::createNodeName($parent_entity,$child_entity).'_edit",$_'.$entity_name.');
		$_'.$entity_name.'->save();
	}
	echo json_encode($_'.$entity_name.');
	unset($_'.inflector::pluralize($entity_name).');	
}
?>';
		return $code;
	
	}	
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_search($entity_name){
		$code = '
<?php
if($user->hasPermission("'.$entity_name.'_search")){
	//append the form data to the session
	$session->form = clean_array($connx,$_POST);
	$session->url = clean_array($connx,$_GET);
	$search_col = $session->form[\'field\'];
	$search_phrase = $session->form[\'search_phrase\'];
	$'.inflector::pluralize($entity_name).'->SetSTMTSqlNoLimit("SELECT * FROM '.$entity_name.' WHERE ".$search_col." LIKE \'%".$search_phrase."%\'");
	
	$'.inflector::pluralize($entity_name).'->OpenEntities(TRUE);
	$'.inflector::pluralize($entity_name).'->page_current = 1;
	//go back to form.
	$hooks->do_action("'.inflector::pluralize($entity_name).'_search",$'.inflector::pluralize($entity_name).');
	//echo html_helper::write_link_child_search_table($'.inflector::pluralize($entity_name).',$session->url[\'current_entity_name\']);
	
	
	$entities = $'.inflector::pluralize($entity_name).';
	$parent = $session->url[\'current_entity_name\'];
	include (dirname(dirname(dirname(__FILE__))).\'/view/default/write_link_child_search_table.php\');
	//echo json_encode($'.inflector::pluralize($entity_name).');
}
?>
';
		return $code;
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_edit($entity_name){
		$code = '<?php
if($user->hasPermission("'.$entity_name.'_edit")){		
	$session->form = clean_array($connx,$_POST);
	$'.$entity_name.'->validate($session->form);
	if(!GetIsError()){
		$'.$entity_name.' = New '.$entity_name.'();
		$'.$entity_name.'->open($session->form[\'id\']);
		$'.$entity_name.'->setPropertiesFromArray($session->form);
		$hooks->do_action("'.$entity_name.'_edit",$'.$entity_name.');
		$'.$entity_name.'->save();
	}
	echo json_encode($'.$entity_name.');
	unset($_'.inflector::pluralize($entity_name).');	
}
?>';
		return $code;
	}
}

?>