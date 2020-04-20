

  <div class="d-flex align-items-center"><i class="fa fa-calendar fa-3x mr-3"></i>
    	
      <span class="month font-weight-bold mb-0 text-uppercase"><?php echo date("F Y",$entity->calendar_time); ?></span>
    </div>
    
    <table class=" w-100">
    	<thead>
    		<tr>
	    		<th class="week calendar-cell font-weight-bold text-uppercase">Sun</th>
	  			<th class="week calendar-cell font-weight-bold text-uppercase">Mon</th>
				<th class="week calendar-cell font-weight-bold text-uppercase">Tue</th>
				<th class="week calendar-cell font-weight-bold text-uppercase">Wed</th>
				<th class="week calendar-cell font-weight-bold text-uppercase">Thu</th>
				<th class="week calendar-cell font-weight-bold text-uppercase">Fri</th>
				<th class="week calendar-cell font-weight-bold text-uppercase">Sat</th>
			</tr>
    	</thead>
     
    </table>


  
    	
	<?php
		
		
		for ($x = calendar::getFirstDayOfWeek($entity->calendar_time);
			$x <= calendar::getLastDayOfWeek($entity->calendar_time);
			$x += calendar::getOneDay()){
				
			
			//create the row skeleton at beginning of week
			if ($x == calendar::getFirstDayOfWeek($x)){
						
				//create first div, with week cells/table	
				echo '<div class="calendar-row  w-100 ">';
					
					echo '<table class="calendar-table w-100 ">';
					echo '<tbody class="">';
					//Echo days	
					for($weekday = $x; $weekday < $x + (7*calendar::getOneDay()); $weekday += calendar::getOneDay()){
						echo '<td class="calendar-cell border days"><p class="date">'.date('j',$weekday).'</p></td>';
					}
					echo '</tbody>';
					echo '</table>';
					
					//create the row content over the skeleton					
					//create first div, with week cells/table	
						
					echo '<table class="calendar-row-content mt-4">';
					echo '<tbody>';
					//Echo days	
//					for ($weekday = $x; $weekday < $x + (7*calendar::getOneDay()); $weekday += calendar::getOneDay()){
//						echo '<td class="calendar-cell border days"><p class="date">'.date('j',$weekday).'</p></td>';
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
						
						for ($weekday = $x; $weekday < $x + (7*calendar::getOneDay()); $weekday += calendar::getOneDay()){
						//add the entity data to the calendar over the skeleton
						//Add entity data here
							
							//ask every day...
							//If begins and ends this week.
							if (calendar::isToday($startTime, $weekday) && $endTime <= calendar::getLastDayOfWeek($weekday)){
								//calculate the span	
								$span = calendar::getDaysFromRange($startTime, $endTime);
								$additional_classes = "both";
								include("calendar_entity.php");
								
								
							}
							
							//if begins this week, but ends later than the end of week
							elseif (calendar::isToday($startTime,$weekday) && $endTime > calendar::getLastDayOfWeek($weekday)){
								//calculate the span	
								$span = calendar::getDaysFromRange($weekday,calendar::getLastDayOfWeek($weekday));
								$additional_classes = "begin"; 
								include("calendar_entity.php");
							}
							
							
							//if today is the first day of the week...
							elseif ($weekday == calendar::getFirstDayOfWeek($weekday)){
									
								//If continued from previous week and ends this week
								if ($startTime < $weekday && calendar::isInWeek($endTime, $weekday)){
									$span = calendar::getDaysFromRange($weekday, $endTime);
									$additional_classes = "end";
									include("calendar_entity.php");
								}
								//If the runs past all days in this week
								elseif ($startTime < $weekday && $endTime > calendar::getLastDayOfWeek($weekday)){
									$span = 7;
									$additional_classes = "";
									include("calendar_entity.php");
								
								} else {
									echo '<td class="calendar-cell" ></td>';
									
								}	
							} else {
								echo '<td class="calendar-cell" ></td>';
							}				
						}
						echo '</tr>';
					}
					echo '</tbody>';
						
					echo '</table>';
					
				echo '</div>';		
					
			}
	}



		