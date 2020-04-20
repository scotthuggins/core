<?php
//append the form data to the session
$session->form = clean_array($connx,$_POST);

//Select all users that = User name or email
$users->SetSTMTSql("SELECT * FROM user WHERE username = '".$session->form['username']."'");    
$users->OpenEntities();

//ensure the user name existed
if (!isset($users->entities[0])){
	SetError('We could not authenticate this username.');
} else {
	//attempt to athenticate this user
	$users->entities[0]->login($session->form['password']);
	if ($users->entities[0]->isLoggedIn()){
		$user->open($users->entities[0]->id);
		$user->login($session->form['password']);
		
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

echo json_encode($user);

?>