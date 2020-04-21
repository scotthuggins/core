<?php
		
		
		$media_array = array();
		if(!isset($entity)){
			$entity = new $entity_name();
			$entity->open($entity_id);
		}
		
		
		//$hooks->do_action($entity_name.'_viewport',$plur_entity);
		
		
		//if the parent is a media object, add it to the media array
		if($entity->class_name == 'media'){
			array_push($media_array,$entity);
			
		}
		//if the parent entity has media
		else{
			$media_array = $entity->getHasByEntity('media');
		}
		
		foreach($media_array as $media_obj){
			
			if ($user->hasPermission('user_download')){
				//add a header and download link
				echo '
					<button class="btn btn-dark float-right m-1">
					<a href="'.$media_obj->mediaFile.'" download class="btn-dark"><i class="fas fa-file-download fa-2x "></i></a>
					</button>
				';
			}
			
			
			
			//if we are an image
			if($media_obj->getType() == 'image'){
				echo '<img class="img-fluid mx-auto py-1 p-auto w-100" src="'.$media_obj->mediaFile.'">';
			}
			
			//if we are a audio file
			if($media_obj->getType() == 'audio'){
				echo '
				<audio controls class="img-fluid mx-auto py-1 p-auto  w-100">
				<source src="'.$media_obj->mediaFile.'" type="audio/mpeg">
				
				Your browser does not support the audio element.
				</audio>
				'; 
			}
			
			//if we are a audio file
			if($media_obj->getType() == 'video'){
				echo '
				<video controls class="img-fluid mx-auto py-1 p-auto  w-100">
				<source src="'.$media_obj->mediaFile.'" type="video/mp4">
				
				Your browser does not support the audio element.
				</video>
				'; 
			}
			
			//if we are a audio file
			if($media_obj->getType() == 'pdf'){
				echo '
				<object type="application/pdf" class="img-fluid mx-auto p-auto py-1 h-100 w-100" data="'.$media_obj->mediaFile.'" style="min-height:600;">
				
				
				<p>The PDF cannot be displayed</p>
				</object>
				'; 
			}
			echo ' <div class="dropdown-divider"></div> ';
		}	

		unset($media_array);
		unset($media_obj);
?>
