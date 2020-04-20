<form class="form form-horizontal" id="role_edit" role="form" method="post" action="index.php/?process=role_edit"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group">
    				<label class="control-label col-12" for="name">Name:</label>
					<div class="col-12">
						<input type="text" class="form-control role_name  " id="" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" placeholder="Name of the new role" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<input hidden type="text" class="form-control role_id" name="id" value="<?php if(isset($session->form['id'])){echo $session->form['id'];}?>" id="id" placeholder="Id of the new role" autocomplet="off" autofocus="on">
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="role_edit" class="btn btn-primary">Edit Role</button>
		    </div>
	  	</div></form>