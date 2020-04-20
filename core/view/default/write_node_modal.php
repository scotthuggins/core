<?php

echo '
<div class="card">
    <div class="card-header">
      <button class="btn border border-warning w-100" data-toggle="collapse" data-target="#node_content">
        Nodes
      </button>
    </div>
    <div id="node_content" class="collapse show " data-parent="#accordion">
      <div class="card-body p-0">
        
		<div class="nodeListContainer">
';
		foreach($entity_object->config['associations']['belongsTo'] as $k){
			//if($v == 'belongsTo'){
				if(baseEntity::hasNode(get_class($entity_object),$k)){
					
					//create node object 
					$node_name = baseEntity::createNodeName(get_class($entity_object),$k);
					$node_object = new $node_name();
					$parent_name = $k;
					$parent_object = new $k();
					
					echo  '
					<div class="nodeParentHeader pg-primary d-flex d-row p-1">
		        	<h3 class="mr-auto">'.html_helper::cleanText($k).': <span class="'.$parent_name.'_'.$parent_object->config['primaryIDProperty'].'"></span></h3>
		        	<button type="button" class="ml-auto  border rounded" >Find More?</button>
					
			        </div>
			        <div id="nodeParentList">
			        	<ul>';
						//Create the node list from it's properties
							foreach(get_class_vars($node_name) as $k => $v){
								if(!in_array($k,baseEntity::getFormIgnoreList())){
									echo '<li><b>'.$k.':</b> <span class="'.$node_name.'_'.$k.'">'.$v.'</span></li>';
								}
							}
			        		
						echo '</ul>
					</div>
					';
				}
			//}
		}
		
	    echo '
		</div>
      </div>
    </div>
  </div>';
?>
