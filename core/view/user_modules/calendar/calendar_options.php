<?php 

	$time_entities = $this->getEntitiesWithTime();
	$colors = new colors();

?>

<button class="btn btn-warning" type="button" data-target="#calendar_view_select_entities" data-toggle="collapse"  autocomplete="off" >Select Views</button>

<form id="calendar_view_select_entities" class="collapse m-2 mt-3" role="form" method="post" enctype="multipart/form-data" action="index.php/?process=calendar_edit">
	
	<?php
		foreach($time_entities as $name => $properties){
			echo '	<div class="form-group ">
					<button class="btn btn-primary option-content" type="button" data-target="#'.$name.'_fields" data-toggle="collapse"  autocomplete="off" >'. html_helper::cleanText($name) .'</button>
						<div id="'.$name.'_fields" class="collapse mt-2 ml-0">';
						
						
						//add the color otions
						echo '<label for="color"></label>';
						echo '<select class="form-control container" name="viewOptionsColors[]" ';						
							foreach($colors->getPalette("default") as $color => $color_name){
								echo '<option value="'.$name.'-'.$color.'" style="background:#'.$color.';">'.$color_name.'</option>';
							}
						echo '</select>';
						
						
						//add the check box options
						foreach($properties as $property){
							echo '<div class="form-check">
  									<label class="form-check-label container">
    									<input type="checkbox" class="form-check-input '.$this->class_name.'_'.$this->id.'_viewOptions '.$name.'-'.$property.'" name="viewOptions[]" value="'.$name.'-'.$property.'" >'.html_helper::cleanText($property).'
    									<span class="checkmark"></span>
									</label>
								  </div>';
						}
						echo '
						</div>
					</div>
				';
		}
	?>
		<input type="text" class="form-control calendar_id" name="id" value="<?php echo $this->id; ?>" id="id" placeholder="Id of the new calendar" autocomplet="off" autofocus="on" hidden="true">
     
      <div class="form-group">
        <button type="submit" class="btn btn-success">Save Changes</button>
      </div>          
</form>

