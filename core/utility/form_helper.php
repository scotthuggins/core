<?php

class form_helper{
//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_form_start($action,$id_prefix,$show_errors=TRUE,$encode = FALSE){
		
		if($encode){$code = '<form class="form form-horizontal" id="'.$id_prefix.'" role="form" method="post" enctype="multipart/form-data" action="index.php/?process='.$action.'">';}
		else{$code = '<form class="form form-horizontal" id="'.$id_prefix.'" role="form" method="post" action="index.php/?process='.$action.'">';}
		if($show_errors){$code = $code.'<div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div>';}
		return $code;
		
	}
	// encode used for file create forms
	static public function write_form_start_inline($action,$id_prefix,$show_errors=TRUE,$encode = FALSE){
		$actions = explode("_", $action);
		if($encode){$code = '<form class="form form-horizontal form-inline" id="'.$id_prefix.'" role="form" method="post" enctype="multipart/form-data" action="index.php/?process='.$action.'">';}
		else{$code = '<form class="form form-horizontal form-inline '.$actions[1].'-form " id="'.$id_prefix.'" role="form" method="post" action="index.php/?process='.$action.'">';}
		if($show_errors){$code = $code.'<div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div>';}
		return $code;
	}
//++++++++++++++++++++++++++++++++++++++++++++
	static public function write_form_end(){
		return '</form>';
	}
//++++++++++++++++++++++++++++++++++++++++++++
	static public function write_submit_button($action,$entity_name,$id_prefix){
		if (class_exists($entity_name)){	
			$entity_object = new $entity_name();
			$entity_name = $entity_object->getPublicName();	
		}	
		if ($action == 'Search'){
			return '<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="'.$id_prefix.'" class="btn btn-secondary"><i class="fas fa-search fa-2x"></i></button>
		    </div>
	  		</div>';
		}			
				
			
		return '
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="'.$id_prefix.'" class="btn btn-primary">'.form_helper::cleanText($action).' '.form_helper::cleanText($entity_name).'</button>
		    </div>
	  	</div>';
	}			
//+++++++++++++++++++++++++++++++++++++++++++
	/* Writes a text form field with passed value
	 * 
	 */
	static public function write_text_with_value($entity,$property,$value,$id_prefix,$hidden=FALSE,$label=TRUE){
		
		if (class_exists($entity)){	
			$entity_object = new $entity();
			$entity = $entity_object->getPublicName();	
		}		
			
		if($hidden){$code = '<input hidden type="text" class="form-control" name="'.$property.'" value="'.$value.'" id="'.$property.'" placeholder="'.form_helper::cleanText($property).' of the new '.$entity.'" autocomplet="off" autofocus="on">';}	
		else{$code = '<div class="form-group">';
			if($label){$code = $code . '<label class="control-label col-12" for="'.$property.'">'.form_helper::cleanText($property).':</label>';}
				$code = $code . '
					<div class="col-12">
						<input type="text" class="form-control" id="'.$id_prefix.'" name="'.$property.'" value="'.$value.'" id="'.$property.'" placeholder="'.form_helper::cleanText($property).' of the new '.$entity.'" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		';
  		}	
		return $code;	
	}
	
