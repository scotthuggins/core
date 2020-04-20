<?php 

class baseTemplate{
	
	public $file_dir;
	public $template_name;
	public $controller;
	public $entity_name;
	public $plur_entity;
	
	public function __construct($controller){
		global $global_objects;
		$this->file_dir = VIEWS_DIRECTORY;
		$this->controller = $controller;
		$this->entity_name = "";
		$this->plur_entity = "";
	}
	
	public function setFileDir($file_dir){
		$this->file_dir = $file_dir;
	}
	
	public function setTemplate($template_name){
		$this->template_name = $template_name;
	}
	
	public function importModule($file_name){
		global $global_objects, $hooks;	
		if(file_exists($this->file_dir .'/'. $file_name .'.php')){
			include($this->file_dir .'/'. $file_name .'.php');
		}
	}
	
	public function render($file_name){
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}
		
		if(file_exists($this->file_dir .'/'. $file_name .'.php')){
			include($this->file_dir .'/'. $file_name .'.php');
		}
	}
	
	public function renderDefault($file_name){
		global $global_objects, $hooks;	
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}
		
		
		//determine the entity name
		if (isset(${$file_name}) && is_object(${$file_name})){
			
			$entity_name = $this->entity_name = inflector::singularize($file_name);
			$plur_entity = $this->plur_entity = $file_name;
			
		}
		
		$this->getJavaScript();
		$this->openHeader();
		$this->getToast();
		$this->getMenu();
		
		//open container
		echo '<div class="container-fluid">';
		
		//include the file first
		if (file_exists($this->file_dir .'/'. $file_name .'.php')){
			include($this->file_dir .'/'. $file_name .'.php');
		} elseif (is_object(${$file_name})){
			include(dirname(dirname(__FILE__)).'/view/default/write_entities.php');
		}
		
		$this->getFooter();
		//close container
		echo '</div>';
		$this->closeHeader();
	}
	
	public function getMenu(){
		global $global_objects, $hooks;
		
		
		$entity_name = $this->entity_name;
		$plur_entity = $this->plur_entity;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}
		
		include(dirname(dirname(__FILE__)).'/view/default/menu.php');
	}
	
	public function getToast(){
		global $global_objects;
		
		//include footer
		include(dirname(dirname(__FILE__)).'/view/default/toast.php');
	}
	
	public function getFooter(){
		global $global_objects;
		
		//include footer
		include(dirname(dirname(__FILE__)).'/view/footer.php');
	}
	
	public function openHeader(){
		
		echo '<!DOCTYPE HTML><html>
		<link rel="icon" href="photos/sol.png">
		<title>'. SITE_NAME . ' - ' . html_helper::cleanText($this->controller->action).'</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<body>
    	<!--<div class="container-fluid">-->';
	}
	
	public function closeHeader(){
		echo '<!--</div>--></body></html>';
	}
	
	
	public function getJavaScript(){
		
		if (file_exists(dirname(dirname(__FILE__)).'/js/'.$this->controller->entity_name.'.js')){
			echo '<script src="./core/js/'.$this->controller->entity_name.'.js"></script>';
		}
	
		//if it exists, include the node js
		if (isset($pg_word[1])){
			if(file_exists(dirname(dirname(__FILE__)).'/js/'.$this->controller->entity_name.'.js')){
				echo '<script src="./core/js/'.$this->controller->entity_name.'.js"></script>';
			}
		}
	
		//Open a HTML DOC response
		include(dirname(dirname(__FILE__)).'/setup/jsheaders.php');
	}
}

?>