<?php

// no direct access
defined('_JEXEC') or die;

echo JLayoutHelper::render( 'dashboard.layouts.default', array () , JPATH_ROOT .'/components/com_donorwiz/layouts' , null );

?>