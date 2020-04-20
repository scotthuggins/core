<?php

//append the form data to the session

$name = inflector::pluralize($this->get['entity']); 
${$name}->SetPage($this->get['page']);

${$name}->SetSTMTSql(${$name}->stmt_sql); 
//<-- the statement has its limit attached, we need to update the statment with the new limit.
${$name}->OpenEntities();

//print_r(${$name});

header ('location: '.$_SERVER['HTTP_REFERER']);
		
?>