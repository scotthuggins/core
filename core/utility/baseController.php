<?php




class baseController {
	
	public $requestURL;
	public $requestString;
	public $post;
	public $get;
	public $files;
	public $action;
	public $action_type;
	public $user;
	public $entity_name;
	public $entity_name_1;
	public $entity_name_2;
	public $entity_action;
	
	
	
	public function __construct(){
		global $user;
		
		//assign the user onto the controller from the global space
		$this->user = $user;
		
		
		$this->requestURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$this->requestString = substr($this->requestURL, strlen(SITE_URL));
		$this->post = clean_array(NULL,$_POST);
		$this->get = clean_array(NULL,$_GET);
		$this->files = clean_array(NULL,$_FILES);

		$this->urlParams = explode('/', $this->requestString);
		
		
		$this->setController();
		$this->getEntityNames();
		$this->callAction();
		ClearErrors();
	}
	
	//Get the entity names from the url action
	public function getEntityNames(){
		//include the correct js for the entity requested
		$pg_word = explode('_',$this->action);
		if(
			isset($pg_word[0])
			&& isset($pg_word[1])
			&& isset($pg_word[2])
			&& class_exists($pg_word[0])
			&& class_exists($pg_word[1])){
			
				$this->entity_name = $pg_word[0] .'_'. $pg_word[1];
				$this->entity_name_1 = $pg_word[0];
				$this->entity_name_2 = $pg_word[1];
				$this->entity_action = $pg_word[2];
		
			}
		else if (
			isset($pg_word[0])
			&& isset($pg_word[1])
			&& class_exists($pg_word[0])){
			
				$this->entity_name = $pg_word[0];
				$this->entity_name_1 = $pg_word[0];
				$this->entity_action = $pg_word[1];
		
		} else {
			
			//SetError("Entity name could not be determined.");
		
		}
		
		
	}
	
	//Sets the controller name based on urlRequests
	public function setController(){
		
		if (array_key_exists('api_request',$this->get)
			&& isset($this->get['api_request'])){
				
			//Api Controller
			$this->action_type = 'api';
			$this->action = $this->get['api_request'];
			
		} else if (array_key_exists('pg',$this->get)
			&& isset($this->get['pg'])){
			
			//View Controllers
			$this->action_type = 'template';
			$this->action = $this->get['pg'];

		} else if (array_key_exists('process',$this->get)
			&& isset($this->get['process'])){
		
			//process controller
			$this->action_type = 'process';
			$this->action = $this->get['process'];
			
		} else {
			
			//default view;
			$this->action_type = 'template';
			$this->action = 'default';
			
		}
	}
	
	//Called to instantiate our controller and call the action.
	
	public function callAction(){
		
		//Check that the method exists before we call
		if (method_exists($this, $this->action_type)){
			$this->{$this->action_type}();	
		} else {
			
			
		}
			
	}
	
	public function api(){
	
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}
		
