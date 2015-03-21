<?php

// no direct access
defined('_JEXEC') or die;

$isGuest = JFactory::getUser()->get('guest');

?>

<?php if($isGuest) :?>
<div class="uk-margin-large-top uk-text-center" data-uk-grid-margin="">
	
	<h1><?php echo JText::_('COM_DONORWIZ_LOGIN');?></h1>
	<p class="uk-text-large"><?php echo JText::_('COM_DONORWIZ_LOGIN_REQUIRED');?></p>
	<?php echo JLayoutHelper::render(
		'popup-button', 
		array (
		'buttonText' => JText::_('COM_DONORWIZ_LOGIN'),
		'buttonIcon' => '',
		'buttonType' => 'uk-button uk-button-primary uk-button-large',

		'layoutPath' => JPATH_ROOT .'/components/com_donorwiz/layouts/user',
		'layoutName' => 'login',
		'layoutParams' => array()
		), 
		JPATH_ROOT .'/components/com_donorwiz/layouts/popup' , 
		null ); 
	?>
</div>
<?php endif;?>

<?php if(!$isGuest) :?>

<div class="uk-grid uk-margin-top" data-uk-grid-margin="">
	
	<div class="uk-width-1-1 uk-width-medium-3-4">
		
		<div class="uk-grid" data-uk-grid-margin="">
			
			<div class="uk-width-1-1">
			<?php echo JLayoutHelper::render( 'widgets-top', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard/default' , null ); ?>
			</div>
			<div class="uk-width-1-1">
			<?php echo JLayoutHelper::render( 'widgets-middle', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard/default' , null ); ?>
			</div>
			<div class="uk-width-1-1">
			<?php echo JLayoutHelper::render( 'main', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard/default' , null ); ?>
			</div>
		
		</div>
	
	</div>

	<div class="uk-width-1-1 uk-width-medium-1-4">
		<?php echo JLayoutHelper::render( 'menu-left', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard' , null ); ?>
	</div>
	
</div>
<?php endif;?>

<?php echo JLayoutHelper::render( 'footer', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard' , null ); ?>

