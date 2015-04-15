<?php 

$userID = JFactory::getUser() -> id;

$component = 'com_dw_donations';
$component_path = JPATH_ROOT.'/components/'.$component;

// Get/configure the users controller
if (!class_exists('Dw_donationsController')) 
	require($component_path.'/controller.php');

$moneydonationslist = new DwDonationsHelper();

$donorwizUser = new DonorwizUser ($userID) ;
$isBeneficiaryDonations = $donorwizUser-> isBeneficiary('com_dw_donations');

$current_month=JFactory::getDate('now')->format('m');
$current_year=JFactory::getDate('now')->format('Y');
$date=array('year'=>$current_year,'month'=>$current_month);

$total = $moneydonationslist -> fn_get_donations_sum_by_user_id( $userID , $isBeneficiaryDonations , $date ) ;

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
			<a href="<?php echo JRoute::_('index.php?Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard&layout=dwdonations', true )->id );?>" class="uk-text-contrast uk-text-truncate">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_VIEW_ALL');?>
				<i class="uk-icon-chevron-right uk-margin-small-left"></i>
			</a>
		</div>	
	
	</div>

</div>