<!DOCTYPE HTML>
<html>
<head>
<script>
function allowDropDefault(ev) {
    ev.preventDefault();
}

function dragDefault(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function dropDefault(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
}
</script>
</head>
<body>

<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)"></div>

<img id="drag1" src="img_logo.gif" draggable="true"
ondragstart="drag(event)" width="336" height="69">

</body>
</html>

<?php

//$h2 = New html($connx);
//$h2->open('2');
//$h2->class = array();
//$h2->save();
//exit;


//$h = New html($connx);
//$h->createElement("p","Hello World".$user->username);

//$h->render();

//$h->Save();

//$h2 = New html($connx);
//$h2->createElement("div");
//$h2->Save();
//++++++++++++++++++++++++++++++
$h = New html($connx);
$h->createElement("H1","H1 Title");
$h->Save();
//unset($h);

$h2 = New html($connx);
$h2->createElement('div');
$h2->Save();
//unset($h2);

$h3 = New html($connx);
$h3->createElement('p','Text of a paragraph');
$h3->save();
//unset($h3);
//=====================
//$h2 = New html($connx);
print_r($h2);
echo '<br><br><br>';
$h->open('1');
$h2->open('2');
$h3->open('3');
$h2->setHas(3,'html');

print_r($h2);
echo '<br><br><br>';

$h2->setClass('well');

$h2->setAttribute('draggable','true');
$h2->setAttribute('ondragstart','dragDefault(event)');
$h2->setAttribute('ondrop','dropDefault(event)');
$h2->setAttribute('ondragover','allowDropDefault(event)');


//$h2->removeClass('well');
print_r($h2);


$h->save();
$h2->save();
$h3->save();
$html_group = New htmls($connx,"html");
$html_group->render(1);
$html_group->render(2);
$html_group->render(2);
$html_group->render(2);
/*
$h4 = New html($connx);

//$h4->Save();

$h4->Open(4);
$h4->setHas(3, 'html');
$h4->setAttribute('draggable','true');
$h4->setAttribute('ondragstart','dragDefault(event)');
$h4->setAttribute('ondrop','dropDefault(event)');
$h4->setAttribute('ondragover','allowDropDefault(event)');
$h4->save();
$html_group->render(2);


//+++++++++++++++++++++++++
*/
?>



