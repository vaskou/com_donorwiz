<?php

defined('JPATH_PLATFORM') or die;

class DonorwizUrl {
	
	public function getCurrentUrlWithNewParams( $params=array() )
	{
			
		if( empty ( $params ) && JFactory::getConfig()->get("sef")==1)
		{
			return JURI::current();
		}	
		
		$uri = JUri::getInstance() ;

		$params = array_replace_recursive( $uri->getQuery( true ), $params );
		
		$query = $uri->buildQuery( $params );
		
		return JURI::current().'?'.$query;

	}

}