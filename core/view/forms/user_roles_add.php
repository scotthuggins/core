<form class="form-horizontal" role="form" method="post" action="index.php/?process=user_roles_add">
  
  <div class="form-group">
  	<span class="col-xs-12 bg-danger"><?php echo GetErrors(); ?></span>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="role">Role Name:</label>
    <div class="col-sm-10">
      <select class="form-control" id="role" name="role">
      	<?php
			$role_table = New roles($connx,'role');
			$role_table->SetSTMTSql("SELECT * FROM role");    
			$role_table->OpenEntities();
			foreach($role_table->entities as $role){
				echo '<option value="'.$role->id.'">'.$role->name.'</option>';
			}
      	?>
      </select>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="user">User Name:</label>
    <div class="col-sm-10">
      <select class="form-control" id="user" name="user">
      	<?php
			$user_table = New users($connx,'user');
			$user_table->SetSTMTSql("SELECT * FROM user");    
			$user_table->OpenEntities();
			foreach($user_table->entities as $_user){
				echo '<option value="'.$_user->id.'">'.$_user->nameLast.', '.$_user->nameFirst.' - ('.$_user->username.')</option>';
			}
      	?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Assign Role</button>
    </div>
  </div>
</form>