$(window).resize(function() {
	//dynamically remove inline style for search forms when we are small port
  if ($(window).width() >= 613) $('.search-form').addClass("form-inline");
  else $('.search-form').removeClass("form-inline");
  
  
  
  
});

$(window).ready(function() {
	//dynamically remove inline style for search forms when we are small port
  if ($(window).width() >= 613) $('.search-form').addClass("form-inline");
  else $('.search-form').removeClass("form-inline");
});


//###########################################################
//###################### LISTENERS ############################
//###########################################################
var current_entity_name;
var current_entity_id;	
var search_view = "Tiles";
var this_page = $(".current_page").attr('id');
var page_count = 0;
var last_page;
var page_id = 1;
var lastScrollPos = 0;
var recentScroll = false;
var recentPageCheck = false;
//Toggle the standard entity browsing view between a table and cards

$(document).on("click", ".searchViewToggle", function(){
		
		
		var element_id = $(this).attr('id').split('_');
		var entity_name = element_id[0];
		var entity_id = element_id[1]; 
		
		//toggle the button.
		if (search_view == "Tiles"){
			$(".searchViewToggle").html('<i class="fas fa-th-large fa-2x"></i>');
			search_view = "Table";
		} else {
			$(".searchViewToggle").html('<i class="fas fa-list fa-2x"></i>');
			search_view = "Tiles";
		}
		
		//Clear the page first
		$('.search_result_primary_'+entity_name).empty();
	
		sendRequest("index.php?process=pagination&entity="+entity_name+"&page="+this_page,'','GET',entity_name);
		sendRequest("index.php?api_request=getTable&current_entity_name="+entity_name+"&search_view="+search_view,loadSearchContainerPrev,'POST',entity_name);
	});

//###########################################################

	


//###########################################################	
	
	$(document).on("click", ".closeModalButton", function(){
		//alert("close clicked");
		$("#viewModal").hide();
		$(".modal_media_content").empty();
		
	});

//###########################################################
	$(document).on("click", ".editModalButton", function(){
		//get the id for the entity to open...
		var element_id = $(this).attr('id').split('_');
		var entity_name = element_id[0];
		var entity_id = element_id[1]; 
		sendRequest("index.php?api_request=getHTML&function_name=write_entity_modal&entity_name="+entity_name+"&entity_id="+entity_id,loadModal,'POST','');
		sendRequest("index.php?api_request=getEntity&entity_name="+entity_name+"&entity_id="+entity_id,loadModalEditForm,'POST',''); 
		current_entity_name = entity_name;
		current_entity_id = entity_id;
		
		$("#viewModal").show();
		
		loadListeners();
		
	});

//#################################
	$(document).on("click", ".deleteModalButton", function(){
		//alert(current_entity_name+" - "+current_entity_id);
		sendRequest("index.php?api_request="+current_entity_name+"_delete_api&"+current_entity_name+"_id="+current_entity_id,'','POST','');
		loadListeners();
		$('#viewModal').hide();
		
	});


//###########################################################
	//on a link child header click get its childeren and lazy load list
	
	$(document).on("click", ".link_child_header", function(){
		var element_id = $(this).attr('id').split('_');
		var entity_name = element_id[3];
		var entity_id = element_id[4]; 
		sendRequest("index.php?api_request=getHTML&function_name=write_link_child_properties&entity_name="+entity_name+"&entity_id="+entity_id,loadLinkChildProperties,'POST',element_id);
		loadListeners();
	});

//############################################################
	//click on unlinkChildButton
	$(document).on("click", ".linkChildButton", function(){
		
		var element_id = $(this).attr('id').split('_');
		var entity_name = element_id[1];
		var entity_id = element_id[2]; 
		//get the api name by creating the node name
		var nodeName = createNodeName(entity_name,current_entity_name);
		sendRequest("index.php?api_request="+nodeName+"_link_api&"+entity_name+"_id="+entity_id+"&"+current_entity_name+"_id="+current_entity_id,'','POST',''); 
		
		//remove the row after the request is successful
		$(this).parent().parent().parent().fadeOut('1000');
		
		//Gather and alter it's button
		$(this).text('Remove');
		$(this).removeClass('btn-success');
		$(this).removeClass('linkChildButton');
		$(this).addClass('unlinkChildButton');
		$(this).addClass('btn-warning');
		$(this).attr("id","un"+$(this).attr('id'));
		
		
		
		var row = '<tr>'+$(this).parent().parent().parent().html()+'<tr>';
		
		$('#link_child_table_'+entity_name+" tr:first").after(row);
		loadListeners();
	});
	


