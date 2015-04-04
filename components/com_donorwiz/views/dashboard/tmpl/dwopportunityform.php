<?php

defined('_JEXEC') or die;

echo JLayoutHelper::render( 
	'dashboard.layouts.dwopportunityform', 
	array (), 
	JPATH_ROOT .'/components/com_donorwiz/layouts', 
	null 
);
?>