<?php

// no direct access
defined('_JEXEC') or die;

?>
<h1 class="uk-article-title uk-text-center"><?php echo JText::_('COM_DONORWIZ_PASSWORD_RESET'); ?></h1>
<?php echo JLayoutHelper::render( 'password-reset',				array () , JPATH_ROOT .'/components/com_donorwiz/layouts/user' , null ); ?>