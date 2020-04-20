<form class="form form-horizontal" id="media_edit" role="form" method="post" action="index.php/?process=media_edit"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group">
    				<label class="control-label col-12" for="mediaFile">Media File:</label>
					<div class="col-12">
						<input type="file" class="form-control-file media_mediaFile  " id="" name="mediaFile" value="<?php if(isset($session->form['mediaFile'])){echo $session->form['mediaFile'];}?>" placeholder="Media File of the new media" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group">
    				<label class="control-label col-12" for="name">Name:</label>
					<div class="col-12">
						<input type="text" class="form-control media_name  " id="" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" placeholder="Name of the new media" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<input hidden type="text" class="form-control media_id" name="id" value="<?php if(isset($session->form['id'])){echo $session->form['id'];}?>" id="id" placeholder="Id of the new media" autocomplet="off" autofocus="on">
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="media_edit" class="btn btn-primary">Edit Media</button>
		    </div>
	  	</div></form>