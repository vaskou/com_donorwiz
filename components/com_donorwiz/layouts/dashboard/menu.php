<?php 
// no direct access
defined('_JEXEC') or die;
?>

<div class="uk-panel uk-panel-box uk-panel-dark uk-animation-slide-top">

	<div class="uk-panel uk-panel-box uk-panel-dark">
	
		<?php 
			include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
			$user = CFactory::getUser();
			$avatarUrl = $user->getThumbAvatar();
			$name = $user->getDisplayName();
		?>
		
		<div class="uk-width-1-1 uk-text-center">
			<img class="uk-thumbnail uk-border-circle" src="<?php echo $avatarUrl;?>" alt="<?php echo $name;?>">
		</div>
		
		<div class="uk-width-1-1 uk-margin-small-top">
			<a class="uk-button uk-button-contrast uk-width-1-1" href="<?php echo JRoute::_('profile');?>">
			<i class="uk-icon-user"></i>
			<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MY_PAGE');?>
			</a>
		</div>

		<div class="uk-width-1-1 uk-margin-small-top uk-text-center">
			<a class="uk-button uk-button-link uk-text-contrast" href="<?php echo JRoute::_('profile/edit-profile');?>" title="<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MYACCOUNT_EDIT');?>" data-uk-tooltip>
				<i class="uk-icon-cog"></i>
			</a>			
			<a class="uk-button uk-button-link uk-text-contrast" href="<?php echo JRoute::_('profile/notifications');?>" title="<?php echo JText::_('COM_DONORWIZ_DASHBOARD_NOTIFICATIONS');?>" data-uk-tooltip>
				<i class="uk-icon-comment"></i>
			</a>
			<a class="uk-button uk-button-link uk-text-contrast" href="<?php echo JRoute::_('profile/message/inbox');?>" title="<?php echo JText::_('COM_DONORWIZ_DASHBOARD_SEND_MESSAGE');?>" data-uk-tooltip>
				<i class="uk-icon-envelope-o"></i>
			</a>
			<a class="uk-button uk-button-link uk-text-contrast" href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=login&Itemid=314&return='.base64_encode(JFactory::getURI()->toString()).'&'. JSession::getFormToken() .'=1');?>" title="<?php echo JText::_('COM_DONORWIZ_LOGOUT_UPPERCASE');?>" data-uk-tooltip>
				<i class="uk-icon-power-off"></i>
			</a>
		</div>
	
	</div>

	<div class="uk-panel ">
	
		<?php 
		//Joomla Module
		jimport( 'joomla.application.module.helper' );
		$module = JModuleHelper::getModule( 'menu', 'Dashboard' );
		$attribs['style'] = 'xhtml';
		echo JModuleHelper::renderModule( $module, $attribs );
		?>
	</div>

</div>