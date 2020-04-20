<form class="form form-horizontal" id="category_create" role="form" method="post" enctype="multipart/form-data" action="index.php/?process=category_create"><div class="form-group">
    				<label class="control-label col-12" for="name">Name:</label>
					<div class="col-12">
						<input type="text" class="form-control category_name  " id="" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" placeholder="Name of the new category" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="category_create" class="btn btn-primary">Create Category</button>
		    </div>
	  	</div></form>