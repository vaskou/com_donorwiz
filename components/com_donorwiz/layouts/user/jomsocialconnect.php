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

$jomsocialconnect = null;

$modules = JModuleHelper::getModules('jomsocialconnect'); 

foreach($modules as $module){

	if($module->module=='mod_arrafacebooklogin'){
		
		$jomsocialconnect = JModuleHelper::renderModule($module);
		break;
	}
}

?>
<h4>Άμεση & ασφαλής σύνδεση με λογαριασμό Facebook</h4>
<?php echo $jomsocialconnect;?>
<p class="uk-article-meta">Δε θα δημοσιεύσουμε τίποτε στο Facebook χωρίς την άδειά σας</p>