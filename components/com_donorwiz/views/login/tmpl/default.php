<?php

// no direct access
defined('_JEXEC') or die;

$user = JFactory::getUser();
$isGuest = $user->get('guest');

?>

<article class="uk-article" >

<?php if($isGuest): ?>

	<?php echo JLayoutHelper::render( 'login', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>

<?php endif; ?>

<?php if(!$isGuest): ?>

	<?php echo JLayoutHelper::render( 'logout', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>

<?php endif; ?>

</article>