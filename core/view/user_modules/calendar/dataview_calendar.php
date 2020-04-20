<?php


$entity->openCalendarEntities();

//print_r($entity->calendar_entities);
//echo '<div class="page_segment w-100 " id="page_segment_'.${$plur_entity}->page_current.'">';
//echo '</div>';

?>
<div class="calendar w-100  bg-white p-2 " id="<?php echo 'viewport_' . $entity->class_name . '_' . $entity->id;?>">
	<div class="calendar-header m-1">
		<?php $hooks->do_action('calendar_header',$entity);
		
		//echo $entity->mode;
		//echo $entity->calendar_view_start.'<br>';
		//echo $entity->calendar_view_end;
		?>
    </div>
    
    <?php include('dataview_'.$entity->mode.'.php'); ?>
	
    
    
</div>



		