//###########################################################
	//click on unlinkChildButton
	$(document).on("click", ".unlinkChildButton", function(){
		
		var element_id = $(this).attr('id').split('_');
		var entity_name = element_id[1];
		var entity_id = element_id[2]; 
		//alert(entity_id);
		//get the api name by creating the node name
		var nodeName = createNodeName(entity_name,current_entity_name);
		sendRequest("index.php?api_request="+nodeName+"_unlink_api&"+entity_name+"_id="+entity_id+"&"+current_entity_name+"_id="+current_entity_id,'','POST',''); 
		
		//remove the row after the request is successful
		$(this).parent().parent().parent().fadeOut('1000');
		
		
	});
	

	$(document).on("click", ".editChildButton", function(){
		var element_id = $(this).attr('id').split('_');
		var entity_name = element_id[1];
		var entity_id = element_id[2]; 
		//load the modal
		sendRequest("index.php?api_request=getHTML&function_name=write_entity_modal&entity_name="+entity_name+"&entity_id="+entity_id,loadModal,'POST','');
		//load the form
		sendRequest("index.php?api_request=getEntity&entity_name="+entity_name+"&entity_id="+entity_id,loadModalEditForm,'POST',''); 
		//load the children headers
		//sendRequest("index.php?api_request=getHTML&function_name=write_link_child_header&entity_name="+entity_name+"&entity_id="+entity_id,loadLinkChildHTML,'POST',entity_name);
		current_entity_name = entity_name;
		current_entity_id = entity_id;
		$("#viewModal").show();
		loadListeners();
	});


	$(document).on("click", ".updateChildButton", function(){
		
		var cnt = 0;
		//Select the inputs from the current row
		$(this).parent().parent().parent().find('input').each(function Foo(){
			
			cnt++;
			var id_array = this.id.split('_');
			if (cnt == 1){
				//find and set entities	
				//var id_array = this.id.split('_');
				var child_id = id_array[0];
				var child_entity = id_array[1];
				var parent_id = id_array[2];
				var parent_entity = id_array[3];
				var node_name = createNodeName(parent_entity,child_entity);
				//start building the url string
				url_string = "index.php?api_request="+node_name+"_edit_api&"+parent_entity+"_id="+parent_id+"&"+child_entity+"_id="+child_id;
				//alert(url_string);
			}
			//remove the leading 4 elements 
			var nothing = id_array.splice(0,4);
			//rejoin the remainder of the element and add the underscore back in.
			var property = id_array.join("_");
			var value = this.value;
			
			//build the url string...
			url_string += "&"+property+"="+value;
			
			//toast!
			updateToast("update",property + ' updated to: '+value);
			
			$(".toast").toast("show");
			
		});
		
		//alert(url_string); 
		sendRequest(url_string,'','GET','');
		
	});

