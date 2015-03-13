<?php

defined('JPATH_PLATFORM') or die;

jimport('joomla.application.component.helper');

class DonorwizMail {

	public function sendMail( $mailParams ){
		
		$mailer = JFactory::getMailer();
		
		if( !isset($mailParams['mailfrom']) && !isset($mailParams['fromname']) ){
			
			$config = JFactory::getConfig();
			$sender = array( 
				$config->get( 'config.mailfrom' ),
				$config->get( 'config.fromname' ) 
			);			
		}
		else
		{
			$sender = array( 
				$mailParams['mailfrom'],
				$mailParams['fromname'] 
			);			
		}
		$mailer->setSender($sender);
		
		$mailer->addRecipient($mailParams['recipient']);
			
		$subject  = ( isset( $mailParams['subject'] ) ) ? $mailParams['subject']  : 'DONORwiz E-mail' ;
		
		if ( $mailParams['isHTML'] )
		{
			
			$body  = JLayoutHelper::render( $mailParams['layout'],$mailParams['layout_params'] , $mailParams['layout_path'] , null ) ;
			$mailer->isHTML(true);
			$mailer->Encoding = 'base64';
		}
		else{
			
			$body  = ( isset( $mailParams['body'] ) ) ? $mailParams['body']  : 'DONORwiz E-mail body' ;
		}
		
		
		
		$mailer->setSubject($subject);
		$mailer->setBody($body);	

		$send = $mailer->Send();	

		//if ( $send !== true ) {
			//echo 'Error sending email: ' . $send->__toString();
		//} 			

	}
}