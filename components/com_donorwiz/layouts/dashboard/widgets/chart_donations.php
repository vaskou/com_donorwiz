<?php 

$userID = JFactory::getUser() -> id;
$donorwizUser = new DonorwizUser ($userID) ;
$isBeneficiaryDonations = $donorwizUser-> isBeneficiary('com_dw_donations');

$data=array('userId'=>$userID,'isBeneficiaryDonations'=>$isBeneficiaryDonations);
echo JLayoutHelper::render('dwdonations.donations_chart', $data, JPATH_ROOT.'/components/com_dw_donations/layouts');

?>


