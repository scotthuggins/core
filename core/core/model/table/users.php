<?php

class users extends baseTable{
	
	public function getUserByUsername($username){
		$this->SetSTMTSql("SELECT * FROM user WHERE username = '".$username."'");
		$this->OpenEntities();
	}
}
?>