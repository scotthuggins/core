<?php
//Create HTML OBJECTS for All future use
/*
$a = New html($connx);
$a->setName('a');
$a->createElement('a');
$a->save();

$abbr = New html($connx);
$abbr->setName('abbreviation');
$abbr->createElement('abbr');
$abbr->save();

$address = New html($connx);
$address->setName('address');
$address->createElement('address');
$address->save();

$area = New html($connx);
$area->setName('area');
$area->createElement('area');
$area->save();

$article = New html($connx);
$article->setName('article');
$article->createElement('article');
$article->save();

$aside = New html($connx);
$aside->setName('aside');
$aside->createElement('aside');
$aside->save();

$audio = New html($connx);
$audio->setName('audio');
$audio->createElement('audio');
$audio->save();

$b = New html($connx);
$b->setName('bold text');
$b->createElement('b');
$b->save();

$base = New html($connx);
$base->setName('base');
$base->createElement('base');
$base->save();

$bdi = New html($connx);
$bdi->setName('Bi-directional Isolation');
$bdi->createElement('bdi');
$bdi->save();

$bdo = New html($connx);
$bdo->setName('Bi-directional Override');
$bdo->createElement('bdo');
$bdo->save();

$blockquotes = New html($connx);
$blockquotes->setName('blockquotes');
$blockquotes->createElement('blockquotes');
$blockquotes->save();

$body = New html($connx);
$body->setName('body');
$body->createElement('body');
$body->save();

$br = New html($connx);
$br->setName('line-break');
$br->createElement('br');
$br->save();

$button = New html($connx);
$button->setName('button');
$button->createElement('button');
$button->save();

$canvas = New html($connx);
$canvas->setName('canvas');
$canvas->createElement('canvas');
$canvas->save();

$caption = New html($connx);
$caption->setName('caption');
$caption->createElement('caption');
$caption->save();

$cite = New html($connx);
$cite->setName('cite');
$cite->createElement('cite');
$cite->save();

$code = New html($connx);
$code->setName('code');
$code->createElement('code');
$code->save();

$col = New html($connx);
$col->setName('col');
$col->createElement('col');
$col->save();

$colgroup = New html($connx);
$colgroup->setName('colgroup');
$colgroup->createElement('colgroup');
$colgroup->save();

$datalist = New html($connx);
$datalist->setName('datalist');
$datalist->createElement('datalist');
$datalist->save();

$dd = New html($connx);
$dd->setName('list - descriptive value');
$dd->createElement('dd');
$dd->save();

$del = New html($connx);
$del->setName('del');
$del->createElement('del');
$del->save();

$details = New html($connx);
$details->setName('details');
$details->createElement('details');
$details->save();

$dfn = New html($connx);
$dfn->setName('defining instance');
$dfn->createElement('dfn');
$dfn->save();

$dialog = new html($connx);
$dialog->setName('dialog');
$dialog->createElement('dialog');
$dialog->save();

$div = New html($connx);
$div->setName('divider');
$div->createElement('div');
$div->save();

$dl = New html($connx);
$dl->setName('descriptive list');
$dl->createElement('dl');
$dl->save();

$dt = New html($connx);
$dt->setName('descriptive term');
$dt->createElement('dt');
$dt->save();

$em = New html($connx);
$em->setName('emphasized text');
$em->createElement('em');
$em->save();

$embed = New html($connx);
$embed->setName('embed');
$embed->createElement('embed');
$embed->save();

$fieldset = New html($connx);
$fieldset->setName('fieldset');
$fieldset->createElement('fieldset');
$fieldset->save();

$figcaption = New html($connx);
$figcaption->setName('caption - figure');
$figcaption->createElement('figcaption');
$figcaption->save();

$figure = New html($connx);
$figure->setName('figure');
$figure->createElement('figure');
$figure->save();

$footer = New html($connx);
$footer->setName('footer');
$footer->createElement('footer');
$footer->save();

$form = New html($connx);
$form->setName('form');
$form->createElement('form');
$form->save();

$h1 = New html($connx);
$h1->setName('h1');
$h1->createElement('h1');
$h1->save();

$h2 = New html($connx);
$h2->setName('h2');
$h2->createElement('h2');
$h2->save();

$h3 = New html($connx);
$h3->setName('h3');
$h3->createElement('h3');
$h3->save();

$h4 = New html($connx);
$h4->setName('h4');
$h4->createElement('h4');
$h4->save();

$h5 = New html($connx);
$h5->setName('h5');
$h5->createElement('h5');
$h5->save();

$h6 = New html($connx);
$h6->setName('h6');
$h6->createElement('h6');
$h6->save();

$head = New html($connx);
$head->setName('head');
$head->createElement('head');
$head->save();

$header = New html($connx);
$header->setName('header');
$header->createElement('header');
$header->save();

$hr = New html($connx);
$hr->setName('hr');
$hr->createElement('hr');
$hr->save();

$html = New html($connx);
$html->setName('html');
$html->createElement('html');
$html->save();

$i = New html($connx);
$i->setName('i');
$i->createElement('i');
$i->save();

$iframe = New html($connx);
$iframe->setName('iframe');
$iframe->createElement('iframe');
$iframe->save();

$img = New html($connx);
$img->setName('img');
$img->createElement('img');
$img->save();

$input = New html($connx);
$input->setName('input');
$input->createElement('input');
$input->save();

$ins = New html($connx);
$ins->setName('ins');
$ins->createElement('ins');
$ins->save();

$kbd = New html($connx);
$kbd->setName('keyboard input');
$kbd->createElement('kbd');
$kbd->save();

$label = New html($connx);
$label->setName('label');
$label->createElement('label');
$label->save();

$legend = New html($connx);
$legend->setName('legend');
$legend->createElement('legend');
$legend->save();

$li = New html($connx);
$li->setName('li');
$li->createElement('li');
$li->save();

$link = New html($connx);
$link->setName('link');
$link->createElement('link');
$link->save();

$main = new html($connx);
$main->setName('main');
$main->createElement('main');
$main->save();

$menuitem = New html($connx);
$menuitem->setName('menuitem');
$menuitem->createElement('menuitem');
$menuitem->save();

$meta = New html($connx);
$meta->setName('meta');
$meta->createElement('meta');
$meta->save();

$meter = New html($connx);
$meter->setName('meter');
$meter->createElement('meter');
$meter->save();

$nav = New html($connx);
$nav->setName('nav');
$nav->createElement('nav');
$nav->save();

$noscript = New html($connx);
$noscript->setName('noscript');
$noscript->createElement('noscript');
$noscript->save();

$object = New html($connx);
$object->setName('object');
$object->createElement('object');
$object->save();

$ol = New html($connx);
$ol->setName('ordered list');
$ol->createElement('ol');
$ol->save();

$optgroup = New html($connx);
$optgroup->setName('optgroup');
$optgroup->createElement('optgroup');
$optgroup->save();

$option = New html($connx);
$option->setName('option');
$option->createElement('option');
$option->save();

$output = New html($connx);
$output->setName('output');
$output->createElement('output');
$output->save();

$p = New html($connx);
$p->setName('paragraph');
$p->createElement('p');
$p->save();

$param = New html($connx);
$param->setName('param');
$param->createElement('param');
$param->save();

$picture = New html($connx);
$picture->setName('picture');
$picture->createElement('picture');
$picture->save();

$pre = New html($connx);
$pre->setName('pre');
$pre->createElement('pre');
$pre->save();

$progress = New html($connx);
$progress->setName('progress');
$progress->createElement('progress');
$progress->save();

$q = New html($connx);
$q->setName('quotation');
$q->createElement('q');
$q->save();

$rp = New html($connx);
$rp->setName('rp');
$rp->createElement('rp');
$rp->save();

$rt = New html($connx);
$rt->setName('rt');
$rt->createElement('rt');
$rt->save();

$ruby = New html($connx);
$ruby->setName('ruby');
$ruby->createElement('ruby');
$ruby->save();

$s = New html($connx);
$s->setName('s');
$s->createElement('s');
$s->save();

$samp = New html($connx);
$samp->setName('samp');
$samp->createElement('samp');
$samp->save();

$script = New html($connx);
$script->setName('script');
$script->createElement('script');
$script->save();

$section = New html($connx);
$section->setName('section');
$section->createElement('section');
$section->save();

$select = New html($connx);
$select->setName('select');
$select->createElement('select');
$select->save();

$small = New html($connx);
$small->setName('small');
$small->createElement('small');
$small->save();

$source = New html($connx);
$source->setName('source');
$source->createElement('source');
$source->save();

$span = New html($connx);
$span->setName('span');
$span->createElement('span');
$span->save();

$strong = New html($connx);
$strong->setName('strong');
$strong->createElement('strong');
$strong->save();

$style = New html($connx);
$style->setName('style');
$style->createElement('style');
$style->save();

$sub = New html($connx);
$sub->setName('sub');
$sub->createElement('sub');
$sub->save();

$summary = New html($connx);
$summary->setName('summary');
$summary->createElement('summary');
$summary->save();

$sup = New html($connx);
$sup->setName('super script');
$sup->createElement('sup');
$sup->save();

$table = New html($connx);
$table->setName('table');
$table->createElement('table');
$table->save();

$tbody = New html($connx);
$tbody->setName('tbody');
$tbody->createElement('tbody');
$tbody->save();

$td = New html($connx);
$td->setName('td');
$td->createElement('td');
$td->save();

$textarea = New html($connx);
$textarea->setName('textarea');
$textarea->createElement('textarea');
$textarea->save();

$tfoot = New html($connx);
$tfoot->setName('tfoot');
$tfoot->createElement('tfoot');
$tfoot->save();

$th = New html($connx);
$th->setName('th');
$th->createElement('th');
$th->save();

$thead = New html($connx);
$thead->setName('thead');
$thead->createElement('thead');
$thead->save();

$time = New html($connx);
$time->setName('time');
$time->createElement('time');
$time->save();

$title = New html($connx);
$title->setName('title');
$title->createElement('title');
$title->save();

$tr = New html($connx);
$tr->setName('tr');
$tr->CreateTable('tr');
$tr->save();

$track = New html($connx);
$track->setName('track');
$track->createElement('track');
$track->save();

$u = New html($connx);
$u->setName('u');
$u->createElement('u');
$u->save();

$ul = New html($connx);
$ul->setName('ul');
$ul->createElement('ul');
$ul->save();

$var = New html($connx);
$var->setName('var');
$var->createElement('var');
$var->save();

$video = New html($connx);
$video->setName('video');
$video->createElement('video');
$video->save();

$wbr = New html($connx);
$wbr->setName('wbr');
$wbr->createElement('wbr');
$wbr->save();

//+++++++++++++++++++++++++++++++++++++++++++++
  
 
//create basic boot strap building blocks
$row = New html($connx);
$row->OpenByName('row');
$row->setName('row');
$row->createElement('div');
$row->setClass('row');
$row->save();

$col_xs_1 = New html($connx);
$col_xs_1->OpenByName('col_xs_1');
$col_xs_1->setName('col_xs_1');
$col_xs_1->createElement('div');
$col_xs_1->setClass('col_xs_1');
$col_xs_1->save();

$col_xs_2 = New html($connx);
$col_xs_2->OpenByName('col_xs_2');
$col_xs_2->setName('col_xs_2');
$col_xs_2->createElement('div');
$col_xs_2->setClass('col_xs_2');
$col_xs_2->save();


$col_xs_3 = New html($connx);
$col_xs_3->OpenByName('col_xs_3');
$col_xs_3->setName('col_xs_3');
$col_xs_3->createElement('div');
$col_xs_3->setClass('col_xs_3');
$col_xs_3->save();

$col_xs_4 = New html($connx);
$col_xs_4->OpenByName('col_xs_4');
$col_xs_4->setName('col_xs_4');
$col_xs_4->createElement('div');
$col_xs_4->setClass('col_xs_4');
$col_xs_4->save();

$col_xs_5 = New html($connx);
$col_xs_5->OpenByName('col_xs_5');
$col_xs_5->setName('col_xs_5');
$col_xs_5->createElement('div');
$col_xs_5->setClass('col_xs_5');
$col_xs_5->save();

$col_xs_6 = New html($connx);
$col_xs_6->OpenByName('col_xs_6');
$col_xs_6->setName('col_xs_6');
$col_xs_6->createElement('div');
$col_xs_6->setClass('col_xs_6');
$col_xs_6->save();

$col_xs_7 = New html($connx);
$col_xs_7->OpenByName('col_xs_7');
$col_xs_7->setName('col_xs_7');
$col_xs_7->createElement('div');
$col_xs_7->setClass('col_xs_7');
$col_xs_7->save();

$col_xs_8 = New html($connx);
$col_xs_8->OpenByName('col_xs_8');
$col_xs_8->setName('col_xs_8');
$col_xs_8->createElement('div');
$col_xs_8->setClass('col_xs_8');
$col_xs_8->save();

$col_xs_9 = New html($connx);
$col_xs_9->OpenByName('col_xs_9');
$col_xs_9->setName('col_xs_9');
$col_xs_9->createElement('div');
$col_xs_9->setClass('col_xs_9');
$col_xs_9->save();

$col_xs_10 = New html($connx);
$col_xs_10->OpenByName('col_xs_10');
$col_xs_10->setName('col_xs_10');
$col_xs_10->createElement('div');
$col_xs_10->setClass('col_xs_10');
$col_xs_10->save();

$col_xs_11 = New html($connx);
$col_xs_11->OpenByName('col_xs_11');
$col_xs_11->setName('col_xs_11');
$col_xs_11->createElement('div');
$col_xs_11->setClass('col_xs_11');
$col_xs_11->save();

$col_xs_12 = New html($connx);
$col_xs_12->OpenByName('col_xs_12');
$col_xs_12->setName('col_xs_12');
$col_xs_12->createElement('div');
$col_xs_12->setClass('col_xs_12');
$col_xs_12->save();

 
//Create table

$bs_table = New html($connx);
$bs_table->OpenByName('bs_table');
$bs_table->setName('bs_table');
$bs_table->createElement('table');
$bs_table->setClass('table');
$bs_table->save();

$bs_thead = New html($connx);
$bs_thead->OpenByName('bs_thead');
$bs_thead->setName('bs_thead');
$bs_thead->createElement('thead');
$bs_thead->save();

$bs_tr = New html($connx);
$bs_tr->OpenByName('bs_tr');
$bs_tr->setName('bs_tr');
$bs_tr->createElement('tr');
$bs_tr->save();

$bs_th = New html($connx);
$bs_th->OpenByName('bs_th');
$bs_th->setName('bs_th');
$bs_th->createElement('th','col name text');
$bs_th->save();

$bs_tbody = New html($connx);
$bs_tbody->OpenByName('bs_tbody');
$bs_tbody->setName('bs_tbody');
$bs_tbody->createElement('tbody');
$bs_tbody->save();

$bs_tr2 = New html($connx);
$bs_tr2->OpenByName('bs_tr2');
$bs_tr2->setName('bs_tr2');
$bs_tr2->createElement('tr');
$bs_tr2->save();

$bs_td = New html($connx);
$bs_td->OpenByName('bs_td');
$bs_td->setName('bs_td');
$bs_td->createElement('td','col content text');
$bs_td->save();

$bs_table->setHasMany(TRUE);
$bs_table->setHas($bs_thead->id,'html');
$bs_table->setHas($bs_tbody->id,'html');
$bs_thead->setHas($bs_tr->id,'html');
$bs_tr->setHas($bs_th->id,'html');
$bs_tbody->setHas($bs_tr2->id,'html');
$bs_tr2->setHas($bs_td->id,'html');

$bs_table->save();
$bs_thead->save();
$bs_tr->save();
$bs_td->save();
$bs_tbody->save();
$bs_tr2->save();
$bs_th->save();


//end create table()




$bs_jumbo = New html($connx);
$bs_jumbo->OpenByName('jumbotron');
$bs_jumbo->setName('jumbotron');
$bs_jumbo->createElement('div');
$bs_jumbo->setClass('jumbotron');
$bs_jumbo->save();

$bs_well = New html($connx);
$bs_well->OpenByName('well');
$bs_well->setName('well');
$bs_well->createElement('div');
$bs_well->setClass('well');
$bs_well->save();

$alert_success = new html($connx);
$alert_success->OpenByName('alert_success');
$alert_success->setName('alert_success');
$alert_success->createElement('div');
$alert_success->setClass('alert');
$alert_success->setClass('alert-success');
$alert_success->save();

$alert_info = new html($connx);
$alert_info->OpenByName('alert_info');
$alert_info->setName('alert_info');
$alert_info->createElement('div');
$alert_info->setClass('alert');
$alert_info->setClass('alert-info');
$alert_info->save();

$alert_warning = new html($connx);
$alert_warning->OpenByName('alert_warning');
$alert_warning->setName('alert_warning');
$alert_warning->createElement('div');
$alert_warning->setClass('alert');
$alert_warning->setClass('alert-warning');
$alert_warning->save();

$alert_danger = new html($connx);
$alert_danger->OpenByName('alert_danger');
$alert_danger->setName('alert_danger');
$alert_danger->createElement('div');
$alert_danger->setClass('alert');
$alert_danger->setClass('alert-danger');
$alert_danger->save();


$button = New html($connx);
$button->OpenByName('bs_button');
$button->setName('bs_button');
$button->createElement('button');
$button->setClass('btn');
$button->save();

$button2 = New html($connx);
$button2->OpenByName('bs_button');
$button2->setName('bs_button');
$button2->createElement('button');
$button2->setClass('btn');
$button2->save();

$button_group = New html($connx);

$button_group->OpenByName('button_group');
$button_group->setHasMany(TRUE);
$button_group->setName('button_group');
$button_group->createElement('div');
$button_group->setClass('btn-group');
$button_group->save();

$button_group->setHas($button2->id,'html');
$button_group->save();
$button2->save();

$progress = New html($connx);
$progress->OpenByName('progressbar');
$progress->setName('progressbar');
$progress->createElement('div');
$progress->setClass('progress');
$progress->save();

$progress_inner = New html($connx);
$progress_inner->openByName('progressinner');
$progress_inner->setName('progressinner');
$progress_inner->createElement('div');
$progress_inner->setClass('progress-bar');
$progress_inner->setAttribute('role','progressbar');
$progress_inner->setAttribute('aria-valuenow','50');
$progress_inner->setAttribute('aria-valuemin','0');
$progress_inner->setAttribute('aria-valuemax','100');
$progress_inner->setAttribute('style','width:50');
$progress_inner->save();

$progress->setHas($progress_inner->id,'html');
$progress->save();
$progress_inner->save();


 
$panel_group = New html($connx);
$panel_group->OpenByName('panel_group');
$panel_group->setName('panel_group');
$panel_group->createElement('div');
$panel_group->setClass('panel-group');
$panel_group->save();

$panel = new html($connx);
$panel->OpenByName('panel');
$panel->setName('panel');
$panel->createElement('div');
$panel->setClass('panel');
$panel->setClass('panel-default');
$panel->save();

$panel_heading = New html($connx);
$panel_heading->OpenByName('panel_heading');
$panel_heading->setName('panel_heading');
$panel_heading->createElement('div','Heading Text');
$panel_heading->setClass('panel-heading');
$panel_heading->save();

$panel_body = New html($connx);
$panel_body->OpenByName('panel_body');
$panel_body->setName('panel_body');
$panel_body->createElement('div','Body Text');
$panel_body->setClass('panel-body');
$panel_body->save();

//$panel_group->removeHas($panel->id,'html');
//$panel->removeHas($panel_body->id,'html');
//$panel->removeHas($panel_heading->id,'html');


$panel_group->setHas($panel->id,'html');
$panel->setHasMany(TRUE);
$panel->setHas($panel_heading->id,'html');
$panel->setHas($panel_body->id,'html');
$panel_group->save();
$panel->save();

*/ 
 
 
 
