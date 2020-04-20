<?php
class htmls extends baseTable{
	
	public function renderByName($name){
		$html = New html();
		$html->OpenByName($name);
		$this->render($html->id);
	}
	
	//renders an HTML parent, encapsulating all of its children
	public function render($id){
		
		if(empty($id) || !isset($id)){return;};
		
		$html = New html();
		$html->Open($id);
		
		$rand = rand(0, 9999999);
		//print_r($ html);
		//Render
		//echo '<'.$html->tag.' id="'.$html->tag.'_'.$html->id.'_'.$rand.'" class="';
		echo '<'.$html->tag.' id="'.$html->tag.'_'.$html->id.'" class="';
			//Add classes
			foreach($html->class as $k){
				echo $k . ' '; //follow each class with a space
				
			}
		echo '" ';
			//print attributes to the page
			foreach($html->attributes as $k=>$v){
				echo $k .'="'.$v. '" ';
			}	
		
		//Close the opening tag
		echo '>'.$html->text;
	
		foreach($html->getHas() as $k){
			if($k['entity'] == 'html'){
				//Only render children than are html
				//recursive...
				$this->render($k['child_id']);	
			}
		}
		//close
		echo '</'.$html->tag.'>';
		
		//echo the child scripts this html element
		unset($html);
	}
	
	public function renderScripts($id){
			
		$html = New html();
		$html->Open($id);
		
		//get and render	
		foreach($html->getHas() as $k){
			if($k['entity'] == 'js_script'){
				$js = New js_script();
				$js->open($k['child_id']);
				$js->render();
			}
			//recursivly get html children and render thier scripts
			if($k['entity'] == 'html'){
				$this->renderScripts($k['child_id']);
			}
		}	
	}
	public function renderScriptsByName($name){
			
		$html = New html($this->connx);
		$html->OpenByName($name);
		
		//get and render	
		foreach($html->getHas() as $k){
			if($k['entity'] == 'js_script'){
				//create and open a new js script, render it	
				$js = New js_script();
				$js->open($k['child_id']);
				$js->render();
			}
			//recursivly get html children and render thier scripts
			if($k['entity'] == 'html'){
				$this->renderScripts($k['child_id']);
			}
		}
	}
}
?>