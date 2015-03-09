<?php

// no direct access
defined('_JEXEC') or die;

$user = JFactory::getUser();
$isGuest = $user->get('guest');

?>

<article class="uk-article" >

<h1 class="uk-text-center"><?php echo JText::_('COM_DONORWIZ_ERROR_404_TITLE');?></h1>
<p class="uk-text-large uk-text-center"><?php echo JText::_('COM_DONORWIZ_ERROR_404_DESC');?></p>

</article>