<?php 

$userID = JFactory::getUser() -> id;
$donorwizUser = new DonorwizUser ($userID) ;
$isBeneficiaryDonations = $donorwizUser-> isBeneficiary('com_dw_donations');

$data=array('userId'=>$userID,'isBeneficiaryDonations'=>$isBeneficiaryDonations);

?>

<div class="uk-panel uk-panel-widget uk-panel-box uk-panel-blank">
    <h2><?php echo JText::_('COM_DONORWIZ_DASHBOARD_WIDGET_CHART_DONATIONS');?></h2>
    <?php echo JLayoutHelper::render('dwdonations.donations_chart', $data, JPATH_ROOT.'/components/com_dw_donations/layouts');?>

</div>