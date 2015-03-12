<?php

defined('JPATH_PLATFORM') or die;

class DonorwizUrl {
	
	public function getCurrentUrlWithNewParams( $params )
	{
		$uri = JUri::getInstance() ;

		$params = array_merge( $uri->getQuery( true ), $params );
		
		$query = $uri->buildQuery( $params );
				
		return JURI::current().'?'.$query;

	}

}