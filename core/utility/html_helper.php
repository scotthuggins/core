<?php
class html_helper{
	/* Returns html for entity_view
	 * 
	 * 
	 */
	static public function write_view_header($entity_name){
		
		$code = '
		<?php //include(dirname(__FILE__)."/'.$entity_name.'.php"); ?>
		<!-- Start the modal header empty -->
		<div class="modal w-100 h-100 p-0 m-0" id="viewModal">
  		<div class="modal-dialog modal-full" style="min-width:100%;min-height:100%;margin:0px;">
   		<div class="modal-content w-100 h-100 p-0 m-0 ">
		</div>
		</div>
		</div>
		
		
		
		<div class="row">
		
	<div class="col-12 col-md-3">
		<div class="card">
		    <div class="card-header">
		      <a class="card-link" data-toggle="collapse" href="#collapseParentLinks">
		        '.html_helper::cleanText($entity_name).' Parents
		      </a>
		    </div>
		    <div id="collapseParentLinks" class="collapse " data-parent="#accordion">
		      <div class="card-body">
		        <?php  
		        	if(isset($'.$entity_name.'->config[\'associations\'])){
		        		foreach($'.$entity_name.'->config[\'associations\'] as $entity=>$relationship){
		        			if($relationship == \'belongsTo\'){
		        					
		        				//if it is a company entity but we are not logged in
								//or if we do not have permission do not temp the user
								//with a link they cant navigate
			          			if ((in_array($entity, $map->company_dir)
								&& !company::isSessionLoggedIn())
								|| !$user->hasPermission(inflector::pluralize($entity) . \'_view\')
								){
									continue;	
								}
								
		        				echo \'<a class="page-link" href="index.php?pg=\'.inflector::pluralize($entity).\'">\'.html_helper::cleanText($entity).\'</a><br>\';
		        		}
		        	}
		        }?>
		      </div>
		    </div>
		</div>
  	</div>
	<div class="col-12 col-md-3">
		<div class="card">
	    	<div class="card-header">'.html_helper::cleanText(inflector::pluralize($entity_name)).'</div>
	    </div>
	</div>
	<div class="col-12 col-md-3">
		<div class="card">
	    	<div class="card-header">
		      <a class="card-link" data-toggle="collapse" href="#collapseCreate">Create a '.html_helper::cleanText($entity_name).'</a>
		    </div>
		    <div id="collapseCreate" class="collapse " data-parent="#accordion">
		      <div class="card-body">
		      	<?php
		      		if ($user->hasPermission("'.$entity_name.'_create")){
		      			include(dirname(__FILE__)."/forms/'.$entity_name.'_create.php");
					} ?>
			  </div>
		    </div>
		    
	    </div>
	</div>
	
	<div class="col-12 col-md-3">
	    <div class="card">
		    <div class="card-header">
		      <a class="card-link" data-toggle="collapse" href="#collapseChildLinks">
		        '.html_helper::cleanText($entity_name).' Children
		      </a>
		    </div>
		    <div id="collapseChildLinks" class="collapse " data-parent="#accordion">
		      <div class="card-body">
		        <?php  
		        	if(isset($'.$entity_name.'->config[\'associations\'])){
		        	foreach($'.$entity_name.'->config[\'associations\'] as $entity=>$relationship){
		        		if($relationship == \'has\'){
		        			
							//if it is a company entity but we are not logged in
							//or if we do not have permission do not temp the user
							//with a link they cant navigate
			          		if ((in_array($entity, $map->company_dir)
							&& !company::isSessionLoggedIn())
							|| !$user->hasPermission(inflector::pluralize($entity) . \'_view\')
							){
								continue;	
							}
							
							
		        			echo \'<a class="page-link" href="index.php?pg=\'.inflector::pluralize($entity).\'">\'.html_helper::cleanText($entity).\'</a><br>\';
		        		}
					}	
		        }?>
		      </div>
		    </div>
	    </div>
  	</div>
</div>';
	
	return $code;	
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_view_body($entity_name){
		$code = '
		<!-- END HEADER -->
<div class="row">
	
	
	<div class="col-12 col-md-12 m-auto">
		<div class="d-flex bg-secondary">
			<div class="mr-auto p-3">
				<button id="'.$entity_name.'_toggleview" class="btn btn-default searchViewToggle">Table</button>
				<?php
					$hooks->do_action("main_toolbar",$'.inflector::pluralize($entity_name).');
					$hooks->do_action("'.inflector::pluralize($entity_name).'_main_toolbar",$'.inflector::pluralize($entity_name).');
				?>
				
				
				
				
			</div>		
		
		
			<div id="main_view" class="ml-auto p-2">		
				<?php if($user->hasPermission("'.$entity_name.'_search")){include(dirname(__FILE__)."/forms/'.$entity_name.'_search.php");} ?>
			</div>
		</div>';
		$code = $code . html_helper::write_view_pagination($entity_name);
		
		$code = $code . '	
<!-- pagination here --> 
		
<!-- Begin Deck Here -->
		<div  class="row search_result_primary_'.$entity_name.'">
  
		    <?php
		    if(isset($'.inflector::pluralize($entity_name).'->config[\'defaultDataView\'])
			&& $'.inflector::pluralize($entity_name).'->config[\'defaultDataView\'] == "Tiles"){
				
				$entities = $'.inflector::pluralize($entity_name).';
				include(dirname(__FILE__).\'/default/dataview_tiles.php\');
		     	//echo html_helper::dataview_tiles($'.inflector::pluralize($entity_name).',"");
			}
			elseif( isset($'.inflector::pluralize($entity_name).'->config[\'defaultDataView\'])
			&& $'.inflector::pluralize($entity_name).'->config[\'defaultDataView\'] == "Table"){
				$entities = $'.inflector::pluralize($entity_name).';
				include(dirname(__FILE__).\'/default/dataview_table.php\');
		     	//echo html_helper::dataview_table($'.inflector::pluralize($entity_name).',"");
			} else {
				$entities = $'.inflector::pluralize($entity_name).';
				include(dirname(__FILE__).\'/default/dataview_tiles.php\');
				// echo html_helper::dataview_tiles($'.inflector::pluralize($entity_name).',""); 
			}
			
				
			?>
		
	</div>
</div>
		
		
		';
		
		
		
		return $code;
	}
//+++++++++++++++++++++++++++++++++++++++++++++
	static public function write_view_pagination($entity_name){
		$code = '
				
		<ul class="pagination">
			<li class="page-item"><a class="page-link" href="#">Previous</a></li>
			<?php
				
				for ($x = ($'.inflector::pluralize($entity_name).'->page_current - 3) ; $x <= 7 + $'.inflector::pluralize($entity_name).'->page_current; $x++){
					if($x > $'.inflector::pluralize($entity_name).'->page_current + 3
						|| $x > $'.inflector::pluralize($entity_name).'->page_count ){
						continue;
					}
					if($x <= 0){
						continue;
					}
					
					if($x == $'.inflector::pluralize($entity_name).'->page_current){
						echo \'<li class="page-item active"><a class="page-link" href="index.php?process=pagination&entity='.$entity_name.'&page=\'.$x.\'">\'.$x.\'</a></li>\';
					}
					else{echo \'<li class="page-item"><a class="page-link" href="index.php?process=pagination&entity='.$entity_name.'&page=\'.$x.\'">\'.$x.\'</a></li>\';}
					
				}
				
			?>
			<li class="page-item"><a class="page-link" href="#">Next</a></li>
		</ul>
		';	

		return $code;
	}	
//++++++++++++++++++++++++++++++++++++++++++++++++++	
	static public function write_entity_modal($entity_name){
		//$entity_object = new $entity_name();	
			
		$code = '
<!--
<div class="modal w-100 h-100 p-0 m-0" id="viewModal">
  <div class="modal-dialog modal-full" style="min-width:100%;min-height:100%;margin:0px;">
    <div class="modal-content w-100 h-100 p-0 m-0 ">
-->
      <!-- Modal Header -->
      <div class="modal-header p-0 m-0">
        <h4 class="modal-title"></h4>
        <button type="button" class="close border rounded closeModalButton" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" style="overflow-y;overflow-y:scroll">
      
      <!-- Place Media Div -->
      <div class="row">
	  <div class="col-12 modal_media_content scrolling-y" style="max-height:650;">
	  </div>
	  
	  
	  </div>
	  ';
	  
	  //Create row for node and linking modules
	  $code = $code . '<div class="row py-3">';	
	  //$code = $code . '<div class="col-12 col-md-4">' . html_helper::write_node_module($entity_name) . '</div>';
	  $code = $code . '<div class="col-12 col-md-4">' . writer::entity_edit_form($entity_name,FALSE) . html_helper::write_holder_module($entity_name). '</div>';
	  $code = $code . '<div class="col-12 col-md-8">' . html_helper::write_links_module($entity_name) . '</div>';
	  
	  
	  $code = $code . '</div>';
	  //end row for node and linking modules
	  
	  //$prop = get_object_vars($entity_object);
				
	 // foreach($prop as $k=>$v){
	//	if(in_array($k,baseEntity::getFormIgnoreList())){continue;}
	 // 	$code = $code . '<b>'.$k.':</b><span class="'.$entity_name.'_'.$k.'"></span></br>';
	  //}
	  
       
      $code = $code . '</div>

      <!-- Modal footer -->
      <div class="modal-footer p-0 m-0">
        <button type="button" class="p-1 m-1 btn btn-danger closeModalButton" data-dismiss="modal">Close</button>
      </div>
<!--
    </div>
  </div>
</div>
-->		
		';
		return $code;		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//	SUB-VIEW MODULES
//
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	
	//ENTITY MODAL NODES BOX
	static public function write_node_module($entity_name){
		$entity_object = new $entity_name();	
		$code = '
		
	<div class="card">
    <div class="card-header">
      <button class="btn border border-warning w-100" data-toggle="collapse" data-target="#node_content">
        Nodes
      </button>
    </div>
    <div id="node_content" class="collapse show " data-parent="#accordion">
      <div class="card-body p-0">
        
		<div class="nodeListContainer">';
			
		foreach($entity_object->config['associations'] as $k => $v){
			if($v == 'belongsTo'){
				if(baseEntity::hasNode(get_class($entity_object),$k)){
					
					//create node object 
					$node_name = baseEntity::createNodeName(get_class($entity_object),$k);
					$node_object = new $node_name();
					$parent_name = $k;
					$parent_object = new $k();
					
					$code = $code .  '
					<div class="nodeParentHeader pg-primary d-flex d-row p-1">
		        	<h3 class="mr-auto">'.html_helper::cleanText($k).': <span class="'.$parent_name.'_'.$parent_object->config['primaryIDProperty'].'"></span></h3>
		        	<button type="button" class="ml-auto  border rounded" >Find More?</button>
					
			        </div>
			        <div id="nodeParentList">
			        	<ul>';
						//Create the node list from it's properties
							foreach(get_class_vars($node_name) as $k => $v){
								if(!in_array($k,baseEntity::getFormIgnoreList())){
									$code = $code . '<li><b>'.$k.':</b> <span class="'.$node_name.'_'.$k.'">'.$v.'</span></li>';
								}
							}
			        		
						$code = $code . '</ul>
					</div>
					';
				}
			}
		}
	     //Close the node container   
		$code = $code . '
		</div>
      </div>
    </div>
  </div>
		';
		return $code;
	}
	
//ENTITY MODAL LINKS BOX
	static public function write_links_module($entity_name){
	$entity_object = new $entity_name();	
		$code = '
		
	<div class="card">
    <div class="card-header">
      <button class="btn border border-warning w-100" data-toggle="collapse" data-target=".link_content">
        Links
      </button>
    </div>
    <div id="" class="link_content collapse show " data-parent="#accordion">
      <div class="card-body p-0">
        
		<div class="linkListContainer">';
		
		foreach($entity_object->config['associations'] as $name => $relationship){
			if($relationship == "has"){
				
			$code = $code . '
			<div>
			 	<div class="w-100 d-flex d-row p-1">
			 	
        			<span class="mr-auto w-100 btn border" data-toggle="collapse" data-target=".link_child_content_'.$name.'">'.inflector::pluralize($name).'</span>
        			<button class="ml-auto btn border" data-toggle="collapse" data-target=".link_child_create_form_'.$name.'">
        			Add '.html_helper::cleanText($name).'
        			</button>
        			
      			</div>    
				<div id="" class="link_child_create_form_'.$name.' w-100 collapse" data-parent="#accordion">'.writer::entity_create_form($name).'</div>		
			</div>
			<div id="" class="link_child_content_'.$name.' collapse" data-parent="#accordion">
				
			</div>
			';
			}
		}
		
	     //Close the node container   
		$code = $code . '
		</div>
      </div>
    </div>
  </div>
		';
		return $code;
	}
	
	//ENTITY MODAL NODES BOX
	static public function write_holder_module($entity_name){
		global $user,$hooks;	
		$code = '
		
	<div class="card">
		<div class="card-header">Actions</div>
		<div class="card-body">';
				if($user->hasPermission($entity_name.'_delete')){$code = $code . '<button id="'.$entity_name.'_delete" class="float-left btn btn-danger deleteModalButton mr-1" type="button" >Delete</button>';}
		
					
					$hooks->do_action($entity_name.'_actions',"");
					
					//include entity actions...
					if(method_exists($entity_name,'actions')){
						$code = $code . $entity_name::actions();
					}
				
		$code = $code . '
			
		</div>
		
	</div>
		';
		return $code;
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_link_child_table($entity_name,$entity_id,$child_entity_name=NULL,$child_entity_id=NULL){
		global $user;
		$temp_user = $user;	
		$entity = new $entity_name();
		$entity->open($entity_id);
		$dummy_child_entity = new $child_entity_name();
		
		if($temp_user->hasPermission($child_entity_name."_search")){
			include(dirname(dirname(__FILE__)).'/view/forms/'.$child_entity_name.'_search.php');
		}
		$code = '<div class="search_result_'.$child_entity_name.'"><table class="w-100 table table-striped table-sm table-responsive-xs"></table></div>';
		
		//Determine if we have nodes before we create the table
		$hasNode = baseEntity::hasNode($entity_name,$child_entity_name);
		//Determin the node Entity Name
		if($hasNode){$nodeEntityName = baseEntity::createNodeName($entity_name,$child_entity_name);}
		
		//Start the code by creating a table
		
		$code = $code . '<table id="link_child_table_'.$child_entity_name.'" class="w-100 table table-striped table-sm table-responsive-">';
		
		
		//Create the actions col
		$code = $code . '<th>Actions</th>';
		//Add the child primary Header names
		 foreach($dummy_child_entity->config['primaryViewProperties'] as $headerTitle){
		 	$code = $code . '<th>'.html_helper::cleanText($headerTitle).'</th>';
		 }
		//if there is a node, add it's properties...
		if($hasNode){
			$node_entity = new $nodeEntityName();
			foreach($node_entity->config['primaryViewProperties'] as $headerTitle){
				$code = $code . '<th>'.html_helper::cleanText($headerTitle).'</th>';
			}
		}
		
		
		foreach($entity->getHasByEntity($child_entity_name) as $child_entity){
			
			$code = $code . '<tr><td>';
			//ACTION BUTTONS
			if($temp_user->hasPermission($child_entity_name."_edit")){
				$code = $code . '<div>
					<button id="editChildButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left editChildButton btn btn-secondary border" >Edit</button>
				</div>';	
			}
			
			if($temp_user->hasPermission(baseEntity::createNodeName($child_entity->class_name,$entity_name)."_unlink")){
				$code = $code . '<div>
					<button id="unlinkButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left unlinkChildButton btn btn-warning border" >Remove</button>
				</div>';
			}
			
			if($hasNode && $temp_user->hasPermission($nodeEntityName."_edit")){
				$code = $code . '<div>
					<button id="_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left updateChildButton btn btn-primary border">Update</button>
				</div>';
			}
			
			$hooks->do_action($entity_name.'_link_child_action',"");
			$hooks->do_action('link_child_action',"");	
			
					
			$code = $code . '</td>';

		foreach($child_entity->config['primaryViewProperties'] as $property){
				 	$code = $code . '<td>'.html_helper::cleanText($child_entity->$property).'</td>';
				 }
			//if the child has a node, add it's properties
			$cnt = 0;
			if($hasNode){
				$cnt++;
				if($cnt == 1){
					//make the node edit form
					//$code = $code . form_helper::write_form_start_inline($nodeEntityName.'_edit',$nodeEntityName);					
				}
				$node_entity = new $nodeEntityName();
				$node_entity->OpenByCompositeId($entity_id,$entity_name,$child_entity->id,$child_entity_name);
				
				foreach($node_entity->config['primaryViewProperties'] as $property){
					$code = $code . '<td><input id="'.$entity_id.'_'.$entity_name.'_'.$child_entity->id.'_'.$child_entity_name.'_'.$property.'" class="form-control" value="'.html_helper::cleanText($node_entity->$property).'"></input></td>';
				}
			
			}
			$code = $code . '</tr>';
		}
		//Close the table
		$code = $code . '</table>';
		return $code;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++=
	static public function write_link_child_search_table($entities,$parent){
		global $user, $hooks;	
			
		$code = '<table class="w-100 table table-striped table-sm table-responsive-xs">';
		
		//Loop the entities children of this type child type
		$cnt = 0;
		
		
		foreach($entities->entities as $child_entity){
			$cnt++;
			//if first iteration, create the header from the primary display fields
			if($cnt == 1){
				//Create the actions col
				$code = $code . '<th>Actions</th>';
				//Add the child primary Header names
				 foreach($child_entity->config['primaryViewProperties'] as $headerTitle){
				 	$code = $code . '<th>'.html_helper::cleanText($headerTitle).'</th>';
				 }
			}
			$code = $code . '<tr><td>';
	
			
			//ACTION BUTTONS
			if($user->hasPermission($child_entity->class_name.'_edit')){
				$code = $code . '<div>
					<button id="editChildButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left editChildButton btn btn-secondary border" >Edit</button>
				</div>';
			}
			if($user->hasPermission( baseEntity::createNodeName($child_entity->class_name, $parent) . '_link')){
				$code = $code . '<div>
				<button id="linkChildButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left linkChildButton btn btn-success border" >Add</button>
			</div>';
			}
			
			$hooks->do_action($entity_name.'_link_child_search_action',"");
			$hooks->do_action('link_child_search_action',"");
			
			
			$code = $code . '</td>';		
			
	
			//Add childs primary view properties
			foreach($child_entity->config['primaryViewProperties'] as $property){
				 	$code = $code . '<td>'.html_helper::cleanText($child_entity->$property).'</td>';
				 }
			
			$code = $code . '</tr>';
		}
		//Close the table
		$code = $code . '</table>';
		return $code;
		
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
static public function dataview_table($entities,$parent){
		global $user, $hooks;	
			
		$code = '<table class="w-100 table table-striped table-sm table-responsive-xs">';
		
		//Loop the entities children of this type child type
		$cnt = 0;
		
		
		foreach($entities->entities as $child_entity){
			$cnt++;
			//if first iteration, create the header from the primary display fields
			if($cnt == 1){
				//Create the actions col
				$code = $code . '<th>Actions</th>';
				//Add the child primary Header names
				 foreach($child_entity->config['primaryViewProperties'] as $headerTitle){
				 	$code = $code . '<th>'.html_helper::cleanText($headerTitle).'</th>';
				 }
			}
			$code = $code . '<tr><td>';
	
			
			//ACTION BUTTONS
			if($user->hasPermission($child_entity->class_name.'_edit')){
				$code = $code . '<div>
					<button id="editChildButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left editChildButton btn btn-secondary border" >Edit</button>
				</div>';
			}
			
			$hooks->do_action($child_entity->class_name.'_card_top',"");
			$hooks->do_action('card_top',"");
			
			//if($user->hasPermission( baseEntity::createNodeName($child_entity->class_name, $parent) . '_link')){
			//	$code = $code . '<div>
			//	<button id="linkChildButton_'.$child_entity->class_name.'_'.$child_entity->id.'" class="float-left linkChildButton btn btn-success border" >Add</button>
			//</div>';
			//}
			$code = $code . '</td>';		
			
	
			//Add childs primary view properties
			foreach($child_entity->config['primaryViewProperties'] as $property){
				 	$code = $code . '<td>'.html_helper::cleanText($child_entity->$property).'</td>';
				 }
			$hooks->do_action($child_entity->class_name.'_card_bottom',"");
			$hooks->do_action('card_bottom',"");
			
			$code = $code . '</tr>';
		}
		//Close the table
		$code = $code . '</table>';
		return $code;
		
	}



//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	static public function dataview_tiles($entities,$parent){
		global $user, $hooks;	
		
		$code = "";
		
		foreach($entities->entities as $entity){
				
			$entity_name = $entity->class_name;
			
		
			$code = $code . '
				
				<div class="col-12 col-md-3 p-2 ">
				<div class="card">
				<div class="card-header p-2"><b>'.$entity->config['primaryIDProperty'].' - <span class="'.$entity->class_name.'_'.$entity->id.'_'.$entity->config['primaryIDProperty'].'">'. 
				$entity->{$entity->config["primaryIDProperty"]}. '</span></b>
				
				<p class="hidden entity_id" style="display:none;" >'.$entity->id.'</p>';
				
				if($user->hasPermission($entity_name.'_edit')){
					$code = $code . '<button id="'.$entity_name.'_'.$entity->id.'" class="float-right btn btn-primary editModalButton mr-1" type="button" >Edit</button>';
				}
				if($user->hasPermission($entity_name.'_view')){
					$code = $code . '<button id="'.$entity_name.'_'.$entity->id.'" class="float-right btn btn-primary editModalButton mr-1" type="button" >View</button>';
				}
				
				$hooks->do_action($entity_name.'_card_top',"");
				$hooks->do_action('card_top',"");
				
				$code = $code .'
				</div><div style="max-height:350;"  class="scrolling-y ">' . html_helper::write_media_module_dynamic($entity_name,$entity->id)
				. '
				</div><div class="">
					<ul class="list-group">
					
				';
				if(isset($entity->config['primaryViewProperties'])){
					foreach($entity->config['primaryViewProperties'] as $property){
						$code = $code . '<li class="list-group-item  p-2">' . form_helper::cleanText($property) . ' -   <span class="' . $entity->class_name.'_'.$entity->id.'_'.$property.'"> '.$entity->$property.'<span></li>';
					}
				}
				//Show these parent nodes only when open/selected
				$code = $code . '<li class="list-group-item  p-2">Node Name:<br> children here</li>
				</ul></div>
				
				<div class="">
					<ul class="list-group">
					<div data-toggle="collapse" data-target="#childlist_'.$entity_name.'_'.$entity->id.'"> 
						<li class="list-group-item p-1">More...</li> 
					
					</div>
					
					 
					<div id="childlist_'.$entity_name.'_'.$entity->id.'" class="collapse">
					
				
				
				</div></ul>';
				
				$hooks->do_action($entity_name.'_card_bottom',"");
				$hooks->do_action('card_bottom',"");
				
				$code = $code . '</div>
				</div></div>';
				
			}
		//Close the table
		
		return $code;
		
	}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	static public function write_media_module_dynamic($entity_name,$entity_id){
		
		$code = '';	
		
		
		$entity_parent = new $entity_name();
		$entity_parent->Open($entity_id);
		
		$media_array = array();
		
		//if the parent is a media object, add it to the media array
		if($entity_parent->class_name == 'media'){
			array_push($media_array,$entity_parent);
			
		}
		//if the parent entity has media
		else{
			$media_array = $entity_parent->getHasByEntity('media');
		}
		
		foreach($media_array as $media){
			//if we are an image
			if($media->getType() == 'image'){
				$code = $code . '<img class="img-fluid mx-auto py-1 p-auto w-100" src="'.$media->mediaFile.'">';
			}
			
			//if we are a audio file
			if($media->getType() == 'audio'){
				$code = $code . '
				<audio controls class="img-fluid mx-auto py-1 p-auto  w-100">
				<source src="'.$media->mediaFile.'" type="audio/mpeg">
				
				Your browser does not support the audio element.
				</audio>
				'; 
			}
			
			//if we are a audio file
			if($media->getType() == 'video'){
				$code = $code . '
				<video controls class="img-fluid mx-auto py-1 p-auto  w-100">
				<source src="'.$media->mediaFile.'" type="video/mp4">
				
				Your browser does not support the audio element.
				</video>
				'; 
			}
			
			//if we are a audio file
			if($media->getType() == 'pdf'){
				$code = $code . '
				<object type="application/pdf" class="img-fluid mx-auto p-auto py-1 h-100 w-100" data="'.$media->mediaFile.'" style="min-height:600;">
				
				
				<p>The PDF cannot be displayed</p>
				</object>
				'; 
			}
		}	
		return $code;
	
	}




//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	static public function cleanText($text){
		return ucwords(str_replace( '_', ' ', preg_replace('/(?<!\ )[A-Z]/', ' $0', $text)));
	}

	

}
?>