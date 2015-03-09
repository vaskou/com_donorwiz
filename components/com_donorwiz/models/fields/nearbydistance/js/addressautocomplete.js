var placeSearch, autocomplete , geocoder;

jQuery(function($) {
	
	var $ = jQuery.noConflict();
	
	$(document).ready(function () {
	
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
			
			fillInLatLngFormFields(place.geometry.location.k,place.geometry.location.D);

			
		});
		
		//Handle browser gelocation to popylate address fill with user location
		if(navigator.geolocation) {
			
			navigator.geolocation.getCurrentPosition( function ( position ) {
				
					console.log(position);
			
				var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				
				fillInLatLngFormFields(position.coords.latitude,position.coords.longitude);
				fillInAddressFormField(position.coords.latitude,position.coords.longitude);
				
				console.log(pos);

			}, function() {
				//handleNoGeolocation(true);
			});
		} 
		else 
		{
			// Browser doesn't support Geolocation
			//handleNoGeolocation(false);
		}



	});
	
});

function fillInAddressFormField ( lat , lng ) {
	

	var latlng = new google.maps.LatLng(lat, lng);
	geocoder = new google.maps.Geocoder();
	
	geocoder.geocode({'latLng': latlng}, function(results, status) {
	
	if (status == google.maps.GeocoderStatus.OK) {
		if (results[1]) {
			
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
function fillInLatLngFormFields ( lat , lng ) {

	document.getElementById('nearby_lat').value = lat;
	document.getElementById('nearby_lng').value =  lng;
	
}

// Bias the autocomplete object to the user's geographical location, as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
	
	if (navigator.geolocation) {
		
		navigator.geolocation.getCurrentPosition(function(position) {
			
			var geolocation = new google.maps.LatLng( position.coords.latitude, position.coords.longitude );
			
			var circle = new google.maps.Circle({
				center: geolocation,
				radius: position.coords.accuracy
			});

			//autocomplete.setBounds(circle.getBounds());
		});
	}
}