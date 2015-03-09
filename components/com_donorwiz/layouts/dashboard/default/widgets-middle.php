<div class="uk-grid" data-uk-grid-margin="">
	
	<div class="uk-width-large-1-2 uk-width-medium-1-1">
		<?php echo JLayoutHelper::render( 
			'chart_donations',
			array(), 
			JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard/widgets',
			null 
		); ?>
	</div>

	<div class="uk-width-large-1-2 uk-width-medium-1-1">
		<?php echo JLayoutHelper::render( 
			'map_volunteering_opportunities',
			array(), 
			JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard/widgets',
			null 
		); ?>

	</div>


	
	
</div>