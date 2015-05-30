<?php 

	JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities/models', 'Dw_opportunitiesModel');
	$opportunitiesModel = JModelLegacy::getInstance('DwOpportunities', 'Dw_opportunitiesModel', array('ignore_request' => true));	
	
	//We are in the dashboard section
	$opportunitiesModel -> setState('filter.dashboard', 'true');
	
	//User object
	$userID = JFactory::getUser()->id ;
	$donorwizUser = new DonorwizUser( $userID );
	
	//Check if user belongs to Donor usergroup
	$isDonor = $donorwizUser -> isDonor();
	
	if ( $isDonor )
	{			
		$opportunitiesModel -> setState('filter.donor_id', $userID );
	}
	else
	{
		$opportunitiesModel -> setState('filter.created_by', $userID );
	}

	$items = $opportunitiesModel -> getItems();
	
	JHtml::_('jquery.framework');

	$DonorwizGooglemaps = new DonorwizGooglemaps();
	$DonorwizGooglemaps ->loadGoogleMapsApi();

	$script = array();
	$script[] = 'var siteURL = "' .Juri::base().'";';
	JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));


?>
<div class="uk-panel uk-panel-widget uk-panel-box uk-panel-blank">
    <h2><?php echo JText::_('COM_DONORWIZ_DASHBOARD_WIDGET_MAP_VOLUNTEERING_OPPORTUNITIES');?></h2>
	<div 
		id="map-canvas"
		style="height:400px;"
		class=""
		data-map-items="<?php echo htmlspecialchars( json_encode( $items ) ); ?>"
	>
	</div>
	
</div>