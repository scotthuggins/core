<form class="form form-horizontal" id="store_delete" role="form" method="post" action="index.php/?process=store_delete"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="store">Store</label>
					<select class="form-control mr-2 mb-2" id="store_delete_store" name="store"></select></div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="store_delete" class="btn btn-primary">Delete Store</button>
		    </div>
	  	</div></form>