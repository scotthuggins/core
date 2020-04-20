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
	
	
</div>
