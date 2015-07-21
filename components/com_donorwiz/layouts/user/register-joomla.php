<?php

// no direct access
defined('_JEXEC') or die;

$return = base64_encode(JFactory::getURI()->toString());

if( JFactory::getApplication()->input->get('return', '', 'BASE64') ){
	
	//JSession::checkToken( 'get' ) or die( 'Invalid Token' );
	$return = JFactory::getApplication()->input->get('return', '', 'BASE64');
	
}

JHtml::_('jquery.framework');

JHtml::_('behavior.formvalidator');
	
JHtml::script(Juri::base() . 'media/com_donorwiz/js/registration.js');

$isPopup=( isset ( $displayData['isPopup'] ) ) ? $displayData['isPopup']  : false ;

$form = new JForm( 'com_donorwiz.passwordreset' , array( 'control' => 'jform', 'load_data' => true ) );
$form->loadFile( JPATH_ROOT . '/components/com_donorwiz/models/forms/registration.xml' );

if($isPopup){
	fn_load_captcha($form);
}

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
			<div class="uk-form-icon uk-width-1-1" title="<?php echo JText::_($form->getFieldAttribute('password1','tooltip'));?>">
				<i class="uk-icon-lock"></i>
				<?php echo $form->getInput('password1');?>
			</div>
		</div>
	</div>	

	<div class="uk-form-row">
        <div class="uk-form-large uk-width-1-1">
            <?php echo $form->getInput('captcha');?>
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

<script type="text/javascript">
jQuery(function(){
	fn_registration_form_init('<?php echo JText::_('COM_DONOWIZ_REGISTER_RECAPTCHA_ERROR')?>');
	try{
		jQuery('a[data-lightbox]').lightbox();
	}catch(ex){
		$widgetkit.load('<?php echo JUri::base().'media/widgetkit/widgets/lightbox/js/lightbox.js' ?>').done(function(){jQuery('a[data-lightbox]').lightbox()});
	}
});
</script>

<?php
function fn_load_captcha($form){
	$document = JFactory::getDocument();
	$app = JFactory::getApplication();
	
	$plugin = JPluginHelper::getPlugin('captcha', 'recaptcha');

	$params = new JRegistry($plugin->params);
	$pubkey= $params->get('public_key','');
	$theme = $params->get('theme2', 'light');
	$id=$form->getField('captcha')->id;
	
	
	$file = $app->isSSLConnection() ? 'https' : 'http';
	$file .= '://www.google.com/recaptcha/api.js?hl=' . JFactory::getLanguage()->getTag() . '&onload=onloadCallback&render=explicit';
	
	$line='var onloadCallback = function() {grecaptcha.render("' . $id . '", {sitekey: "' . $pubkey . '", theme: "' . $theme . '"});}';
	echo '<script src="'.$file.'"></script>';
	echo '<script>'.$line.'</script>';
}
?>