<?php 

$userID = JFactory::getUser() -> id;

if (!class_exists('Dw_donationsController')) 
	require_once(JPATH_ROOT.'/components/com_dw_donations/controller.php');

$moneydonationslist = new DwDonationsHelper();

$date=JFactory::getDate('now')->format('Y-m');

$filter_array=array(
	'modified_from_dateformat'=>$date.'-01',
	'state'=>1
);

$total=$moneydonationslist->fn_get_donations_sum_by_user_id($filter_array,$userID);

?>

<div class="uk-panel uk-panel-box uk-panel-box-donations">

	<div class="uk-grid">
		
		<div class="uk-width-1-4 uk-text-center">
			<i class="uk-icon-euro uk-icon-extra-large"></i>
		</div>
		
		<div class="uk-width-3-4 uk-text-right">
		
			<div class="uk-width-1-1 uk-text-right uk-text-extra-large">
			<?php echo $total;?>
			</div>
			<div class="uk-width-1-1 uk-text-right uk-text-large uk-text-truncate">
			<?php echo JText::_('COM_DONORWIZ_DASHBOARD_DONATIONS_TOTAL_THIS_MONTH');?>
			</div>
		
		</div>
		
		<div class="uk-width-1-1 uk-text-right uk-margin-small-top">
			<a href="<?php echo JRoute::_('index.php?Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard&layout=dwdonations', true )->id );?>" class="uk-button uk-button-link uk-text-contrast uk-button-small uk-text-truncate">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_VIEW_ALL');?>
				<i class="uk-icon-chevron-right uk-margin-small-left"></i>
			</a>
			<a href="<?php echo JRoute::_('index.php?Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_dw_donations&view=dwdonationform', true )->id );?>" class="uk-button uk-button-blank uk-button-small uk-text-truncate">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_DONATE_NOW');?>
				<i class="uk-icon-chevron-right uk-margin-small-left"></i>
			</a>
		</div>	
	
	</div>

</div>