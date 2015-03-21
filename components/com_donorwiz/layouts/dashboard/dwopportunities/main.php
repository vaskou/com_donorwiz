<?php 

$app = JFactory::getApplication();

$component = 'com_dw_opportunities';
$component_path = JPATH_ROOT.'/components/'.$component;

// Get/configure the users controller
if (!class_exists('Dw_opportunitiesController')) 
	require($component_path.'/controller.php');

$config['base_path'] = $component_path;
$controller = new Dw_opportunitiesController($config);

// Get the view and add the correct template path
$view =& $controller->getView('dwopportunities', 'html');
$view->addTemplatePath($component_path.'/views/dwopportunities/tmpl');

// Set which view to display and add appropriate paths
$jinput = JFactory::getApplication()->input;
$jinput->set('view', 'dwopportunities');

if ( $app -> getUserState ('com_donorwiz.dashboard.isBeneficiary.opportunities') ){

	$jinputFilterBefore = ( is_array( $jinput->get('filter','','array') ) ) ?  $jinput->get('filter','','array')  : array() ;
	$jinput->set('filter', array_replace_recursive( $jinputFilterBefore , array ( 'created_by' =>  JFactory::getUser()->id) )   );

}

if ( !$app -> getUserState ('com_donorwiz.dashboard.isBeneficiary.opportunities') ){
	$jinput->set( 'filter' , array ( 'responders_id' => JFactory::getUser()->id ) );
}

$jinput->set('dashboard', 'true');


JForm::addFormPath($component_path.'/models/forms');
JForm::addFieldPath($component_path.'/models/fields');



JFactory::getLanguage()->load($component, JPATH_SITE);

// And finally render the view!
$controller->display( );

?>




