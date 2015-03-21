<?php
/**
 * @package     Joomla.Platform
 * @subpackage  User
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

require_once(JPATH_SITE."/libraries/aws/aws-autoloader.php");

use Aws\S3\S3Client;
use Aws\Common\Credentials\Credentials;

class DonorwizS3 {
	
	public function upload(){
		
		JSession::checkToken() or die( 'Invalid Token');
		
		$user = JFactory::getUser();
		
		if( !$user->id )
		{
			try
			{
				echo new JResponseJson( null , 'Invalid user' , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();			
			
		}
		
		$objecttype = JFactory::getApplication() -> input -> post -> get('objecttype', '', 'string') ;
		$field = JFactory::getApplication() -> input -> post -> get('field', '', 'string') ;
		$objectid = JFactory::getApplication() -> input -> post -> get('objectid', '', 'int') ;
		$formpath = base64_decode( JFactory::getApplication() -> input -> post -> get('formpath', '', 'BASE64') );
		$formItemSession = JFactory::getApplication()->getUserState('com_dw_opportunities.form.item');
		
		//Check object type -------------------------------------------------------------------------------------
		if( !$objecttype || !$objectid )
		{
			echo new JResponseJson( null , 'Missing object data' , true );
			jexit();
		}

		//Check object id from session -------------------------------------------------------------------------------------
		if( !$formItemSession->id == $objectid )
		{
			try
			{
				echo new JResponseJson( null , 'No permission to edit item id' , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
		}

		//Check permissions on object type ---------------------------------------------------------------------------
		$canEdit = $user->authorise('core.edit', $objecttype) ;
		if (!$canEdit && $user->authorise('core.edit.own', $objecttype)) 
		{
			//Check if the user is the owner from session data
			$canEdit = $user->id == $formItemSession->created_by;
		}

		if( $canEdit === false ){
			
			echo new JResponseJson( null , 'Cannot edit item' , true );
			jexit();
		}
		
		$file = JRequest::getVar( 'files', '', 'files', 'array' );
		//TO DO
		//$jinput = JFactory::getApplication()->input;
		//$file = $jinput -> get ( 'files', '',  'array' );
		
		//Validate the file
		$form = new JForm( $objecttype , array( 'control' => 'jform', 'load_data' => false ) );
		$form->loadFile( JPATH_ROOT .$formpath ); 
				
		//Check size
		$size = $form -> getFieldAttribute( $field , 'size' ); 
		
		if ( intval( $file['size'][0] )/1024 > intval($size) )
		{
			
			try
			{
				echo new JResponseJson( null , 'File too big' , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();		
			
		}
		
		//Check type
		$allow = $form -> getFieldAttribute( $field , 'allow' );  
		
		if ( !in_array ( $file['type'][0] , explode("|", $allow)) )
		{
			
			try
			{
				echo new JResponseJson( null , 'File type not permitted' , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();		
			
		}		
		
		//Check S3 credentials----------------------------------------------------------------------------------
		$config = JFactory::getConfig();
			
		if ( !$config->get('s3accesskey') || !$config->get('s3secretkey') )
		{
			try
			{
				echo new JResponseJson( null , 'Missing credentials' , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
		}		
	

		$fileprotocol = ( $config->get('force_ssl') == '0' ) ? 'http://' : 'https://';
		
		$filebasepath = ( $config->get('s3cname') ) ? $fileprotocol.$config->get('s3cname') :$fileprotocol.$config->get('s3endpoint') ;

		
		
		$user = JFactory::getUser();
		
		$Key = $objecttype.'/'.$user->id.'/'.$objectid.'/'.$field.'/'.str_replace(' ', '', JFile::makeSafe($file['name'][0]));
		
		$FileFullPath = $filebasepath.'/'.$Key;
		
		$SourceFile = $file['tmp_name'][0];
		
		$FileType = $file['type'][0];
		
		$credentials = new Credentials( $config->get('s3accesskey') , $config->get('s3secretkey'));
		
		$client = S3Client::factory( array( 
			"credentials"=>$credentials
		));
		
		if($config->get('s3region')!=''){
			
			$client->setRegion($config->get('s3region'));
		}
		
		try
		{
			$uploadParams = array(
				
				'Bucket'     => $config->get('s3bucket'),
				'Key'        => $Key,
				'SourceFile' => $SourceFile,
				'ACL'        => 'public-read',
				'CacheControl' => 'max-age=172800',
				"Expires" => gmdate("D, d M Y H:i:s T", strtotime("+3 years")),
				'Metadata'   => array(
					'Content-Type'        => $FileType
				),

				'FileBasePath'   =>	$filebasepath,
				'FileFullPath'   =>	$FileFullPath
			);

			$upload = $client->putObject( 
		
				$uploadParams
			);
			
			echo new JResponseJson( $uploadParams );
		 }
		 catch(Exception $e)
		 {
			 JLog::add(__METHOD__." ".$e->getMessage(), JLog::ERROR, "jspace");
			 echo new JResponseJson( null , $e , true );
		 }

		jexit();

	}
	
	public function delete(){
		
		JSession::checkToken() or die( 'Invalid Token');
		
		$user = JFactory::getUser();

		if( !$user->id )
		{
			try
			{
				echo new JResponseJson( null , 'Invalid user' , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();			
			
		}
		
		$objecttype = JFactory::getApplication() -> input -> post -> get('objecttype', '', 'string') ;
		$objectid = JFactory::getApplication() -> input -> post -> get('objectid', '', 'int') ;
		$imgsrc = base64_decode( JFactory::getApplication() -> input -> post -> get('imgsrc', '', 'BASE64') );
		$formItemSession = JFactory::getApplication()->getUserState('com_dw_opportunities.form.item');
		
		
		//Check post data---------------------------------------------------------------------------------------------------
		if( !$imgsrc || !$objectid || !$objecttype )
		{
			try
			{
				echo new JResponseJson( null , 'No data' , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
		}
		
		//Check object id from session -------------------------------------------------------------------------------------
		if( !$formItemSession->id == $objectid )
		{
			try
			{
				echo new JResponseJson( null , 'No permission to edit item id' , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
		}
		
		//Check permissions on object type ---------------------------------------------------------------------------
		$canEdit = $user->authorise('core.edit', $objecttype) ;
		if (!$canEdit && $user->authorise('core.edit.own', $objecttype)) 
		{
			//Check if the user is the owner from session data
			$canEdit = $user->id == $formItemSession->created_by;
		}

		if( $canEdit === false ){
			
			echo new JResponseJson( null , 'Cannot edit item' , true );
			jexit();
		}
		
		$config = JFactory::getConfig();
		
		if ( !$config->get('s3accesskey') || !$config->get('s3secretkey') )
		{
			echo new JResponseJson( null , 'Missing access and secret key' , true );
			
			jexit();
		}	

		$credentials = new Credentials( $config->get('s3accesskey') , $config->get('s3secretkey'));
		
		$client = S3Client::factory( array( 
			"credentials"=>$credentials
		));
	

		if($config->get('s3region')!=''){
			
			$client->setRegion($config->get('s3region'));
		}
		
		$fileprotocol = ( $config->get('force_ssl') == '0' ) ? 'http://' : 'https://';
		$filebasepath = ( $config->get('s3cname') ) ? $fileprotocol.$config->get('s3cname') :$fileprotocol.$config->get('s3endpoint') ;
		
		$Key = str_replace($filebasepath, "", $imgsrc);
	
		try
		{
			$deleteParams = array(
				'Bucket'     => $config->get('s3bucket'),
				'Key'        => $Key
			);
			 
			$delete = $client->deleteObject( 
				$deleteParams
			);
			 
			echo new JResponseJson( $deleteParams );
		 }
		 catch(Exception $e)
		 {
			 JLog::add(__METHOD__." ".$e->getMessage(), JLog::ERROR, "jspace");
			 echo new JResponseJson(null, $e , false);
		 }

		jexit();		
	}
	
}