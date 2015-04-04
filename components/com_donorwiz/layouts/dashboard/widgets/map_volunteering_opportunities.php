<?php 

	JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities/models', 'Dw_opportunitiesModel');
	
	$opportunitiesModel = JModelLegacy::getInstance('DwOpportunities', 'Dw_opportunitiesModel', array('ignore_request' => true));	

	
	$opportunitiesModel->setState('filter.created_by', JFactory::getUser()->id);
	$opportunitiesModel->setState('list.dashboard', true);
		
	$items = $opportunitiesModel -> getItems( );
	JHtml::_('jquery.framework');


	$DonorwizGooglemaps = new DonorwizGooglemaps();
	$DonorwizGooglemaps ->loadGoogleMapsApi();

	$script = array();
	$script[] = 'var siteURL = "' .Juri::base().'";';
	JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));


?>

<div 
	id="map-canvas"
	style="height:400px;"
	class=""
	data-map-items="<?php echo htmlspecialchars(json_encode($items));?>"
>
</div>