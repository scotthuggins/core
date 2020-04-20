<?php
//Create HTML OBJECT
$html = New htmls($connx,"html");

$html->SetSTMTSql("SELECT * FROM $html->entity WHERE name IS NOT NULL");
$html->OpenEntities();




?>