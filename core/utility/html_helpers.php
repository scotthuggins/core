<?php


function clean_array($connx,$arr){

	//clean _POST of white space
	foreach ($arr as $key=>$value) {
		// added 1.9.19 for file-form submitions	
		if(is_array($arr[$key])){
			$arr[$key] = $value;
			continue;
		} 
		$arr[$key] = trim($arr[$key]);
		$arr[$key] = htmlentities($arr[$key]);
		$arr[$key] = sprintf("%s",$arr[$key]);
		//$arr[$key] = mysqli_real_escape_string($connx,$arr[$key]);
	}
	return $arr;
}



/**
 * @param string    $str           Original string
 * @param string    $needle        String to trim from the end of $str
 * @param bool|true $caseSensitive Perform case sensitive matching, defaults to true
 * @return string Trimmed string
 */
function rightTrim($str, $needle, $caseSensitive = true)
{
    $strPosFunction = $caseSensitive ? "strpos" : "stripos";
    if ($strPosFunction($str, $needle, strlen($str) - strlen($needle)) !== false) {
        $str = substr($str, 0, -strlen($needle));
    }
    return $str;
}

/**
 * @param string    $str           Original string
 * @param string    $needle        String to trim from the beginning of $str
 * @param bool|true $caseSensitive Perform case sensitive matching, defaults to true
 * @return string Trimmed string
 */
function leftTrim($str, $needle, $caseSensitive = true)
{
    $strPosFunction = $caseSensitive ? "strpos" : "stripos";
    if ($strPosFunction($str, $needle) === 0) {
        $str = substr($str, strlen($needle));
    }
    return $str;
}

?>