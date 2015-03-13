<?php

defined('JPATH_PLATFORM') or die;

jimport('joomla.application.component.helper');

require_once JPATH_ROOT.'/components/com_community/libraries/core.php';

class DonorwizMessaging {

	public function sendNotification( $messageParams ){
	
		$cmd = ( isset ( $messageParams['cmd'] ) ) ? $messageParams['cmd'] : 'system_messaging' ;
		$template = ( isset ( $messageParams['template'] ) ) ? $messageParams['template'] : '' ;
		
		$actor_id = ( isset ( $messageParams['actor_id'] ) ) ? $messageParams['actor_id'] : null ;
		$target = ( isset ( $messageParams['target'] ) ) ? $messageParams['target'] : null ;
		$subject = ( isset ( $messageParams['subject'] ) ) ? $messageParams['subject'] : 'DONORwiz e-mail' ;
		$body = ( isset ( $messageParams['body'] ) ) ? $messageParams['body'] : null ;
		$link = ( isset ( $messageParams['link'] ) ) ? $messageParams['link'] : null ;

		$opportunity_title = ( isset ( $messageParams['opportunity_title'] ) ) ? $messageParams['opportunity_title'] : null ;
		$response_status = ( isset ( $messageParams['response_status'] ) ) ? $messageParams['response_status'] : null ;
		
		if( !$actor_id || !$target || !$body || !$link )
			return false;
		
		$actor = CFactory::getUser($actor_id);
		$params = new CParameter('');
		$params->set('actor', $actor->getDisplayName()); // can be used as {actor} tag
		$params->set('actor_url', 'index.php?option=com_community&view=profile&userid=' . $actor->id); // Link for the {actor} tag
		$params->set('url', $link); //url of the whole activity. Used when hovering over avatar in notification window. Can be used as {url} tag in outgoing emails too. Make sure that you have defined $link variable :)
		
		$params->set('opportunity_title', $opportunity_title); 
		$params->set('response_status', $response_status); 
		
		CNotificationLibrary::add( $cmd , $actor->id , $target , $subject , $body , $template , $params );
		

	}
}