//+++++++++++++++++++++++++++++++++++++++++++
	static public function write_text($entity,$property,$id_prefix,$hidden=FALSE){
		
		//Used for public names
		if (class_exists($entity)){	
			$entity_object = new $entity();
			$publicName = $entity_object->getPublicName();	
		}	
		
		if($hidden){$code = '<input hidden type="text" class="form-control '.$entity.'_'.$property.'" name="'.$property.'" value="<?php if(isset($session->form[\''.$property.'\'])){echo $session->form[\''.$property.'\'];}?>" id="'.$property.'" placeholder="'.form_helper::cleanText($property).' of the new '.$publicName.'" autocomplet="off" autofocus="on">';}	
		else{$code = '<div class="form-group">
    				<label class="control-label col-12" for="'.$property.'">'.form_helper::cleanText($property).':</label>
					<div class="col-12">
						<input type="text" class="form-control '.$entity.'_'.$property.'  " id="'.$id_prefix.'" name="'.$property.'" value="<?php if(isset($session->form[\''.$property.'\'])){echo $session->form[\''.$property.'\'];}?>" placeholder="'.form_helper::cleanText($property).' of the new '.$publicName.'" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		';
  		}	
		return $code;	
	}
	
	
	static public function write_text_BACKUP($entity,$property,$id_prefix,$hidden=FALSE){
		if($hidden){$code = '<input hidden type="text" class="form-control" name="'.$property.'" value="<?php if(isset($session->form[\''.$property.'\'])){echo $session->form[\''.$property.'\'];}?>" id="'.$property.'" placeholder="'.form_helper::cleanText($property).' of the new '.$entity.'" autocomplet="off" autofocus="on">';}	
		else{$code = '<div class="form-group">
    				<label class="control-label col-12" for="'.$property.'">'.form_helper::cleanText($property).':</label>
					<div class="col-12">
						<input type="text" class="form-control" id="'.$id_prefix.'" name="'.$property.'" value="<?php if(isset($session->form[\''.$property.'\'])){echo $session->form[\''.$property.'\'];}?>" placeholder="'.form_helper::cleanText($property).' of the new '.$entity.'" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		';
  		}	
		return $code;	
	}
