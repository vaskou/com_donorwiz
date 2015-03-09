<?php

/**
 * @version     1.0.0
 * @package     com_volunteers
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// No direct access
defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

class DonorwizControllerUser extends DonorwizController {

    /**
     * Method to check if user with the provided email already exists
     *
     */
    public function emailExists() {
	
		//Check access token
		JSession::checkToken( 'get' ) or die( 'Invalid Token' );
		
		$jinput = JFactory::getApplication()->input;
		$email = $jinput->get('email', '', 'username');
		
		if( $email ) {
			
			$db = JFactory::getDBO();
			
			$query = $db->getQuery(true);
			
			$query -> select( array ( $db -> quoteName('id') , $db -> quoteName('username') ));
			
			$query->from($db->quoteName('#__users'));
			
			$query->where($db->quoteName('email') . ' LIKE '. $db->quote($email));
			
			$db->setQuery( $query ); 
			
			$result=$db->loadObject();
			
			if ($result) {      
				$return = $result;
				$message = 'Email exists.';
			} else {
				$return = false;	
				$message = 'Email does not exist.';
			}
		} 
		else {
			$return = false;
			$message = 'Email field is blank.';
		}
		
		try
		{
			echo new JResponseJson( $return , $message );
		}
		catch(Exception $e)
		{
			echo new JResponseJson($e);
		}
	
		jexit();
    }
	
	public function ajaxRegister()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$jsonReturn = false;
		$message = '';
		
		// If registration is disabled - Redirect to login page.
		if (JComponentHelper::getParams('com_users')->get('allowUserRegistration') == 0)
		{
			$message = 'User registration not allowed';
			try{echo new JResponseJson( $return , $message );}
			catch(Exception $e){echo new JResponseJson($e);}
			jexit();
			return false;
		}

		$app	= JFactory::getApplication();
		$model	= $this->getModel('Registration', 'UsersModel');

		// Get the user data.
		$requestData = $this->input->post->get('jform', array(), 'array');

		// Validate the posted data.
		$form	= $model->getForm();

		if (!$form)
		{
			$message = 'Invalid form';
			try{echo new JResponseJson( $return , $message );}
			catch(Exception $e){echo new JResponseJson($e);}
			jexit();
			return false;

		}

		$data	= $model->validate($form, $requestData);

		// Check for validation errors.
		if ($data === false)
		{
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			$message = 'Invalid data';
			try{echo new JResponseJson( $return , $message );}
			catch(Exception $e){echo new JResponseJson($e);}
			jexit();

			return false;
		}

		// Attempt to save the data.
		$return	= $model->register($data);

		// Check for errors.
		if ($return === false)
		{

			// Redirect back to the edit screen.
			$this->setMessage($model->getError(), 'warning');
			$message = $model->getError();
			try{echo new JResponseJson( $return , $message );}
			catch(Exception $e){echo new JResponseJson($e);}
			jexit();
			return false;
		}

		// Flush the data from the session.
		$app->setUserState('com_users.registration.data', null);
		
		$return = true ;
		$message = 'USer registered';
		try{echo new JResponseJson( $return , $message );}
		catch(Exception $e){echo new JResponseJson($e);}
		jexit();
			
			
		// Redirect to the profile screen.
		// if ($return === 'adminactivate')
		// {
			// $this->setMessage(JText::_('COM_USERS_REGISTRATION_COMPLETE_VERIFY'));
			// $this->setRedirect(JRoute::_('index.php?option=com_users&view=registration&layout=complete', false));
		// }
		// elseif ($return === 'useractivate')
		// {
			// $this->setMessage(JText::_('COM_USERS_REGISTRATION_COMPLETE_ACTIVATE'));
			// $this->setRedirect(JRoute::_('index.php?option=com_users&view=registration&layout=complete', false));
		// }
		// else
		// {
			// $this->setMessage(JText::_('COM_USERS_REGISTRATION_SAVE_SUCCESS'));
			// $this->setRedirect(JRoute::_('index.php?option=com_users&view=login', false));
		// }

		return true;
	}
	
	
	public function socialLogin() {
		
		//Check access token
		JSession::checkToken('get') or die( 'Invalid Token' );
		
		$jinput = JFactory::getApplication()->input;
		$userID = $jinput->get('userID', '', 'int');
		$userName = $jinput->get('userName', '', 'username');
		
		if($userID==''||$userName=='')
		{
			$return = false;	
			$message = 'userID or userName is blank';
				
			try
			{
				echo new JResponseJson( $return , $message );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}

			jexit();
		}
		
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		//Get old password
		$query->select($db->quoteName('password'));
		$query->from($db->quoteName('#__users'));
		$query->where($db->quoteName('id') . ' LIKE '. $db->quote($userID) );
		$db->setQuery($query);
		$oldPassword = $db->loadResult();
		
		if(!$oldPassword)
		{
			$return = false;	
			$message = 'userID/userName combination does not exist.';
				
			try
			{
				echo new JResponseJson( $return , $message );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}

			jexit();		
		}
		
		//Create a temporary password 
		JLoader::import('joomla.user.helper');
		$tempPassword = JUserHelper::genRandomPassword();
		
		//Store temporary password in the DB
		$fields = array(
			$db->quoteName('password') . ' = ' . $db->quote(md5($tempPassword))
		);
		
		$conditions = array(
			$db->quoteName('id') . ' = ' .$userID
		);

		$query->update($db->quoteName('#__users'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$tempPasswordSetResult = $db->execute();
		
		//Login user
		$app = JFactory::getApplication();

		$credentials = array();
		$credentials['username'] = $userName;
		$credentials['password'] = $tempPassword;

		$options = array();
		$options['remember']	= true;

		$app->login($credentials, $options);
		
		//Restore the old password		
		$fields = array(
			$db->quoteName('password') . ' = ' . $db->quote($oldPassword)
		);
		$conditions = array(
			$db->quoteName('id') . ' = '.$userID
		);

		$query->update($db->quoteName('#__users'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$tempPasswordSetResult = $db->execute();
		
		$return = true ;
		$message = 'User is now logged in.' ;
		
		try
		{
			echo new JResponseJson( $return , $message );
		}
		catch(Exception $e)
		{
			echo new JResponseJson($e);
		}
	
		jexit();

	}
	
	public function fbConnectToSession() {
		
		//Check access token
		JSession::checkToken() or die( 'Invalid Token' );	
		
		$response = $this->input->post->get('response', array(), 'array');
		
		JFactory::getApplication()->setUserState('com_donorwiz.fbConnect.response', $response);
		
		$return = true ;
		$message = 'FBConnect saved to session.' ;
		
		try
		{
			echo new JResponseJson( $return , $message );
		}
		catch(Exception $e)
		{
			echo new JResponseJson($e);
		}
	
		jexit();
		
		
	}

}