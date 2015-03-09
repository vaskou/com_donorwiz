<?php

defined('_JEXEC') or die('Restricted access');
require_once( JPATH_ROOT . '/components/com_community/models/user.php' );

class DonorwizModelUser extends CommunityModelUser {
    
	public function getPaymentReceiverUser() {
        
		$db = JFactory::getDBO();
        $query = 'SELECT u.' . $db->quoteName('id') . ' FROM ' . $db->quoteName('#__users') . ' as u LEFT JOIN '.$db->quoteName('#__community_users').' as cu on u.id=cu.userid WHERE cu.profile_id=2' ;

        $db->setQuery($query);
        $db->Query();

        $ids = $db->loadColumn();

        CFactory::loadUsers($ids);

        $users = array();
        foreach ($ids as $id) {
            $users[] = CFactory::getUser($id);
        }

        return $users;
    }

}


?>