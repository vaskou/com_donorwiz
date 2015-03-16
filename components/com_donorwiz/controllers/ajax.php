<?php

defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

class DonorwizControllerAjax extends DonorwizController {

    public function getLayout() {
	
		//Check access token
		JSession::checkToken( ) or die( 'Invalid Token' );
		
		$jinput = JFactory::getApplication()->input;
		
		$layout = $jinput->get('layout', '', 'string');
		$layoutPath = $jinput->get('layoutPath', '', 'base64');
		$layoutParams = json_decode(  htmlspecialchars_decode ( $jinput->get('layoutParams', '', 'html') ) );

		try
		{
			echo new JResponseJson( JLayoutHelper::render( $layout , (array) $layoutParams , base64_decode ( $layoutPath ) , null ) );
		}
		catch(Exception $e)
		{
			echo new JResponseJson($e);
		}
	
		jexit();
    }
	


}