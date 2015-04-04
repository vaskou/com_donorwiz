jQuery(function($) {
	
	var $ = jQuery.noConflict();
	
	$(document).ready(function() {
	
		var options = {
			valueNames: [ "created" , "name" , "message", "telephone" , "status" ]
			//valueNames: [ "name" ]
		};
		
		var responsesList = new List("opportunity_responses_list", options );
		
		jQuery( ".status-filter" ).change(function() {
			
			var status = jQuery(this).val();
		
			if (status == "ALL" || status == "") {
				responsesList.filter(); 
				return false;
			} 
		
			responsesList.filter(function(item) {
		
				if (item.values().status == status) {
					return true;
				} 
				else{
					return false;
				}
			}); 
		
		});	
		
		jQuery( ".created-sort" ).change(function() {
			
			var sort = jQuery(this).val();
		
			if (sort == "NEWEST") {
				responsesList.sort('created', { order: "desc" }); 
				return false;
			} 

			if (sort == "OLDEST") {
				responsesList.sort('created', { order: "asc" }); 
				return false;
			}			

		
		});
	});
});