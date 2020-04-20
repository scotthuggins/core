<form class="form-horizontal" role="form" method="post" action="index.php/?process=category_link">
  
  <div class="form-group">
  	<span class="col-xs-12 bg-danger"><?php echo GetErrors(); ?></span>
  </div>
  
  <div class="form-group">
    <label class="control-label col-12" for="parent_id">Parent Category:</label>
    <div class="col-12">
      <select class="form-control" id="parent_id" name="parent_id">
      	<?php
			
			$categories->SetSTMTSql("SELECT * FROM category");    
			$categories->OpenEntities();
			foreach($categories->entities as $_category){
				echo '<option value="'.$_category->id.'">'.$_category->name.'</option>';
			}
      	?>
      </select>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-12" for="child_id">Child Category:</label>
    <div class="col-12">
      <select class="form-control" id="child_id" name="child_id">
      	<?php
			
			
			foreach($categories->entities as $_category){
				echo '<option value="'.$_category->id.'">'.$_category->name.'</option>';
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