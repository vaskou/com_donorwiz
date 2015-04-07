<?php 

	JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities/models', 'Dw_opportunitiesModel');
	
	$opportunitiesModel = JModelLegacy::getInstance('DwOpportunities', 'Dw_opportunitiesModel', array('ignore_request' => true));	
	
	$opportunitiesModel -> setState ('filter.dashboard', 'true') ;
	
	$userID = JFactory::getUser()->id ;
	
	$donorwizUser = new DonorwizUser( $userID );
	
	$isDonor = $donorwizUser -> isDonor();
	
	if ( $isDonor )
	{			
		$opportunitiesModel->setState('filter.donor_id', $userID);
	}
	else
	{
		$opportunitiesModel->setState('filter.created_by', $userID);
	}
	
	$items = $opportunitiesModel -> getCount( $userID );

?>

<div class="uk-panel uk-panel-box uk-panel-box-donations">

	<div class="uk-grid">
		
		<div class="uk-width-1-4 uk-text-center">
		<i class="uk-icon-th-list uk-icon-extra-large"></i>
		</div>
		<div class="uk-width-3-4 uk-text-right">
		
			<div class="uk-width-1-1 uk-text-right uk-text-extra-large">
			<?php echo $items;?>
			</div>
			<div class="uk-width-1-1 uk-text-right uk-text-large uk-text-truncate">
			<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MY_VOLUNTEERING_OPPORTUNITIES');?>
			</div>
		</div>
		<div class="uk-width-1-1 uk-text-right uk-margin-small-top">
			<a href="<?php echo JRoute::_('index.php?Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard&layout=dwopportunities', true )->id );?>" class="uk-text-contrast uk-text-truncate">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_VIEW_ALL');?>
				<i class="uk-icon-chevron-right uk-margin-small-left"></i>
			</a>
		</div>	
	
	</div>

</div>