//++++++++++++++++++++++++++++++++++++++++++++++++++
//pagination clicks
	$(document).on("click", ".paginationButton", function(){
		var element_id = $(this).attr('id').split('_');
		var entity_name = element_id[1];
		var page_id = element_id[2];
		
		
		
		//remove active class from the last page
		$("paginationButton").each(function(){
			$(this).removeClass('btn-primary');
			$(this).addClass('btn-dark');
		});
		
		//make the current page active
		$("#pagination_"+entity_name+"_"+page_id).addClass('btn-primary');
		$("#pagination_"+entity_name+"_"+page_id).removeClass('btn-dark');
		
		//check if the page segment already exists
		if ( $( "#page_segment_"+page_id ).length ) {
			//ONLY notify the server of the new page number via 
			sendRequest("index.php?process=pagination&entity="+entity_name+"&page="+page_id,'','GET',entity_name);
		
		
		} else {
			//notify the server of the new page number via and load the view
			sendRequest("index.php?process=pagination&entity="+entity_name+"&page="+page_id,'','GET',entity_name);
		
			sendRequest("index.php?api_request=getTable&current_entity_name="+entity_name+"&search_view="+search_view,loadSearchContainer,'POST',entity_name);
			loadListeners();
		}
		
		current_entity_name = entity_name;
	
		var last_page = page_id;
		this_page = Number(page_id);
		//alert(this_page);
	});

	
	$(window).scroll(function () {
		//Stop recent scrolls
		if(recentScroll){return;}
		
		scrollDelay = 50;
		
		var entity_name = $(".entity_name").attr('id');
		
		if(typeof entity_name === 'undefined'){return;}
		
		//discover page by page_segment visibility...?
		if(!recentPageCheck){
   			$(".page_segment").each(function( index ){
   				if( $(this).isInViewport() ){
   					
   					var element_id = $(this).attr('id').split('_');
					var view_page_id = element_id[2];
   					
   					//turn the pages
   					this_page = view_page_id;
   					prev_page = this_page - 1;
   					next_page = this_page + 1;
   					
   					//remove active class from the last page
					$(".paginationButton").each(function(){
						$(this).removeClass('btn-primary');
						$(this).addClass('btn-dark');
					});
					
					//make the current page active
					$("#pagination_"+entity_name+"_"+this_page).removeClass("btn-dark");
					$("#pagination_"+entity_name+"_"+this_page).addClass("btn-primary");

					//calculate and show the corousel page
					var carouselPage = (Math.ceil(this_page/5) - 1);
					$('#paginationCorousel').carousel(carouselPage);
					
					//notify the server we can moved pages
					//sendRequest("index.php?process=pagination&entity="+entity_name+"&page="+this_page,'','GET',entity_name);
   					
   					console.log(entity_name+" In view port & Page: " + view_page_id);
   					
   					recentPageCheck = true;
        			window.setTimeout(function(){ recentPageCheck = false; }, 300);
        			
        			return false;
   				}
   			});
		}
		
		//Get the scroll direction
		var st = $(this).scrollTop();
		if (st > lastScrollPos){
 			 var direction = 'next';
		 } else {
 		 	var direction = 'prev';
		 }
		lastScrollPos = st;
		
		//if this page is not set, get the current page/last statically loaded from dom.
		if (typeof this_page === "undefined"){
			
			var this_page = ($(".current_page").attr('id'));
			//alert('assigned from dom: ' + this_page);
		}
		
		//set the page count
		if (typeof page_count === "undefined" || page_count == 0){
			var page_count = ($(".page_count").attr('id'));
		}
		
		//ensure that this page is a NUMBER
		var this_page = Number(this_page);
		var prev_page = this_page - 1 ;
		var next_page = this_page + 1;
		
	    // top of the document reached?
	    if (!recentScroll && ($(document).height() - $(this).height() <= $(this).scrollTop())) {
	    	
	    	//only go if the page segment doens't exist
	    	if (direction == 'prev' && ($( "#page_segment_"+prev_page ).length == 0)){
	    		
	    		//prevent loading and moving page if prev page will be zero
	    		if(this_page == 1){return;}
	    		
	    		//console.log('Loading... Page: ' + this_page + ' Dir: ' + direction + ' prev: '+ prev_page + " this: " + this_page + " next: " + next_page);
	    		console.log('Loading Up Page: ' + prev_page );
	    		
	    		//get scroll position before content is added
	    		var old_height = $(document).height();  //store document height before modifications
				var old_scroll = $(window).scrollTop(); //remember the scroll position
	        	
	        	sendRequest("index.php?process=pagination&entity="+entity_name+"&page="+prev_page,'','GET',entity_name);
		    	sendRequest("index.php?api_request=getTable&current_entity_name="+entity_name+"&search_view="+search_view,loadSearchContainerPrev,'POST',entity_name);
		    	
		    	//Restore Scroll Positionl to this page to prevent getting sent to top of page and retriggering
		    	$(document).scrollTop(old_scroll + $(document).height() - old_height + 50);
				document.getElementById('page_segment_'+this_page).scrollIntoView();

		    	
		    	//move this page back..
		    	this_page --;
		    	
	       		recentScroll = true;
   				window.setTimeout(function(){ recentScroll = false; }, scrollDelay);
   				return;
	       }
	    }
	     // bottom of the document reached?
	   	if (!recentScroll && ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight)) {
	        
	        if (direction == 'next' && ($( "#page_segment_"+next_page ).length == 0)){
	        	
	        	//prevent loading and moving page if next page will above page count, we are at last page
	    		if(this_page == page_count){return;}
	    		
		        	//console.log('Loading... Page: ' + this_page + ' Dir: ' + direction + ' prev: '+ prev_page + " this: " + this_page + " next: " + next_page);
		        	console.log('Loading Down Page: ' + next_page );
		        	
		        	sendRequest("index.php?process=pagination&entity="+entity_name+"&page="+next_page,'','GET',entity_name);
			    	sendRequest("index.php?api_request=getTable&current_entity_name="+entity_name+"&search_view="+search_view,loadSearchContainerNext,'POST',entity_name);
		       		
		       		//move this page forward..
			    	this_page++;
		       		
		       		//alert(this_page);
		       		recentScroll = true;
        			window.setTimeout(function(){ recentScroll = false; }, scrollDelay);
        			return;
	       }
	    }
	}); 

