<?php
//append the form data to the session


//Select all users that = User name or email
$users->SetSTMTSql("SELECT * FROM user WHERE username = '".$this->post['username']."'");    
//print_r($users);
$users->OpenEntities();


//echo '<br><br>';
//print_r($users);

//ensure the user name existed
if (!isset($users->entities[0])){
	SetError('We could not authenticate this username.');
} else {
	//attempt to athenticate this user
	$users->entities[0]->login($this->post['password']);
	if ($users->entities[0]->isLoggedIn()){
		$user->open($users->entities[0]->id);
		$user->login($this->post['password']);
			
		//If the user only belongs to one company, log them into that company
		$_company = $user->getBelongsToByEntity('company');
		if (count($_company) == 1){
			$company->open($_company[0]->id);
			$company->login();
		}
	} else {
		SetError('We could not athenticate this password');
	}	
}


if (!GetIsError()){
	header ('location: ../index.php?pg=home');
} else {
	//go back to form.
	header ('location: '.$_SERVER['HTTP_REFERER']);
}
?>