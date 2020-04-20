<form class="form-horizontal" role="form" method="post" action="index.php/?process=store_login">
  
  <div class="form-group">
  	<span class="col-xs-12 bg-danger"><?php echo GetErrors(); ?></span>
  </div>
  
  <div class="form-group">
    <label class="control-label col-12" for="store_id">Store Number:</label>
    <div class="col-sm-11">
      <select class="form-control" id="store_id" name="store_id">
      	<?php
      		
      		//Get all the companies this user belongs to
			foreach($company->getHasByEntity('store') as $parent){
				echo '<option value="'.$parent->id.'">'.$parent->store_number.'</option>';
			}
	  	?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Login to this Store</button>
    </div>
  </div>
</form>