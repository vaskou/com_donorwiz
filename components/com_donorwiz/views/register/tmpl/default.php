<?php

// no direct access
defined('_JEXEC') or die;

$user = JFactory::getUser();
$isGuest = $user->get('guest');
JHtml::_('behavior.framework');
?>




<article class="uk-article" >

<?php if($isGuest): ?>

<h1 class="uk-article-title uk-text-center"><?php echo JText::_('COM_DONORWIZ_REGISTER');?> </h1>

<div class="uk-grid">
    <div class="uk-width-1-1">

		<?php echo JLayoutHelper::render( 'login-social', array ( 'buttonText' => JText::_('COM_DONORWIZ_REGISTER_WITH_UPPERCASE') ) , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>

		
	</div>
	
	<div class="uk-width-1-1 uk-text-center uk-text-large uk-margin">
		<?php echo JText::_('COM_DONORWIZ_LOGIN_OR');?>
	</div>
	
    <div class="uk-width-1-1">
		<?php echo JLayoutHelper::render( 'register-joomla', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>
	</div>
	

</div>
<hr class="uk-grid-divider">
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1 uk-text-center">
	
		<?php echo JText::_('COM_DONORWIZ_LOGIN_ALREADY_HAVE_ACCOUNT');?> <a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=login',false);?>"><?php echo JText::_('COM_DONORWIZ_LOGIN');?></a></li>
	</div>

</div>

<?php endif; ?>

<?php if(!$isGuest): ?>



		<?php echo JLayoutHelper::render( 'logout', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>



<?php endif; ?>

</article>