		//example url: index.php?process=user_register
		$destination_file = dirname(dirname(__FILE__)).'/controller/api/' . $this->get['api_request'] . '.php';	
		
		
		if ($this->user->hasPermission($this->get['api_request'])){
			
			
			
			if (file_exists($destination_file)){
				
				
				//otherwise see if a file exists
				include ($destination_file);
			
			} else if (
				isset($this->entity_name_1)
				&& isset($this->entity_name_2)
				&& isset($this->entity_action)
				){
					//try the enity_entity dynamic controllers next
					if(method_exists($this,'entity_entity_'.$this->entity_action)){
						$method = 'entity_entity_'.$this->entity_action;
						$this->$method($this->entity_name_1,$this->entity_name_2);
					}	
			} else if (
				isset($this->entity_name_1)
				&& isset($this->entity_action)
				){
					//try the entity dynamic controllers next
					if(method_exists($this,'entity_'.$this->entity_action)){
						$method = 'entity_'.$this->entity_action;
						$this->$method($this->entity_name_1);
					}
			
			} else  {
				echo 'no found';
				SetError('Controller Not Found.');
			}
			
			
			
			
		} else {		
			
			SetError('You do not have permission for this area');

		}
	}
	
	
	public function process(){
		
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}
		
		//example url: index.php?process=user_register
		$destination_file = dirname(dirname(__FILE__)).'/controller/' . $this->get['process'] . '.php';	
		
		
		if ($this->user->hasPermission($this->get['process'])){
			
			if (file_exists($destination_file)){
						
				//otherwise see if a file exists
				include ($destination_file);
			
			} else if (
				isset($this->entity_name_1)
				&& isset($this->entity_name_2)
				&& isset($this->entity_action)
				){
					//try the enity_entity dynamic controllers next
					if(method_exists($this,'entity_entity_'.$this->entity_action)){
						$method = 'entity_entity_'.$this->entity_action;
						$this->$method($this->entity_name_1,$this->entity_name_2);
					}	
			} else if (
				isset($this->entity_name_1)
				&& isset($this->entity_action)
				){
					//try the entity dynamic controllers next
					if(method_exists($this,'entity_'.$this->entity_action)){
						$method = 'entity_'.$this->entity_action;
						$this->$method($this->entity_name_1);
					}
			
			} else  {
				
				SetError('Controller Not Found.');
			}
		} else {		
			
			SetError('You do not have permission for this area');

		}
		
		//Always go back to where we came from
		if(empty(headers_list()) || !headers_sent()){
				
			//echo GetErrors();
			header ('location: '.$_SERVER['HTTP_REFERER']);
		}
	}
	
	public function template(){
				
		//example url: index.php?pg=repairs
		$template = new baseTemplate($this);
		
		//perform the default action
		if($this->action=='default'){
		
			$template->renderDefault('home');
		
		} else if ($this->user->hasPermission($this->get['pg']."_view")){
				
			$template->renderDefault($this->get['pg']);
			
		} else {
				
			$template->renderDefault('default');
			SetError('You do not have permission for this area');
		
		}
	
	}
	
	
	
	//Catch unknown action calls with the magic method
	public function __call($name,$args){
		
		//print_r($this);
		//disect the url
		//echo $name. '__Call'.print_r($args);
	}

	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	public function entity_create($entity_name){
			
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}	
		
		$entities_name = inflector::pluralize($entity_name);
		
		//$session->form = clean_array($connx,$_POST);
		$_{$entities_name} = new $entities_name();
		$_{$entities_name}->SetSTMTSql("SELECT * FROM $entity_name WHERE name = '".$this->post['name']."'");    
		$_{$entities_name}->OpenEntities();
		if(isset($_{$entities_name}->entities[0])){SetError('The '.$entity_name.' "'.$this->post['name'].'" already exists');}
		$hooks->do_action($entity_name."_create_pre");
		${$entity_name}->validate($this->post);
		
		
		
		if(!GetIsError()){
			${$entity_name} = New $entity_name();
			$hooks->do_action($entity_name."_create_mid");
			${$entity_name}->setPropertiesFromArray($this->post);
			
			${$entity_name}->setBelongsToMany(TRUE); // allow to belong to many users
			${$entity_name}->setHasMany(TRUE); // allow to have many permissions
			
			if($entity_name == 'media'){
				${$entity_name}->upload();
			}
			
			//Find the relationships of the entity being created, then create links for
			//each entity that is open
			//re-open entities to see changes live in the session
			//TODO: we need to prevent acting on objects in the company domain when a company is not open
			foreach (${$entity_name}->config['associations']['has'] as $name){
				if(isset(${$name}->id)){
					
					${$entity_name}->setHas(${$name}->id,$name);
					${$name}->open(${$name}->id);
				}	
			}	
			foreach (${$entity_name}->config['associations']['belongsTo'] as $name){
				if (isset(${$name}->id)){
						
					${$entity_name}->setBelongsTo(${$name}->id,$name);
					${$name}->open(${$name}->id);
				}
			}
			
			$entity_id = ${$entity_name}->save();
			$hooks->do_action($entity_name."_create_post",${$entity_name});
		}
		//echo json_encode($card);
		unset($_{$entities_name});	
		
		echo GetErrors();
		
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function entity_delete($entity_name){
		
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}	
		
		if($user->hasPermission($entity_name."_delete")){
	
			//append the form data to the session
			${$entity_name} = New $entity_name();
			${$entity_name}->open($this->get[$entity_name.'_id']);
			$hooks->do_action($entity_name."_delete_pre",${$entity_name});
			
			//remove all child links
			foreach(${$entity_name}->has as $child){
				${$entity_name}->removeHas($child["id"],$child["entity"],$child["dbname"]);
			}
			//remove all parent links
			foreach(${$entity_name}->belongs_to as $parent){
				${$entity_name}->removeBelongsTo($parent["id"],$parent["entity"],$parent["dbname"]);
			}
			$hooks->do_action($entity_name."_delete_post",${$entity_name});
			${$entity_name}->delete();
		
		}

	}
