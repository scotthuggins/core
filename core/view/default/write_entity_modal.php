<?php
     echo '<!-- Modal Header -->
      <div class="modal-header p-0 m-0 bg-secondary">
        <h4 class="modal-title m-2 text-light text-capitalize"></h4>
        <button type="button" class="close btn closeModalButton m-0 " data-dismiss="modal"><span class="text-light">&times;</span></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" style="overflow-y;overflow-y:scroll">
      
      <!-- Place Media Div -->
      <div class="row">
	  <div class="col-sm-12 col-md-4 modal_media_content scrolling-y" style="max-height:900;">';
	  
	  $hooks->do_action($entity_name.'_modal_viewport',$entity_object);
	  
	  echo '</div>
	  
	  
	  
	  ';
	  
	  //$code = $code . '<div class="col-12 col-md-4">' . html_helper::write_node_module($entity_name) . '</div>';
	  echo '<div class="col-sm-12 col-md-4">';
	  	if ($user->hasPermission($entity_name.'_edit')){
	  		include(dirname(dirname(__FILE__)).'/forms/'.$entity_name.'_edit.php');
		} else {
			
			echo '<ul class="list-group m-2">';
			foreach($entity_object->config['primaryViewProperties'] as $property){
				echo '<li class="list-group-item"><b>'.html_helper::cleanText($property).':</b> '.$entity_object->$property.'</li>';
			}
			echo '</ul>';
		}
		
	  	
	  	 
	  echo '</div>';
	  echo '<div class="col-sm-12 col-md-4">';
	  
	  include(dirname(dirname(__FILE__)).'/default/write_holder_module.php');
	  echo '</div>';
	  echo '</div>';
	  //Create row for node and linking modules
	  echo '<div class="row py-3">';	
	  
	  echo '<div class="col-sm-12 ">';
	  
	  	include(dirname(dirname(__FILE__)).'/default/write_links_module.php');
			  
	   //. html_helper::write_links_module($entity_name) . '</div>';
	  
	  
	  echo '</div>';
	  //end row for node and linking modules
	  
	  //$prop = get_object_vars($entity_object);
				
	 // foreach($prop as $k=>$v){
	//	if(in_array($k,baseEntity::getFormIgnoreList())){continue;}
	 // 	$code = $code . '<b>'.$k.':</b><span class="'.$entity_name.'_'.$k.'"></span></br>';
	  //}
	  
       
      echo '</div>

      <!-- Modal footer -->
      <div class="modal-footer p-0 m-0">
        <button type="button" class="p-1 m-1 btn btn-danger closeModalButton" data-dismiss="modal">Close</button>
      </div>
<!--
    </div>
  </div>
</div>
-->		
		';
?>		