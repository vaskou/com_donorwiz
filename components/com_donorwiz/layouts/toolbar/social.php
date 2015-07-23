<?php
$doc =& JFactory::getDocument();

$url=( isset($displayData['url']) ) ? $displayData['url'] : JUri::getInstance()->toString();
$redirect_uri=( isset($displayData['redirect_uri']) ) ? $displayData['redirect_uri'] : JUri::getInstance()->toString();
$title=( isset($displayData['title']) ) ? $displayData['title'] : $doc->title;


$fb_link = "https://www.facebook.com/dialog/share?";
$fb_link .= "app_id=1519342301673374";
$fb_link .= "&display=popup";
$fb_link .= "&href=".$url;
$fb_link .= "&redirect_uri=".$redirect_uri;

echo '<div class="dw-social">';
echo '	<a href="'.$fb_link.'" class="uk-button uk-button-primary"><i class="uk-icon-facebook"></i> Share</a>';


$tweet_link = "https://twitter.com/intent/tweet?";
$tweet_link .= "text=".urlencode($title);
$tweet_link .= "&url=".urlencode($url);

$doc->addScript("//platform.twitter.com/widgets.js","text/javascript",false,true);
echo '	<a href="'.$tweet_link.'" class="uk-button uk-button-primary"><i class="uk-icon-twitter"></i> Tweet</a>';

echo '</div>';



?>