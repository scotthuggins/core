<form class="form-horizontal" role="form" method="post" action="index.php/?process=role_permission_remove">
  
  <div class="form-group">
  	<span class="col-xs-12 bg-danger"><?php echo GetErrors(); ?></span>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="role">Role Name:</label>
    <div class="col-sm-10">
      <select class="form-control" id="role" name="role">
      	<?php
			$role_table = New roles($connx);
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
    <label class="control-label col-sm-2" for="permission">Permission Name:</label>
    <div class="col-sm-10">
      <select class="form-control" id="permission" name="permission">
      	<?php
			$permission_table = New permissions($connx);
			$permission_table->SetSTMTSql("SELECT * FROM permission");    
			$permission_table->OpenEntities();
			foreach($permission_table->entities as $permission){
				echo '<option value="'.$permission->id.'">'.$permission->name.'</option>';
			}
      	?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Remove Permission</button>
    </div>
  </div>
</form>