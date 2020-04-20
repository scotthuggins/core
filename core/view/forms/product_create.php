<form class="form form-horizontal" id="product_create" role="form" method="post" enctype="multipart/form-data" action="index.php/?process=product_create"><div class="form-group">
    				<label class="control-label col-12" for="desc_short">Desc Short:</label>
					<div class="col-12">
						<input type="text" class="form-control product_desc_short  " id="" name="desc_short" value="<?php if(isset($session->form['desc_short'])){echo $session->form['desc_short'];}?>" placeholder="Desc Short of the new product" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="desc_long">Desc Long:</label>
					<div class="col-12">
						<input type="text" class="form-control product_desc_long  " id="" name="desc_long" value="<?php if(isset($session->form['desc_long'])){echo $session->form['desc_long'];}?>" placeholder="Desc Long of the new product" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="name">Name:</label>
					<div class="col-12">
						<input type="text" class="form-control product_name  " id="" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" placeholder="Name of the new product" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="product_create" class="btn btn-primary">Create Product</button>
		    </div>
	  	</div></form>