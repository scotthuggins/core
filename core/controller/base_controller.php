<?php

$controller = new baseController();
//print_r($global_objects);
//print_r($controller);

/*
//if the request is a page requesting a view
//processors will redirect to this requesting a view
$get = clean_array($connx,$_GET);

if (!isset($get['pg'])){$get['pg']='default';}


//if the request is an api request
if (isset($get['api_request'])){
		
	$destination_file = dirname(dirname(__FILE__)).'/controller/api/' . $get['api_request'] . '.php';
	
	// If a bad value is sent and page doesn't exist....
	if (!file_exists($destination_file)){
		SetError('This controller does not exist');
		echo ' not exists';			
	}
	//If the user has permission
	
	$api_permission_array = explode("_", $get['api_request']);
	//remove _api for permission checks
	if ($api_permission_array[count($api_permission_array)-1] == 'api'){
		substr($get['api_request'],-4);
	}
	
	
	if ($user->hasPermission($get['api_request'])){
		//include controller
		include ($destination_file);
	} else {
		SetError('You do not have permission to process this request');
	}
	return;
	
}


//if the request is a process
if (isset($get['process'])){
	//example url: index.php?process=user_register
	$destination_file = dirname(dirname(__FILE__)).'/controller/' . $get['process'] . '.php';
	
	// If a bad value is sent and page doesn't exist....
	if (!file_exists($destination_file))
	{
		SetError('This controller does not exist');
		echo ' not exists';			
	}
	//If the user has permission
	if ($user->hasPermission($get['process'])){
		//include controller
		include ($destination_file);
	} else {
		SetError('You do not have permission to process this request');
		
		//go back where you came from!
		header ('location: '.$_SERVER['HTTP_REFERER']);
		
	}
	
	
	
}
//If the request is a view
elseif (isset($get['pg']) || (!isset($get['pg'])) && !isset($get['process']))
{
	//example url: index.php?pg=repairs
	if (isset($get['pg'])){
		$destination_file = dirname(dirname(__FILE__)).'/view/' . $get['pg'] . '.php';
	}
	if (!isset($get['pg'])){
		$destination_file = dirname(dirname(__FILE__)).'/view/default.php';;
	}
	
	//If the user NOT has permission, overwrite the destination
	if (!$user->hasPermission($get['pg']."_view")){
		$destination_file = dirname(dirname(__FILE__)).'/view/default.php';;
		SetError('You do not have permission for this area');
	}
	
	// If a bad value is sent and page doesn't exist....
	if (!file_exists($destination_file)){		
		$destination_file = dirname(dirname(__FILE__)).'/view/page_404.php';
	}
	//Open a HTML DOC response
	//include(dirname(dirname(__FILE__)).'/setup/jsheaders.php');
	
	//include the correct js for the entity requested
	$pg_word = explode('_',$get['pg']);
	
	//include the primary name
	timer('js_nodes');
	
	if (file_exists(dirname(dirname(__FILE__)).'/js/'.inflector::singularize($pg_word[0]).'.js')){
		echo '<script src="./core/js/'.inflector::singularize($pg_word[0]).'.js"></script>';
	}
	
	//if it exists, include the node js
	if (isset($pg_word[1])){
		if(file_exists(dirname(dirname(__FILE__)).'/js/'.inflector::singularize($pg_word[1]).'.js')){
			echo '<script src="./core/js/'.inflector::singularize($pg_word[1]).'.js"></script>';
		}
	}
	timer('js_nodes',FALSE);
	
	//Open a HTML DOC response
	include(dirname(dirname(__FILE__)).'/setup/jsheaders.php');
	
	timer('build_dom');
	echo '<!DOCTYPE HTML><html>
	<title>'. SITE_NAME . ' - ' . html_helper::cleanText(inflector::singularize($pg_word[0])).'</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <body>';
		
		//open the pages container
		echo '<div class="container-fluid">';
		
		timer('build_menu');
		//include menu
		include(dirname(dirname(__FILE__)).'/view/menu.php');
		timer('build_menu',FALSE);
		
		timer('build_view');
		//include page view
		include ($destination_file);
		timer('build_view',FALSE);
		
		timer('build_footer');
		//include footer
		include(dirname(dirname(__FILE__)).'/view/footer.php');
		timer('build_footer',FALSE);
		//close
		echo '</div>';
		
	//Close the HTML DOC response
	echo '</body></html>';
	timer('build_dom',FALSE);
}



GetErrors();
 
 */