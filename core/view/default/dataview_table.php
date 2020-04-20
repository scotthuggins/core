<?php
echo '
<div class="row w-100 page_segment" id="page_segment_'.${$plur_entity}->page_current.'">
<div class="w-100 bg-dark rounded p-1 m-1"><h2 class="text-center text-white">Page: '.${$plur_entity}->page_current.'</h2></div>
<table  class="w-100 table table-striped table-sm table-responsive-xs">';
		
		//Loop the entities children of this type child type
		$cnt = 0;
		
		
		foreach($entities->entities as $entity){
			$cnt++;
			//if first iteration, create the header from the primary display fields
			if($cnt == 1){
				//Create the actions col
				echo '<th>Actions</th>';
				//Add the child primary Header names
				 foreach($entity->config['primaryViewProperties'] as $headerTitle){
				 	echo '<th>'.html_helper::cleanText($headerTitle).'</th>';
				 }
			}
			echo '<tr><td >';
	
			echo '<div class="d-flex align-items-start">';
			
			
			echo '<div style="max-width:150px;max-height:200px;" class="img-fluid float-left m-1 overflow-hidden responsive">';
			
			$hooks->do_action($entity->class_name.'_table_viewport',$plur_entity);
			include(dirname(dirname(__FILE__))."/default/write_media_module_dynamic.php");
			echo '</div>';
			
			
			//ACTION BUTTONS
			if($user->hasPermission($entity->class_name.'_edit')){
				
				echo '<button id="editChildButton_'.$entity->class_name.'_'.$entity->id.'" class="float-left editChildButton btn btn-primary border" >Edit</button>';
			}
			if($user->hasPermission($entity->class_name.'_edit')){
				echo '<button id="editChildButton_'.$entity->class_name.'_'.$entity->id.'" class="float-left editChildButton btn btn-primary border" >View</button>';
			}
			echo '</div>';
			
			$hooks->do_action($entity->class_name.'_card_top',"");
			$hooks->do_action('card_top',"");
			
			//if($user->hasPermission( baseEntity::createNodeName($child_entity->class_name, $parent) . '_link')){
			//	echo '<div>
			//	<button id="linkChildButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left linkChildButton btn btn-success border" >Add</button>
			//</div>';
			//}  
			echo '</td>';		
			
	
			//Add childs primary view properties
			foreach($entity->config['primaryViewProperties'] as $property){
				 	echo '<td>'.html_helper::cleanText($entity->$property).'</td>';
				 }
			$hooks->do_action($entity->class_name.'_card_bottom',"");
			$hooks->do_action('card_bottom',"");
			
			echo '</tr>';
		}
		//Close the table
		echo '</table>
		</div>';
		
?>