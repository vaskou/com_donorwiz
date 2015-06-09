<?php

defined('JPATH_PLATFORM') or die;

jimport('joomla.application.component.helper');

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
include_once JPATH_ROOT.'/components/com_community/libraries/user.php';

class DonorwizUser extends CUser {
	
	public function isBeneficiary($component)
	{
		$com_params = JComponentHelper::getParams($component);

		if ( !$com_params->get('beneficiary_usergroups') )
			return false;
		
		$com_beneficiary_usergroups = $com_params->get('beneficiary_usergroups');
		
		$table   = JUser::getTable();
		
		if(!$table->load( $this -> id ))
		{
			return false;	
		}

		$user = JFactory::getUser( $this -> id );
		
		$user_usergroups = $user -> get('groups');
		
		$isBeneficiary = false; 
		
		foreach ($user_usergroups as $key => $value) {
			
			if( in_array ( $value , $com_beneficiary_usergroups ))
			{
				$isBeneficiary = true;
			}
		}
		
		return $isBeneficiary;
	
	}

	public function isDonor()
	{
		$com_params = JComponentHelper::getParams('com_donorwiz');
		
		$donor_usergroups = $com_params->get('donor_usergroups');
		
		$table   = JUser::getTable();
		
		if(!$table->load( $this -> id ))
		{
			return false;	
		}

		$user = JFactory::getUser( $this -> id );
		
		$user_usergroups = $user -> get('groups');
		
		$isDonor = false; 
		
		foreach ($user_usergroups as $key => $value) {
			
			if( in_array ( $value , $donor_usergroups ))
			{
				$isDonor = true;
			}
		}
		
		return $isDonor;
	
	}
	
	public function getCoordinates($address)
	{

		if($address==''||!$address)
			return array( "lat" => 0, "lng" => 0 , "address" => '' );
		

		$address = urlencode($address);
		$url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $address;
		$response = file_get_contents($url);
		
		if(!$response)
			return array( "lat" => 0, "lng" => 0 , "address" => '' );
		
		$json = json_decode($response,true);
		
		if( isset( $json['results'] ) && isset( $json['results'][0] ) && isset( $json['results'][0]['geometry'] ) && isset( $json['results'][0]['geometry']['location'] ) ) 
		{
		
			$lat = $json['results'][0]['geometry']['location']['lat'];
			$lng = $json['results'][0]['geometry']['location']['lng'];

			return array( "lat" => $lat, "lng" => $lng , "address" => urldecode ( $address ) );

		}
		else
		{
			return array( "lat" => 0, "lng" => 0 , "address" => '' );
			
		}
	}

	
	public function getUserCoordinates($user_id)
	{
		$user = CFactory::getUser($user_id);
		
		$address = $user -> getInfo('FIELD_ADDRESS');
		$state = $user -> getInfo('FIELD_STATE');
		$city = $user -> getInfo('FIELD_CITY');
		$pc = $user -> getInfo('FIELD_PC');
		$country = $user -> getInfo('FIELD_COUNTRY');
		
		$lang = JFactory::getLanguage();
		$lang->load('com_community.country', JPATH_SITE , $lang->getTag(), true);
		$coordinates_address=array();
		
		if( trim ( $address ) !='')
			$coordinates_address[]= trim ( $address );

		if( trim ( $state ) !='')
			$coordinates_address[]= ' '.trim ( $state );

		if( trim ( $city ) !='')
			$coordinates_address[]= ' '.trim ( $city );

		if( trim ( $pc ) !='')
			$coordinates_address[]= ' '.trim ( $pc );

		if( trim ( JText::_($country) ) !='')
			$coordinates_address[]= ' '. trim ( JText::_($country) );

		return $this->getCoordinates( implode ( $coordinates_address ) );
	}
	
	public function getProfileCompletenessProgress(){
		
		$user = CFactory::getUser();
		
		$profileType = $user -> getProfileType() ;
		
		$progressFields = array ( );
		
		if ( $profileType == '1' )
		{	
			array_push( $progressFields, 'FIELD_GENDER');
			array_push( $progressFields, 'FIELD_BIRTHDATE');
			array_push( $progressFields, 'FIELD_MOBILE');
			array_push( $progressFields, 'FIELD_SKILLS ');
			array_push( $progressFields, 'FIELD_OBJECTIVE');
			array_push( $progressFields, 'FIELD_ACTIONAREA');
			
			if( $user -> getInfo ('FIELD_INTERESTED_IN_DONATIONS') == '' && $user -> getInfo ('FIELD_INTERESTED_IN_INKINDDONATIONS') == '' && $user -> getInfo ('FIELD_INTERESTED_IN_VOLUNTEERS') == ''){
				array_push( $progressFields, 'FIELD_INTERESTED_IN ');
			}
		}
		
		if ( $profileType == '2' )
		{	
			array_push( $progressFields, 'FIELD_ABOUT');
			array_push( $progressFields, 'FIELD_COMPANYNAME');
			array_push( $progressFields, 'FIELD_ADDRESS');
			array_push( $progressFields, 'FIELD_STATE');
			array_push( $progressFields, 'FIELD_CITY');
			array_push( $progressFields, 'FIELD_PC');
			array_push( $progressFields, 'FIELD_LANDPHONE');
			array_push( $progressFields, 'FIELD_WEBSITE');
		
			if( $user -> getInfo ('FIELD_INTERESTED_IN_DONATIONS') == '' && $user -> getInfo ('FIELD_INTERESTED_IN_INKINDDONATIONS') == '' && $user -> getInfo ('FIELD_INTERESTED_IN_VOLUNTEERS') == ''){
				array_push( $progressFields, 'FIELD_INTERESTED_IN ');
			}
		
		}
		
		$progressTotal = count ( $progressFields ) ;
		$progressCurrent = count ( $progressFields ) ;
		
		foreach ( $progressFields as $key) 
		{
			if ( $user -> getInfo($key) == '' && $key != 'FIELD_INTERESTED_IN' )
			{
				$progressCurrent -- ;
			}
		}
		
		if ( $progressTotal !=0 )
		{
			$progress = intval ( ( $progressCurrent / $progressTotal ) * 100 );
		}
		else{
			$progress = 0;
		}
		
		return $progress;
	}
}