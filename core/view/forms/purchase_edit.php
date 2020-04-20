<form class="form form-horizontal" id="purchase_edit" role="form" method="post" action="index.php/?process=purchase_edit"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group"><label class="control-label col-12">Created Date</label>
				<div class="col-12">
				<select class="form-control" id="1584640671_createdDate_month" name="createdDate_month">
				      	<?php
							foreach($calendar->getMonths() as $month=>$monthName){
								echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
							}
				      	?>
				</select>	
				</div>
	  			
			<div class="col-12">
			<select class="form-control" id="1584640671_createdDate_day" name="createdDate_day">
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
			<select class="form-control" id="1584640671_createdDate_year" name="createdDate_year">
			  	<?php
					foreach($calendar->getYearsFromNow('5') as $year){
						echo '<option value="'.$year.'">'.$year.'</option>';
					}
			  	?>
			  </select>	
			</div>
			</div><div class="form-group"><label class="control-label col-12">Start Date</label>
				<div class="col-12">
				<select class="form-control" id="1584640671_startDate_month" name="startDate_month">
				      	<?php
							foreach($calendar->getMonths() as $month=>$monthName){
								echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
							}
				      	?>
				</select>	
				</div>
	  			
			<div class="col-12">
			<select class="form-control" id="1584640671_startDate_day" name="startDate_day">
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
			<select class="form-control" id="1584640671_startDate_year" name="startDate_year">
			  	<?php
					foreach($calendar->getYearsFromNow('5') as $year){
						echo '<option value="'.$year.'">'.$year.'</option>';
					}
			  	?>
			  </select>	
			</div>
			</div><div class="form-group"><label class="control-label col-12">End Date</label>
				<div class="col-12">
				<select class="form-control" id="1584640671_endDate_month" name="endDate_month">
				      	<?php
							foreach($calendar->getMonths() as $month=>$monthName){
								echo '<option value="'.$month.'">['.$month.'] '.$monthName.'</option>';
							}
				      	?>
				</select>	
				</div>
	  			
			<div class="col-12">
			<select class="form-control" id="1584640671_endDate_day" name="endDate_day">
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
			<select class="form-control" id="1584640671_endDate_year" name="endDate_year">
			  	<?php
					foreach($calendar->getYearsFromNow('5') as $year){
						echo '<option value="'.$year.'">'.$year.'</option>';
					}
			  	?>
			  </select>	
			</div>
			</div><div class="form-group">
    				<label class="control-label col-12" for="PoNumber"> Po Number:</label>
					<div class="col-12">
						<input type="text" class="form-control purchase_PoNumber  " id="" name="PoNumber" value="<?php if(isset($session->form['PoNumber'])){echo $session->form['PoNumber'];}?>" placeholder=" Po Number of the new order" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group"><label class="control-label col-12">Status Color:</label>	
			<div class="col-12">
			<select class="form-control" id="_statusColor" name="statusColor">
			  	<?php
					foreach($colors->getPalette("default") as $color => $name){
						echo '<option value="'.$color.'" style="background:#'.$color.';">'.$name.'</option>';
					}
			  	?>
			  </select>	
			</div>
			</div><div class="form-group">
    				<label class="control-label col-12" for="name">Name:</label>
					<div class="col-12">
						<input type="text" class="form-control purchase_name  " id="" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" placeholder="Name of the new order" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<input hidden type="text" class="form-control purchase_id" name="id" value="<?php if(isset($session->form['id'])){echo $session->form['id'];}?>" id="id" placeholder="Id of the new order" autocomplet="off" autofocus="on">
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="purchase_edit" class="btn btn-primary">Edit Order</button>
		    </div>
	  	</div></form>