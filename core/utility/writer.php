<?php

class writer{
//*******************************************************************
// IIIII N   N  CCCC |   SSSS EEEEE
//   I   NN  N C     |  S     E
//   I   N N N C     |   SSS  EEE
//   I   N  NN C     |      S E
// IIIII N   N  CCCC |  SSSS  EEEEE
//
//*******************************************************************
	public static function write_session_arrays(){
		$code = php_helper::create_array_from_session_scan();
		file_put_contents(dirname(dirname(__FILE__))."/setup/session_arrays.php", $code);
	}



	public static function write_includes(){
		
		$ignore_files = array(
		//Base core objects
				'db',
				'baseEntity',
				'baseEntityNode',
				'baseTable',
				'session',
				'dbs',
				'error',
				'htmls',
				'js_scripts'
		);
		
		
		$code = '<?php 
		';	
		//Get all the files
		$core_tables = array_slice(scandir(dirname(dirname(__FILE__)).'/core/model/table/'),2);
		$core_entities = array_slice(scandir(dirname(dirname(__FILE__)).'/core/model/entity/'),2);
		$company_tables = array_slice(scandir(dirname(dirname(__FILE__)).'/model/table/'),2);
		$company_entities = array_slice(scandir(dirname(dirname(__FILE__)).'/model/entity/'),2);
		
		//Clear the extention (.php)
		$core_tables = array_map(function($e){
		    return pathinfo($e, PATHINFO_FILENAME);
		}, $core_tables);
		$core_entities = array_map(function($e){
		    return pathinfo($e, PATHINFO_FILENAME);
		}, $core_entities);
		$company_tables = array_map(function($e){
		    return pathinfo($e, PATHINFO_FILENAME);
		}, $company_tables);
		$company_entities = array_map(function($e){
		    return pathinfo($e, PATHINFO_FILENAME);
		}, $company_entities);
		
		foreach($core_entities as $file_name){
			if(in_array($file_name,$ignore_files)){continue;}
			$code = $code . 'require(dirname(dirname(__FILE__))."/core/model/entity/'.$file_name.'.php");
			';
		}
		foreach($core_tables as $file_name){
			if(in_array($file_name,$ignore_files)){continue;}
			$code = $code . 'require(dirname(dirname(__FILE__))."/core/model/table/'.$file_name.'.php");
			';
		}
		foreach($company_entities as $file_name){
			if(in_array($file_name,$ignore_files)){continue;}
			$code = $code . 'require(dirname(dirname(__FILE__))."/model/entity/'.$file_name.'.php");
			';
		}
		foreach($company_tables as $file_name){
			if(in_array($file_name,$ignore_files)){continue;}
			$code = $code . 'require(dirname(dirname(__FILE__))."/model/table/'.$file_name.'.php");
			';
		}
		
		$code = $code . ' ?>';
		file_put_contents(dirname(dirname(__FILE__))."/setup/includes.php", $code);
				
	}

//************************************************
//
//  AAA  PPPP  IIIII
// A   A P   P   I
// AAAAA PPPP    I
// A   A P       I
// A   A P     IIIII
//
//++++++++++++++++++++++++++++++++++++++++++++++++
	
	  
	 /* Default returns the code for the module, set write to true to write the file to disk
	 * 
	 * 
	 */
	 public static function entity_edit_api($entity_name,$write=FALSE){
		$code = api_helper::entity_edit($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/api/".$entity_name.'_edit_api.php', $code);}
		else{return $code;}
	} 
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	 
	public static function entity_create_api($entity_name,$write=FALSE){
		$code = api_helper::entity_create($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/api/".$entity_name.'_create_api.php', $code);}
		else{return $code;}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_delete_api($entity_name,$write=FALSE){
		$code = api_helper::entity_delete($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/api/".$entity_name.'_delete_api.php', $code);}
		else{return $code;}
	}
//*****************************************************************************
	public static function entity_remove_api($entity_name,$write=FALSE){
		$code = api_helper::entity_remove($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/api/".$entity_name.'_remove_api.php', $code);}	
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function entity_entity_link_api($parent_entity,$child_entity,$write=FALSE){
		$code = api_helper::entity_entity_link($parent_entity,$child_entity);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/api/".baseEntity::createNodeName($parent_entity, $child_entity).'_link_api.php', $code);}	
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_entity_unlink_api($parent_entity,$child_entity,$write=FALSE){
		$code = api_helper::entity_entity_unlink($parent_entity,$child_entity);		
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/api/".baseEntity::createNodeName($parent_entity, $child_entity).'_unlink_api.php', $code);}
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_entity_add_api($parent_entity,$child_entity,$write=FALSE){
		$code = api_helper::entity_entity_add($parent_entity,$child_entity);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/api/".baseEntity::createNodeName($parent_entity, $child_entity).'_add_api.php', $code);}	
		else{return $code;}	
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_entity_edit_api($parent_entity,$child_entity,$write=FALSE){
		$code = api_helper::entity_entity_edit($parent_entity,$child_entity);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/api/".baseEntity::createNodeName($parent_entity, $child_entity).'_edit_api.php', $code);}	
		else{return $code;}	
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_search_api($entity_name,$write=FALSE){
		$code = api_helper::entity_search($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/api/".$entity_name.'_search_api.php', $code);}
		else{return $code;}
	}	 
	 
	 
	 
	 
	 
//************************************************
//    ccc  OOO   N   N TTTTT RRRR   OOO  L  
//   c    O   O  NN  N   T   R   R O   O L
//   c    O   O  N N N   T   RRRR  O   O L
//   c    O   O  N  NN   T   R   R O   O L  
//    ccc  OOO   N   N   T   R   R  OOO  LLLLL
//++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_edit($entity_name,$write=FALSE){
		$code = php_helper::entity_edit($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/".$entity_name.'_edit.php', $code);}
		else{return $code;}
	} 
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	 
	public static function entity_create($entity_name,$write=FALSE){
		$code = php_helper::entity_create($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/".$entity_name.'_create.php', $code);}
		else{return $code;}
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_delete($entity_name,$write=FALSE){
		$code = php_helper::entity_delete($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/".$entity_name.'_delete.php', $code);}
		else{return $code;}
	}
//*****************************************************************************
	public static function entity_remove($entity_name,$write=FALSE){
		$code = php_helper::entity_remove($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/".$entity_name.'_remove.php', $code);}	
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function entity_entity_link($parent_entity,$child_entity,$write=FALSE){
		$code = php_helper::entity_entity_link($parent_entity,$child_entity);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/".baseEntity::createNodeName($parent_entity, $child_entity).'_link.php', $code);}	
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_entity_unlink($parent_entity,$child_entity,$write=FALSE){
		$code = php_helper::entity_entity_unlink($parent_entity,$child_entity);		
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/".baseEntity::createNodeName($parent_entity, $child_entity).'_unlink.php', $code);}
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_entity_add($parent_entity,$child_entity,$write=FALSE){
		$code = php_helper::entity_entity_add($parent_entity,$child_entity);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/".baseEntity::createNodeName($parent_entity, $child_entity).'_add.php', $code);}	
		else{return $code;}	
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_entity_edit($parent_entity,$child_entity,$write=FALSE){
		$code = php_helper::entity_entity_edit($parent_entity,$child_entity);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/".baseEntity::createNodeName($parent_entity, $child_entity).'_edit.php', $code);}	
		else{return $code;}	
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_search($entity_name,$write=FALSE){
		$code = php_helper::entity_search($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__))."/controller/".$entity_name.'_search.php', $code);}
		else{return $code;}
	}


//************************************************
//   FFFF  OOO   RRRR   M   M   SSSS
//   F    O   O  R   R  MM MM  S
//   FFF  O   O  RRRR   M M M   SSSS
//   F    O   O  R  R   M   M       S
//   F	   OOO   R   R  M   M   SSSS
//++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_edit_form($entity_name,$write=FALSE){
		$object = new $entity_name();
		//start with creating the form 
		$code = form_helper::write_form_start($entity_name.'_edit',$entity_name.'_edit');
		foreach($object as $property => $value){
			$type = gettype($value);	
			//if property should be ignored, exclude any arrays as well.
			//Also, when creating when can igore the ID
			if(in_array($property,$object::getFormIgnoreList()) 
				|| is_array($value) 
				|| is_object($value)
				|| $property=='id'
				|| $property=='belongs_to_many'
				|| $property=='has_many'
				|| $property=='is_deleted'
				){continue;}
			$code = $code . form_helper::get_form_field($entity_name, $property, $value,$entity_name.'_edit');
		}
		
		$code = $code . form_helper::write_text($entity_name,'id',"",TRUE); //add a hidden id property
		$code = $code . form_helper::write_submit_button('edit', $entity_name,$entity_name.'_edit');
		$code = $code . form_helper::write_form_end();
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/forms/'.$entity_name.'_edit.php', $code);}
		else{return $code;}
	}
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function entity_create_form($entity_name,$write=FALSE){
		$object = new $entity_name();
		//start with creating the form 
		//use special form starts for entities that have a file property
		if($object->hasSpecialProperty('File')){$code = form_helper::write_form_start($entity_name.'_create',$entity_name.'_create','',TRUE);}
		else{$code = form_helper::write_form_start($entity_name.'_create',$entity_name.'_create');}
		
		foreach($object as $property => $value){
			$type = gettype($value);	
			//if property should be ignored, exclude any arrays as well.
			//Also, when creating when can igore the ID
			if(in_array($property,$object::getFormIgnoreList()) 
				|| is_array($value) 
				|| is_object($value)
				|| $property=='id'
				|| $property=='belongs_to_many'
				|| $property=='has_many'
				|| $property=='is_deleted'
				){continue;}
			$code = $code . form_helper::get_form_field($entity_name, $property, $value,$entity_name.'_create');
		}
		$code = $code . form_helper::write_submit_button('create', $entity_name,$entity_name.'_create');
		$code = $code . form_helper::write_form_end();
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/forms/'.$entity_name.'_create.php', $code);}
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_remove_form($entity_name,$write=FALSE){
		$option_array = form_helper::getOptionsArrayFromEntityName($entity_name);	
		$code = form_helper::write_form_start($entity_name.'_remove',$entity_name.'_remove');
		$code = $code . form_helper::write_option($entity_name,$option_array,$entity_name.'_remove');
		$code = $code . form_helper::write_submit_button('remove', $entity_name,$entity_name.'_remove');
		$code = $code . form_helper::write_form_end();
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/forms/'.$entity_name.'_remove.php', $code);}
		else{return $code;}
	
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_delete_form($entity_name,$write=FALSE){
		$option_array = form_helper::getOptionsArrayFromEntityName($entity_name);	
		$code = form_helper::write_form_start($entity_name.'_delete',$entity_name.'_delete');
		$code = $code . form_helper::write_option($entity_name,$option_array,$entity_name.'_delete');	  
		$code = $code . form_helper::write_submit_button('delete', $entity_name,$entity_name.'_delete');
		$code = $code . form_helper::write_form_end();
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/forms/'.$entity_name.'_delete.php', $code);}
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function entity_entity_link_form($parent_entity,$child_entity,$write=FALSE){
			
		$parent_option_array = form_helper::getOptionsArrayFromEntityName($parent_entity);
		$child_option_array = form_helper::getOptionsArrayFromEntityName($child_entity);
		//Write the forme
		$code = form_helper::write_form_start(baseEntity::createNodeName($parent_entity, $child_entity).'_link',$parent_entity.'_'.$child_entity.'_link');
		$code = $code . form_helper::write_option($parent_entity, $parent_option_array,$parent_entity.'_'.$child_entity.'_link');
		$code = $code . form_helper::write_option($child_entity, $child_option_array,$parent_entity.'_'.$child_entity.'_link');
		$code = $code . form_helper::write_submit_button('Link', form_helper::cleanText(baseEntity::createNodeName($parent_entity, $child_entity)),$parent_entity.'_'.$child_entity.'_link');
		$code = $code . form_helper::write_form_end();
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/forms/'.baseEntity::createNodeName($parent_entity, $child_entity).'_link.php', $code);}
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function entity_entity_unlink_form($parent_entity,$child_entity,$write=FALSE){
		$parent_option_array = form_helper::getOptionsArrayFromEntityName($parent_entity);
		$child_option_array = form_helper::getOptionsArrayFromEntityName($child_entity);
		$code = form_helper::write_form_start(baseEntity::createNodeName($parent_entity, $child_entity).'_unlink',$parent_entity.'_'.$child_entity.'_unlink');	
		$code = $code . form_helper::write_option($parent_entity, $parent_option_array,$parent_entity.'_'.$child_entity.'_unlink');
		$code = $code . form_helper::write_option($child_entity, $child_option_array,$parent_entity.'_'.$child_entity.'_unlink');
		$code = $code . form_helper::write_submit_button('Un-Link', form_helper::cleanText(baseEntity::createNodeName($parent_entity, $child_entity)),$parent_entity.'_'.$child_entity.'_unlink');
		$code = $code . form_helper::write_form_end();
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/forms/'.baseEntity::createNodeName($parent_entity, $child_entity).'_unlink.php', $code);}
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function entity_search_form($entity_name,$write){
		//get all the fields and prepare to place into option field
		$child_single = new  $entity_name();
		$fields_array = array();
		foreach(get_object_vars($child_single) as $k=>$v){
				
			if(in_array($k,baseEntity::getFormIgnoreList())
			|| is_array($v) 
				|| is_object($v)
				|| $k=='id'
				|| $k=='belongs_to_many'
				|| $k=='has_many'
				|| $k=='is_deleted'){continue;}
			$field_array[$k] = $k;
		}
				
		$code = form_helper::write_form_start_inline($entity_name.'_search',$entity_name.'_search',FALSE);
		$code = $code . form_helper::write_text_with_value($entity_name, 'search_phrase', 'Search', '',FALSE,FALSE);
		$code = $code . form_helper::write_option('field', $field_array,'');
		$code = $code . form_helper::write_submit_button('Search', form_helper::cleanText($entity_name),$entity_name.'_search');
		$code = $code . form_helper::write_form_end();
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/forms/'.$entity_name.'_search.php', $code);}
		else{return $code;}
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function entity_entity_add_form($parent_entity,$child_entity,$write=FALSE){
		$parent_option_array = form_helper::getOptionsArrayFromEntityName($parent_entity);
		$child_option_array = form_helper::getOptionsArrayFromEntityName($child_entity);
		$code = form_helper::write_form_start_inline(baseEntity::createNodeName($parent_entity, $child_entity).'_add',$parent_entity.'_'.$child_entity.'_unlink',FALSE);
		$code = $code . form_helper::write_option($parent_entity, $parent_option_array,$parent_entity.'_'.$child_entity.'_unlink');
		$code = $code . form_helper::write_option($child_entity, $child_option_array,$parent_entity.'_'.$child_entity.'_unlink');
		$code = $code . form_helper::write_submit_button('Add', $child_entity,$parent_entity.'_'.$child_entity.'_unlink');	
		$code = $code . form_helper::write_form_end();
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/forms/'.baseEntity::createNodeName($parent_entity, $child_entity).'_add.php', $code);}
		else{return $code;}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function entity_entity_edit_form($parent_entity,$child_entity,$write=FALSE){
		$parent_option_array = form_helper::getOptionsArrayFromEntityName($parent_entity);
		$child_option_array = form_helper::getOptionsArrayFromEntityName($child_entity);
		$code = form_helper::write_form_start_inline(baseEntity::createNodeName($parent_entity, $child_entity).'_edit',$parent_entity.'_'.$child_entity.'_edit',FALSE);
		$code = $code . form_helper::write_option($parent_entity, $parent_option_array,$parent_entity.'_'.$child_entity.'_edit');
		$code = $code . form_helper::write_option($child_entity, $child_option_array,$parent_entity.'_'.$child_entity.'_edit');
		$code = $code . form_helper::write_submit_button('Edit', $child_entity,$parent_entity.'_'.$child_entity.'_edit');	
		$code = $code . form_helper::write_form_end();
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/forms/'.baseEntity::createNodeName($parent_entity, $child_entity).'_edit.php', $code);}
		else{return $code;}
	}
	
	public static function write_entity_view($entity_name,$write=FALSE){
		$code = html_helper::write_view_header($entity_name);
		$code = $code . html_helper::write_view_body($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/'.inflector::pluralize($entity_name).'.php', $code);}
		else{return $code;}
		
	}
	
	public static function write_entity_modal($entity_name,$write=FALSE){
		$code = html_helper::write_entity_modal($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/view/'.$entity_name.'.php', $code);}
		else{return $code;}
		
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//	JJJJJ       SSSS   CCCC  RRRR   IIIII  PPPP   TTTTT
//	  J        S      C      R   R    I    P   P    T
//    J	  ###   SSS   C      RRRR     I    PPPP     T
//	J J            S  C      R  R     I    P        T 
//   J     	   SSSS    CCCC  R   R  IIIII  P        T  
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function write_js($entity_name,$write=FALSE){
		$code = js_helper::write_js($entity_name);
		if($write){file_put_contents(dirname(dirname(__FILE__)).'/js/'.$entity_name.'.js', $code);}
		else{return $code;}
		
		
		
	}
	
}



?>