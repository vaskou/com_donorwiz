<div class="dw-toolbar">

<?php

$donate_button_params=$displayData['donate_button_params'];
$vounteer_params=$displayData['vounteer_params'];

echo JLayoutHelper::render('dwdonationform.donation_form_button',$donate_button_params,JPATH_ROOT.'/components/com_dw_donations/layouts');

?>

<?php	$donorwizUser=new DonorwizUser(intval($vounteer_params['actor']));?>
<?php	$isBeneficiaryVolunteers = $donorwizUser-> isBeneficiary('com_dw_opportunities');?>
<?php 
if ($isBeneficiaryVolunteers):
	JFactory::getLanguage()->load('com_dw_opportunities');


    $app = JFactory::getApplication(); 
    $menu = $app->getMenu();
    $menuItem = $menu->getItems( 'link', 'index.php?option=com_dw_opportunities&view=dwopportunities', true );
?>
    
    <a href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunities&Itemid='.$menuItem->id.'&created_by='.$vounteer_params['actor']);?>" class="uk-button uk-button-primary" style="border:0;">
        <i class="uk-icon uk-icon-users"></i>
        <?php echo JText::_('COM_DONORWIZ_DASHBOARD_VOLUNTEERS'); ?>
    </a>
<?php endif;?>

</div>