//*****************************************************************************
	public function entity_remove($entity_name){
		
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}	
			
		if($user->hasPermission($entity_name."_remove")){
			//append the form data to the session
			${$entity_name} = New $entity_name();
			${$entity_name}->open($this->post[$entity_name.'_id']);
			${$entity_name}->remove();
			$hooks->do_action($entity_name."_remove");
		}

	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function entity_entity_link($entity_a,$entity_b){
		
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}	
		$parent_entity = baseEntity::getParent($entity_a,$entity_b);
		$child_entity = baseEntity::getChild($entity_a, $entity_b);
		
		//	echo "P:" . $parent_entity .  " C:" . $child_entity;
		if($user->hasPermission(baseEntity::createNodeName($parent_entity, $child_entity).'_link')){
				
			//append the form data to the session
			$_{$parent_entity} = new $parent_entity();
			$_{$parent_entity}->Open($this->get[$parent_entity.'_id']);
			$hooks->do_action(baseEntity::createNodeName($parent_entity,$child_entity).'_link_pre');
			$_{$parent_entity}->setHas($this->get[$child_entity.'_id'],$child_entity);
			$_{$parent_entity}->save();
			${$parent_entity}->Open($this->get[$parent_entity.'_id']);
			$hooks->do_action(baseEntity::createNodeName($parent_entity,$child_entity).'_link_post');
		}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public  function entity_entity_unlink($child_entity,$parent_entity){
			
		echo "parent: ".$parent_entity. " child: ".$child_entity;	
			
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}
			
		if($user->hasPermission(baseEntity::createNodeName($parent_entity, $child_entity).'_unlink')){
			//append the form data to the session
			$_{$parent_entity} = new $parent_entity();
			$_{$parent_entity}->Open($this->get[$parent_entity.'_id']);
			$hooks->do_action(baseEntity::createNodeName($parent_entity,$child_entity).'_unlink_pre');
			$_{$parent_entity}->removeHas($this->get[$child_entity.'_id'],$child_entity,baseEntity::getOrigin($child_entity));
			$hooks->do_action(baseEntity::createNodeName($parent_entity,$child_entity).'_unlink_post');
			$_{$parent_entity}->save();
			${$parent_entity}->Open($this->get[$parent_entity.'_id']);
			
		}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function entity_entity_add($parent_entity,$child_entity){
			
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}	
			
		if($user->hasPermission(baseEntity::createNodeName($parent_entity, $child_entity).'_add')){
			
			${$child_entity}->validate($this->post);
			if(!$parent_entity::isLoggedIn()){
				SetError('No '.$parent_entity.' is logged in');
			}
			if(!GetIsError()){
				${$child_entity} = New $child_entity();
				${$child_entity}->setPropertiesFromArray($this->post);
				${$child_entity}->setBelongsToMany(TRUE); // allow a role to belone to many users
				${$child_entity}->setHasMany(TRUE); // allow to have many permissions
				${$child_entity}->save();
				$hooks->do_action(baseEntity::createNodeName($parent_entity,$child_entity).'_add_pre',$child_entity);
				${$child_entity}->setBelongsTo(${$parent_entity}->id, $parent_entity);
				$hooks->do_action(baseEntity::createNodeName($parent_entity,$child_entity).'_add_post',$child_entity);
				${$parent_entity}->open(${$parent_entity}->id);
			}
		}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public  function entity_entity_edit($parent_entity,$child_entity){
			
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}	
		$entity_name = baseEntity::createNodeName($parent_entity, $child_entity);
		if($user->hasPermission(baseEntity::createNodeName($parent_entity, $child_entity).'_edit')){
			
			//${$entity_name}->validate($this->get);
			if(!GetIsError()){
				$_{$entity_name} = New $entity_name();
				$_{$entity_name}->OpenByCompositeId($this->get[$parent_entity.'_id'],$parent_entity,$this->get[$child_entity.'_id'],$child_entity);
				$_{$entity_name}->setPropertiesFromArray($this->get);
				$hooks->do_action(baseEntity::createNodeName($parent_entity,$child_entity).'_edit',$_{$entity_name});
				$_{$entity_name}->save();
			}
			
		}

	}		
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function entity_search($entity_name){
		
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}	
	
		if($user->hasPermission($entity_name.'_search')){
			//append the form data to the session
			//$session->form = clean_array($connx,$_POST);
			//$session->url = clean_array($connx,$_GET);
			$search_col = $this->post['field'];
			$search_phrase = $this->post['search_phrase'];
			$entities = inflector::pluralize($entity_name);
			${$entities}->SetPage(1);
			${$entities}->SetSTMTSqlNoLimit("SELECT * FROM ".$entity_name." WHERE ".$search_col." LIKE '%".$search_phrase."%'");
			
			${$entities}->OpenEntities(TRUE);
			
			
			//go back to form.
			$hooks->do_action($entities.'_search',${$entities});
			
		}
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function entity_edit($entity_name){
			
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}		
			
		if($user->hasPermission($entity_name.'_edit')){
			
			${$entity_name}->validate($this->post);
			if(!GetIsError()){
				${$entity_name} = New $entity_name();
				${$entity_name}->open($this->post['id']);
				${$entity_name}->setPropertiesFromArray($this->post);
				$hooks->do_action($entity_name.'_edit',${$entity_name});
				${$entity_name}->save();
			}
			
			//unset($_'.inflector::pluralize($entity_name).');	
			
		}
	}
	
	
	
	
}

?>