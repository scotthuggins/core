<form class="form form-horizontal form-inline search-form " id="card_search" role="form" method="post" action="index.php/?process=card_search"><div class="form-group">
					<div class="col-12">
						<input type="text" class="form-control" id="" name="search_phrase" value="Search" id="search_phrase" placeholder="Search Phrase of the new card" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="field">Field</label>
					<select class="form-control mr-2 mb-2" id="_field" name="field"><option value="name">name</option><option value="expMonth">expMonth</option><option value="expYear">expYear</option><option value="ccNumber">ccNumber</option><option value="billingNameFirst">billingNameFirst</option><option value="billingNameLast">billingNameLast</option><option value="billingAddressLine1">billingAddressLine1</option><option value="billingAddressLine2">billingAddressLine2</option><option value="billingZip">billingZip</option><option value="billingState">billingState</option><option value="cardType">cardType</option><option value="cvv">cvv</option><option value="isDefault">isDefault</option></select></div><div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="card_search" class="btn btn-secondary"><i class="fas fa-search fa-2x"></i></button>
		    </div>
	  		</div></form>