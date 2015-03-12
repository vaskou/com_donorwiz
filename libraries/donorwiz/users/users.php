<?php

defined('JPATH_PLATFORM') or die;

class DonorwizUsers {
	
	public function getUsersByUserGroupsIDs( $UserGroupsIDs , $enabled )
	{
		
		if( !count ( $UserGroupsIDs ) )
		{
			return array();	
		}
		
		jimport('joomla.access.access');
		
		jimport('joomla.user.user');		
		
		$users = array();
		
		foreach ( $UserGroupsIDs as $key => $usergroup_id)
		{
			$usergroupUsers = JAccess::getUsersByGroup($usergroup_id);
			
			$users = array_merge($users, $usergroupUsers);
		}
		
		$users = array_unique($users);
		
		//Get only enabled users
		if( $enabled )
		{
			foreach ( $users as $key => $user_id)
			{
				$user = JFactory::getUser($user_id);
				
				if( $user->block == '1' )
				{
					unset ($users[$key]);
				}
			}			
			
		}

		return $users;
	}

}