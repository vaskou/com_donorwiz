<?php

$doc =& JFactory::getDocument();
$doc->setMetaData( 'og:url', JUri::getInstance()->toString() );
$doc->setMetaData( 'og:image', $displayData['image'] );
$doc->addCustomTag(
'<meta property="og:image" content="'.$displayData['image'].'">'
);

$link = "https://www.facebook.com/dialog/feed?";
$link .= "app_id=1605759389698331";
$link .= "&display=popup";
$link .= "&caption=An%20example%20caption";
$link .= "&link=".urlencode(JUri::getInstance()->toString());
$link .= "&redirect_uri=".urlencode(JUri::getInstance()->toString());
//$link .= "&picture=".urlencode($displayData['image']);

?>

<div class="dw-social">

<a href="<?php echo $link; ?>" target="_blank">Share</a>

</div>