<div class="uk-panel uk-panel-widget uk-panel-box uk-panel-blank">

    <?php 
    //Joomla Module
    jimport( 'joomla.application.module.helper' );
    $module = JModuleHelper::getModule( 'mod_activitystream' , 'DashboardWidgetActivityStream');
    $params = "max_entry=5\n\rparam2=chris"; //This is the way of passing params values
    $module->params = $params;
    $attribs['style'] = 'xhtml';
    echo JModuleHelper::renderModule( $module, $attribs );
    ?>
        
</div>