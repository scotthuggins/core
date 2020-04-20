<?php
	//include the default modal 
	include(dirname(__FILE__)."/modal.php");
	 
?>
		
<div id="paginationSpace" class="row m-0">
	<div id="<?php echo $entity_name; ?>" class="col-12 entity_name ">
	<div id="<?php echo ${$plur_entity}->page_current; ?>" class="current_page">
	<div id="<?php echo ${$plur_entity}->page_count; ?>" class="page_count">
<!-- Begin Deck Here -->
		<div data-spy="scroll" data-target="#carousel-inner" data-offset="0"  class="row search_result_primary_<?php echo $entity_name; ?>">
  			
  			
  
		    <?php
		   
		    
			if(isset(${$plur_entity}->config['defaultDataView'])
			&& ${$plur_entity}->config['defaultDataView'] == "Tiles"){
				
				$entities = ${$plur_entity};
				include(dirname(dirname(__FILE__)).'/default/dataview_tiles.php');
			}
			elseif( isset(${$plur_entity}->config['defaultDataView'])
			&& ${$plur_entity}->config['defaultDataView'] == "Table"){
				$entities = ${$plur_entity};
				include(dirname(dirname(__FILE__)).'/default/dataview_table.php');
			}
			 else {
				$entities = ${$plur_entity};
				include(dirname(dirname(__FILE__)).'/default/dataview_tiles.php');
			}
			?>
		</div>
	</div>
</div>		