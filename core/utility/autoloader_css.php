<?php
//Loads all files in a dir that are not already defined
//as a class from the path name	
function autoloader_css($dir){

	//get array of file names from the dir		
	$files = array_slice(scandir($dir),2);

	//remove .php
	$files = array_map(function($e){
	    return pathinfo($e, PATHINFO_FILENAME);
	}, $files);
	
	foreach($files as $file)
	{
		
		$full_path = $dir . '/' . $file . '.css';
		if (file_exists($full_path)){
			
			if (empty($code)){
				$code = '<link rel="stylesheet" href="'.$full_path.'">';
			} else {
				$code .= '<link rel="stylesheet" href="'.$full_path.'">';
			}	
			
		}
	}
	return $code;

}
