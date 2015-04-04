<div class="uk-grid" data-uk-grid-margin="">
	
	<div class="uk-width-large-1-3 uk-width-medium-1-1">
		<?php echo JLayoutHelper::render( 
			'total_donations',
			array(), 
			JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard/widgets',
			null 
		); ?>
	</div>

	<div class="uk-width-large-1-3 uk-width-medium-1-1">

		<?php echo JLayoutHelper::render( 
			'total_volunteering_opportunities',
			array(), 
			JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard/widgets',
			null 
		); ?>

	</div>

	<div class="uk-width-large-1-3 uk-width-medium-1-1">
		<?php echo JLayoutHelper::render( 
			'total_supporters',
			array(), 
			JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard/widgets',
			null 
		); ?>
	</div>
	
</div>