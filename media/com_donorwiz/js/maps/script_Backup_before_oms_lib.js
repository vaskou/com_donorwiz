var map;
var mapMarkers=[];

jQuery(function($) {
	
	var $ = jQuery.noConflict();
	
	$(document).ready(function () {
		
		var mapCanvas = document.getElementById("map-canvas");
		
		var mapObjects = getMapObjects( $.parseJSON( $(mapCanvas).attr("data-volunteering-opportunities-items") ));
	
		map = new google.maps.Map( mapCanvas , {} );
		
		map.setOptions({
			
			styles: getMapStyles()
		
		});
		
		setMarkers ( map , mapObjects );		
		
		map.fitBounds ( getMapBounds ( mapObjects ) );
		
		console.log(map);
		
	});
	
});


function setMarkers( map , mapObjects ) {

	var infowindow = new google.maps.InfoWindow({
		maxWidth: 200 
	});
				
	for (var key  in mapObjects) {
				
		var location = mapObjects[key];
		var title = location.title;
		var address = location.address;
		
		var html = '';
		
		html += '<h4>'+title+'</h4>';
		html += '<p>'+address+'</p>';
		html += '<a href="'+siteURL+'index.php?option=com_volunteers&view=opportunityitem&lang=el&id='+location.id+'">Διαβάστε περισσότερα</a>';

		var marker = new google.maps.Marker({

			position: new google.maps.LatLng( parseFloat ( location.lat ) , parseFloat ( location.lng) ),
			map: map,
			icon: {
				url : siteURL+"media/com_donorwiz/images/mapicons/"+location.causearea+".png"
			},
			title: title,
			html: html,
			animation: google.maps.Animation.DROP,
		});
	
		google.maps.event.addListener( marker, 'click', function () {
			
			infowindow.setContent(this.html);
			
			this.setAnimation( google.maps.Animation.DROP );
			
			infowindow.open( map , this );
		});
		
		mapMarkers.push(marker);
		
		
	}
	
	console.log(mapMarkers);
}

function getMapBounds(mapObjects){
	
	var bounds = new google.maps.LatLngBounds ();

	for (var key  in mapObjects) 
	{
		var location = mapObjects[key];
		bounds.extend ( new google.maps.LatLng ( parseFloat(location.lat) , parseFloat(location.lng) ) );
	}
	
	return bounds;
	
}


function zoomMapByCoordinates( lat , lng ){
	
	var myLatlng = new google.maps.LatLng(lat, lng);
	
	map.panTo(myLatlng);
	
	map.setZoom(14);
	
	for (var key  in mapMarkers) 
	{
		var marker = mapMarkers[key];
		var markerLat = marker.position.k;
		var markerLng = marker.position.D;
		
		if( lat == markerLat && lng == markerLng )
		{
			google.maps.event.trigger( marker , 'click' );
		}
	}	
}

function getMapObjects( mapObjects ){
		
	jQuery.each( mapObjects, function( k, v ) 
	{
		if( v.category=="COM_VOLUNTEERS_VIRTUAL" || ( v.lat == "" && v.lat == "" ) )
		{
			delete mapObjects[k];
		}
	});	
	
	return mapObjects;
	
}

function getMapStyles(){
	
	var styleArray = [	
		{	
			featureType: "all",
			stylers: 
			[
				{ saturation: -80 }
			]
		},
		{
			featureType: "road.arterial",
			elementType: "geometry",
			stylers: 
			[
				{ hue: "#00ffee" },
				{ saturation: 50 }
			]
		},
		{
			featureType: "poi.business",
			elementType: "labels",
				stylers: [
					{ visibility: "off" }
				]
		}
	];

	return styleArray;
}

