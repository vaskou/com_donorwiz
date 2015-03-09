<?php 

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
$count = CFactory::getUser( JFactory::getUser()->id )->getFriendCount();

?>

<div class="uk-panel uk-panel-box uk-panel-box-donations">

	<div class="uk-grid">
		
		<div class="uk-width-1-4 uk-text-center">
		<i class="uk-icon-users uk-icon-extra-large"></i>
		</div>
		<div class="uk-width-3-4 uk-text-right">
		
			<div class="uk-width-1-1 uk-text-right uk-text-extra-large">
			<?php echo $count;?>
			</div>
			<div class="uk-width-1-1 uk-text-right uk-text-large">
			<?php echo JText::_('COM_DONORWIZ_DASHBOARD_SUPPORTERS');?>
			</div>
		</div>
		<div class="uk-width-1-1 uk-text-right uk-margin-small-top">
			<a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=volunteers');?>" class="uk-text-contrast">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_VIEW_ALL');?>
				<i class="uk-icon-chevron-right uk-margin-small-left"></i>
			</a>
		</div>	
	
	</div>

</div>


