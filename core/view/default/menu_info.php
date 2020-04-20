<div class="rounded d-none d-md-block m0 w-100 ">
    <ul class=' list-group list-group-flush '>
		<li class=" p-0 pl-1 list-group-item list-group-item-secondary"><span class='font-weight-bold'>Username: </span>
			<?php echo '<span class="user_username">'.$user->username.'</span>';
				if($user->isLoggedIn()){echo '<a class="" href="index.php/?process=user_logout"><button class="btn btn-warning pt-0 pb-0 m-1 float-right">Logout</button></a>';}
				else{echo '<a class="" href="index.php?pg=user_login"><button class="btn btn-success pt-0 pb-0 m-1 float-right">Login</button></a>';}
			?>
		</li>
		<li class="p-0 pl-1 list-group-item list-group-item-secondary"><span class='font-weight-bold'>Company Name: </span>
			<?php 
			if ($user->isLoggedIn()){
				if(company::getLoggedInName()){echo $company->name;}
				if(company::getLoggedInName()){ 
					echo '<a class="" href="index.php/?process=company_logout"><button class="btn btn-warning pt-0 pb-0 m-1 float-right">Logout</button></a>';
				} else { include(dirname(dirname(__FILE__))."/forms/company_login.php"); }
				
			}
			?>
		</li>
		<li class="p-0 pl-1 list-group-item list-group-item-secondary"><span class='font-weight-bold'>Store Number: </span><?php if(store::isSessionLoggedIn()){echo $store->store_number;} ?></li>
	</ul>
</div>