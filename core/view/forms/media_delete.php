<form class="form form-horizontal" id="media_delete" role="form" method="post" action="index.php/?process=media_delete"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="media">Media</label>
					<select class="form-control mr-2 mb-2" id="media_delete_media" name="media"><option value="16"></option><option value="15"></option><option value="17"></option></select></div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="media_delete" class="btn btn-primary">Delete Media</button>
		    </div>
	  	</div></form>