<?php
//remove this timer!
function timer($name,$start=TRUE){
	if($name == 'get_called_class'){echo 'get_called_class';}
	//set start to false to end timer
	static $exe_timer = array();
	static $exe_timer_start;
	static $func_counter = array();
	
	if($start == TRUE){
		$exe_timer_start = microtime(TRUE);
		$exe_timer[$name]['start_time'] = $exe_timer_start;
		//set the function counter to one on first use
		if(!isset($func_counter[$name]) || empty($func_counter[$name])){
			$func_counter[$name] = 1;
		}
		else{$func_counter[$name]++;}
		//Set total time
		if(!isset($exe_timer[$name]['total_time']) || empty($exe_timer[$name]['total_time'])){
			$exe_timer[$name]['total_time'] = 0;
		}
	}
	if($start==FALSE)
	{
		$time = microtime(TRUE);
		$exe_time = ($time - $exe_timer[$name]['start_time']);
		//set total call count
		$exe_timer[$name]['total_calls'] = $func_counter[$name];
		$exe_timer[$name]['total_time'] = $exe_timer[$name]['total_time'] + $exe_time;
	}
	
	return $exe_timer;
}


function log_append($file,$content){
	
	//temp logger
	$new_line = date("Y-m-d G:i:s",time()) . " > ". $content;
	$content = file_get_contents($file);
	$content .= $new_line . '<br>';
	file_put_contents($file, $content);		
}
