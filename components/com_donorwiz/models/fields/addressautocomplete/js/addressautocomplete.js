var placeSearch, autocomplete , autocompleteInput , autocompleteForm , geocoder , latInput, lngInput;

jQuery(function($) {
	
	var $ = jQuery.noConflict();
	
	$(document).ready(function () {
		
		//Init vars
		latInput = $('#nearby_lat');
		lngInput = $('#nearby_lng');
		autocompleteForm = $('#autocomplete').closest('form');
		autocompleteInput = $('#autocomplete');
		
		autocompleteForm.submit(function( event ) {
			
			if( latInput.val() == '0' || latInput.val() == '0' )
			{
				$.UIkit.notify( "<i class=uk-icon-warning></i> " + JText_COM_DONORWIZ_TYPE_LOCATION_AND_SELECT , { timeout:5000 } );
				event.preventDefault();
			}

		});
		
		
		//Prevent form submit when user clicks enter inside autocomplete field
		autocompleteInput.keypress( function( event ) 
		{ 
			return event.keyCode != 13; 	
		});
		
		//Reset lat,lng when autocomplete empty
		autocompleteInput.blur( function( ) { 
			
			
			if( $.trim ( $(this).val() ) == '' ){
				$(this).val('');
				fillInLatLngFormFields( 0 , 0 );
			}
				
		});
		
		// Create the autocomplete object, restricting the search to geographical location types.
		autocomplete = new google.maps.places.Autocomplete(
			/** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
			{	 
				types: ['geocode'] 
			}
		);
		
		// When the user selects an address from the dropdown, populate the address fields in the form.
		google.maps.event.addListener( autocomplete , 'place_changed', function() {
			
			var place = autocomplete.getPlace();
			console.log(place);
			fillInLatLngFormFields( place.geometry.location.A , place.geometry.location.F );

			
		});
		
		//Handle browser gelocation to popylate address fill with user location
		if(navigator.geolocation) {
			
			// navigator.geolocation.getCurrentPosition( function ( position ) {
								
				// if(!autocompleteInput.val()){
					
					// var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				
					// fillInLatLngFormFields(position.coords.latitude,position.coords.longitude);
					// fillInAddressFormField(position.coords.latitude,position.coords.longitude);
					
				// }

			// }, function() {

			// });
		} 
		else 
		{
			// Browser doesn't support Geolocation
			//handleNoGeolocation(false);
		}



	});
	
});

function fillInLatLngFormFields ( lat , lng ) 
{
	latInput.val( lat ) ;
	lngInput.val( lng ) ;
}

function fillInAddressFormField ( lat , lng ) 
{
	var latlng = new google.maps.LatLng(lat, lng);
	geocoder = new google.maps.Geocoder();
	geocoder.geocode({'latLng': latlng}, function(results, status) {
	
	if (status == google.maps.GeocoderStatus.OK) 
	{
		if (results[1]) 
		{
			document.getElementById('autocomplete').value  = results[1].formatted_address;
		} 
		else 
		{
			console.log('No geocoding results found for autocomplete geocoding.');
		}
	} 
	else 
	{
		console.log('Geocoding for autocomplete failed. Status: ' + status);
	}
	});
}

// Bias the autocomplete object to the user's geographical location, as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
	
	if (navigator.geolocation) 
	{
		navigator.geolocation.getCurrentPosition(function(position) 
		{
			var geolocation = new google.maps.LatLng( position.coords.latitude, position.coords.longitude );
			
			var circle = new google.maps.Circle({
				center: geolocation,
				radius: position.coords.accuracy
			});
			//autocomplete.setBounds(circle.getBounds());
		});
	}
}