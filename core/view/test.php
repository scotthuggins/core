<div class="row">
	<div class="col-4 card bg-light">
		<div class="card-header">User</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				print_r($user);
				echo '<br><br>';
				print_r($session_scan);
				echo '<br><br>';
				print_r($company_dir);
				echo '<br><br>';
				print_r(get_declared_classes());
				?>	
			</p>
		</div>
	</div>
	
	<div class="col-4 card bg-light">
		<div class="card-header">session</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				print_r($_SESSION);
				?>	
			</p>
		</div>
	</div>
	
	<div class="col-4 card bg-light">
		<div class="card-header">Media Obj</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				
				print_r($medias);
				
				?>	
			</p>
		</div>
	</div>
	
	<div class="col-4 card bg-light">
		<div class="card-header">SESSION</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				
				print_r($_SESSION);
				
				?>	
			</p>
		</div>
	</div>
	<div class="col-4 card bg-light">
		<div class="card-header">Create Company</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				
				
	print_r($company);	
				
				?>	
			</p>
		</div>
	</div>
	<div class="col-4 card bg-light">
		<div class="card-header">Assign a user</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				
				?>	
			</p>
		</div>
	</div>
	
	<div class="col-4 card bg-light">
		<div class="card-header">verify each object has or belongs to</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				?>	
			</p>
		</div>
	</div>
	<div class="col-4 card bg-light">
		<div class="card-header">remove association using removeHas()</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				?>	
			</p>
		</div>
	</div>
	<div class="col-4 card bg-light">
		<div class="card-header">Assign a user via BelongsTo</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				
				?>	
			</p>
		</div>
	</div>
	<div class="col-4 card bg-light">
		<div class="card-header">verify each object has or belongs to</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				?>	
			</p>
		</div>
	</div>
	<div class="col-4 card bg-light">
		<div class="card-header">remove via BelongsTo</div>
		<div class="card-body text-center">
			<p class="card-text">
				<?php
				
				?>		
			</p>
		</div>
	</div>
	
	
</div>

<?php

function print_class($object){
	echo '<p style="font-weight:bold;">'.get_class($object).':<p>';

	
	foreach(get_object_vars($object) as $property=>$value){
			
		if(is_object($value)){
			print_class($value);
			continue;
		}
		if(is_array($value)){
			echo "ARRAY: ".$property.'<br>';
			print_array($value);
			echo '<br>';
		}
		else{
			echo $property." = ".$value;
			echo '<br>';
		}		
	}
}

function print_array($array){
	foreach($array as $element=>$value){
		if(is_object($value)){
			print_class($value);
			continue;
		}
		if(is_array($value)){
			
			print_array($value);
		}
		else{
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$element." = ".$value;
			echo '<br>';
		}
	}
}

foreach(get_declared_classes() as $className){
	//we only have interst in classes that come from our files
	if(file_exists(dirname(dirname(__FILE__)).'/core/model/table/'.$className.'.php')
	|| file_exists(dirname(dirname(__FILE__)).'/core/model/entity/'.$className.'.php'))
	{
		//don't process these special object
	if($className == 'baseEntity'
	|| $className == 'baseEntityNode'
	|| $className == 'baseTable'
	|| $className == 'db'
	|| $className == 'dbs'
	|| $className == 'session'
	|| $className == 'error')
	{continue;}
		print_class($$className);
		
	}
}


?>
