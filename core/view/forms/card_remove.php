<form class="form form-horizontal" id="card_remove" role="form" method="post" action="index.php/?process=card_remove"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="card">Card</label>
					<select class="form-control mr-2 mb-2" id="card_remove_card" name="card"></select></div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="card_remove" class="btn btn-primary">Remove Card</button>
		    </div>
	  	</div></form>