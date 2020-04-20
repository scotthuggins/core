<form class="form-horizontal" role="form" method="post" action="index.php/?process=product_add">
  
  <div class="form-group">
  	<span class="col-12 bg-danger"><?php echo GetErrors(); ?></span>
  </div>
  
  <div class="form-group">
    <label class="control-label col-12" for="name">Product Name:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" id="name" placeholder="Name the product" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-12" for="make">Make:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="make" value="<?php if(isset($session->form['make'])){echo $session->form['make'];}?>" id="make" placeholder="Make/Manufacturer" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-12" for="model">Model:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="model" value="<?php if(isset($session->form['model'])){echo $session->form['model'];}?>" id="model" placeholder="Model" autocomplet="off" autofocus="on">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-12" for="desc_short">Product Description - Short:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="desc_short" value="<?php if(isset($session->form['desc_short'])){echo $session->form['desc_short'];}?>" id="desc_short" placeholder="Short Description" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-12" for="desc_long">Product Description - Long:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="desc_long" value="<?php if(isset($session->form['desc_long'])){echo $session->form['desc_long'];}?>" id="desc_long" placeholder="Long Description" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-12" for="price_rent">Rental Price:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="price_rent" value="<?php if(isset($session->form['price_rent'])){echo $session->form['price_rent'];}?>" id="price_rent" placeholder="Base rental price($x.xx)" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-12" for="price_buy">Purchase Price:</label>
    <div class="col-12">
      <input type="text" class="form-control" name="price_buy" value="<?php if(isset($session->form['price_buy'])){echo $session->form['price_buy'];}?>" id="price_buy" placeholder="Base purchase price($x.xx)" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-12" for="dims">Product Dimensions (inches)</label>
    <div class="col-12">
      <input type="text" class="form-control" name="dim_x" value="<?php if(isset($session->form['dim_x'])){echo $session->form['dim_x'];}?>" id="dim_x" placeholder="X dim in inches" autocomplet="off" autofocus="on">
    </div>
    <div class="col-12">
      <input type="text" class="form-control" name="dim_y" value="<?php if(isset($session->form['dim_y'])){echo $session->form['dim_y'];}?>" id="dim_y" placeholder="Y dim in inches" autocomplet="off" autofocus="on">
    </div>
    <div class="col-12">
      <input type="text" class="form-control" name="dim_z" value="<?php if(isset($session->form['dim_z'])){echo $session->form['dim_z'];}?>" id="dim_z" placeholder="Z dim in inches" autocomplet="off" autofocus="on">
    </div>
    <div class="col-12">
      <input type="text" class="form-control" name="weight" value="<?php if(isset($session->form['weight'])){echo $session->form['weight'];}?>" id="weight" placeholder="Weight in pounds" autocomplet="off" autofocus="on">
    </div>
    <div class="col-12">
      <input type="text" class="form-control" name="weight_shipping" value="<?php if(isset($session->form['weight_shipping'])){echo $session->form['weight_shipping'];}?>" id="weight_shipping" placeholder="Shipping Weight in pounds" autocomplet="off" autofocus="on">
    </div>
  </div>
  
 		
  <div class="form-group">
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Create New Product</button>
    </div>
  </div>

</form>
