

  <div class="d-flex align-items-center"><i class="fa fa-calendar fa-3x mr-3"></i>
    	
      <span class="month font-weight-bold mb-0 text-uppercase"><?php echo date("F d Y",$entity->calendar_time); ?></span>
    </div>
    <div class="calendar-row">
    <table class=" w-100">
    	<thead>
    		<tr>
	    		<?php
	    		
	    		
	    		for ($hour = calendar::getStartOfToday($entity->calendar_time);
					$hour <= calendar::getEndofToday($entity->calendar_time);
					$hour += calendar::getFifteenMinutes()){
						
						
						$display_hours = array("12","3","6","9");
						
						
						$d_hour = date('g',$hour);
						$meridiem = rtrim(date('a',$hour),'m');
						//$display = date('g',$hour).$meridiem;
						$display = "";
						$additional_class = '';
						foreach ($display_hours as $h){
							
							//if the time is allowed and is a zero-second interval	
							if($h == $d_hour && date('i',$hour)=='00'){
								$display = date('g',$hour).$meridiem;
								$additional_class = 'border-left';
								break;
							}
						}
						
						
						echo '<th class="'.$additional_class.' hour week calendar-hour font-weight-bold overflow-hidden">'.$display.'</th>';
					}
					
	    		?>
				
			</tr>
    	</thead>
     
    </table>
    <table class="calendar-table sunset-colors w-100">
    	<thead>
    		<tr>
	    		<?php
	    		
	    		
	    		for ($hour = calendar::getStartOfToday($entity->calendar_time);
					$hour <= calendar::getEndofToday($entity->calendar_time);
					$hour += calendar::getFifteenMinutes()){
						
						
						
						$additional_class = '';
						//if the time is allowed and is a zero-second interval	
						if(date('i',$hour)=='00'){
								
								$additional_class = 'border-left';
						}
						//create 15 min divider with border-left drawn for whole hours		
						echo '<th class="'.$additional_class.' hour week calendar-hour font-weight-bold overflow-hidden"></th>';
					}
					
	    		?>
				
			</tr>
    	</thead>
     
    </table>
    
<?php    
	echo '<table class="calendar-row-content mt-4">';
	echo '<tbody>';
	//Echo days	
//					for ($quarterHour = $x; $quarterHour < $x + (7*calendar::getOneDay()); $quarterHour += calendar::getOneDay()){
//						echo '<td class="calendar-cell border days"><p class="date">'.date('j',$quarterHour).'</p></td>';
//					}
	
	foreach ($entity->calendar_entities as $entityKey => $calendar_entity){	
		
		//anylize the options and select times for this entity accordingly
		foreach ($entity->viewOptions as $option){
			
			$optionPart = explode("-",$option);
			
			//ensure the $calendar entity has matching options to display
			if ( is_object($calendar_entity)
				&& property_exists($calendar_entity,$optionPart[1])
				&& $calendar_entity->class_name == $optionPart[0]
				){
			
				//If the calendar entity uses a range set end time using the end range name
				if ($entity->getOptionHasEndRange($option) != false){
						
					$startTime = calendar::getTimestamp($calendar_entity->{$optionPart[1]});
					$end_property = $entity->getOptionHasEndRange($option);
					$endTime = calendar::getTimestamp($calendar_entity->{$end_property});
					break;
				
				} else {
					
					//The start and end time are both set the same
					$startTime = calendar::getTimestamp($calendar_entity->{$optionPart[1]});
					$endTime = calendar::getTimestamp($calendar_entity->{$optionPart[1]});
					break;
				}
			}
		}

		//alylize the bg_color options;
		//set color if we don't break from above;
		$bg_color = '007bff';
		if(isset($entity->viewOptionsColors)){
			foreach ($entity->viewOptionsColors as $option){
				$optionPart = explode("-",$option);
				if ( $calendar_entity->class_name == $optionPart[0]){
					$bg_color = $optionPart[1];
					break;
				}
				
			}
		} 
		
		//Set outline colors
		if (isset($calendar_entity->statusColor)){
			$border_color = $calendar_entity->statusColor;
		} else {
			$border_color = "FFFFFF";
		}
		
		//if the entity is not in the week, continue
		//if(!calendar::isInWeek($startTime,$x) && !calendar::isInWeek($endTime, $x)){continue;}
		
		echo '<tr>';
		
		for ($quarterHour = calendar::getStartOfToday($entity->calendar_time);
					$quarterHour <= calendar::getEndofToday($entity->calendar_time);
					$quarterHour += calendar::getFifteenMinutes()){
		//add the entity data to the calendar over the skeleton
		//Add entity data here
			
			
			//print_r($calendar_entity);
			//echo $quarterHour .' - '. calendar::getStartOfToday($quarterHour);
			//ask every day...
			
			//If begins now and ends after today.
			
			if (calendar::isInQuarterHour($startTime, $quarterHour) && $endTime > calendar::getEndOfToday($quarterHour)){
				//calculate the span	
				$span = calendar::getQuarterHoursFromRange($startTime, $endTime);
				$additional_classes = "begin";
				include("calendar_entity_hour.php");
				
				
			}
			
			//if begins this day, but ends before the end of eday
			elseif (calendar::isInQuarterHour($startTime,$quarterHour) && $endTime < calendar::getEndofToday($quarterHour)){
					
				
					
				//calculate the span	
				$span = calendar::getQuarterHoursFromRange($quarterHour,$endTime);
				$additional_classes = "both"; 
				include("calendar_entity_hour.php");
			}
			
			
			/*
			//if hour is the first of the day...
			elseif ($quarterHour == calendar::getStartOfToday($quarterHour)){
					
				//If continued from previous day and ends this day
				if ($startTime < $quarterHour && calendar::isInDay($endTime, $quarterHour)){
					$span = calendar::getQuarterHoursFromRange($quarterHour, $endTime);
					$additional_classes = "end";
					include("calendar_entity_hour.php");
				}
				//If the runs past all day 
				elseif ($startTime < calendar::getStartOfToday($quarterHour) && $endTime > calendar::getEndofToday($quarterHour)){
					$span = 96 ;
					$additional_classes = "";
					include("calendar_entity_hour.php");
				
				} else {
					echo '<td class="calendar-hour " ></td>';
					
				}	
			}
			 */ 
			  else {
				echo '<td class="calendar-hour " ></td>';
			}				
		}
		echo '</tr>';
	}
	echo '</tbody>';
		
	echo '</table>';
	
echo '</div>';		
?>	


		