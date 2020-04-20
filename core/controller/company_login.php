<?php



//Select all users that = User name or email

$companies->SetSTMTSql("SELECT * FROM company WHERE id = '".$this->post['id']."'");    
$companies->OpenEntities();

//ensure the user name existed
if(!isset($companies->entities[0])){SetError('We could not authenticate this Company Name');}
//ensure the user belongs to company
else{
	// TODO: uncomment below
	if(!$companies->entities[0]->has($user->id,'user')){
		SetError('This user does not belong to this company');
	}
}

if(!GetIsError()){
	
	$company->logout();
	foreach($map->core_dir as $k=>$v){
		unset($_SESSION[$v]);
	}
	
	$company->open($this->post['id']);
	$company->login();	
		
	header ('location: ../index.php?pg=home');
}
else{
	//go back to form.
	header ('location: '.$_SERVER['HTTP_REFERER']);
}
	
?>