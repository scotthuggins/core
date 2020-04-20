<?php
class hasher{
	
	static function hash($in){
		return hash('whirlpool', hash('gost',$in.SALT).PEPPER);
	}
}

?>