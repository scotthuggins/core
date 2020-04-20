<?php
		
		$temp_user = $user;	
		$entity = new $entity_name();
		$entity->open($entity_id);
		$dummy_child_entity = new $child_entity_name();
		
		if($temp_user->hasPermission($child_entity_name."_search")){
			include(dirname(dirname(__FILE__)).'/forms/'.$child_entity_name.'_search.php');
		}
		echo '<div class="search_result_'.$child_entity_name.'"><table class="w-100 table table-striped table-sm table-responsive-xs"></table></div>';
		
		//Determine if we have nodes before we create the table
		$hasNode = baseEntity::hasNode($entity_name,$child_entity_name);
		//Determin the node Entity Name
		if($hasNode){$nodeEntityName = baseEntity::createNodeName($entity_name,$child_entity_name);}
		
		//Start the code by creating a table
		
		echo'<table id="link_child_table_'.$child_entity_name.'" class="w-100 table table-striped table-sm table-responsive-">';
		
		
		//Create the actions col
		echo'<th>Actions</th>';
		//Add the child primary Header names
		 foreach($dummy_child_entity->config['primaryViewProperties'] as $headerTitle){
		 	echo'<th>'.html_helper::cleanText($headerTitle).'</th>';
		 }
		//if there is a node, add it's properties...
		if($hasNode){
			$node_entity = new $nodeEntityName();
			foreach($node_entity->config['primaryViewProperties'] as $headerTitle){
				echo'<th>'.html_helper::cleanText($headerTitle).'</th>';
			}
		}
		
		
		foreach($entity->getHasByEntity($child_entity_name) as $child_entity){
			
			echo'<tr><td>';
			//ACTION BUTTONS
			if($temp_user->hasPermission($child_entity_name."_edit")){
				echo'<div>
					<button id="editChildButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left editChildButton btn btn-secondary border" >Edit</button>
				</div>';	
			}
			
			if($temp_user->hasPermission(baseEntity::createNodeName($child_entity->class_name,$entity_name)."_unlink")){
				echo'<div>
					<button id="unlinkButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left unlinkChildButton btn btn-warning border" >Remove</button>
				</div>';
			}
			
			if($hasNode && $temp_user->hasPermission($nodeEntityName."_edit")){
				echo'<div>
					<button id="_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left updateChildButton btn btn-primary border">Update</button>
				</div>';
			}			
			echo'</td>';

		foreach($child_entity->config['primaryViewProperties'] as $property){
				 	echo'<td>'.html_helper::cleanText($child_entity->$property).'</td>';
				 }
			//if the child has a node, add it's properties
			$cnt = 0;
			if($hasNode){
				$cnt++;
				if($cnt == 1){
					//make the node edit form
					//echoform_helper::write_form_start_inline($nodeEntityName.'_edit',$nodeEntityName);					
				}
				$node_entity = new $nodeEntityName();
				$node_entity->OpenByCompositeId($entity_id,$entity_name,$child_entity->id,$child_entity_name);
				
				foreach($node_entity->config['primaryViewProperties'] as $property){
					echo'<td><input id="'.$entity_id.'_'.$entity_name.'_'.$child_entity->id.'_'.$child_entity_name.'_'.$property.'" class="form-control" value="'.html_helper::cleanText($node_entity->$property).'"></input></td>';
				}
			
			}
			echo'</tr>';
		}
		//Close the table
		echo'</table>';
		
?>