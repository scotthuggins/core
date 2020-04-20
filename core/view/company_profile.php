<div class="row">
		<div class="col-12 col-md-4 card bg-light">
			<div class="card-header">Billing Account Management</div>
			<div class="card-body text-center">
				<?php
					
						foreach($company->getHasbyEntity('card') as $_card){
							echo '<li>'.$_card->id.' - '.$_card->name.'</li>';
	    			}
				 ?>
				 
				 Total Employees: <?php echo $user_count = $company->countHasByEntity('user') ?><br>
				 Total Stores: <?php echo $store_count = $company->countHasByEntity('store') ?><br>
				 Total Billing: <?php 
				 	$c = cost_per_account 
				 	+((cost_per_store * $store_count) - cost_per_store)
				 	+((cost_per_employee * $user_count) - cost_per_employee);
				 	number_format($c,2);
				 	echo "$".$c;
				 
				 ?>				 
				 
			</div>
		</div>
		
		
		<div class="col-12 col-md-4 card bg-light">
			<div class="card-header">Create a company</div>
			<div class="card-body text-center">
				<?php include(dirname(__FILE__)."/forms/company_create.php"); ?>
			</div>
		</div>
		
		<div class="col-12 col-md-4 card bg-light">
			<div class="card-header">Manage add-ons</div>
			<div class="card-body text-center">
				 <div id="accordion">

						  <div class="card">
						    <div class="card-header">
						      <a class="card-link" data-toggle="collapse" href="#collapseOne">
						        Add an Employee
						      </a>
						    </div>
						    <div id="collapseOne" class="collapse " data-parent="#accordion">
						      <div class="card-body">
						        <?php include(dirname(__FILE__)."/forms/company_user_link.php"); ?>
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header">
						      <a class="card-link" data-toggle="collapse" href="#collapseOne.2">
						        Remove an Employee
						      </a>
						    </div>
						    <div id="collapseOne.2" class="collapse " data-parent="#accordion">
						      <div class="card-body">
						        <?php include(dirname(__FILE__)."/forms/company_user_unlink.php"); ?>
						      </div>
						    </div>
						  </div>
						
						  <div class="card">
						    <div class="card-header">
						      <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
						        Create a Store
						      </a>
						    </div>
						    <div id="collapseTwo" class="collapse" data-parent="#accordion">
						      <div class="card-body">
						        <?php include(dirname(__FILE__)."/forms/store_create.php"); ?>
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header">
						      <a class="collapsed card-link" data-toggle="collapse" href="#collapse21">
						        Create a Credit Card
						      </a>
						    </div>
						    <div id="collapse21" class="collapse" data-parent="#accordion21">
						      <div class="card-body">
						        <?php include(dirname(__FILE__)."/forms/card_create.php"); ?>
						      </div>
						    </div>
						  </div>						
						  <div class="card">
						    <div class="card-header">
						      <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
						        Add a Credit Card
						      </a>
						    </div>
						    <div id="collapseThree" class="collapse" data-parent="#accordion">
						      <div class="card-body">
						        <?php include(dirname(__FILE__)."/forms/card_add.php"); ?>
						      </div>
						    </div>
						  </div>
						   <div class="card">
						    <div class="card-header">
						      <a class="collapsed card-link" data-toggle="collapse" href="#collapse777">
						        Link Card Company 
						      </a>
						    </div>
						    <div id="collapse777" class="collapse" data-parent="#accordion">
						      <div class="card-body">
						        <?php include(dirname(__FILE__)."/forms/card_company_link.php"); ?>
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header">
						      <a class="collapsed card-link" data-toggle="collapse" href="#collapse444">
						        Un-Link Card Company 
						      </a>
						    </div>
						    <div id="collapse444" class="collapse" data-parent="#accordion">
						      <div class="card-body">
						        <?php include(dirname(__FILE__)."/forms/card_company_unlink.php"); ?>
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header">
						      <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
						        Remove Credit Card
						      </a>
						    </div>
						    <div id="collapseFour" class="collapse" data-parent="#accordion">
						      <div class="card-body">
						        <?php include(dirname(__FILE__)."/forms/card_remove.php"); ?>
						      </div>
						    </div>
						  </div>
						  
						  <div class="card">
						    <div class="card-header">
						      <a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">
						        Link Store to User
						      </a>
						    </div>
						    <div id="collapseFive" class="collapse" data-parent="#accordion">
						      <div class="card-body">
						        <?php include(dirname(__FILE__)."/forms/store_user_link.php"); ?>
						      </div>
						    </div>
						  </div>
						</div> 
			</div>
		</div>
		<div class="col-12 col-md-4 card bg-light">
			<div class="card-header">Company Outline</div>
			<div class="card-body text-center">
				<?php //print_r($users->entities);?>
				<p class="card-text"> Companies owned by user
					<?php
					foreach($user->getBelongsToByEntity('company') as $_company){
						echo '<li>'.$_company->name.'</li>';
					}
				 ?></p>
			</div>
		</div>
		<div class="col-12 col-md-4 card bg-light">
			<div class="card-header">Company Outline</div>
			<div class="card-body text-center">
				<?php //print_r($users->entities);?>
				<p class="card-text"> Company Employees
					<?php
						foreach($company->getHasbyEntity('user') as $employee){
							echo '<li>'.$employee->id.' - '.$employee->nameFirst.'</li>';
	    			}
				 ?></p>
			</div>
		</div>
		
		<div class="col-12 col-md-4 card bg-light">
			<div class="card-header">Company Outline</div>
			<div class="card-body text-center">
				<?php //print_r($users->entities);?>
				<p class="card-text"> Company Stores
					<?php
						foreach($company->getHasbyEntity('store') as $_store){
							
							echo '<li>'.$_store->id.' - '.$_store->store_number.'</li>';
							foreach($_store->getHasByEntity('user') as $_user){
								echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;'.$_user->id.'</li>';
							}
	    			}
				 ?></p>
				 
				 <p></p>
				 
			</div>
		</div>
</div>