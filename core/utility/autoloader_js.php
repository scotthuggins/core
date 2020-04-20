<?php
//Loads all files in a dir that are not already defined
//as a class from the path name	
function autoloader_js($dir){

	//get array of file names from the dir		
	$files = array_slice(scandir($dir),2);

	//remove .php
	$files = array_map(function($e){
	    return pathinfo($e, PATHINFO_FILENAME);
	}, $files);
	
	foreach($files as $file)
	{
		
		$full_path = $dir . '/' . $file . '.js';
		if (file_exists($full_path)){
			
			if (empty($code)){
				$code = '<script src="'.$full_path.'"></script> ';
			} else {
				$code .= '<script src="'.$full_path.'"></script> ';
			}	
			
		}
	}
	return $code;

}
