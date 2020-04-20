<?php

//Get the core connection
$connx = db::getConnection(DBHOST,DBUSER,DBPASSWORD,COREDBNAME);

//get the extended connection
if (company::isSessionLoggedIn()){
	$co_connx = db::getConnection(DBHOST,DBUSER,DBPASSWORD,COMPANYDBPREFIX.'c_'.company::getLoggedInId());			
}


$global_objects = array();
array_push($global_objects,$map);
foreach($map->all_dir as $varName){
	
	//hide the error...
	$serialized = @unserialize($_SESSION[$varName]);
	
	////if the value is serialized...
	//restore from the session, place entities back
	//onto tables via OpenEntities
	if ($serialized !== FALSE ){
		//unserialze to allow php to collect its dirived class
		$object = unserialize($_SESSION[$varName]);
		
		$$varName = $object;
		if (is_object($object) && in_array(get_class($object),$map->all_dir)){
			
			
			//Place the correct connection object on this entity.
			//if the file comes from the extensions and should belong to a company DB
			if (in_array(get_class($object),$map->company_dir)){	//Get the company connection using the ID from the currently stored object
				if(company::isSessionLoggedIn()){
					$$varName->setConnection($co_connx);
				}
			}	
			//If the file comes from the core folders replace standard connection
			elseif (in_array(get_class($object),$map->core_dir)){
				$$varName->setConnection($connx);
			} else {
				trigger_error('could not determine a connection for object: '.$varName." Current logged in company id:". company::getLoggedInCompanyId().company::isCompanyLoggedIn());
			}
			if (in_array(get_class($object),$map->map['core_tables'])){	
					
				$$varName->OpenEntities();
				//$$varName->OpenCalendarEntities();
				
			}
			elseif (in_array(get_class($object),$map->map['company_tables']) 
				&& company::isSessionLoggedIn()){
					
				$$varName->OpenEntities();
				//$$varName->OpenCalendarEntities();
				
			}
			//added 1.23.19
			if (method_exists($$varName,'init')){
				$$varName->init();
			}
			//push the object onto the global object
			array_push($global_objects,$$varName);
		}
		
 	} else {
		
		//The entity was not in the session so...

		//create a company entity
		//don't create company objects until we are logged in...	
		if (in_array($varName,$map->company_dir) && company::isSessionLoggedIn()){
			
			//create a new company entity
			//connections are made in __construct
			$$varName = new $varName();
			//added 1.23.19
			//Run init if it exists to load all hooks for this entity
			if (method_exists($$varName,'init')){
				$$varName->init();
			}
			array_push($global_objects,$$varName);
		}
		//create a core entity
		if (in_array($varName, $map->core_dir))
		{
			
			//Create a new core object 
			//connections are made in __construct()
			$$varName = new $varName();
			
			//added 1.23.19
			//Run init if it exists to load all hooks for this entity
			if (method_exists($$varName,'init')){
				$$varName->init();
			}
			array_push($global_objects,$$varName);
			
		}
	}
}
array_push($global_objects,$calendar);
array_push($global_objects,$colors);
array_push($global_objects,$session);
unset($object);