//+++++++++++++++++++++++++++++++++++++++++++++++	
	static public function write_number($entity,$property,$id_prefix,$hidden=FALSE){
		
		//Used for public names
		if (class_exists($entity)){	
			$entity_object = new $entity();
			$publicName = $entity_object->getPublicName();	
		}
		
		if($hidden){$code = '<input hidden type="number" class="form-control" name="'.$property.'" value="<?php if(isset($session->form[\''.$property.'\'])){echo $session->form[\''.$property.'\'];}?>" id="'.$property.'" placeholder="'.form_helper::cleanText($property).' of the new '.$publicName.'" autocomplet="off" autofocus="on">';}	
		else{$code ='<div class="form-group">
    				<label class="control-label col-12" for="'.$property.'">'.form_helper::cleanText($property).':</label>
					<div class="col-12">
	  					<input type="number" class="form-control" id="'.$id_prefix.'" name="'.$property.'" value="<?php if(isset($session->form[\''.$property.'\'])){echo $session->form[\''.$property.'\'];}?>" placeholder="'.form_helper::cleanText($property).' of the new '.$publicName.'" autocomplet="off" autofocus="on">
					</div>
  				</div>
  				';
		}	
		return $code;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_month($entity,$property,$id_prefix,$use_label = TRUE,$hidden=FALSE){
		$code = '';	
		if($hidden){$code = '<select hidden class="form-control" id="'.$id_prefix.'_'.$property.'_month" name="'.$property.'_month">
	      	<?php
				foreach($calendar->getMonths() as $month=>$monthName){
					echo \'<option value="\'.$month.\'">[\'.$month.\'] \'.$monthName.\'</option>\';
				}
	      	?>
			</select>';	
		}
		else{
			if($use_label){$code = '<label class="control-label col-12">'.form_helper::cleanText($property).'</label>';}	
			$code = $code .'
				<div class="col-12">
				<select class="form-control" id="'.$id_prefix.'_'.$property.'_month" name="'.$property.'_month">
				      	<?php
							foreach($calendar->getMonths() as $month=>$monthName){
								echo \'<option value="\'.$month.\'">[\'.$month.\'] \'.$monthName.\'</option>\';
							}
				      	?>
				</select>	
				</div>
	  		';
		}
  		return $code;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_day($entity,$property,$id_prefix,$use_label = TRUE,$hidden=FALSE){
		$code = '';	
		if($hidden){'	
			<select hidden class="form-control" id="'.$id_prefix.''.$property.'_day" name="'.$property.'_day">
			      	<?php
			      		for($day = 1; $day<=31; $day++ ){
			      			echo \'<option value="\'.$day.\'">\'.$day.\'</option>\';
			      		}
						//foreach($calendar->getMonths() as $month=>$monthName){
						//	echo \'<option value="\'.$month.\'">[\'.$month.\'] \'.$monthName.\'</option>\';
						//}
			      	?>
			</select>';	
		}	
		else{
			if($use_label){$code = '<label class="control-label col-12">'.form_helper::cleanText($property).'</label>';}	
			$code = $code .'	
			<div class="col-12">
			<select class="form-control" id="'.$id_prefix.'_'.$property.'_day" name="'.$property.'_day">
			      	<?php
			      		for($day = 1; $day<=31; $day++ ){
			      			echo \'<option value="\'.$day.\'">\'.$day.\'</option>\';
			      		}
						//foreach($calendar->getMonths() as $month=>$monthName){
						//	echo \'<option value="\'.$month.\'">[\'.$month.\'] \'.$monthName.\'</option>\';
						//}
			      	?>
			</select>	
			</div>';
		}
  		return $code;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_year($entity,$property,$id_prefix,$use_label = TRUE,$hidden=FALSE){
		$code = '';
		if($hidden){$code = '<select hidden class="form-control" id="'.$id_prefix.'_'.$property.'_year" name="'.$property.'_year">
			  <?php
					foreach($calendar->getYearsFromNow(\'5\') as $year){
						echo \'<option value="\'.$year.\'">\'.$year.\'</option>\';
					}
			  ?>
			  </select>';
		}
		else{
			if($use_label){$code = '<label class="control-label col-12">'.form_helper::cleanText($property).'</label>';}	
			$code = $code .'	
			<div class="col-12">
			<select class="form-control" id="'.$id_prefix.'_'.$property.'_year" name="'.$property.'_year">
			  	<?php
					foreach($calendar->getYearsFromNow(\'5\') as $year){
						echo \'<option value="\'.$year.\'">\'.$year.\'</option>\';
					}
			  	?>
			  </select>	
			</div>
			';
		}
		return $code;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_color($entity,$property,$id_prefix,$use_label = TRUE,$hidden=FALSE){
		$code = '';
		if($hidden){$code = '<select hidden class="form-control" id="'.$id_prefix.'_'.$property.'" name="'.$property.'">
			  <?php
					foreach($colors->getPalette("default") as $color => $name){
						echo \'<option value="\'.$color.\'" style="background:#\'.$color.\';">\'.$name.\'</option>\';
					}
			  ?>
			  </select>';
		}
		else{
			$code = $code . '<div class="form-group">';
			if($use_label){$code = $code . '<label class="control-label col-12">'.form_helper::cleanText($property).':</label>';}	
			$code = $code .'	
			<div class="col-12">
			<select class="form-control" id="'.$id_prefix.'_'.$property.'" name="'.$property.'">
			  	<?php
					foreach($colors->getPalette("default") as $color => $name){
						echo \'<option value="\'.$color.\'" style="background:#\'.$color.\';">\'.$name.\'</option>\';
					}
			  	?>
			  </select>	
			</div>
			</div>';
		}
		return $code;
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	static public function write_checkbox($entity_name,$property,$id_prefix,$hidden=FALSE){
		if($hidden){return '<input hidden type="checkbox" class="form-check-input" id="'.$id_prefix.'" name="'.$property.'" value="TRUE">'.$property.'</input>';}
		else{return '<div class="form-check">
	 				<label class="form-check-label col-12">
					    <input type="checkbox" class="form-check-input" id="'.$id_prefix.'" name="'.$property.'" value="TRUE">'.$property.'</input>
					</label>
				</div>
			';
		}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++
static public function write_date($entity_name,$property,$id_prefix,$hidden=FALSE){
	if($hidden){
		$code = form_helper::write_month($entity_name,$property,$id_prefix,FALSE,$hidden);
		$code = $code . form_helper::write_day($entity_name,$property,$id_prefix,FALSE,$hidden);
		$code = $code . form_helper::write_year($entity_name,$property,$id_prefix,FALSE,$hidden);
	}
	else{
		$code = '<div class="form-group"><label class="control-label col-12">'.form_helper::cleanText($property).'</label>';
		$code = $code . form_helper::write_month($entity_name,$property,$id_prefix,FALSE,$hidden);
		$code = $code . form_helper::write_day($entity_name,$property,$id_prefix,FALSE,$hidden);
		$code = $code . form_helper::write_year($entity_name,$property,$id_prefix,FALSE,$hidden);
		$code = $code . '</div>';
	}	
	
	return $code;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_option($property,$array,$id_prefix,$hidden=FALSE){
		if($hidden){$code = '
			<select hidden class="form-control mr-sm-2" id="'.$id_prefix.'_'.$property.'" name="'.$property.'">';
			foreach($array as $k=>$v){
				$code = $code . '<option value="'.$k.'">'.$v.'</option>';
			}
			$code = $code .'</select>';
		}
		else{		
			$code = '<div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="'.$property.'">'.form_helper::cleanText($property).'</label>
					<select class="form-control mr-2 mb-2" id="'.$id_prefix.'_'.$property.'" name="'.$property.'">';
			foreach($array as $k=>$v){
				$code = $code . '<option value="'.$k.'">'.$v.'</option>';
			}
			$code = $code .'</select></div>';
		}
		return $code;		
	}


//++++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_file($entity,$property,$id_prefix,$hidden=FALSE){
		
		//Used for public names
		if (class_exists($entity)){	
			$entity_object = new $entity();
			$publicName = $entity_object->getPublicName();	
		}
		
		if($hidden){$code = '<input hidden type="text" class="form-control '.$entity.'_'.$property.'" name="'.$property.'" value="<?php if(isset($session->form[\''.$property.'\'])){echo $session->form[\''.$property.'\'];}?>" id="'.$property.'" placeholder="'.form_helper::cleanText($property).' of the new '.$publicName.'" autocomplet="off" autofocus="on">';}	
		else{$code = '<div class="form-group">
    				<label class="control-label col-12" for="'.$property.'">'.form_helper::cleanText($property).':</label>
					<div class="col-12">
						<input type="file" class="form-control-file '.$entity.'_'.$property.'  " id="'.$id_prefix.'" name="'.$property.'" value="<?php if(isset($session->form[\''.$property.'\'])){echo $session->form[\''.$property.'\'];}?>" placeholder="'.form_helper::cleanText($property).' of the new '.$publicName.'" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		';
  		}	
		return $code;	
	}
	
//+++++++++++++++++++++++++++++++++++++++++++++++++		
	static public function write_text_area(){}
	
	static public function write_range(){}
	static public function write_radio(){}
	
	
	static public function write_telephone(){}
	
	static public function write_dateTime(){}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public static function get_form_field($entity_name,$property,$id_prefix,$value=""){
		$type = gettype($value);
		if($type == "boolean"){return form_helper::write_checkbox($entity_name,$property,$id_prefix);}
		elseif(substr($property,-4)=='Date'){return form_helper::write_date($entity_name,$property,$id_prefix);}
		elseif(substr($property,-4)=='File'){return form_helper::write_file($entity_name,$property,$id_prefix);}
		elseif(substr($property,-5)=='Month'){return form_helper::write_month($entity_name, $property,$id_prefix);}
		elseif(substr($property,-4)=='Year'){return form_helper::write_year($entity_name, $property,$id_prefix);}
		elseif(substr($property,-5)=='Color'){return form_helper::write_color($entity_name, $property,$id_prefix);}
		
		
		
		elseif(is_numeric($value)){return form_helper::write_number($entity_name,$property,$id_prefix);}
		elseif(!isset($set_type) && $type == "string"){return form_helper::write_text($entity_name,$property,$id_prefix);}
		elseif(!isset($set_type) && $type == "NULL"){return form_helper::write_text($entity_name,$property,$id_prefix);}
		
		return;
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	static public function cleanText($text){
		return ucwords(str_replace( '_', ' ', preg_replace('/(?<!\ )[A-Z]/', ' $0', $text)));
	}
	
	
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	static public function getOptionsArrayFromEntityName($entity_name){
		//get all the possible children and prepare to place into option field
		
		$child_table = inflector::pluralize($entity_name);
		
		
		
		$child = new $child_table();
		$child_single = new  $entity_name();
		$view_field = $child_single->config['primaryIDProperty'];
		$child->SetSTMTSql("SELECT id FROM ".$entity_name);
		$child->OpenEntities();
		$children_array = array();
		//populat the array for the write_option function
		foreach($child->entities as $entity){
			$this_array = array($entity->id => $entity->{$view_field});
			$children_array[$entity->id] = $entity->{$view_field};	
		}
		return $children_array;

	}
	
}
































?>