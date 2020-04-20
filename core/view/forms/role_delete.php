<form class="form form-horizontal" id="role_delete" role="form" method="post" action="index.php/?process=role_delete"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="role">Role</label>
					<select class="form-control mr-2 mb-2" id="role_delete_role" name="role"><option value="2"></option><option value="3"></option></select></div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="role_delete" class="btn btn-primary">Delete Role</button>
		    </div>
	  	</div></form>