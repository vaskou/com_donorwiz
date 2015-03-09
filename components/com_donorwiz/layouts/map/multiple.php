<?php 

$items = $displayData['items'];
$widthClass = $displayData['widthClass'];

JHtml::_('jquery.framework');

$DonorwizGooglemaps = new DonorwizGooglemaps();
$DonorwizGooglemaps ->loadGoogleMapsApi();


$script = array();
$script[] = 'var siteURL = "' .Juri::base().'";';
JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
JHtml::script( Juri::base() . 'media/com_donorwiz/js/maps/oms.min.js');

JHtml::script( Juri::base() . 'media/com_donorwiz/js/maps/script.js');


?>

<div class="map-container <?php echo $widthClass;?>">
	<div 
		id="map-canvas"
		class=""
		data-map-items="<?php echo htmlspecialchars(json_encode($items));?>"
		
	>
	</div>
</div>