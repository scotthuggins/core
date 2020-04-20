<?php
  

$h = New html($connx);
$h->open(1);
$h->createElement('!DOCTYPE HTML');
$h->save();

$h2 = New html($connx);
$h2->open(2);
$h2->setHasMany(TRUE);
$h2->createElement('html');
$h2->save();

$h3 = New html($connx);
$h3->open(3);
$h3->createElement('head');
$h3->setName('head');
	
$h3->save();

$h2->setHas('3','html');
$h2->save();

$h4 = New html($connx);
$h4->open(4);
$h4->CreateElement('body');
$h4->save();

//Create Script Elements for Head
$h5 = New html($connx);
$h5->open(5);
$h5->createElement('script');
$h5->setAttribute('src','./core/bootstrap/jquery/jquery.min.js');
$h5->save();

$h6 = New html($connx);
$h6->open(6);
$h6->createElement('script');
$h6->setAttribute('src','./core/bootstrap/js/bootstrap.min.js');
$h6->save();

$h7 = New html($connx);
$h7->open(7);
$h7->createElement('link');
$h7->setAttribute('rel','stylesheet');
$h7->setAttribute('href','./core/bootstrap/css/bootstrap.min.css');
$h7->save();

//Set script elements to belong to head
$h3->setHasMany(TRUE);
$h3->setHas('5','html');
$h3->setHas('6','html');
$h3->setHas('7','html');
$h3->save();

//Create page one
$page1 = New html($connx);
$page1->open(8);
$page1->setHasMany(TRUE);
$page1->setName('page1');
$page1->createElement('div');
$page1->setClass('container');
$page1->Save();

$elem1 = New html($connx);
$elem1->open(9);
$elem1->setHasMany(TRUE);
$elem1->createElement('h1','My H1 text is here');
$elem1->setAttribute('draggable','true');
$elem1->setAttribute('ondragstart','dragDefault(event)');
$elem1->setAttribute('ondrop','dropDefault(event)');
$elem1->setAttribute('ondragover','allowDropDefault(event)');
$elem1->setClass('well');
$elem1->setClass('bg-danger');
$elem1->save();

$elem2 = New html($connx);
$elem2->open(10);
$elem2->setHasMany(TRUE);
$elem2->createElement('p','my draggable paragraph text is here');
$elem2->setAttribute('draggable','true');
$elem2->setAttribute('ondragstart','dragDefault(event)');
$elem2->setAttribute('ondrop','dropDefault(event)');
$elem2->setAttribute('ondragover','allowDropDefault(event)');
$elem2->setClass('well');
$elem2->setClass('bg-danger');
$elem2->save();

//Link Elements 1 and 2 to page 1

$page1->setHas('9','html');
$page1->setHas('10','html');
$page1->save();

$h->setHas('2','html'); $h->save();
$h2->setHas('3','html'); $h2->save();
$h2->setHas('4','html'); $h2->save();
$h4->setHas('8','html'); $h4->save();


$js1 = New js_script($connx);
$js1->open(1);
$js1->setName('allowDropDefault(ev)');
$js1->setFunction('ev.preventDefault();');

$js2 = New js_script($connx);
$js2->open(2);
$js2->setName('dragDefault(ev)');
$js2->setFunction('ev.dataTransfer.setData("text", ev.target.id);');

$js3 = New js_script($connx);
$js3->open(3);
$js3->setName('dropDefault(ev)');
$js3->setFunction('
	ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
');

$js1->save();
$js2->save();
$js3->save();




$elem1->setHas('1','js_script');
$elem1->setHas('2','js_script');
$elem1->setHas('3','js_script');

$elem2->setHas('1','js_script');
$elem2->setHas('2','js_script');
$elem2->setHas('3','js_script');

$elem1->save();
$elem2->save();


//print_r($h3);
//echo '<br><br>';
//print_r($h7);

$h7->removeBelongsTo($h3->id,'html');
$h7->save();

//echo '<br><br>';
//print_r($h3);
//echo '<br><br>';
//print_r($h7);



$html_group = New htmls($connx,"html");
echo '<script>';

$html_group->renderScripts(10);

echo '</script>';
$html_group->render(1);
//$html_group->render(2);
//$html_group->render(2);
//$html_group->render(2);

?>

	

