<?php

// no direct access
defined('_JEXEC') or die;

?>

<div class="uk-grid" data-uk-grid-margin="">

	<div class="uk-width-1-1 uk-width-medium-3-4">
		
		<div class="uk-grid" data-uk-grid-margin="">
			
			<div class="uk-width-1-1">
			
			
			<?php 

				$component = 'com_dw_opportunities';
				$component_path = JPATH_ROOT.'/components/'.$component;

				// Get/configure the users controller
				if (!class_exists('Dw_opportunitiesController')) 
					require($component_path.'/controller.php');

				$config['base_path'] = $component_path;
				$controller = new Dw_opportunitiesController($config);

				// Get the view and add the correct template path
				$view =& $controller->getView('dwopportunity', 'html');
				$view->addTemplatePath($component_path.'/views/dwopportunity/tmpl');
				$view->setLayout('volunteers');

				// Set which view to display and add appropriate paths
				$jinput = JFactory::getApplication()->input;
				$jinput->set('view', 'dwopportunity');
				$jinput->set('id', JFactory::getApplication()->input->get('id', '', 'int'));
				$jinput->set('dashboard', 'true');



				JForm::addFormPath($component_path.'/models/forms');
				JForm::addFieldPath($component_path.'/models/fields');

				JFactory::getLanguage()->load($component, JPATH_SITE);

				// And finally render the view!
				$controller->display();

				?>

			</div>
		
		</div>
	
	</div>

	<div class="uk-width-1-1 uk-width-medium-1-4">
		<?php echo JLayoutHelper::render( 'dashboard.menu', array () , JPATH_ROOT .'/components/com_donorwiz/layouts/' , null ); ?>
	</div>
	
</div>