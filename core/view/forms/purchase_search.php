<form class="form form-horizontal form-inline search-form " id="purchase_search" role="form" method="post" action="index.php/?process=purchase_search"><div class="form-group">
					<div class="col-12">
						<input type="text" class="form-control" id="" name="search_phrase" value="Search" id="search_phrase" placeholder="Search Phrase of the new order" autocomplet="off" autofocus="on">			
					</div>
  				</div>
  		<div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="field">Field</label>
					<select class="form-control mr-2 mb-2" id="_field" name="field"><option value="createdDate">createdDate</option><option value="startDate">startDate</option><option value="endDate">endDate</option><option value="PoNumber">PoNumber</option><option value="statusColor">statusColor</option><option value="name">name</option></select></div><div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="purchase_search" class="btn btn-secondary"><i class="fas fa-search fa-2x"></i></button>
		    </div>
	  		</div></form>