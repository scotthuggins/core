<form class="form form-horizontal" id="media_create" role="form" method="post" enctype="multipart/form-data" action="index.php/?process=media_create"><div class="form-group">
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
  		
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="media_create" class="btn btn-primary">Create Media</button>
		    </div>
	  	</div></form>