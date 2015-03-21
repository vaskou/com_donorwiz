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

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';

class DonorwizForm {
	
	public function cleanPostParameters( $post, $trusted_vars )
	{
		$_post = $post;
		
		foreach ($_post as $key => $value) {
			if( !in_array( $key , $trusted_vars ) )
				unset( $_post[$key] );
			else
				$_post[$key] = strip_tags( $_post[$key] );
				
			if($key == 'message')
				$_post[$key] = mb_substr($_post[$key], 0, 400, 'UTF-8');
		}
		
		return array();
	
	}
	
	public function test(){
	
		return array();
	
	}
	
	    public function imageUpload() {
        
		return array();

    }

}