/*		<div>
 * 			<ul>
 * 				<li>HTML HEADER
 * 			<div>
 * 				<ul>
 * 					<li>HTML ITEMS
 * 
 * 
 * 
 * 
 * 
 * 
 */ 
 
 
/* 

 
$development_menu = new html($connx);
$development_menu->OpenByName('development_menu');
$development_menu->setName('development_menu');
$development_menu->setHasMany(TRUE);
$development_menu->createElement('div');
$development_menu->removeAttribute('style');
$development_menu->setAttribute('style','display:block; 
										position:absolute; 
										position-x:0px; 
										position-y:0px; 
										width:25%;
										height:100%;
										background-color:#333;');
$development_menu->save();

//first UL
//$dev_html_menu = New html($connx);
//$dev_html_menu->OpenByName('dev_html_menu');
//$dev_html_menu->setName('dev_html_menu');

//$dev_html_menu->createElement('ul');
//$dev_html_menu->setClass('list-group');
//$dev_html_menu->setBelongsTo($development_menu->id, 'html');
//$dev_html_menu->save();

//toggle button 
$dev_html_menu_header = New html($connx);
$dev_html_menu_header->OpenByName('dev_html_menu_header');
$dev_html_menu_header->setName('dev_html_menu_header');
$dev_html_menu_header->createElement('button','HTML Elements');
$dev_html_menu_header->setClass('list-group-item');
$dev_html_menu_header->setClass('list-group-item-info');
$dev_html_menu_header->setAttribute('data-toggle','collapse');
$dev_html_menu_header->setBelongsTo($development_menu->id, 'html');
$dev_html_menu_header->save();

//div to toggle
$dev_html_menu_div = New html($connx);
$dev_html_menu_div->OpenByName('dev_html_menu_div');
$dev_html_menu_div->setName('dev_html_menu_div');
$dev_html_menu_div->setHasMany(TRUE);
$dev_html_menu_div->setBelongsTo($development_menu->id, 'html');
$dev_html_menu_div->createElement('div');
$dev_html_menu_div->setClass('collapse');
$dev_html_menu_div->save();

$dev_html_menu_header->setAttribute('data-target','#div_'.$dev_html_menu_div->id);
$dev_html_menu_header->save();

//second UL
$dev_html_menu2 = New html($connx);
$dev_html_menu2->OpenByName('dev_html_menu2');
$dev_html_menu2->setName('dev_html_menu2');
$dev_html_menu2->setHasMany(TRUE);
$dev_html_menu2->setBelongsTo($dev_html_menu_div->id, 'html');
$dev_html_menu2->createElement('ul');
$dev_html_menu2->setClass('list-group');
$dev_html_menu2->save();

$desired_elements = array('button','body','divider','paragraph','title');

foreach($desired_elements as $k=>$v){
	$html_elements = new htmls($connx,'html');		
	$html_elements->SetPageMax(5);
	$html_elements->SetSTMTSql("SELECT * FROM html WHERE name = '".$v."' ");
	$html_elements->OpenEntities();
	foreach($html_elements->entities as $entity){
		$this_list_item = new html($connx);
		$this_list_item->OpenByName('dev_html_menu_item_'.$entity->name);
		$this_list_item->setName('dev_html_menu_item_'.$entity->name);
		$this_list_item->createElement('li',$entity->name);
		$this_list_item->setClass('list-group-item');
		$this_list_item->setBelongsTo($dev_html_menu2->id, "html");
		$this_list_item->save();
	}
}
 
$html = new htmls($connx,'html');
$html->renderByName('development_menu');
*/
$js = New js_script($connx);
$js->OpenByName('dragHtml(ev)');
$js->setName('dragHtml(ev)');
$js->setFunction('
	ev.dataTransfer.setData("text", ev.target.id);
	passing_text = ev.target.text();
	
	
	');
$js->save();

$js2 = New js_script($connx);
$js2->OpenByName('allowDrop(ev)');
$js2->setName('allowDrop(ev)');
$js2->setFunction('
	ev.preventDefault();
	$(ev.target).addClass("hover");
	
	$(ev.target).mouseleave(function(){
		$(this).removeClass("hover");	
	});
	
	    



');
$js2->save();


$js3 = New js_script($connx);
$js3->OpenByName('onDrop(ev)');
$js3->setName('onDrop(ev)');
$js3->setFunction('
	ev.preventDefault();
    alert(passing_text);'
	);

    
    
    
    
    
$js3->save();










$html_canvas = new html($connx,'html');
$html_canvas->openByName('main_canvas');
$html_canvas->setName('main_canvas');
$html_canvas->createElement('div');
$html_canvas->setAttribute('style','width:100%;height:100%;');
$html_canvas->setAttribute('onDrop','onDrop(event)');
$html_canvas->setAttribute('onDragOver','allowDrop(event)');
$html_canvas->setHasMany(TRUE);
$html_canvas->setHas($js2->id,'js_script');
$html_canvas->setHas($js3->id,'js_script');
$html_canvas->save();





$desired_elements = array('button','body','divider','paragraph','title');

foreach($desired_elements as $k=>$v){
	$html_elements = new htmls($connx,'html');		
	$html_elements->SetPageMax(5);
	$html_elements->SetSTMTSql("SELECT * FROM html WHERE name = '".$v."' ");
	$html_elements->OpenEntities();
	foreach($html_elements->entities as $entity){
		$this_list_item = new html($connx);
		$this_list_item->OpenByName('dev_html_menu_item_'.$entity->name);
		$this_list_item->setName('dev_html_menu_item_'.$entity->name);
		$this_list_item->createElement('li',$entity->name);
		//$this_list_item->setClass('list-group-item');
		//$this_list_item->setBelongsTo($dev_html_menu2->id, "html");
		$this_list_item->setHasMany(TRUE);
		$this_list_item->setHas($js->id,'js_script');
		$this_list_item->setAttribute('draggable','true');
		$this_list_item->setAttribute('ondragstart','dragHtml(event)');
		$this_list_item->save();
	}
}
//echo '<script>';
//$js->render();
//echo '</script>';

$js_scripts = new js_scripts($connx,'js_script');

$h = New html($connx,'html');
$h->OpenByName('development_menu');


$js_scripts->gatherFunctionsFromHTML($h->id);
$js_scripts->gatherFunctionsFromHTML($html_canvas->id);


$html = new htmls($connx,'html');
echo '<script>';
echo 'var passing_text;';
$html->renderScriptsByName('development_menu');
$html->renderScriptsByName('main_canvas');
//$js_scripts->renderFunctionCollection();
echo '</script>';




$html->renderByName('development_menu');



$html->renderByName('main_canvas');


//$html->renderByName('alert_info');
//$html->renderByName('alert_warning');
//$html->renderByName('alert_danger');






?>