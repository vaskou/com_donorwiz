<?php
/**
 * @version     1.0.0
 * @package     com_donorwiz
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// no direct access

defined('_JEXEC') or die;

?>
<div id="popup-login-jomsocialconnect-register" class="uk-grid">
	<div class="uk-width-1-2" style="border-right:1px dashed #ddd">
		<?php echo JLayoutHelper::render( 'popup-login',				array () , JPATH_ROOT .'/components/com_donorwiz/layouts/popup' , null ); ?>
		<?php echo JLayoutHelper::render( 'popup-jomsocialconnect',		array () , JPATH_ROOT .'/components/com_donorwiz/layouts/popup' , null ); ?>
	</div>	
	<div class="uk-width-1-2">
		<?php echo JLayoutHelper::render( 'popup-register',				array () , JPATH_ROOT .'/components/com_donorwiz/layouts/popup' , null ); ?>
	</div>
</div>


