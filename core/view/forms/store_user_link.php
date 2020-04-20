<form class="form-horizontal" role="form" method="post" action="index.php/?process=store_user_link">
  
  <div class="form-group">
  	<span class="col-xs-12 bg-danger"><?php echo GetErrors(); ?></span>
  </div>
  
  <div class="form-group">
    <label class="control-label col-12" for="store_id">Store Number:</label>
    <div class="col-12">
      <select class="form-control" id="store_id" name="store_id">
      	<?php
			
			$stores->SetSTMTSql("SELECT * FROM store");    
			$stores->OpenEntities();
			foreach($stores->entities as $_store){
				echo '<option value="'.$_store->id.'">'.$_store->store_number.'</option>';
			}
      	?>
      </select>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-12" for="user_id">User Name:</label>
    <div class="col-12">
      <select class="form-control" id="user_id" name="user_id">
      	<?php
			$users->SetSTMTSql("SELECT * FROM user");    
			$users->OpenEntities();
			foreach($users->entities as $_user){
				echo '<option value="'.$_user->id.'">'.$_user->username .' - '.$_user->nameFirst .' '.$_user->nameLast  .'</option>';
			}
      	?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Link User to Store</button>
    </div>
  </div>
</form>