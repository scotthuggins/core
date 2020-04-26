


$(document).on("click", ".calendarForward", function(){
		
		//get the id for the entity to open...
		var element_id = $(this).closest('.calendar_actions_toolbar').attr('id').split('_');
		
		
		var entity_name = element_id[0];
		var entity_id = element_id[1]; 
		
		sendAjax("index.php?api_request=calendar/calendarForward&entity_name="+entity_name+"&entity_id="+entity_id,'','POST','').done( function (data){
		
			sendAjax("index.php?api_request=getHTML&function_name=user_modules/calendar/dataview_calendar&entity_name="+entity_name+"&entity_id="+entity_id,loadCalendar,'POST','');
			
		});
		
		
		current_entity_name = entity_name;
		current_entity_id = entity_id;
});


$(document).on("click", ".calendarDay", function(){
		
		//get the id for the entity to open...
		var element_id = $(this).closest('.calendar_actions_toolbar').attr('id').split('_');
		
		
		var entity_name = element_id[0];
		var entity_id = element_id[1]; 
		sendAjax("index.php?api_request=calendar/calendarSetMode&entity_name="+entity_name+"&entity_id="+entity_id+"&mode=Day"   ,'','POST','').done( function(data){
			sendAjax("index.php?api_request=getHTML&function_name=user_modules/calendar/dataview_calendar&entity_name="+entity_name+"&entity_id="+entity_id,loadCalendar,'POST','');	
		});
		
		 
		current_entity_name = entity_name;
		current_entity_id = entity_id;
});







$(document).on("click", ".calendarWeek", function(){
		
		//get the id for the entity to open...
		var element_id = $(this).closest('.calendar_actions_toolbar').attr('id').split('_');
		
		
		var entity_name = element_id[0];
		var entity_id = element_id[1]; 
		sendAjax("index.php?api_request=calendar/calendarSetMode&entity_name="+entity_name+"&entity_id="+entity_id+"&mode=Week"   ,'','POST','').done( function(data){
			sendAjax("index.php?api_request=getHTML&function_name=user_modules/calendar/dataview_calendar&entity_name="+entity_name+"&entity_id="+entity_id,loadCalendar,'POST','');
		});
		
		 
		current_entity_name = entity_name;
		current_entity_id = entity_id;
});




$(document).on("click", ".calendarMonth", function(){
		
		//get the id for the entity to open...
		var element_id = $(this).closest('.calendar_actions_toolbar').attr('id').split('_');
		
		
		var entity_name = element_id[0];
		var entity_id = element_id[1]; 
		
		sendAjax("index.php?api_request=calendar/calendarSetMode&entity_name="+entity_name+"&entity_id="+entity_id+"&mode=Month"   ,'','POST','').done( function(data){
			sendAjax("index.php?api_request=getHTML&function_name=user_modules/calendar/dataview_calendar&entity_name="+entity_name+"&entity_id="+entity_id,loadCalendar,'POST','');
		});
		
		
		 
		current_entity_name = entity_name;
		current_entity_id = entity_id;
});




$(document).on("click", ".calendarFullScreen", function(){
		
		//get the id for the entity to open...
		var element_id = $(this).closest('.calendar_actions_toolbar').attr('id').split('_');
		
		
		var entity_name = element_id[0];
		var entity_id = element_id[1]; 
		
		sendAjax("index.php?api_request=getHTML&function_name=user_modules/calendar/calendar_modal&entity_name="+entity_name+"&entity_id="+entity_id,loadModal,'POST','');
		 
		current_entity_name = entity_name;
		current_entity_id = entity_id;
		
		$("#viewModal").show();
});

$(document).on("click", ".calendarBack", function(){
		
		//get the id for the entity to open...
		var element_id = $(this).closest('.calendar_actions_toolbar').attr('id').split('_');
		
		
		var entity_name = element_id[0];
		var entity_id = element_id[1]; 
		
		sendAjax("index.php?api_request=calendar/calendarBack&entity_name="+entity_name+"&entity_id="+entity_id,'','POST','').done( function(data){
			sendAjax("index.php?api_request=getHTML&function_name=user_modules/calendar/dataview_calendar&entity_name="+entity_name+"&entity_id="+entity_id,loadCalendar,'POST','');
		});
		
		 
		current_entity_name = entity_name;
		current_entity_id = entity_id;
});

$(document).on("click", ".calendarReset", function(){
		
		//get the id for the entity to open...
		var element_id = $(this).closest('.calendar_actions_toolbar').attr('id').split('_');
		
		
		var entity_name = element_id[0];
		var entity_id = element_id[1]; 
		
		sendAjax("index.php?api_request=calendar/calendarReset&entity_name="+entity_name+"&entity_id="+entity_id,'','POST','').done( function(data){
			sendAjax("index.php?api_request=getHTML&function_name=user_modules/calendar/dataview_calendar&entity_name="+entity_name+"&entity_id="+entity_id,loadCalendar,'POST','');
		});
		
		 
		current_entity_name = entity_name;
		current_entity_id = entity_id;
		
});

$(document).ready(function(){
  //$('[data-toggle="calendar-tooltip"]').tooltip({
  	
  		
  		//placement: "auto"
  		
  //});   
});

$(document).ready(function(){
  
  //adjusts row heights for calendars
  $(".calendar-row-content").each(function(){
  	
  	h = $(this).height();
  	$(this).siblings(".calendar-table").height(h + 25);
  	
  });

});

function loadCalendar(html){
	
	$('#viewport_calendar_'+current_entity_id).replaceWith(html);
	
	//('#viewport_calendar_'+current_entity_id).each( function(){
	//	
	//	$(this).replaceWith(html);
	//});
	
	
	
	//re adjust row hieght once html updates
	cal = $('#viewport_calendar_'+current_entity_id).find(".calendar-row-content").each(function(){
		h = $(this).height();
  		$(this).siblings(".calendar-table").height(h + 25);
  	});
  
}

$(window).resize(function() {

	calendar_resize();	
});


function calendar_resize(){
	
	$(".calendar-row-content").each(function(){
  	
  		h = $(this).height();
  		$(this).siblings(".calendar-table").height(h + 25);
  	
  	});

}

