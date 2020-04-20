<form class="form-inline" role="form" method="post" action="index.php/?process=company_login">
  
  <div class="form-group col-6">
    
    <div class="">
      <select class="form-control w-100 pt-0 pb-0 m-1 float-right" id="id" name="id">
      	<?php
      		//Get all the companies this user belongs to
			foreach($user->getBelongsToByEntity('company') as $parent){
				echo '<option value="'.$parent->id.'">'.$parent->name.'</option>';
			}
	  	?>
      </select>
    </div>
  </div>

  <div class="form-group col-6">
    <div class="w-100">
      <button type="submit" class="btn btn-warning pt-0 pb-0 m-1 float-right">Login to this Company</button>
    </div>
  </div>
</form>