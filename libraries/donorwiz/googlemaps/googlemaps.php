<?php
/**
 * @package     Joomla.Platform
 * @subpackage  User
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.application.component.helper');

class DonorwizGooglemaps {
	
	public function getApiKey()
	{
		return JComponentHelper::getParams('com_donorwiz')->get('googlemapsapikey');
	}
	
	public function loadGoogleMapsApi()
	{
		$doc = JFactory::getDocument();
		$apiURL = 'https://maps.googleapis.com/maps/api/js?libraries=places&key='.$this->getApiKey();
		
		if(!isset($doc->_scripts[$apiURL])){
		
				$doc->addScript($apiURL);
		}
	}

}