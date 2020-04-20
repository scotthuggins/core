<form class="form-horizontal" role="form" method="post" action="index.php/?process=card_add">
  
  <div class="form-group">
  	<span class="col-xs-12 bg-danger"><?php echo GetErrors(); ?></span>
  </div>
  
  <div class="form-group">
    <label class="control-label col-12" for="name">Card Name:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" id="name" placeholder="Enter a name for this card" autocomplet="off" autofocus="on">
    </div>
  </div>

<div class="form-group">
    <label class="control-label col-12" for="role">Card Type:</label>
    <div class="col-12">
      <select class="form-control" id="cardType" name="cardType">
      	<?php
			foreach($card->getCardTypes() as $cardType){
				echo '<option value="'.$cardType.'">'.$cardType.'</option>';
			}
      	?>
      </select>
    </div>
  </div>


<div class="form-group">
    <label class="control-label col-12" for="ccNumber">Card Number:</label>
    <div class="col-12">
      <input type="number" class="form-control" name="ccNumber" value="<?php if(isset($session->form['ccNumber'])){echo $session->form['ccNumber'];}?>" id="ccNumber" placeholder="Enter the card number" autocomplet="off" autofocus="on">
    </div>
  </div>



<div class="form-group">
    <label class="control-label col-12">Expiration Date:</label>
    <div class="col-12">
    <select class="form-control" id="expMonth" name="expMonth">
      	<?php
			foreach($calendar->getMonths() as $month=>$monthName){
				echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
			}
      	?>
      </select>	
      <select class="form-control" id="expYear" name="expYear">
      	<?php
			foreach($calendar->getYearsFromNow(5) as $year){
				echo '<option value="'.$year.'">'.$year.'</option>';
			}
      	?>
      </select>
      
      
    </div>
  </div>
  

<div class="form-group">
    <label class="control-label col-12" for="cvv">CVV:</label>
    <div class="col-12">
      <input type="number" class="form-control" name="cvv" value="<?php if(isset($session->form['cvv'])){echo $session->form['cvv'];}?>" id="cvv" placeholder="Card CVV" autocomplet="off" autofocus="on">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-12" for="billingNameFirst">Billing Name First:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="billingNameFirst" value="<?php if(isset($session->form['billingNameFirst'])){echo $session->form['billingNameFirst'];}?>" id="billingNameFirst" placeholder="Enter your First Name" autocomplet="off" autofocus="on">
    </div>
  </div>
  
<div class="form-group">
    <label class="control-label col-12" for="billingNameLast">Billing Name Last:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="billingNameLast" value="<?php if(isset($session->form['billingNameLast'])){echo $session->form['billingNameLast'];}?>" id="billingNameLast" placeholder="Enter your Last Name" autocomplet="off" autofocus="on">
    </div>
  </div>

  
<div class="form-group">
    <label class="control-label col-12" for="billingNameLast">Billing Address:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="billingAddressLine1" value="<?php if(isset($session->form['billingAddressLine1'])){echo $session->form['billingAddressLine1'];}?>" id="billingAddressLine1" placeholder="Billing Address Line 1" autocomplet="off" autofocus="on">
      <input type="text" class="form-control" name="billingAddressLine2" value="<?php if(isset($session->form['billingAddressLine2'])){echo $session->form['billingAddressLine2'];}?>" id="billingAddressLine2" placeholder="Billing Address Line 2" autocomplet="off" autofocus="on">
      <input type="text" class="form-control" name="billingZip" value="<?php if(isset($session->form['billingZip'])){echo $session->form['billingZip'];}?>" id="billingZip" placeholder="Billing Zip" autocomplet="off" autofocus="on">
      <input type="text" class="form-control" name="billingState" value="<?php if(isset($session->form['billingState'])){echo $session->form['billingState'];}?>" id="billingState" placeholder="Billing State" autocomplet="off" autofocus="on">
    </div>
  </div>
	
	<div class="form-check ">
    <label class="form-check-label">
      <input class="form-check-input" type="checkbox" name="idDefault" id="isDefault" value="true"> Make this the default card.
    </label>
  </div>

	
		
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Add Card</button>
    </div>
  </div>


</form>
