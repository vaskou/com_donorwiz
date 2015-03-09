<?php

// no direct access
defined('_JEXEC') or die;

JFactory::getLanguage()->load('com_slogin');

$return = base64_encode(JFactory::getURI()->toString());

if( JFactory::getApplication()->input->get('return', '', 'BASE64') ){
	JSession::checkToken( 'get' ) or die( 'Invalid Token' );
	$return = JFactory::getApplication()->input->get('return', '', 'BASE64');
	
}

$buttonText = ( isset ( $displayData['buttonText'] ) ) ? $displayData['buttonText'] : JText::_('COM_DONORWIZ_LOGIN_WITH_UPPERCASE') ;


$user = JFactory::getUser();

$input = new JInput;

$callbackUrl = '&return=' . $return;

$dispatcher	= JDispatcher::getInstance();
JPluginHelper::importPlugin('slogin_auth');

$plugins = array();

$dispatcher->trigger('onCreateSloginLink', array(&$plugins, $callbackUrl));
// $profileLink = $avatar = '';

// if(JPluginHelper::isEnabled('slogin_integration', 'profile') && $user->id > 0){
        // require_once JPATH_BASE.'/plugins/slogin_integration/profile/helper.php';
        // $profile = plgProfileHelper::getProfile($user->id);
        // $avatar = isset($profile->avatar) ? $profile->avatar : '';
        // $profileLink = isset($profile->social_profile_link) ? $profile->social_profile_link : '';
    // }
    // else if(JPluginHelper::isEnabled('slogin_integration', 'slogin_avatar') && $user->id > 0){
        // require_once JPATH_BASE.'/plugins/slogin_integration/slogin_avatar/helper.php';
        // $path = Slogin_avatarHelper::getavatar($user->id);
        // if(!empty($path['photo_src'])){
            // $avatar = $path['photo_src'];
            // if(JString::strpos($avatar, '/') !== 0)
                // $avatar = '/'.$avatar;
        // }
		// $profileLink = isset($path['profile']) ? $path['profile'] : '';
    // }

		

		

?>
	
<div id="slogin-buttons" class="slogin-buttons">


<?php //var_dump($plugins); ?>
<!--
array (size=2)
  0 => 
    array (size=4)
      'link' => string 'index.php?option=com_slogin&task=auth&plugin=facebook&return=aHR0cDovL3llc2ludGVybmV0LmRldi9kb25vcndpei9pbmRleC5waHA/b3B0aW9uPWNvbV9kb25vcndpeiZ2aWV3PWxvZ2luJkl0ZW1pZD0zMTQmbGFuZz1lbA==' (length=185)
      'class' => string 'facebookslogin' (length=14)
      'plugin_name' => string 'facebook' (length=8)
      'plugin_title' => string 'Facebook' (length=8)
  1 => 
    array (size=4)
      'link' => string 'index.php?option=com_slogin&task=auth&plugin=google&return=aHR0cDovL3llc2ludGVybmV0LmRldi9kb25vcndpei9pbmRleC5waHA/b3B0aW9uPWNvbV9kb25vcndpeiZ2aWV3PWxvZ2luJkl0ZW1pZD0zMTQmbGFuZz1lbA==' (length=183)
      'class' => string 'googleslogin' (length=12)
      'plugin_name' => string 'google' (length=6)
      'plugin_title' => string 'Google' (length=6)
	  
-->	  
    <?php if (count($plugins)): ?>
    <?php
        foreach($plugins as $link):
            $linkParams = '';
            if(isset($link['params'])){
                foreach($link['params'] as $k => $v){
                    $linkParams .= ' ' . $k . '="' . $v . '"';
                }
            }
			$title = (!empty($link['plugin_title'])) ? ' title="'.$link['plugin_title'].'"' : '';
            ?>
            <a class="uk-button uk-button-large uk-width-1-1 uk-margin-small <?php echo $link['class'];?>" rel="nofollow" target="_blank" <?php echo $linkParams.$title;?> href="<?php echo JRoute::_($link['link']);?>">
				<i 
				class="uk-margin-small-right
				<?php echo ' uk-icon-'.$link['plugin_name'];?>
				"
				>
				</i>
				<?php echo $buttonText.' '.JText::_($link['plugin_title']);?>
			</a>
        <?php endforeach; ?>
    <?php endif; ?>
	
	<div class="uk-text-muted uk-text-center"><?php echo JText::_('COM_DONORWIZ_SOCIAL_LOGIN_PRIVACY'); ?></div>
	

</div>