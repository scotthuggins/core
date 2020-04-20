<?php
//append the form data to the session
$session->form = clean_array($connx,$_POST);

//Select all users that = User name or email
$users->SetSTMTSql("SELECT * FROM user WHERE username = '".$session->form['username']."' OR email = '".$session->form['email']."'");    
$users->OpenEntities();

if( count($users->entities) >= 1){
	SetError('The username or email you entered is already in use');
}


$user->validate($session->form);

if(!GetIsError()){
	$_user = new user($connx);
	$_user->username = $session->form['username'];
	$_user->nameFirst = $session->form['nameFirst'];
	$_user->nameLast = $session->form['nameLast'];
	$_user->nameCompany = $session->form['nameCompany'];
	$_user->phone = $session->form['phone'];
	$_user->email = $session->form['email'];
	$_user->password = hasher::hash($session->form['password1']);
	$_user->setHasMany(TRUE);
	$_user->setBelongsToMany(TRUE);
	$_user->save();
	
	//header ('location: ../index.php?pg=default');
}
else{
	//go back to form.
	//header ('location: '.$_SERVER['HTTP_REFERER']);
}	
?>