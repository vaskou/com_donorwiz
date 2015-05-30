<div class="uk-panel uk-panel-widget uk-panel-box uk-panel-blank">
    <h2><?php echo JText::_('COM_DONORWIZ_DASHBOARD_WIDGET_ACTIVITYSTREAM_TITLE');?></h2>
    <?php 
    //Joomla Module
    jimport( 'joomla.application.module.helper' );
    $module = JModuleHelper::getModule( 'mod_activitystream');
    $params = "max_entry=5\n\rmoduleclass_sfx=dashboard_widget_activity_stream"; //This is the way of passing params values
    $module->params = $params;
    $attribs['style'] = 'xhtml';
    echo JModuleHelper::renderModule( $module, $attribs );
    ?>
        
</div>