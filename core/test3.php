<!DOCTYPE HTML>
<html>
<head>
<script>	
<?php
$html_group = New htmls($connx,"html");
$html_group->renderScripts(2);
?>	
</script>
<!--<script>
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
</script>-->
</head>
<body>
<!--
<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)"></div>

<img id="drag1" src="img_logo.gif" draggable="true"
ondragstart="drag(event)" width="336" height="69">
-->
</body>
</html>

<?php
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


//$js1 = New js_script($connx);
//$js1->Open(1);

//$js2 = New js_script($connx);
//$js2->Open(2);

//$js2 = New js_script($connx);
//$js2->Open(2);

$h = new html($connx);
$h->open(2);
$h->setHasMany(TRUE);
$h->setHas('1','js_script');
$h->setHas('2','js_script');
$h->setHas('3','js_script');
$h->setAttribute('draggable','true');
$h->save();



//print_r($h);

$html_group = New htmls($connx,"html");
$html_group->renderScripts(2);
$html_group->render(1);
$html_group->render(2);
$html_group->render(2);
$html_group->render(2);

?>



