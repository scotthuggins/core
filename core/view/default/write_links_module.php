<?php

	echo '
	<div class="card">
    <div class="card-header">
      <button class="btn border border-warning w-100" data-toggle="collapse" data-target=".link_content">
        Links
      </button>
    </div>
    <div id="" class="link_content collapse show " data-parent="#accordion">
      <div class="card-body p-0">
        
		<div class="linkListContainer">';
		
		
		foreach($entity_object->config['associations']['has'] as $name){
			
				
			echo '
			<div>
			 	<div class="w-100 d-flex d-row p-1">
			 	
        			<span class="mr-auto w-100 btn border text-capitalize" data-toggle="collapse" data-target=".link_child_content_'.$name.'">'.inflector::pluralize(${$name}->getPublicName()).'</span>
        			<button class="ml-auto btn border" data-toggle="collapse" data-target=".link_child_create_form_'.$name.'">
        			Add '.html_helper::cleanText(${$name}->getPublicName()).'
        			</button>
        			
      			</div>    
				<div id="" class="link_child_create_form_'.$name.' w-100 collapse" >';
				
					include(dirname(dirname(__FILE__)).'/forms/'.$name .'_create.php');
					//.writer::entity_create_form($name).
					
				echo '</div>		
			</div>
			<div id="callingclass_'.$entity_object->class_name.'" class="link_child_content_'.$name.' collapse" >
				
			</div>
			';
			
		}
		
	     //Close the node container   
		echo '
		</div>
      </div>
    </div>
  </div>
		';
?>