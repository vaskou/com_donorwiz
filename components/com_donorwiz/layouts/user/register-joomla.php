<?php

// no direct access
defined('_JEXEC') or die;

$return = base64_encode(JFactory::getURI()->toString());

if( JFactory::getApplication()->input->get('return', '', 'BASE64') ){
	
	//JSession::checkToken( 'get' ) or die( 'Invalid Token' );
	$return = JFactory::getApplication()->input->get('return', '', 'BASE64');
	
}

JHtml::_('jquery.framework');

JHtml::_('behavior.formvalidation');

	
JHtml::script(Juri::base() . 'media/com_donorwiz/js/registration.js');

$form = new JForm( 'com_donorwiz.passwordreset' , array( 'control' => 'jform', 'load_data' => true ) );
$form->loadFile( JPATH_ROOT . '/components/com_donorwiz/models/forms/registration.xml' );

?>

<form id="dw-registration-form" class="uk-form form-validate" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
	
	<div class="uk-form-row uk-text-center uk-text-muted">
		<?php echo JText::_('COM_DONORWIZ_REGISTER_NEW_ACCOUNT'); ?>
	</div>
	
	
	<div class="uk-form-row uk-margin-small-top">
		<div class="uk-width-1-1">
			<div class="uk-form-icon uk-width-1-1">
				<i class="uk-icon-user"></i>
				<?php echo $form->getInput('jsfirstname');?>
			</div>
		</div>
	</div>
		
	<div class="uk-form-row uk-margin-small-top">
		<div class="uk-width-1-1">
			<div class="uk-form-icon uk-width-1-1">
				<i class="uk-icon-user"></i>
				<?php echo $form->getInput('jslastname');?>
			</div>
		</div>
	</div>

	<div class="uk-form-row uk-margin-small-top">
		<div class="uk-width-1-1">
			<div class="uk-form-icon uk-width-1-1">
				<i class="uk-icon-envelope-o"></i>
				<?php echo $form->getInput('email1');?>
			</div>
		</div>
	</div>
	
	<div class="uk-form-row uk-margin-small-top">
		<div class="uk-width-1-1">
			<div class="uk-form-icon uk-width-1-1">
				<i class="uk-icon-lock"></i>
				<?php echo $form->getInput('password1');?>
			</div>
		</div>
	</div>	




	
	
	<?php echo $form->getInput('name');?>
	<?php echo $form->getInput('email2');?>
	<?php echo $form->getInput('username');?>
	<?php echo $form->getInput('password2');?>
	
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="registration.register" />
		
	<input type="hidden" name="return" value="<?php echo $return;?>">	

	<?php echo JHtml::_('form.token');?>
	
	<p class="uk-article-meta"><?php echo JText::_('COM_DONOWIZ_REGISTER_EULA');?></p>

	<div class="uk-form-row" data-uk-margin>
		<button type="submit" class="validate uk-width-1-1 uk-button uk-button-primary uk-button-large"><?php echo JText::_('COM_DONOWIZ_REGISTER_SUBMIT');?></button>

	</div>


</form>

