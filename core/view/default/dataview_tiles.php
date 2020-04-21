<?php	
echo '<div class="row page_segment w-100 " id="page_segment_'.${$plur_entity}->page_current.'">
<div class="col-12 bg-dark rounded p-1 m-1"><h2 class="rounded text-center text-white">Page: '.${$plur_entity}->page_current.'</h2></div>
';
	
		$cnt=0;
		foreach($entities->entities as $entity){
			$cnt++;
			$entity_name = $entity->class_name;
			
		
			echo '
				
				<div  class="col-12 col-md-3 p-2 ">
				<div class="card">
				<div class="card-header p-2"><b class="mb-2">'.form_helper::cleanText($entity->config['primaryIDProperty']).' - <span class="'.$entity->class_name.'_'.$entity->id.'_'.$entity->config['primaryIDProperty'].'">'. 
				$entity->{$entity->config["primaryIDProperty"]}. '</span></b>
				
				<p class="hidden entity_id" style="display:none;" >'.$entity->id.'</p>';
				echo '<div class="d-flex align-items-end align-self-stretch mr-auto">';
				if($user->hasPermission($entity_name.'_edit')){
					echo '<button id="'.$entity_name.'_'.$entity->id.'" class="float-right btn btn-primary editModalButton mr-1" type="button" >Edit</button>';
				}
				if($user->hasPermission($entity_name.'_view')){
					echo '<button id="'.$entity_name.'_'.$entity->id.'" class="float-right btn btn-primary editModalButton mr-1" type="button" >View</button>';
				}
				echo '</div>';
				$hooks->do_action($entity_name.'_card_top',"");
				$hooks->do_action('card_top',"");
				
				echo'
				</div><div id="viewport_tile_'.$entity_name.'_'.$entity->id.'" style="max-height:350;"  class="scrolling-y ">';
				$hooks->do_action($entity_name.'_tile_viewport',$entity);
				
				//include(dirname(dirname(__FILE__))."/default/write_media_module_dynamic.php");
				echo '
				</div><div class="">
					<ul class="list-group">
					
				';
				if(isset($entity->config['primaryViewProperties'])){
					foreach($entity->config['primaryViewProperties'] as $property){
						echo '<li class="list-group-item  p-2">' . form_helper::cleanText($property) . ' -   <span class="' . $entity->class_name.'_'.$entity->id.'_'.$property.'"> '.$entity->$property.'<span></li>';
					}
				}

				
				$hooks->do_action($entity_name.'_card_bottom',"");
				$hooks->do_action('card_bottom',"");
				
				echo '</div></div></div>';
		}
	echo '</div>';		
?>		