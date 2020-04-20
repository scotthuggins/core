<?php
		
		echo '<table class="w-100 table table-striped table-sm table-responsive-xs">';
		
		//Loop the entities children of this type child type
		$cnt = 0;
		
		
		foreach($entities->entities as $child_entity){
			$cnt++;
			//if first iteration, create the header from the primary display fields
			if($cnt == 1){
				//Create the actions col
				echo '<th>Actions</th>';
				//Add the child primary Header names
				 foreach($child_entity->config['primaryViewProperties'] as $headerTitle){
				 	echo '<th>'.html_helper::cleanText($headerTitle).'</th>';
				 }
			}
			echo '<tr><td>';
	
			
			//ACTION BUTTONS
			if($user->hasPermission($child_entity->class_name.'_edit')){
				echo '<div>
					<button id="editChildButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left editChildButton btn btn-secondary border" >Edit</button>
				</div>';
			}
			//echo "????".$child_entity->class_name ."::".$this->get['calling_class'];
			if($user->hasPermission( baseEntity::createNodeName($child_entity->class_name,$this->get['calling_class']) . '_link')){
				echo '<div>
				<button id="linkChildButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left linkChildButton btn btn-success border" >Add</button>
			</div>';
			}
			
			$hooks->do_action('link_child_search_action',"");
			$hooks->do_action($child_entity->class_name.'_link_child_search_action',"");
			
			echo '</td>';		
			
	
			//Add childs primary view properties
			foreach($child_entity->config['primaryViewProperties'] as $property){
				 	echo '<td>'.html_helper::cleanText($child_entity->$property).'</td>';
				 }
			
			echo '</tr>';
		}
		//Close the table
		echo '</table>';
?>