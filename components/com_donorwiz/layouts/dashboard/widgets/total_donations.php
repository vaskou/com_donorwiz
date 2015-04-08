<?php 

$userID = JFactory::getUser() -> id;

$component = 'com_dw_donations';
$component_path = JPATH_ROOT.'/components/'.$component;

if (!class_exists('Dw_donationsController')) 
	require($component_path.'/controller.php');

$moneydonationslist = new DwDonationsHelper();

$donorwizUser = new DonorwizUser ($userID) ;
$isBeneficiaryDonations = $donorwizUser-> isBeneficiary('com_dw_donations');
$isDonor = $donorwizUser -> isDonor();

$date=JFactory::getDate('now')->format('Y-m');

$filter_array=array(
	'modified_from_dateformat'=>$date.'-01',
	'state'=>1
);
if($isBeneficiaryDonations){
	$filter_array['beneficiary_id']=$userID;
}elseif($isDonor){
	$filter_array['donor_id']=$userID;
}else{
	$filter_array=array();
}
$total=$moneydonationslist->fn_get_donations_sum_by_user_id($filter_array);

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
			<div class="uk-width-1-1 uk-text-right uk-text-large">
			<?php echo JText::_('COM_DONORWIZ_DASHBOARD_DONATIONS_TOTAL_THIS_MONTH');?>
			</div>
		
		</div>
		
		<div class="uk-width-1-1 uk-text-right uk-margin-small-top">
			<a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=donations');?>" class="uk-text-contrast">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_VIEW_ALL');?>
				<i class="uk-icon-chevron-right uk-margin-small-left"></i>
			</a>
		</div>	
	
	</div>

</div>