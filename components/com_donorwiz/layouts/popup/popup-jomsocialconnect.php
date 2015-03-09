<?php
/**
 * @version     1.0.0
 * @package     com_volunteers
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.module.helper');

?>

<article class="uk-article">

<h4><i class="uk-icon-facebook uk-icon-medium"></i> LOGIN μέσω FACEBOOK</h4>
<p>Κάνε είσοδο μέσω του λογαριασμού σου στο Facebook</p>

<?php

$modules = JModuleHelper::getModules('jomsocialconnect'); 

		
foreach($modules as $module){
	if($module->module=='mod_jomsocialconnect')
		echo JModuleHelper::renderModule($module);
}

?>

</article>