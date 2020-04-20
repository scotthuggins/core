<?php
//append the form data to the session
$session->form = clean_array($connx,$_POST);


//Select all users that = User name or email

$stores->SetSTMTSql("SELECT * FROM store WHERE id = '".$session->form['store_id']."'");    
$stores->OpenEntities();

//ensure the user name existed
if(!isset($stores->entities[0])){SetError('We could not authenticate this Company Name');}
//ensure the user belongs to company

// Commented out from company login in processor
//if(!$companies->entities[0]->has($user->id,'user')){
//	SetError('This user does not belong to this company');
//}

if(!GetIsError()){
	
	$store->logout();
	//foreach($core_dir as $k=>$v){
	//	unset($_SESSION[$v]);
	//}
	
	$store->open($session->form['store_id']);
	$store->login();
	
		
		
	header ('location: ../index.php?pg=home');
}
else{
	//go back to form.
	header ('location: '.$_SERVER['HTTP_REFERER']);
}
	
?>