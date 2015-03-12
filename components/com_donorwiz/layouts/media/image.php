<?php

defined('_JEXEC') or die;

$src =  ( $displayData['src'] ) ? $displayData['src'] : '' ;
$alt =  ( $displayData['alt'] ) ? $displayData['alt'] : '' ;
$title =  ( $displayData['title'] ) ? $displayData['title'] : '' ;
$class = ( $displayData['class'] ) ? 'class="'.$displayData['class'].'"' : '' ;
	
?>
<?php if ($src):?>
<img <?php echo $class;?> src="<?php echo $src;?>" alt="<?php echo $src;?>" title="<?php echo $title;?>">
<?php endif;?>