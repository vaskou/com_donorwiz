<?php 

defined('_JEXEC') or die;

$donorwizUser = new DonorwizUser( JFactory::getUser() -> id );
$progress = $donorwizUser -> getProfileCompletenessProgress();

?>

<?php if ( $progress != 100 ) :?>
<div class="uk-panel uk-margin-bottom">
	<h3 class="uk-margin-remove uk-text-contrast uk-text-center">
		<?php echo JText::_('COM_DONORWIZ_DASHBOARD_COMPLETE_YOUR_PROFILE');?>
	</h3>
	<div class="uk-text-contrast uk-text-center">
		<?php echo JText::_('COM_DONORWIZ_DASHBOARD_COMPLETE_YOUR_PROFILE_DESCR');?>
	</div>
	<div class="uk-progress uk-margin-small-top uk-margin-small-bottom">
		<div class="uk-progress-bar" style="width:<?php echo $progress;?>%;"><?php echo $progress;?>%</div>
	</div>
	<div class="uk-text-contrast uk-text-center">
		<i class="uk-icon-cog"></i>
		<a class="uk-text-contrast" href="<?php echo JRoute::_('profile/edit');?>">
		
		<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MYACCOUNT_EDIT');?>
		</a>
	</div>
</div>
<hr>
<?php endif;?>