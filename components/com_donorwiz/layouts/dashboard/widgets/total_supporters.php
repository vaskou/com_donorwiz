<?php 

// include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
// $count = CFactory::getUser( JFactory::getUser()->id )->getFriendCount();

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
$responsesModel = JModelLegacy::getInstance('DwOpportunitiesresponses', 'Dw_opportunities_responsesModel', array('ignore_request' => true));	
$responsesModel->setState('filter.opportunity_created_by', JFactory::getUser()->id );
$responses = $responsesModel -> getItems();
$count = count ($responses);


?>

<?php if ( $count ) :?>
<div class="uk-panel uk-panel-box uk-panel-box-donations">

	<div class="uk-grid">
		
		<div class="uk-width-1-4 uk-text-center">
		<i class="uk-icon-users uk-icon-extra-large"></i>
		</div>
		<div class="uk-width-3-4 uk-text-right">
		
			<div class="uk-width-1-1 uk-text-right uk-text-extra-large">
			<?php echo $count;?>
			</div>
			<div class="uk-width-1-1 uk-text-right uk-text-large uk-text-truncate">
			<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MY_VOLUNTEERS');?>
			</div>
		</div>
		<div class="uk-width-1-1 uk-text-right uk-margin-small-top">
			<a href="<?php echo JRoute::_('index.php?Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard&layout=dwopportunitiesresponses', true )->id );?>" class="uk-text-contrast uk-text-truncate">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_VIEW_ALL');?>
				<i class="uk-icon-chevron-right uk-margin-small-left"></i>
			</a>
		</div>	
	
	</div>

</div>
<?php endif;?>