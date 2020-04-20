<form class="form form-horizontal" id="user_edit" role="form" method="post" action="index.php/?process=user_edit"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group">
    				<label class="control-label col-12" for="username">Username:</label>
					<div class="col-12">
						<input type="text" class="form-control user_username  " id="" name="username" value="<?php if(isset($session->form['username'])){echo $session->form['username'];}?>" placeholder="Username of the new user" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="nameCompany">Name Company:</label>
					<div class="col-12">
						<input type="text" class="form-control user_nameCompany  " id="" name="nameCompany" value="<?php if(isset($session->form['nameCompany'])){echo $session->form['nameCompany'];}?>" placeholder="Name Company of the new user" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="nameFirst">Name First:</label>
					<div class="col-12">
						<input type="text" class="form-control user_nameFirst  " id="" name="nameFirst" value="<?php if(isset($session->form['nameFirst'])){echo $session->form['nameFirst'];}?>" placeholder="Name First of the new user" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="nameLast">Name Last:</label>
					<div class="col-12">
						<input type="text" class="form-control user_nameLast  " id="" name="nameLast" value="<?php if(isset($session->form['nameLast'])){echo $session->form['nameLast'];}?>" placeholder="Name Last of the new user" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="phone">Phone:</label>
					<div class="col-12">
						<input type="text" class="form-control user_phone  " id="" name="phone" value="<?php if(isset($session->form['phone'])){echo $session->form['phone'];}?>" placeholder="Phone of the new user" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="email">Email:</label>
					<div class="col-12">
						<input type="text" class="form-control user_email  " id="" name="email" value="<?php if(isset($session->form['email'])){echo $session->form['email'];}?>" placeholder="Email of the new user" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="avatarImage">Avatar Image:</label>
					<div class="col-12">
						<input type="text" class="form-control user_avatarImage  " id="" name="avatarImage" value="<?php if(isset($session->form['avatarImage'])){echo $session->form['avatarImage'];}?>" placeholder="Avatar Image of the new user" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group"><label class="control-label col-12">Join Date</label>
				<div class="col-12">
				<select class="form-control" id="_joinDate_month" name="joinDate_month">
				      	<?php
							foreach($calendar->getMonths() as $month=>$monthName){
								echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
							}
				      	?>
				</select>	
				</div>
	  			
			<div class="col-12">
			<select class="form-control" id="_joinDate_day" name="joinDate_day">
			      	<?php
			      		for($day = 1; $day<=31; $day++ ){
			      			echo '<option value="'.$day.'">'.$day.'</option>';
			      		}
						//foreach($calendar->getMonths() as $month=>$monthName){
						//	echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
						//}
			      	?>
			</select>	
			</div>	
			<div class="col-12">
			<select class="form-control" id="_joinDate_year" name="joinDate_year">
			  	<?php
					foreach($calendar->getYearsFromNow('5') as $year){
						echo '<option value="'.$year.'">'.$year.'</option>';
					}
			  	?>
			  </select>	
			</div>
			</div><div class="form-group"><label class="control-label col-12">Last Login Date</label>
				<div class="col-12">
				<select class="form-control" id="_lastLoginDate_month" name="lastLoginDate_month">
				      	<?php
							foreach($calendar->getMonths() as $month=>$monthName){
								echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
							}
				      	?>
				</select>	
				</div>
	  			
			<div class="col-12">
			<select class="form-control" id="_lastLoginDate_day" name="lastLoginDate_day">
			      	<?php
			      		for($day = 1; $day<=31; $day++ ){
			      			echo '<option value="'.$day.'">'.$day.'</option>';
			      		}
						//foreach($calendar->getMonths() as $month=>$monthName){
						//	echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
						//}
			      	?>
			</select>	
			</div>	
			<div class="col-12">
			<select class="form-control" id="_lastLoginDate_year" name="lastLoginDate_year">
			  	<?php
					foreach($calendar->getYearsFromNow('5') as $year){
						echo '<option value="'.$year.'">'.$year.'</option>';
					}
			  	?>
			  </select>	
			</div>
			</div><div class="form-group">
    				<label class="control-label col-12" for="password">Password:</label>
					<div class="col-12">
						<input type="text" class="form-control user_password  " id="" name="password" value="<?php if(isset($session->form['password'])){echo $session->form['password'];}?>" placeholder="Password of the new user" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="name">Name:</label>
					<div class="col-12">
						<input type="text" class="form-control user_name  " id="" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" placeholder="Name of the new user" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<input hidden type="text" class="form-control user_id" name="id" value="<?php if(isset($session->form['id'])){echo $session->form['id'];}?>" id="id" placeholder="Id of the new user" autocomplet="off" autofocus="on">
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="user_edit" class="btn btn-primary">Edit User</button>
		    </div>
	  	</div></form>