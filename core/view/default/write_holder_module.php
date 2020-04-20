<?php
echo '
<div class="card">
		<div class="card-header">Actions</div>
		<div class="card-body">';

		if ($user->hasPermission($entity_name.'_delete')){
			
			echo '<button id="'.$entity_name.'_delete" class="float-left btn btn-danger deleteModalButton mr-1" type="button" >Delete</button>';
		}

			
		$hooks->do_action($entity_name.'_actions',$entity_object);
		$hooks->do_action('actions','');
				
		echo '
			
		</div>
		
	</div>';
?>