<div class="uk-panel uk-panel-widget uk-panel-box uk-panel-blank">
    <h2><?php echo JText::_('COM_DONORWIZ_DASHBOARD_WIDGET_OUR_BLOG_TITLE');?></h2>
    <?php 
    //Joomla Module
    jimport( 'joomla.application.module.helper' );
    $module = JModuleHelper::getModule( 'mod_articles_latest');
    $params = '{"catid":["13"],"count":"10","show_featured":"","ordering":"c_dsc","user_id":"0","layout":"_:default","moduleclass_sfx":"","cache":"0","cache_time":"900","cachemode":"static","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}'; //This is the way of passing params values
    
    $module->params = $params;
    
    $attribs['style'] = 'xhtml';
    echo JModuleHelper::renderModule( $module, $attribs );
    ?>
        
</div>