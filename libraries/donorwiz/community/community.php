<?php

defined('JPATH_PLATFORM') or die;

jimport('joomla.application.component.helper');

require_once JPATH_ROOT.'/components/com_community/libraries/core.php';
require_once (JPATH_ROOT.'/components/com_community/models/friends.php');

class DonorwizCommunity {

    /**
     * Add a friend to stranger. Stranger will have to approve
     * @param	$id		int		ususally the user id of the NGO
     * @param   $fromid int     ususally the user id of the donor, who makes a donorshipowner
     * @param   $msg    string  a message to include, now does nothing because we do not send a message
     * @param   $status int     if 0 a friend request which will have to be approved by the NGO will be created. If 1, the user will automatically be added to NGO friends list
	 */
	 
	public function addAsAFriend( $id , $fromid , $msg = '' , $status = 0 )
	{

		if( $fromid != 0 && $id != 0 ){
			
			$friendsModel = new CommunityModelFriends();
			
			$alredyFriends = $friendsModel->getFriendIds($id);
			
		
			if ( !in_array( $fromid , $alredyFriends ) ) {
			
				//Delete friendrequest if already exists
				$deleteSentRequest = $friendsModel -> deleteSentRequest( $fromid , $id );
			
				//Create friend request
				$addfriend = $friendsModel -> addFriend( $id , $fromid , $msg , $status );
				
				//trigger for onFriendRequest, only if status = 0
				
				if( $status == 0 ){
				
					require_once(JPATH_ROOT .'/components/com_community/controllers/controller.php');
					require_once(JPATH_ROOT .'/components/com_community/controllers/friends.php');
				
					$eventObject = new stdClass();
					$eventObject->profileOwnerId 	= $fromid;
					$eventObject->friendId 			= $id;
				
					CommunityFriendsController::triggerFriendEvents( 'onFriendRequest' , $eventObject);
				
					unset($eventObject);
					
				}
				
				//If $status = 1 , then also confirm the friend request automatically
				if( $status == 1 ){
				
					//Get the recently created connection_id
					
					 $db = JFactory::getDbo();
					
					 $query = 'SELECT '. $db->quoteName('connection_id')
					 .' FROM '. $db->quoteName('#__community_connection')
					 .' WHERE '. $db->quoteName('connect_from').'='.$db->Quote($fromid)
					 .' AND '. $db->quoteName('connect_to').'='.$db->Quote($id);

					 $db->setQuery($query);
					 $row = $db->loadObject();
					 
					 if($row->connection_id)
						$connection_id = $row->connection_id ;
						
						
					// //Approve the request
					if($connection_id){
						
						$approveRequest = $friendsModel->approveRequest( $connection_id );
					
						//trigger for onFriendApprove
						$eventObject = new stdClass();
						$eventObject->profileOwnerId 	= $fromid;
						$eventObject->friendId 			= $id;
						$CommunityFriendsController->triggerFriendEvents( 'onFriendApprove' , $eventObject);
						unset($eventObject);
					}
				}
			}
		}
	}
	
}