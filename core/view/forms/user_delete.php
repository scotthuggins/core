<form class="form form-horizontal" id="user_delete" role="form" method="post" action="index.php/?process=user_delete"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="user">User</label>
					<select class="form-control mr-2 mb-2" id="user_delete_user" name="user"><option value="1"></option><option value="11"></option><option value="12"></option><option value="13"></option><option value="14"></option><option value="15"></option><option value="16"></option><option value="17"></option><option value="18"></option></select></div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="user_delete" class="btn btn-primary">Delete User</button>
		    </div>
	  	</div></form>