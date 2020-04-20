<?php
class error extends baseEntity{
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
	}	
	
	// Initialize error containers
	function ClearErrors() {
		
		unset ($_SESSION['LOGIN_ERROR']);
		unset ($_SESSION['LOGIN_MESSAGE']);
		
	}
	
		
	// returns a string of errors to be displayed on the page
	public static function GetErrors() {
		
		$errors=''; 
		$_error=(isset($_SESSION['LOGIN_ERROR']))?$_SESSION['LOGIN_ERROR']:'';

		if (!empty($_error)){
			foreach($_error as $k=>$v){ if(!empty($errors)) $errors.="<br>"; $errors.=$v; }
		}
		
		$_error=(isset($_SESSION['LOGIN_MESSAGE']))?$_SESSION['LOGIN_MESSAGE']:'';
		
		if (!empty($_error)){
			foreach($_error as $k=>$v){ if(!empty($errors)) $errors.="<br>"; $errors.=$v; }
		}
		
		ClearErrors();
		
		return $errors;
		
	}
	
		// returns TRUE if an error exists
	public static function GetIsError() {
		
		if (isset($_SESSION['LOGIN_ERROR']))			 
			if (!empty($_SESSION['LOGIN_ERROR'][0])) 
				return true;
		
		return false;
		
	}

	
	// adds error message to an array of messages
	public static function SetError($msg) {
		
		if (!isset($_SESSION['LOGIN_ERROR'])) 
			$_SESSION['LOGIN_ERROR'] = array();
		
		array_push($_SESSION['LOGIN_ERROR'], $msg);
		
	}
}
?>