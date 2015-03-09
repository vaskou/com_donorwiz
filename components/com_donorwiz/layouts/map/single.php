<?php

// no direct access
defined('_JEXEC') or die;

$id = 		( isset ( $displayData['id'] ) && $displayData['id']!='' ) ? $displayData['id'] : '0' ;
$height = 	( isset ( $displayData['height'] ) && $displayData['height']!='' ) ? $displayData['height'] : '250' ;
$lat = 		( isset ( $displayData['lat'] ) && $displayData['lat']!='' ) ? $displayData['lat'] : null ;
$lng = 		( isset ( $displayData['lng'] ) && $displayData['lng']!='' ) ? $displayData['lng'] : null ;
$address = 	( isset ( $displayData['address'] ) && $displayData['address']!='' ) ? $displayData['address'] : 'Athens' ;
$icon = 	( isset ( $displayData['icon'] ) && $displayData['icon']!='' ) ? $displayData['icon'] : 'donorwiz' ;
$zoom = 	( isset ( $displayData['zoom'] ) && $displayData['zoom']!='' ) ? $displayData['zoom'] : 12 ;
$showaddress = 	( isset ( $displayData['showaddress'] ) && $displayData['showaddress'] ) ? $displayData['showaddress'] : false ;

?>

<?php if( $lat && $lng) : ?>

<div id="map_canvas_<?php echo $id; ?>" style="width: 100%; height: <?php echo $height; ?>px;"></div>

<?php if ($showaddress): ?>
<div class="uk-panel uk-panel-box uk-margin-top">
	<h3 class="uk-panel-title"><i class="uk-icon-map-marker uk-icon-medium"></i> Τοποθεσία</h3>
	<p><?php echo $address; ?></p>
</div>

<?php endif;?>

<?php 
	$doc = JFactory::getDocument();
	
	$DonorwizGooglemaps = new DonorwizGooglemaps();
	
	$DonorwizGooglemaps ->loadGoogleMapsApi();
	
	// Build the script.
	$script = array();
	
	$script[] = '	jQuery(function($) {';
	
	$script[] = '			var $ = jQuery.noConflict();';
	
	$script[] = '			$(document).ready(function () {';
	
	$script[] = '				var latlng = { lat: '.$lat.' , lng: '.$lng.' } ;';
	
	$script[] = '				var mapOptions = {';
	$script[] = '					center: latlng,';
	$script[] = '					zoom: '.$zoom.'';
	$script[] = '				};';
	
	$script[] = '				var map = new google.maps.Map(document.getElementById("map_canvas_'.$id.'"),mapOptions);';
	
	$script[] = '				var marker = new google.maps.Marker({';
	$script[] = '					position: latlng,';
	$script[] = '					map: map,';
	$script[] = '					icon: "components/com_donorwiz/layouts/map/icons/'.$icon.'.png"';
	$script[] = '				});';
	
	$script[] = '				var styleArray = [';
	$script[] = '					{';
	$script[] = '						featureType: "all",';
	$script[] = '						stylers: [';
	$script[] = '							{ saturation: -80 }';
	$script[] = '						]';
	$script[] = '					},';
	$script[] = '					{';
	$script[] = '						featureType: "road.arterial",';
	$script[] = '						elementType: "geometry",';
	$script[] = '						stylers: [';
	$script[] = '							{ hue: "#00ffee" },';
	$script[] = '							{ saturation: 50 }';
	$script[] = '						]';
	$script[] = '					}';
	$script[] = '				];';
	
	$script[] = '				map.setOptions( { styles: styleArray } );';
	
	$script[] = '			});';
	$script[] = '		});';

	// Add the script to the document head.
	$doc->addScriptDeclaration(implode("\n", $script));

?>

<?php endif;?>