//##################################################
//	LOADERS
//##################################################
function loadMedia(xmlObject){
	var entityObject = JSON.parse(xmlObject.responseText);
    var entity_name = entityObject['class_name'];
    var entity_id = entityObject['id'];
    var options = entity_name;
    //empty the child content
    sendRequest("index.php?api_request=getHTML&function_name=write_media_module_dynamic&entity_name="+entity_name+"&entity_id="+entity_id,updateMediaHTML,'POST',options);        
    
	loadListeners();
}
//##################################################
function loadModal(xmlObject){
	var html = xmlObject.responseText;
	$('.modal-content').html(html);
	
	//$('.modal-title').text(current_entity_name);
	loadListeners();
	
	
}
//##################################################	
function loadModalEditForm(xmlObject){
	//loadMedia(xmlObject);
	updateEditForm(xmlObject);
	loadLinkChildrenTable(xmlObject);
	updateModalTitle(xmlObject);
	updateObjectProperties(xmlObject);
	loadListeners();
}


//##################################################
//Passed a parent, so lets load its children
function loadLinkChildrenTable(xmlObject){
	var entityObject = JSON.parse(xmlObject.responseText);
    var entity_name = entityObject['class_name'];
    var entity_id = entityObject['id'];
    var options = entity_name;
    //empty the child content
    for(key in entityObject['config']['associations']['has']){
    	key = entityObject['config']['associations']['has'][key];
    	$(".link_child_content_"+key).empty();
    	options = key;
		sendRequest("index.php?api_request=getHTML&function_name=write_link_child_table&entity_name="+entity_name+"&entity_id="+entity_id+"&child_entity_name="+key,updateLinkChildHTML,'POST',options);        
    }
  	loadListeners();
	
}

function loadSearchContainer(xmlObject,entity_name){
	var html = xmlObject.responseText;
	
	//load the search results
	$(".search_result_primary_"+entity_name).html(html);
	options = entity_name;
	//load the new pagination
	sendRequest("index.php?api_request=getHTML&function_name=pagination&entity_name="+entity_name,updatePagination,'POST',options);
	//loadListeners();
}

function loadSearchContainerPrev(xmlObject,entity_name){
	var html = xmlObject.responseText;
	
	//load the search results
	$(".search_result_primary_"+entity_name).prepend(html);
	options = entity_name;
	//load the new pagination
	//sendRequest("index.php?api_request=getHTML&function_name=pagination&entity_name="+entity_name,updatePagination,'POST',options);
	loadListeners();
}

function loadSearchContainerNext(xmlObject,entity_name){
	var html = xmlObject.responseText;
	
	//load the search results
	$(".search_result_primary_"+entity_name).append(html);
	options = entity_name;
	//load the new pagination
	//sendRequest("index.php?api_request=getHTML&function_name=pagination&entity_name="+entity_name,updatePagination,'POST',options);
	loadListeners();
}


//##################################################
//Passed a xml object, entity name of search table to populate
function loadLinkChildrenSearchTable(xmlObject,entity_name){
	var html = xmlObject.responseText;
	
	$(".search_result_"+entity_name).html(html);
	loadListeners();
	
}

function updatePagination(xmlObject,entity_name){
	//appends pagination to the DOM from a entities page search 
	var html = xmlObject.responseText;
	
	$(".pagination_container").html(html);
	loadListeners();
	
}


function updateMediaHTML(xmlObject,entity_name){
	//appends link_child_content to the DOM from a loadLinkChildren() call. 
	var html = xmlObject.responseText;
	
	$(".modal_media_content").html(html);
	loadListeners();
}

