<?php 

defined('_JEXEC') or die;

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
include_once JPATH_ROOT.'/components/com_community/libraries/user.php';

$user = CFactory::getUser();

$profileType = $user -> getProfileType() ;

$progressFields = array ( );

if ( $profileType == '1' )
{	
	array_push( $progressFields, 'FIELD_GENDER');
	array_push( $progressFields, 'FIELD_BIRTHDATE');
	array_push( $progressFields, 'FIELD_MOBILE');
	array_push( $progressFields, 'FIELD_SKILLS ');
	array_push( $progressFields, 'FIELD_OBJECTIVE');
	array_push( $progressFields, 'FIELD_ACTIONAREA');
	
	if( $user -> getInfo ('FIELD_INTERESTED_IN_DONATIONS') == '' && $user -> getInfo ('FIELD_INTERESTED_IN_INKINDDONATIONS') == '' && $user -> getInfo ('FIELD_INTERESTED_IN_VOLUNTEERS') == '')
		array_push( $progressFields, 'FIELD_INTERESTED_IN ');
}

if ( $profileType == '2' )
{	
	array_push( $progressFields, 'FIELD_ABOUT');
	array_push( $progressFields, 'FIELD_COMPANYNAME');
	array_push( $progressFields, 'FIELD_ADDRESS');
	array_push( $progressFields, 'FIELD_STATE');
	array_push( $progressFields, 'FIELD_CITY');
	array_push( $progressFields, 'FIELD_PC');
	array_push( $progressFields, 'FIELD_LANDPHONE');
	array_push( $progressFields, 'FIELD_WEBSITE');
	
	if( $user -> getInfo ('FIELD_INTERESTED_IN_DONATIONS') == '' && $user -> getInfo ('FIELD_INTERESTED_IN_INKINDDONATIONS') == '' && $user -> getInfo ('FIELD_INTERESTED_IN_VOLUNTEERS') == '')
		array_push( $progressFields, 'FIELD_INTERESTED_IN ');
	
}

$progressTotal = count ( $progressFields ) ;
$progressCurrent = count ( $progressFields ) ;

foreach ( $progressFields as $key) 
{
    if ( $user -> getInfo($key) == '' && $key != 'FIELD_INTERESTED_IN' )
	{
		$progressCurrent -- ;
	}
}

if ( $progressTotal !=0 )
{
	$progress = intval ( ( $progressCurrent / $progressTotal ) * 100 );
}
else{
	$progress = 0;
}

?>

<?php if ( $progress != 100 ) :?>
<div class="uk-panel uk-margin-bottom">
	<h3 class="uk-margin-remove uk-text-contrast uk-text-center">
		<?php echo JText::_('COM_DONORWIZ_DASHBOARD_COMPLETE_YOUR_PROFILE');?>
	</h3>
	<div class="uk-text-contrast uk-text-center">
		<?php echo JText::_('COM_DONORWIZ_DASHBOARD_COMPLETE_YOUR_PROFILE_DESCR');?>
	</div>
	<div class="uk-progress uk-margin-small-top uk-margin-small-bottom">
		<div class="uk-progress-bar" style="width:<?php echo $progress;?>%;"><?php echo $progress;?>%</div>
	</div>
	<div class="uk-text-contrast uk-text-center">
		<i class="uk-icon-cog"></i>
		<a class="uk-text-contrast" href="<?php echo JRoute::_('profile/edit');?>">
		
		<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MYACCOUNT_EDIT');?>
		</a>
	</div>
</div>
<hr>
<?php endif;?>