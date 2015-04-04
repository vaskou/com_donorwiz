<?php 

$items = $displayData['items'];
$widthClass = $displayData['widthClass'];

JHtml::_('jquery.framework');

$DonorwizGooglemaps = new DonorwizGooglemaps();
$DonorwizGooglemaps ->loadGoogleMapsApi();

$script = array();
$script[] = 'var siteURL = "' .Juri::base().'";';
JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

?>

<div class="map-container <?php echo $widthClass;?>">
	<div 
		id="map-canvas"
		class=""
		data-map-items="<?php echo htmlspecialchars(json_encode($items));?>"
		
	>
	</div>
</div>