//###########################################################
function updateLinkChildHTML(xmlObject,entity_name){
	//appends link_child_content to the DOM from a loadLinkChildren() call. 
	var html = xmlObject.responseText;
	
	$(".link_child_content_"+entity_name).append(html);
	loadListeners();
	
}
//###########################################################
function updateEditForm(xmlObject){
	
	var entityObject = JSON.parse(xmlObject.responseText);
    
    for(key in entityObject) {
    	//format selectors as: $(".company_name").text(entityObject.name);
		$("."+entityObject.class_name+"_"+key).text(entityObject[key]);
		$("."+entityObject.class_name+"_"+key).val(entityObject[key]);
		
	
		
	}
}
//###########################################################
function updateObjectProperties(xmlObject){
	var entityObject = JSON.parse(xmlObject.responseText);
    
    for(key in entityObject) {
    	//format selectors as: $(".company_name").text(entityObject.name);
		$("."+entityObject.class_name+"_"+entityObject.id+"_"+key).text(entityObject[key]);
		
		//update checkboxes and other array things
		if(Array.isArray(entityObject[key])){
			
			for(subkey in entityObject[key]){
				//console.log(entityObject[key][subkey]);
				
				$("."+entityObject.class_name+"_"+entityObject.id+"_"+key).filter("."+entityObject[key][subkey]).prop("checked", true);
				//$("."+entityObject.class_name+"_"+entityObject.id+"_"+key).filter("#"+entityObject[key][subkey]).prop("checked", true);
				//$("."+entityObject.class_name+"_"+entityObject.id+"_"+key+" #"+entityObject[key][subkey]).prop("checked", true);
				//$("."+entityObject.class_name+"_"+entityObject.id+"_"+key).prop("checked", true);
				
				
				console.log("."+entityObject.class_name+"_"+entityObject.id+"_"+key+" ."+entityObject[key][subkey]);
			}
		}
		
		
	}
}
//############################################################
function updateModalTitle(xmlObject){
	var entityObject = JSON.parse(xmlObject.responseText);
	
	if (typeof entityObject.config.altPublicName !== 'undefined'){
		$('.modal-title').text(entityObject.config.altPublicName);	
	}
	else { $('.modal-title').text(current_entity_name); }
	
	//$('.modal-title').text('hello');
}

//############################################################
function updateToast(header,text){
	$(".toast-header").html(header);
	$(".toast-body").html(text);
}

//move toasts z-index when showing and hiding
$('.toast').on('show.bs.toast', function(){
	$(this).css({'z-index':'2000'});
});

$('.toast').on('hidden.bs.toast', function(){
	$(this).css({'z-index':'0'});
});
//##################################################
// CORE FUNCTIONS	
//###########################################################
function createNodeName(entity_1,entity_2){
	var entity_array = [entity_1,entity_2];
	entity_array.sort();
	return entity_array[0]+'_'+entity_array[1];
}

function createNodeNameAsArray(entity_1,entity_2){
	var entity_array = [entity_1,entity_2];
	entity_array.sort();
	return entity_array;
}

function sendRequest(url,callback,postData,options) {
	var req = createXMLHTTPObject();
	if (!req) return;
	var method = (postData) ? "POST" : "GET";
	req.open(method,url,true);
	req.setRequestHeader("User-Agent","XMLHTTP/1.0");
	if (postData)
		req.setRequestHeader("Content-type","application/json");
	req.onreadystatechange = function () {
		if (req.readyState != 4) return ;
		if (req.status != 200 && req.status != 304) {
			//alert("HTTP error " + req.status);
			return;
		}
		if(callback){
			callback(req,options);
		}
	};
	if (req.readyState == 4) return ;
	req.send(postData);
	return ;
}

var XMLHttpFactories = [
function () {return new XMLHttpRequest();},
function () {return new ActiveXObject("Msxml2.XMLHTTP");},
function () {return new ActiveXObject("Msxml3.XMLHTTP");},
function () {return new ActiveXObject("Microsoft.XMLHTTP");}
];

function createXMLHTTPObject() {
	var xmlhttp = false;
	for (var i=0;i<XMLHttpFactories.length;i++) {
		try {
			xmlhttp = XMLHttpFactories[i]();
		}
		catch (e) {
			continue;
		}
		break;
	}
	return xmlhttp;
}
//
//###########################################################	
//Process all forms as jQuery
//function formSubmit(){
	//We need to turn off this handler to prevent multiple calls
