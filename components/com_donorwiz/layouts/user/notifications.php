<?php

defined('_JEXEC') or die('Restricted access');

require_once ( JPATH_BASE.'/modules/mod_notify/helper.php');
require_once( JPATH_BASE .'/components/com_community/libraries/core.php');
CWindow::load();

$document = JFactory::getDocument();
// $document->addStyleSheet(JURI::root(true).'/components/com_community/assets/modules/module.css');
// $document->addStyleSheet(JURI::root(true).'/modules/mod_notify/style.css');
$config	= CFactory::getConfig();
$my		= CFactory::getUser();
$js		= 'assets/script-1.2.min.js';
CFactory::attach($js, 'js');


if( $my->isOnline() && $my->id != 0 )
{
	$inboxModel			= CFactory::getModel('inbox');
	$notifModel = CFactory::getModel('notification');
	$filter				= array();
	$filter['user_id']	= $my->id;
	$friendModel		= CFactory::getModel ( 'friends' );
	$profileid 			= JRequest::getVar('userid' , 0 , 'GET');

	//CFactory::load( 'libraries' , 'toolbar' );
	$toolbar = CToolbarLibrary::getInstance();
	$newMessageCount		= $toolbar->getTotalNotifications( 'inbox' );
	$newEventInviteCount	= $toolbar->getTotalNotifications( 'events' );
	$newFriendInviteCount	= $toolbar->getTotalNotifications( 'friends' );
	$newGroupInviteCount	= $toolbar->getTotalNotifications( 'groups' );

	$myParams			=	$my->getParams();
	$newNotificationCount	= $notifModel->getNotificationCount($my->id,'0',$myParams->get('lastnotificationlist',''));
	$newEventInviteCount	= $newEventInviteCount + $newNotificationCount;

	//CFactory::load( 'helpers' , 'string');

	$config	= CFactory::getConfig();
	$uri	= CRoute::_('index.php?option=com_community' , false );
	$uri	= base64_encode($uri);

	//CFactory::load('helpers' , 'string' );

	$show_global_notification 	= 1;
	$show_friend_request 	= 0;
	$enable_private_message 	= 1;

?>


		<?php if($show_global_notification ) : ?>
			<a href="javascript:joms.notifications.showWindow();" class="joms-module-global-notif uk-icon-button uk-icon-globe" title="<?php echo JText::_('COM_COMMUNITY_NOTIFICATIONS_GLOBAL');?>" data-uk-tooltip>
			<?php if($newEventInviteCount ) : ?>
			<span class="uk-badge uk-badge-notification" style="position:absolute"><?php echo $newEventInviteCount ;?></span>
			<?php endif; ?>
			</a>

			
		<?php endif; ?>
		<?php if($show_friend_request ) : ?>
		<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&task=pending');?>" onclick="joms.notifications.showRequest();return false;" class="joms-module-friend-invite-notif" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_INVITE_FRIENDS' );?>" data-uk-tooltip>
			<i class="uk-icon-users"></i>
			<span class="notifcount"><?php echo ($newFriendInviteCount) ? $newFriendInviteCount : '' ;?></span>
		</a>
		<?php endif; ?>
		
		<?php if($enable_private_message ) : ?>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=inbox');?>" class="joms-module-new-message-notif uk-icon-button uk-icon-envelope-o" onclick="joms.notifications.showInbox();return false;" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_INBOX' );?>" data-uk-tooltip>
			
			<?php if($newMessageCount ) : ?>
			<div class="uk-badge uk-badge-notification" style="position:absolute"><?php echo $newMessageCount ;?></div>
			<?php endif; ?>
			</a>
		<?php endif; ?>

<?php
	}
?>