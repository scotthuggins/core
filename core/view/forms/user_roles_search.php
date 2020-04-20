<form class="form-horizontal form-inline" role="form" method="post" action="index.php/?process=user_roles_search">
  
  <div class="form-group col-sm-12">
  	<span class=" bg-danger"><?php echo GetErrors(); ?></span>
  </div>
  
  <div class="form-group ">
    <label class="control-label" for="nameFirst"></label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="nameFirst" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" id="name" placeholder="Search Users" autocomplet="off" autofocus="on">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="nameCol">Column:</label>
    <div class="col-sm-5">
      <select class="form-control" id="nameCol" name="nameCol">
      	<?php
			      	
      	
			foreach(get_object_vars($user) as $k=>$v){
				echo '<option value="'.$k.'">'.$k.'</option>';	
			}
      	?>
      </select>
    </div>
  </div>
 		
  <div class="form-group">
    <div class="col-sm-2">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </div>

</form>
