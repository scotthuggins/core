<form class="form form-horizontal" id="card_create" role="form" method="post" enctype="multipart/form-data" action="index.php/?process=card_create"><div class="form-group">
    				<label class="control-label col-12" for="name">Name:</label>
					<div class="col-12">
						<input type="text" class="form-control card_name  " id="" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" placeholder="Name of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<label class="control-label col-12">Exp Month</label>
				<div class="col-12">
				<select class="form-control" id="0_expMonth_month" name="expMonth_month">
				      	<?php
							foreach($calendar->getMonths() as $month=>$monthName){
								echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
							}
				      	?>
				</select>	
				</div>
	  		<label class="control-label col-12">Exp Year</label>	
			<div class="col-12">
			<select class="form-control" id="0_expYear_year" name="expYear_year">
			  	<?php
					foreach($calendar->getYearsFromNow('5') as $year){
						echo '<option value="'.$year.'">'.$year.'</option>';
					}
			  	?>
			  </select>	
			</div>
			<div class="form-group">
    				<label class="control-label col-12" for="ccNumber">Cc Number:</label>
					<div class="col-12">
						<input type="text" class="form-control card_ccNumber  " id="0" name="ccNumber" value="<?php if(isset($session->form['ccNumber'])){echo $session->form['ccNumber'];}?>" placeholder="Cc Number of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="billingNameFirst">Billing Name First:</label>
					<div class="col-12">
						<input type="text" class="form-control card_billingNameFirst  " id="first Name" name="billingNameFirst" value="<?php if(isset($session->form['billingNameFirst'])){echo $session->form['billingNameFirst'];}?>" placeholder="Billing Name First of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="billingNameLast">Billing Name Last:</label>
					<div class="col-12">
						<input type="text" class="form-control card_billingNameLast  " id="last name" name="billingNameLast" value="<?php if(isset($session->form['billingNameLast'])){echo $session->form['billingNameLast'];}?>" placeholder="Billing Name Last of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="billingAddressLine1">Billing Address Line1:</label>
					<div class="col-12">
						<input type="text" class="form-control card_billingAddressLine1  " id="address line one" name="billingAddressLine1" value="<?php if(isset($session->form['billingAddressLine1'])){echo $session->form['billingAddressLine1'];}?>" placeholder="Billing Address Line1 of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="billingAddressLine2">Billing Address Line2:</label>
					<div class="col-12">
						<input type="text" class="form-control card_billingAddressLine2  " id="address line two" name="billingAddressLine2" value="<?php if(isset($session->form['billingAddressLine2'])){echo $session->form['billingAddressLine2'];}?>" placeholder="Billing Address Line2 of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="billingZip">Billing Zip:</label>
					<div class="col-12">
						<input type="text" class="form-control card_billingZip  " id="0" name="billingZip" value="<?php if(isset($session->form['billingZip'])){echo $session->form['billingZip'];}?>" placeholder="Billing Zip of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="billingState">Billing State:</label>
					<div class="col-12">
						<input type="text" class="form-control card_billingState  " id="XX" name="billingState" value="<?php if(isset($session->form['billingState'])){echo $session->form['billingState'];}?>" placeholder="Billing State of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="cardType">Card Type:</label>
					<div class="col-12">
						<input type="text" class="form-control card_cardType  " id="XXXX" name="cardType" value="<?php if(isset($session->form['cardType'])){echo $session->form['cardType'];}?>" placeholder="Card Type of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="cvv">Cvv:</label>
					<div class="col-12">
						<input type="text" class="form-control card_cvv  " id="0" name="cvv" value="<?php if(isset($session->form['cvv'])){echo $session->form['cvv'];}?>" placeholder="Cvv of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="isDefault">Is Default:</label>
					<div class="col-12">
						<input type="text" class="form-control card_isDefault  " id="1" name="isDefault" value="<?php if(isset($session->form['isDefault'])){echo $session->form['isDefault'];}?>" placeholder="Is Default of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="card_create" class="btn btn-primary">Create Card</button>
		    </div>
	  	</div></form>