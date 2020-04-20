<form class="form form-horizontal" id="company_edit" role="form" method="post" action="index.php/?process=company_edit"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group">
    				<label class="control-label col-12" for="phone">Phone:</label>
					<div class="col-12">
						<input type="text" class="form-control company_phone  " id="" name="phone" value="<?php if(isset($session->form['phone'])){echo $session->form['phone'];}?>" placeholder="Phone of the new company" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="email">Email:</label>
					<div class="col-12">
						<input type="text" class="form-control company_email  " id="" name="email" value="<?php if(isset($session->form['email'])){echo $session->form['email'];}?>" placeholder="Email of the new company" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="logoImage">Logo Image:</label>
					<div class="col-12">
						<input type="text" class="form-control company_logoImage  " id="" name="logoImage" value="<?php if(isset($session->form['logoImage'])){echo $session->form['logoImage'];}?>" placeholder="Logo Image of the new company" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group"><label class="control-label col-12">Founded Date</label>
				<div class="col-12">
				<select class="form-control" id="_foundedDate_month" name="foundedDate_month">
				      	<?php
							foreach($calendar->getMonths() as $month=>$monthName){
								echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
							}
				      	?>
				</select>	
				</div>
	  			
			<div class="col-12">
			<select class="form-control" id="_foundedDate_day" name="foundedDate_day">
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
			<select class="form-control" id="_foundedDate_year" name="foundedDate_year">
			  	<?php
					foreach($calendar->getYearsFromNow('5') as $year){
						echo '<option value="'.$year.'">'.$year.'</option>';
					}
			  	?>
			  </select>	
			</div>
			</div><div class="form-group">
    				<label class="control-label col-12" for="name">Name:</label>
					<div class="col-12">
						<input type="text" class="form-control company_name  " id="" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" placeholder="Name of the new company" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<input hidden type="text" class="form-control company_id" name="id" value="<?php if(isset($session->form['id'])){echo $session->form['id'];}?>" id="id" placeholder="Id of the new company" autocomplet="off" autofocus="on">
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="company_edit" class="btn btn-primary">Edit Company</button>
		    </div>
	  	</div></form>