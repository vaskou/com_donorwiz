<?php

defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

class DonorwizControllerExport extends DonorwizController {
	
	public function csv() {
		
		//Check access token
		JSession::checkToken( ) or die( 'Invalid Token' );

		$jinput = JFactory::getApplication()->input;
		$filename = $jinput->get('filename', '', 'string') ;
		$items = json_decode(  htmlspecialchars_decode ( $jinput->get('items', '', 'html') ) );
		$fields = explode(',', $jinput->get('fields', '', 'string')) ;
		$component = $jinput->get('component', '', 'string') ;
		
		//Check if the user is beneficiary for the component, so that he can export
		$isBeneficiary = null;

		if ( $component ) 
		{
			$user = JFactory::getUser();
			$donorwizUser = new DonorwizUser( $user -> id );
			$isBeneficiary = ( $donorwizUser -> isBeneficiary( $component ) == true ) ? true : null;	
		}
		
		if( !$isBeneficiary )
			die( 'Access denied' );
		
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment;Filename=".$filename.".csv");

		$jinput = JFactory::getApplication()->input;
		$items = json_decode(  htmlspecialchars_decode ( $jinput->get('items', '', 'html') ) );
		$fields = explode(',', $jinput->get('fields', '', 'string')) ;

		$csv = '';

		//First get the columns
		foreach ( $items as $key => $item) {

			foreach ( $item as $k => $v)
			{
				if ( in_array( $k , $fields) )
				{
					$csv = $csv . $k . ";" ;
				}
			}
			
			break;
		}

		$csv = $csv . "\n";

		//Get the data
		foreach ( $items as $key => $item) {

			foreach ( $item as $k => $v)
			{
				if ( is_string( $item->$k ) && in_array ( $k , $fields ) ) 
				{
					//TO DO : escape character ; , because it is the delimeter and if it is inside the value it causes malformed columns.
					$csv = $csv . str_replace( ';', '?' , html_entity_decode( $item->$k ) ) . ';';
				}
			}
			
			$csv = $csv . "\n";
		}

		echo $csv;

		jexit();
	}
}