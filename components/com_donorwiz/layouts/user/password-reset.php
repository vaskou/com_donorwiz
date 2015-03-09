<?php

defined('_JEXEC') or die;

JSession::checkToken( 'get' ) or die( 'Invalid Token' );

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');


$formFile = JPATH_ROOT . '/components/com_volunteers_responses/models/forms/responsewizard_beneficiary.xml' ;



    //JFactory::getLanguage()->load('com_volunteers_responses');

    //Load the Response Wizard form



	
	
?>
	<form class="uk-form form-validate form-horizontal well" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>" method="post">
	<div class="uk-form-row uk-text-center uk-text-muted">
		<?php echo JText::_('COM_DONORWIZ_PASSWORD_RESET_INSTRUCTIONS'); ?>
	</div>
	<div class="uk-form-row">
		<div class="uk-width-1-1">
			<div class="uk-form-icon uk-width-1-1">
				<i class="uk-icon-envelope-o"></i>
				<?php echo $form->getInput('email');?>

				</div>
		</div>
	</div>
	<div class="uk-form-row">
				<button type="submit" class="uk-button uk-width-1-1 uk-button-primary uk-button-large validate"><?php echo JText::_('COM_DONORWIZ_PASSWORD_RESET_SUBMIT'); ?></button>
	</div>

		<?php echo JHtml::_('form.token'); ?>
	</form>