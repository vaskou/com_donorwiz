<?php

// no direct access
defined('_JEXEC') or die;

$user = JFactory::getUser();
$isGuest = $user->get('guest');

?>

<?php if(!$isGuest) :?>

<div class="uk-grid uk-margin-top" data-uk-grid-margin="">

	<div class="uk-width-1-1 uk-width-medium-3-4">
		
			<?php

				$component = 'com_dw_opportunities';
				$component_path = JPATH_ROOT.'/components/'.$component;

				// Get/configure the users controller
				if (!class_exists('Dw_opportunitiesController')) 
					require($component_path.'/controller.php');
				
				$config['base_path'] = $component_path;
				$controller = new Dw_opportunitiesController($config);

				// Get the view and add the correct template path
				$view =& $controller->getView('dwopportunityform', 'html');
				$view->addTemplatePath($component_path.'/views/dwopportunityform/tmpl');

				// Set which view to display and add appropriate paths
				JRequest::setVar('view', 'dwopportunityform');
				JForm::addFormPath($component_path.'/models/forms');
				JForm::addFieldPath($component_path.'/models/fields');

				JFactory::getLanguage()->load($component, JPATH_SITE);

				// And finally render the view!
				$controller->display();

			?> 


			
	
	</div>

	<div class="uk-width-1-1 uk-width-medium-1-4">
		<?php echo JLayoutHelper::render( 'menu-left', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard' , null ); ?>
	</div>
	
</div>
<?php endif;?>