//	jQuery("form").off();
	
	//jQuery("form").submit( function(e) {


	$(document).on("submit", "form", function(){		
		//e.preventDefault();
		
		//we change the url to use the api counter part of the form target
		var targetURL = $(this).attr("action");
		var targetURLArray = targetURL.split('=');
		
		//get the entity name that we are searching for use below
		var entity_name_array = $(this).attr("id").split("_");
		var entity_name = entity_name_array[0];
		var ret = $(this).attr("id").search('search');
		
		//get the type of search (in main view or in modal)
		var is_main_search = $(this).parent().attr("id").search('main_view');
		
		//find if we are a search form or other
		var ret = $(this).attr("id").search('search');
		
		//find the calling class, used for search entity forms
		var calling_class_array = $(this).parent().attr("id").split("_");
		var calling_class = calling_class_array[1];
		
		
		//commented 6.12.19 to prevent multiple calls during a main search...
		//sendRequest("index.php?api_request=getTable&current_entity_name="+entity_name+"&search_view="+search_view,loadSearchContainer,'POST',entity_name);
		//append "_api" and the current entity name
		var action = "index.php/?api_request="+targetURLArray[1]+"_api&current_entity_name="+current_entity_name;
		
		var formData = new FormData(this);
		
		//if we are not a search form submit normally
		if(-1 == ret){
			$.ajax({
	         // url     : $(this).attr("action"),
	            url 	: action,
	            type    : $(this).attr("method"),
	            dataType: 'json',
	            data    :  formData,
	            processData: false,
	            contentType: false,
	            success : function( data ) {
							updateVisualObjectProperties(data);            	
	                      },
	            error   : function( xhr, err ) {
	                        alert("Error: "+err);     
	                      }
	        });  
		}
		//Special for search form submits
		else{
			$.ajax({
           // url     : $(this).attr("action"),
            url 	: action,
            type    : $(this).attr("method"),
            dataType: 'html',
            data    :  $(this).serialize(),
            success : function( data ) {
						if(0 == is_main_search){
							//load main_view tables
							sendRequest("index.php?api_request=getTable&current_entity_name="+entity_name+"&search_view="+search_view,loadSearchContainer,'POST',entity_name);
						} else {
							//updateVisualObjectProperties(data);            	
            				sendRequest("index.php?api_request=getHTML&function_name=write_link_child_search_table&current_entity_name="+entity_name+"&calling_class="+calling_class+"&search_view=table",loadLinkChildrenSearchTable,'POST',entity_name);
            				
            				
            				//loadLinkChildrenSearchTable(data,entity_name);
                        	//alert("Search Submitted"+entity_name);
                       	}
                      },
            error   : function( xhr, err ) {
            			
                        alert("Error for search submit:"+err);     
                      }
       		});  
		}		
        return false;
    });
//}	
//###########################################################	

function updateVisualObjectProperties(xmlObject){
	
	var entityObject = xmlObject;
    //update all html spans by entityName_entityID_entityProperty with text of that property
    for(key in entityObject) {
    	//format selectors as: $(".company_name").text(entityObject.name);
		$("."+entityObject.class_name+"_"+entityObject.id+"_"+key).text(entityObject[key]);
	}
}

function loadListeners(){
	//paginationScroll();
	//paginationClick();
	//searchViewToggle();
	//searchViewCalendar();
	//deleteButtonClick();
	//editButtonClick();
	//closeModalButtonClick();
	//unlinkChildButtonClick();
	//linkChildButtonClick();
	//linkChildHeaderClick();
	//editChildClick();
	//updateChildClick();
	//formSubmit();
	
	
	
}

loadListeners();



$.fn.isInViewport = function() {


//    var elementTop = $(this).offset().top;
//    var elementBottom = elementTop + $(this).outerHeight();

//    var viewportTop = $(window).scrollTop();
//    var viewportBottom = viewportTop + $(window).height();

//    return elementBottom > viewportTop && elementTop < viewportBottom;

    var top_of_element = $(this).offset().top;
    var bottom_of_element = $(this).offset().top + $(this).outerHeight();
    var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
    var top_of_screen = $(window).scrollTop();
    return (bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element);

};