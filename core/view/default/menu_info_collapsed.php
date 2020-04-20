<ul class='d-block d-sm-none d-none d-sm-block d-md-none  p-0 m-0 col-12 col-md-4 list-group list-group-flush float-md-right'>
	<li class="p-1 list-group-item list-group-item-secondary"><span class='font-weight-bold'>Username: </span>
		<?php echo '<span class="user_username">'.$user->username.'</span>';
			if($user->isLoggedIn()){echo '<a class="" href="index.php/?process=user_logout"><button class="btn btn-warning pt-0 pb-0 float-right">Logout</button></a>';}
			else{echo '<a class="" href="index.php?pg=user_login"><button class="btn btn-success pt-0 pb-0 float-right">Login</button></a>';}
		?>
	</li>
	<li class="p-1 list-group-item list-group-item-secondary"><span class='font-weight-bold'>Company Name: </span>
		<?php 
		if($user->isLoggedIn()){
			if(company::getLoggedInName()){echo $company->name;}
			if(company::getLoggedInName()){ 
				echo '<a class="" href="index.php/?process=company_logout"><button class="btn btn-warning pt-0 pb-0 float-right">Logout</button></a>';
			}
			else{
				include(dirname(dirname(__FILE__))."/forms/company_login.php");	
				//echo '<a class="" href="index.php?pg=company_login"><button class="btn btn-success pt-0 pb-0 float-right">Login</button></a>';
			}
			
		}
		?>
	</li>
	<li class="p-1 rounded-bottom shadow list-group-item list-group-item-secondary"><span class='font-weight-bold'>Store Number: </span><?php if(store::isSessionLoggedIn()){echo $store->store_number;} ?></li>
</ul>