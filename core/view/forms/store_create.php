<form class="form form-horizontal" id="store_create" role="form" method="post" enctype="multipart/form-data" action="index.php/?process=store_create"><div class="form-group">
    				<label class="control-label col-12" for="store_number">Store Number:</label>
					<div class="col-12">
						<input type="text" class="form-control store_store_number  " id="" name="store_number" value="<?php if(isset($session->form['store_number'])){echo $session->form['store_number'];}?>" placeholder="Store Number of the new store" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="name">Name:</label>
					<div class="col-12">
						<input type="text" class="form-control store_name  " id="" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" placeholder="Name of the new store" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="store_create" class="btn btn-primary">Create Store</button>
		    </div>
	  	</div></form>