<?php

defined('_JEXEC') or die;

JFactory::getLanguage()->load('com_donorwiz');

$id = $displayData['beneficiary_id'];

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
$user = CFactory::getUser($id);
$avatarUrl = $user->getThumbAvatar();
$name = $user->getDisplayName();
$link = CRoute::_('index.php?option=com_community&view=profile&userid='.$id);
$about = $user->getInfo('FIELD_ABOUT');

?>

<div class="uk-panel uk-panel-box uk-margin-top" style="background:#ffffff;">
	<h2>
		<a href="<?php echo $link;?>" title="<?php echo JText::_('COM_DONORWIZ_VIEW_PROFILE_PAGE');?>" data-uk-tooltip>
			<img class="uk-border-circle uk-thumbnail" src="<?php echo $avatarUrl;?>">
		</a>
		<span class="uk-text-middle"><?php echo $name;?></span>

	</h2>

	<?php if( $about ) : ?>
	<p><?php echo $about;?></p>
	<?php endif;?>
	
	<p class="uk-text-right">
		<a href="<?php echo $link;?>">
			<?php echo JText::_('COM_DONORWIZ_VIEW_PROFILE_PAGE');?>
		</a>
	</p>
</div>
