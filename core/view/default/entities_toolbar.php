<div class="row w-100  bg-secondary m-0" >
	
	<div id="menu_info_collapse" class=" w-100 collapse nav-collapse float-right">
	    <?php 
	    	
	    	if($user->isLoggedIn()){
					include(dirname(__FILE__)."/menu_info.php");
					include(dirname(__FILE__)."/menu_info_collapsed.php");
			}
			if(!$user->isLoggedIn()){
				echo '<a class="" href="index.php?pg=user_login"><button class="btn btn-success pt-0 pb-0 m-1 float-left">Login</button></a>';
				echo '<a class="" href="index.php?pg=user_register"><button class="btn btn-success pt-0 pb-0 m-1 float-left">Sign Up</button></a>';
			}
			 
		?>
	</div>
	
	<div class="col-10 col-lg-6 ">
		<div>
		<?php
			if ($user->hasPermission($entity_name."_create")){
      			echo '<button class="btn btn-secondary" data-toggle="collapse" data-target="#create_form_container"><i class="fas fa-file-medical fa-2x"></i></button>';
			} 
			echo '<button id="'.$entity_name.'_toggleview" class="btn btn-secondary searchViewToggle"><i class="fas fa-list fa-2x"></i></button>';
			//echo '<button id="'.$entity_name.'_toggleview" class="btn btn-secondary searchViewCalendar"><i class="fas fa-calendar fa-2x"></i></button>';				
			//$plur_entity = inflector::pluralize($entity_name);
			$hooks->do_action("main_toolbar",${$plur_entity});
			$hooks->do_action($entity_name."_main_toolbar",${$plur_entity});
			//echo '<button id="entity_navigation_toggleview" class="btn btn-secondary float-right"><i class="fas fa-project-diagram fa-2x"></i></button>';
		?>
		<input data-onstyle="info" data-offstyle="warning" type="checkbox" checked data-toggle="toggle" data-on="<i class='fa fa-book-open'></i> Play" data-off="<i class='fa fa-arrows-alt-v'></i> Play">
		</div>
	</div>		
	
	
<!-- small search view -->
	<div class="d-none d-block d-sm-block d-md-none col-2 col-lg-6 " id="main_view">
		<?php
			if($user->hasPermission($entity_name."_search")){
				echo '<button class="ml-auto btn btn-secondary" data-toggle="collapse" data-target="#search_form_container"><i class="fas fa-search fa-2x"></i></button>';
			}
		?>
	</div>
	
<!-- medium search view -->
	
	<div class="d-none d-md-block col-xs-12 col-lg-6 p-0 " id="main_view">		
		<?php if($user->hasPermission($entity_name."_search")){include(dirname(dirname(__FILE__))."/forms/".$entity_name."_search.php");} ?>
	</div>



	

<!-- create/search form container -->
<?php
	
	if ($user->hasPermission($entity_name."_create")){
		
		echo '<div id="create_form_container" class=" border rounded-bottom col-12 collapse bg-light pb-1 pt-1 mb-2">';	
			include(dirname(dirname(__FILE__))."/forms/".$entity_name."_create.php");
		echo '</div>';
	} 
	if ($user->hasPermission($entity_name."_search")){
		
		echo '<div id="search_form_container" class=" border rounded-bottom col-12 collapse bg-light pb-1 pt-1 mb-2">';	
			include(dirname(dirname(__FILE__))."/forms/".$entity_name."_search.php");
		echo '</div>';
	} 
?>

	<div class="pagination_container col-12 col-md-6">
		<?php include(dirname(__FILE__)."/pagination.php"); ?>		
	</div>	
	
</div>
