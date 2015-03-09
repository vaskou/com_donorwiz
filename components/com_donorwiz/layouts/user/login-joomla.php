<?php

// no direct access
defined('_JEXEC') or die;

$return = base64_encode(JFactory::getURI()->toString());

if( JFactory::getApplication()->input->get('return', '', 'BASE64') ){
	
	JSession::checkToken( 'get' ) or die( 'Invalid Token' );
	$return = JFactory::getApplication()->input->get('return', '', 'BASE64');
	
}

JHtml::_('behavior.formvalidation');

?>

<form class="uk-form uk-form-horizontal form-validate" action="<?php echo JURI::base();?>" method="post">

	<div class="uk-form-row uk-text-center uk-text-muted">
		<?php echo JText::_('COM_DONORWIZ_LOGIN_WITH_YOUR_ACCOUNT'); ?>
	</div>

	<div class="uk-form-row">
		<div class="uk-width-1-1">
			<div class="uk-form-icon uk-width-1-1">
				<i class="uk-icon-envelope-o"></i>
				<input type="email" name="username" class="uk-form-large uk-width-1-1 validate-email required" required="required" placeholder="E-mail">
			</div>
		</div>
	</div>	

	<div class="uk-form-row">
		<div class="uk-width-1-1">
			<div class="uk-form-icon uk-width-1-1">
				<i class="uk-icon-lock"></i>
				<input type="password" name="password" class="uk-form-large uk-width-1-1 required" required="required" placeholder="<?php echo JText::_('COM_DONORWIZ_LOGIN_PASSWORD'); ?>">
			</div>
		</div>
	</div>	
	
	<div class="uk-form-row">
		<input type="checkbox" name="remember" value="yes" checked="">
		<label><?php echo JText::_('COM_DONORWIZ_LOGIN_REMEMBER_ME'); ?></label>
	</div>
		
	<div class="uk-form-row">
		<button class="validate uk-button uk-width-1-1 uk-button-primary uk-button-large" value="<?php echo JText::_('COM_DONORWIZ_LOGIN_UPPERCASE'); ?>" name="Submit" type="submit"><?php echo JText::_('COM_DONORWIZ_LOGIN_UPPERCASE'); ?></button>
	</div>

	<div class="uk-form-row uk-grid uk-text-center">
		<a class="uk-width-1-1" href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=316',false);?>">
		<?php echo JText::_('COM_DONORWIZ_LOGIN_FORGOT_PASSWORD'); ?>
		</a>
	</div>
	
	<input type="hidden" name="option" value="com_users">
	
	<input type="hidden" name="task" value="user.login">
	
	<input type="hidden" name="return" value="<?php echo $return;?>">
	
	<?php echo JHtml::_('form.token'); ?>

</form>