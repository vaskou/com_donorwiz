<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class DonorwizViewLogin extends JViewLegacy {



    /**
     * Display the view
     */
    public function display($tpl = null) {
		
		$app	= JFactory::getApplication();
		$login_data=$app->getUserState('com_donorwiz.registration.login');
		
		if($login_data){
			
			$credentials = array(
				"username" => $login_data['user']["username"], 
				"password" => $login_data['user']['password1']
			);

			$app->login($credentials);
			
			$app->setUserState('com_donorwiz.registration.login',null);

			if(isset($login_data['return_url'])){
				$app -> redirect(JRoute::_(base64_decode($login_data['return_url']),false));
			}
			
		}
		

        $this->_prepareDocument();

        parent::display($tpl);
    }

    /**
     * Prepares the document
     */
    protected function _prepareDocument() {
  
    }

}
