<?php 
// no direct access
defined('_JEXEC') or die;
?>

<div class="uk-width-1-1 uk-text-center uk-margin" style="overflow:hidden;">
    <?php echo JLayoutHelper::render( 
        'facebook_page',
        array(), 
        JPATH_ROOT .'/components/com_donorwiz/layouts/dashboard/widgets',
        null 
    ); ?>

</div>	

<div class="uk-panel uk-text-center">
<?php echo '© '.JText::_('COM_DONORWIZ_DONORWIZ').' - '.JText::_('COM_DONORWIZ_SOLIDARITY_APPLIED');?>
</div>