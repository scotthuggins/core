<?php


if(DEVELOPMENT){
	
	if(REWRITE_PERMISSIONS){
		
		//if no user exists in the DB, lets create the default admin account.
		
		$user->createRootUser();
		
		//=======================================================
		
		permission::stripAdmin();
		
		//Get all the views
		$views = array_slice(scandir(dirname(dirname(__FILE__)).'/view/'),2);
		$views = array_map(function($e){
		    return pathinfo($e, PATHINFO_FILENAME);
		}, $views);
		//print_r($views);
		foreach($views as $k=>$v){
			//Create permissions for each entity view
			permission::create_permission($v,"view");
		}
		//add login creds
		permission::create_permission('user','download');
		permission::create_permission('user', 'login');
		permission::create_permission('user', 'logout');
		permission::create_permission('company', 'login');
		permission::create_permission('company', 'logout');
		permission::create_permission('getHTML'); //used for jquery calls
		permission::create_permission('getEntity'); //used for jquery calls
		permission::create_permission('getForm'); //used for jquery calls
		permission::create_permission('pagination'); //used for executing pagination requests by all users
		permission::create_permission('seeAllEntities'); //used to overwrite the entity->config['onlySeeThiers'] option
		
		$user->addAdminRole();
		$role->createGuestRole();
		
	}

	
	//Anylize each existing object in both cores
	//Using each object and relationship, determine which controllers and forms are needed
	//Check if the controller and forms already exist
	//if not, open the file and write code dynamically...
	
	foreach($map->all_entities as $this_object){
	
		if(baseEntity::isNodeStatic($this_object)){continue;} // Skip nodes
		if(!company::isSessionLoggedIn() && in_array($this_object,$map->company_dir)){continue;} // added 1.9.19 to ignore company things when not logged in		
		//Create all default files for create/remove/delete
		$default_auto_files = array("create","remove","delete","search","edit");
		
		foreach($default_auto_files as $auto_file_type){
			
			if(REWRITE_PERMISSIONS){
				//Create permissions for each edit type
				permission::create_permission($this_object,$auto_file_type);
			}
			//views
			if(!file_exists(dirname(dirname(__FILE__)).'/view/'.inflector::pluralize($this_object).'.php')
			|| REWRITE_VIEWS){
				//create all views here	
				//echo dirname(dirname(__FILE__))."/view/forms/".$this_object.'_'.$auto_file_type.'.php';
//				$writer_func = 'write_entity_view';	
//				writer::{$writer_func}($this_object,TRUE);
				//Create permissions for this
				
			}
			//modals
			if(!file_exists(dirname(dirname(__FILE__)).'/view/'.$this_object.'.php')
			|| REWRITE_MODALS){
				//create all views here	
				//echo dirname(dirname(__FILE__))."/view/forms/".$this_object.'_'.$auto_file_type.'.php';
//				$writer_func = 'write_entity_modal';	
//				writer::{$writer_func}($this_object,TRUE);	
			}	
			//js
			if(!file_exists(dirname(dirname(__FILE__)).'/js/'.$this_object.'.js')
			|| REWRITE_JS){
				//create all views here	
				//echo dirname(dirname(__FILE__))."/view/forms/".$this_object.'_'.$auto_file_type.'.php';
				$writer_func = 'write_js';	
				writer::{$writer_func}($this_object,TRUE);	
			}
				
			//forms
			if(!file_exists(dirname(dirname(__FILE__)).'/view/forms/'.$this_object.'_'.$auto_file_type.'.php')
			|| REWRITE_FORMS){
				//create all forms here	
				//echo dirname(dirname(__FILE__))."/view/forms/".$this_object.'_'.$auto_file_type.'.php';
				$writer_func = 'entity_'.$auto_file_type.'_form';	
				writer::{$writer_func}($this_object,TRUE);	
			}
			
			//controllers
			if(!file_exists(dirname(dirname(__FILE__))."/controller/".$this_object.'_'.$auto_file_type.'.php')
			|| REWRITE_CONTROLLERS){
				//create controllers here
//				$writer_func = 'entity_'.$auto_file_type;	
//				writer::{$writer_func}($this_object,TRUE);
			}
			
			//api
			if(!file_exists(dirname(dirname(__FILE__))."/controller/api/".$this_object.'_'.$auto_file_type.'_api.php')
			|| REWRITE_APIS){
				//create controllers here
//				$writer_func = 'entity_'.$auto_file_type.'_api';	
//				writer::{$writer_func}($this_object,TRUE);
				
			}
		}

		//If it is one of our objects and the associations is set,
		//Create forms and controllers for:
		//	ADD
		//	LINK
		//	UNLINK
		//  EDIT (added 1.8.19)
		$default_auto_files_links = array("link","unlink","add","edit");
		
		
		
		if(isset($$this_object->config['associations'])){
								
			$relationship_array = array();
			
			$relationship_array = array_merge($$this_object->config['associations']['has'],
				$$this_object->config['associations']['belongsTo']);
				
			
			foreach($relationship_array as $linking_entity){
				if(!company::isSessionLoggedIn() && (in_array($this_object,$map->company_dir) || in_array($linking_entity,$map->company_dir))){continue;} // added 1.9.19 to ignore company things when not logged in
				foreach($default_auto_files_links as $auto_file_type){
								
					if(REWRITE_PERMISSIONS){
						permission::create_permission(baseEntity::createNodeName($this_object, $linking_entity),$auto_file_type);
					}		
						
					//create links here
					//$this_object is the child
					if(!file_exists(dirname(dirname(__FILE__))."/view/forms/".baseEntity::createNodeName($this_object, $linking_entity).'_'.$auto_file_type.'.php')
					|| REWRITE_FORMS){
						//Create FORMS
						$writer_func = 'entity_entity_'.$auto_file_type.'_form';	
						writer::{$writer_func}($linking_entity,$this_object,TRUE);
					}
					if(!file_exists(dirname(dirname(__FILE__))."/controller/".baseEntity::createNodeName($this_object, $linking_entity).'_'.$auto_file_type.'.php')
					|| REWRITE_CONTROLLERS){
						//Create CONTROLLERS
						$writer_func = 'entity_entity_'.$auto_file_type;	
//						if($relationship == 'belongsTo'){writer::{$writer_func}($linking_entity,$this_object,TRUE);}
//						if($relationship == 'has'){writer::{$writer_func}($this_object,$linking_entity,TRUE);}
					}
					if(!file_exists(dirname(dirname(__FILE__))."/controller/api/".baseEntity::createNodeName($this_object, $linking_entity).'_'.$auto_file_type.'_api.php')
					|| REWRITE_APIS){
						//Create API
						$writer_func = 'entity_entity_'.$auto_file_type.'_api';	
//						if($relationship == 'belongsTo'){writer::{$writer_func}($linking_entity,$this_object,TRUE);}
//						if($relationship == 'has'){writer::{$writer_func}($this_object,$linking_entity,TRUE);}
					}
				}
			}
			unset($relationship_array); 	
		}
	}	
}




?>