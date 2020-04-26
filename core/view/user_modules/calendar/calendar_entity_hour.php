<?php


echo '<td class="calendar-hour pl-0 pr-0">';

echo '<div 
			id="'.$calendar_entity->class_name.'_'.$calendar_entity->id.'" 
			style="border-style:solid;border-width:.15rem;border-color:#'.$border_color.';background-color:#'.$bg_color.';width:'.$span.'00%; "
			class="p-1 pl-2 editModalButton text-white calendar-event '.$additional_classes.' "
			 
			';
			
			//Abanonded tool-tips because they would not keep html formatting after ajax calls.
			//data-toggle="calendar-tooltip" title="';
			//foreach ($calendar_entity->config['primaryViewProperties'] as $prop){
			//	echo $prop . ': ' . $calendar_entity->$prop .'&#x000A;';
			//}

echo '>';
//echo $calendar_entity->name;   
echo '</div>';


echo '<div 
			id="'.$calendar_entity->class_name.'_'.$calendar_entity->id.'" 
			
			class="p-1 pl-2 editModalButton text-white calendar-event calender-event-day-text '.$additional_classes.' "
			 
			';
			
			//Abanonded tool-tips because they would not keep html formatting after ajax calls.
			//data-toggle="calendar-tooltip" title="';
			//foreach ($calendar_entity->config['primaryViewProperties'] as $prop){
			//	echo $prop . ': ' . $calendar_entity->$prop .'&#x000A;';
			//}

echo '>';
//echo $calendar_entity->name;
foreach ($calendar_entity->config['primaryViewProperties'] as $prop){
	echo html_helper::cleanText($prop) . ': ' . $calendar_entity->$prop .'<br>';
}   
echo '</div>';




echo '</td>';
?>