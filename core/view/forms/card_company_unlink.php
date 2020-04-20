<form class="form form-horizontal" id="card_company_unlink" role="form" method="post" action="index.php/?process=card_company_unlink"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="card">Card</label>
					<select class="form-control mr-2 mb-2" id="card_company_unlink_card" name="card"></select></div><div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="company">Company</label>
					<select class="form-control mr-2 mb-2" id="card_company_unlink_company" name="company"><option value="11"></option><option value="12"></option><option value="13"></option><option value="14"></option><option value="15"></option></select></div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="card_company_unlink" class="btn btn-primary"> Un- Link  Card Company</button>
		    </div>
	  	</div></form>