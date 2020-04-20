<?php
require(dirname(__FILE__).'/core/setup/config.php');





//INIT SESSION
$session = New Session();
$session->start();
$get = $_GET;


//if the request is a process to destroy
if (isset($get['process']) && $get['process']=='user_logout'){
	$session->destroy();
	header ('location: '.$_SERVER['HTTP_REFERER']);
	return;
}
//Session Restore
timer('restore');
require(dirname(__FILE__).'/core/session/session_restore.php');
timer('restore',false);


//Writer file that creates all forms and controllers from objects
timer('write_exe');
require(dirname(__FILE__).'/core/writer/write_executor.php');
timer('write_exe', false);
//Insert Controller
include(dirname(__FILE__).'/core/controller/base_controller.php');

//Session Save
require(dirname(__FILE__).'/core/session/session_save.php');


timer('end');
foreach(timer('end',FALSE) as $func => $timer){
	if($func == 'end'){continue;}
	//echo '<li>'.$timer['total_time'].' - '.$timer['total_calls'].' - '.$func.'</li>';
}
//echo "<br><br><br><br><br>";


//Close Session
$session->commit();