<?php 

$jinput = JFactory::getApplication()->input;
$layout = $jinput->get('layout', '', 'string');
$app = JFactory::getApplication();
?>

<div class="uk-panel uk-panel-box uk-panel-dark" data-uk-sticky="{top:76}">

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
		<a class="uk-button uk-button-contrast uk-width-1-1" href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=login&Itemid=314&return='.base64_encode(JFactory::getURI()->toString()).'&'. JSession::getFormToken() .'=1');?>">
		<i class="uk-icon-power-off"></i>
		<?php echo JText::_('COM_DONORWIZ_LOGOUT_UPPERCASE');?>
		</a>
	</div>
	
	
	<ul class="uk-nav uk-nav-side uk-nav-parent-icon uk-margin-top" data-uk-nav="">
		
		<li <?php if ( !$layout ) echo 'class="uk-active"';?>>
			<a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard');?>">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_HOME');?>
			</a>
		</li>

		<li class="uk-nav-divider"></li>
		
		<li class="uk-nav-header"><?php echo JText::_('COM_DONORWIZ_DASHBOARD_DONATIONS');?></li>
		
		<li class="uk-parent">
			<a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=donations');?>">
				<i class="uk-icon-euro"></i>
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_DONATIONS_VIEW');?>
			</a>
		</li>
		
		<li class="uk-nav-divider"></li>
		
		<!-- Volunteers Sub menu ---------------------------------------------------------------------------------------->
		<li class="uk-nav-header"><?php echo JText::_('COM_DONORWIZ_DASHBOARD_VOLUNTEERS');?></li>
		
		<?php if ( $app -> getUserState ('com_donorwiz.dashboard.isBeneficiary.opportunities') ) : ?>
		
		<li <?php if ( $layout == 'dwopportunities' ) echo 'class="uk-active"';?>>
			<a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunities');?>">
				<i class="uk-icon-th-list"></i>
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MY_VOLUNTEERING_OPPORTUNITIES');?>
			</a>
		</li>

		<li <?php if ( $layout == 'dwopportunitiesresponses' ) echo 'class="uk-active"';?>>
			<a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunitiesresponses');?>">
				<i class="uk-icon-users"></i>
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MY_VOLUNTEERS');?>
			</a>
		</li>
		
		<li <?php if ( $layout == 'dwopportunityform' ) echo 'class="uk-active"';?>>
			<a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunityform');?>">
				<i class="uk-icon-plus"></i>
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_VOLUNTEERS_ADD');?>
				
			</a>
		</li>		
		
		<?php endif;?>
		
		<?php if ( !$app -> getUserState ('com_donorwiz.dashboard.isBeneficiary.opportunities') ) : ?>
		
		<li <?php if ( $layout == 'dwopportunitiesresponses' ) echo 'class="uk-active"';?>>
			<a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunitiesresponses');?>">
				<i class="uk-icon-users"></i>
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MY_VOLUNTEERING_OPPORTUNITIES');?>
			</a>
		</li>
		
		<li <?php if ( $layout == 'volunteers_resposnes' ) echo 'class="uk-active"';?>>
			<a href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunities&Itemid=261');?>" target="_blank">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_VOLUNTEERS_ADS');?>
			</a>
		</li>
		
		<?php endif;?>

		
		<li class="uk-nav-divider"></li>
		
		<!------------------------------------------------------------------------------------------------------------------>
		
		<li class="uk-nav-header"><?php echo JText::_('COM_DONORWIZ_DASHBOARD_MYACCOUNT');?></li>
		
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_community&view=profile&Itemid=108');?>">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MYPAGE');?>
			</a>
		</li>

		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_community&view=profile&task=edit&Itemid=111');?>">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MYACCOUNT_EDIT');?>
			</a>
		</li>
		
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_community&view=profile&task=uploadAvatar');?>">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MYACCOUNT_EDIT_PROFILE_AVATAR');?>
			</a>
		</li>
	
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_community&view=profile&task=notifications');?>">
				<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MYACCOUNT_NOTIFICATIONS');?>
			</a>
		</li>
	
	</ul>

</div>