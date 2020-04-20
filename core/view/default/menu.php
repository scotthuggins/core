

<nav class="navbar navbar-expand-md fixed-top-sm fixed-top justify-content-start flex-nowrap bg-dark navbar-dark p-0 m-0" style="z-index:20000;">
    
    <?php include(dirname(__FILE__)."/navigation_menu.php"); ?>
    
    <!--<a class="navbar-brand" href="index.php?pg=home"><img style="width:150px" src="photos/sol.png" alt="Sol Solution"></a>-->	
    <button type="button" class="navbar-toggler ml-auto margin" data-toggle="collapse" data-target="#menu_info_collapse">
    	<span class="navbar-toggler-icon"></span>
    </button>
      
    <div class="collapse navbar-collapse" id="myNavbar">
     
    	
      
      	<ul class="nav navbar-nav ">
      	
      		<?php
      		if(!$user->isLoggedIn()){
				echo '<a class="" href="index.php?pg=user_login"><button class="btn btn-success pt-0 pb-0 m-1 float-left">Login</button></a>';
				echo '<a class="" href="index.php?pg=user_register"><button class="btn btn-success pt-0 pb-0 m-1 float-left">Sign Up</button></a>';
			}
      		?>
      	</ul>
      	
      	<?php 
  			if ($user->isLoggedIn()){
  				echo '<button type="button" class="ml-auto btn btn-dark d-none d-md-block" data-target="#menu_info_collapse" data-toggle="collapse">
  	 			<i class="fas fa-cog fa-2x"></i>
  				</button>';
			}
		?>
    </div>
  	
</nav>


	<!-- Second Nav bar -->
	<nav class="navbar navbar-expand-md fixed-top w-100 mt-5 m-0 p-0">
		<div class=" navbar-collapse w-100">
			<?php
			
			
			
			if(isset($entity_name) && !empty($entity_name)){
				include(dirname(__FILE__)."/entities_toolbar.php"); 
			}
			else {
				include(dirname(__FILE__)."/toolbar.php");
			}
			
				
			?>
		</div>
	</nav>
<div class="row bg-black " style="padding-top:200px; margin:0px; z-index:0;">
	
</div>
	
