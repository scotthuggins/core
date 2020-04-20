<div id="entity_navigation_menu" class=" float-right">
	

	<div class="dropdown float-left">
  		<button class=" btn btn-dark  m-1 p-0 pl-2 dropdown-toggle" data-toggle="dropdown"><i class="fas fa-project-diagram fa-2x"></i></button>
  	
  		<div class="dropdown-menu">
  			<a class="dropdown-item" href="index.php?pg=home">Home</a>
  			
  			<?php
  		  		foreach($map->all_entities as $dir){
        			//if it is a company entity but we are not logged in
					//or if we don't have permission don't temp the user
					//with a link they cant navigate
          			if ((in_array($dir, $map->company_dir)
					&& !company::isSessionLoggedIn())
					|| !$user->hasPermission(inflector::pluralize($dir) . '_view')
					){
						continue;	
					}
					//if it is a node, continue
					if(baseEntity::isNodeStatic($dir)){
						continue;
					}
					echo '<a class="dropdown-item" href="index.php?pg=' . inflector::pluralize($dir) . '">' . html_helper::cleanText(inflector::pluralize(${$dir}->getPublicName())) . '</a>';					
          		}
          	?>
    		
  		</div>
  	</div>
	
	<?php
		if (isset(${$this->controller->action}) 
		&& is_object(${$this->controller->action}) 
		&& in_array(get_class(${$this->controller->action}),$map->all_dir)){
					
			echo '<div class="dropdown float-left">
  		<button class=" btn btn-light  m-1 dropdown-toggle" data-toggle="dropdown"><i class="fas fa-level-up-alt fa-1x"></i> <i class="fas fa-ellipsis-h fa-1x"></i></button>
  	
  		<div class="dropdown-menu">';	
			foreach (${$this->controller->action}->config['associations']['belongsTo'] as $dir){
          				
					//if it is a company entity but we are not logged in
					//or if we don't have permission don't temp the user
					//with a link they cant navigate
          			if ((in_array($dir, $map->company_dir)
					&& !company::isSessionLoggedIn())
					|| !$user->hasPermission(inflector::pluralize($dir) . '_view')
					){
						continue;	
					}
					//if it is a node, continue
					if (baseEntity::isNodeStatic($dir)){
						continue;
					}
					echo '<a class="dropdown-item text-capitalize" href="index.php?pg=' . inflector::pluralize($dir) . '">' . html_helper::cleanText(inflector::pluralize(${$dir}->getPublicName())) . '</a>';					
          		}
			echo '	</div>
  		</div>';
			}
	?>	
	
  	<div class="float-left">
  		<button class="btn btn-warning btn-outline-light  m-1 text-capitalize font-weight-bolder text-dark " >
  			<?php 
  				if (isset(${$this->controller->action}) && is_object(${$this->controller->action})){
  					echo html_helper::cleanText(inflector::pluralize(${inflector::singularize($this->controller->action)}->getPublicName()));
				} else {
					echo html_helper::cleanText($this->controller->action);
				} 
			?>
  		</button>
  	</div>
  	
  	<?php
		if (isset(${$this->controller->action}) 
		&& is_object(${$this->controller->action}) 
		&& in_array(get_class(${$this->controller->action}),$map->all_dir)){
					
			echo '<div class="dropdown float-left">
  		<button class=" btn btn-light  m-1 dropdown-toggle" data-toggle="dropdown"><i class="fas fa-level-down-alt fa-1x"></i> <i class="fas fa-ellipsis-h fa-1x"></i></button>
  	
  		<div class="dropdown-menu">';	
			foreach(${$this->controller->action}->config['associations']['has'] as $dir){
          				
					//if it is a company entity but we are not logged in
					//or if we don't have permission don't temp the user
					//with a link they cant navigate
          			if ((in_array($dir, $map->company_dir)
					&& !company::isSessionLoggedIn())
					|| !$user->hasPermission(inflector::pluralize($dir) . '_view')
					){
						continue;	
					}
					//if it is a node, continue
					if(baseEntity::isNodeStatic($dir)){
						continue;
					}
					echo '<a class="dropdown-item text-capitalize" href="index.php?pg=' . inflector::pluralize($dir) . '">' . html_helper::cleanText(inflector::pluralize(${$dir}->getPublicName())) . '</a>';					
          		}
			echo '	</div>
  		</div>';
			}
	
	
	?>	
</div> 			
					
					
				