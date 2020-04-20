<form class="form form-horizontal" id="calendar_remove" role="form" method="post" action="index.php/?process=calendar_remove"><div class="form-group"><span class="col-12 bg-danger"><?php echo GetErrors(); ?></span></div><div class="form-group col-xs-12 col-sm-0 m-3 mt-md-4"><label class="control-label mr-2 mb-2" for="calendar">Calendar</label>
					<select class="form-control mr-2 mb-2" id="calendar_remove_calendar" name="calendar"><option value="1"></option><option value="2"></option><option value="3"></option></select></div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" id="calendar_remove" class="btn btn-primary">Remove Calendar</button>
		    </div>
	  	</div></form>