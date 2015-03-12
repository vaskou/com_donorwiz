<?php

defined('_JEXEC') or die;

$url = $displayData['src'];
preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
$id = $matches[1];
$width = '800';
$height = '450';

?>

<?php if($id) :?>

<iframe 
	id="ytplayer" 
	class="uk-responsive-width" 
	type="text/html" 
	width="<?php echo $width; ?>" 
	height="<?php echo $height; ?>"
    src="https://www.youtube.com/embed/<?php echo $id ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
    frameborder="0" 
	allowfullscreen
	>
</iframe> 
	

	
<?php endif;?>