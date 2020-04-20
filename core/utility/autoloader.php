<?php
//Loads all files in a dir that are not already defined
//as a class from the path name	
function autoloader($dir){

	//get array of file names from the dir		
	$files = array_slice(scandir($dir),2);

	//remove .php
	$files = array_map(function($e){
	    return pathinfo($e, PATHINFO_FILENAME);
	}, $files);
	
	foreach($files as $file)
	{
		if (class_exists($file)
		|| function_exists($file)){
			//avoid requiring or declaring twice
			continue;
		}
		$full_path = $dir . '/' . $file . '.php';
		if (file_exists($full_path)){
				
			//include the file
			require($full_path);
		}
	}

}
