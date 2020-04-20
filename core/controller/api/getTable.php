
<?php


	
//append the form data to the session
//$session->form = clean_array($connx,$_POST);
//$session->url = clean_array($connx,$_GET);

if (isset($this->get['search_view'])){
	//Set the dataView to the table object...
	$table_name = $plur_entity = inflector::pluralize($this->get['current_entity_name']);
	$search_view = ${$table_name}->config['defaultDataView'] = $this->get['search_view'];
	
	//added 6.12.19 to get resulting tables to be from page 1 when a search is first performed
	//${$table_name}->OpenEntities();
	//${$table_name}->page_current = 1;
	
} else {
	$search_view = 'Table';
}


	
if($user->hasPermission("get_table")){
	
	
	
	
	$entities = ${inflector::pluralize($this->get['current_entity_name'])};
	
	
	$parent = $this->get['current_entity_name'];
	
	if ($search_view == 'Table'){
		if(file_exists(dirname(dirname(dirname(__FILE__))).'/view/default/dataview_table.php')){
			include (dirname(dirname(dirname(__FILE__))).'/view/default/dataview_table.php');
	}
		//echo html_helper::dataview_table(${inflector::pluralize($session->url['current_entity_name'])},$session->url['current_entity_name']);
	}
	if ($search_view == 'Tiles'){
		if(file_exists(dirname(dirname(dirname(__FILE__))).'/view/default/dataview_tiles.php')){
			include (dirname(dirname(dirname(__FILE__))).'/view/default/dataview_tiles.php');
		}
		//echo html_helper::dataview_tiles(${inflector::pluralize($session->url['current_entity_name'])},$session->url['current_entity_name']);
	}
//	if ($search_view == 'Calendar'){
		
		
//		if(file_exists(dirname(dirname(dirname(__FILE__))).'/view/user_modules/calendar/dataview_calendar.php')){
//			include (dirname(dirname(dirname(__FILE__))).'/view/user_modules/calendar/dataview_calendar.php');
//		}
		//echo html_helper::dataview_tiles(${inflector::pluralize($session->url['current_entity_name'])},$session->url['current_entity_name']);
//	}
 }
?>
