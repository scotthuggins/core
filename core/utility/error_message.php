<?php
/*
 * This script contains procedural functions that are useful for dealing with forms
 * 
 * 
 *  > ClearErrors()						// removes all error and notification messages
 *  > GetErrors()						// returns a string of messages for display
 *  > GetIsError()						// returns TRUE if there is an error message stored (ignores notifications)
 *  > SetError(message)					// Add a new error message to the list
 * 
 */
	// Initialize error containers
	function ClearErrors() {
		
		unset ($_SESSION['LOGIN_ERROR']);
		unset ($_SESSION['LOGIN_MESSAGE']);
		
	}
	
		
	// returns a string of errors to be displayed on the page
	function GetErrors() {
		
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
	function GetIsError() {
		
		if (isset($_SESSION['LOGIN_ERROR']))			 
			if (!empty($_SESSION['LOGIN_ERROR'][0])) 
				return true;
		
		return false;
		
	}

	
	// adds error message to an array of messages
	function SetError($msg) {
		
		if (!isset($_SESSION['LOGIN_ERROR'])) 
			$_SESSION['LOGIN_ERROR'] = array();
		
		array_push($_SESSION['LOGIN_ERROR'], $msg);
		
	}
	
		
	
	
	
?>