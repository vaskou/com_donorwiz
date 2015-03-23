<?php

// no direct access
defined('_JEXEC') or die;

JFactory::getLanguage()->load('com_donorwiz');

$isGuest = JFactory::getUser()->get('guest');

$mode = 'login';
if ( JFactory::getApplication()->input->get('mode', '', 'string') == 'register' || isset($displayData['mode'])=='register' )
	$mode = 'register';
JHtml::_('jquery.framework');

JHtml::_('behavior.formvalidator');

$isPopup=( isset ( $displayData['isPopup'] ) ) ? $displayData['isPopup']  : false ;
?>

<?php if($isGuest): ?>

<div id="#toggle-login" class="uk-width-1-1 toggle-login-register uk-animation-fade<?php if($mode == 'register') echo ' uk-hidden';?>">

<h1 class="uk-article-title uk-text-center uk-margin-small-bottom"><?php echo JText::_('COM_DONORWIZ_LOGIN');?> </h1>

<div class="uk-grid">
    
	<div class="uk-width-1-1">

		<?php echo JLayoutHelper::render( 'login-social', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>

	</div>
	
	<div class="uk-width-1-1 uk-text-center uk-text-large uk-margin-small-top uk-margin-small-bottom">
		<?php echo JText::_('COM_DONORWIZ_LOGIN_OR');?>
	</div>
	
	<div class="uk-width-1-1">
		
		<?php echo JLayoutHelper::render( 'login-joomla', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>
	
	</div>
	

</div>

<hr class="uk-grid-divider">

<div class="uk-grid" data-uk-grid-margin>
    
	<div class="uk-width-1-1 uk-text-center">
	
		<?php echo JText::_('COM_DONORWIZ_NEED_AN_ACCOUNT');?> 
		<a class="uk-text-primary" href="#" data-uk-toggle="{target:'.toggle-login-register'}"><?php echo JText::_('COM_DONORWIZ_REGISTER');?></a>
	
	</div>

</div>

</div>


<div id="#toggle-register" class="uk-width-1-1 toggle-login-register uk-animation-fade<?php if($mode == 'login') echo ' uk-hidden';?>">

<h1 class="uk-article-title uk-text-center"><?php echo JText::_('COM_DONORWIZ_REGISTER');?> </h1>

<div class="uk-grid">
    <div class="uk-width-1-1">

		<?php echo JLayoutHelper::render( 'login-social', array ( 'buttonText' => JText::_('COM_DONORWIZ_REGISTER_WITH_UPPERCASE') ) , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>

		
	</div>
	
	<div class="uk-width-1-1 uk-text-center uk-text-large uk-margin-small-top uk-margin-small-bottom">
		<?php echo JText::_('COM_DONORWIZ_LOGIN_OR');?>
	</div>
	
    <div class="uk-width-1-1">
		<?php echo JLayoutHelper::render( 'register-joomla', array ('isPopup'=>$isPopup) , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>
	</div>
	

</div>
<hr class="uk-grid-divider">
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1 uk-text-center">
	
		<?php echo JText::_('COM_DONORWIZ_LOGIN_ALREADY_HAVE_ACCOUNT'); ?>
		<a class="uk-text-primary" href="#" data-uk-toggle="{target:'.toggle-login-register'}"><?php echo JText::_('COM_DONORWIZ_LOGIN'); ?></a></li>
	</div>

</div>

</div>

<?php endif;?>

<?php if(!$isGuest): ?>

<?php echo JLayoutHelper::render( 'logout', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>

<?php endif; ?>