<?php
$doc =& JFactory::getDocument();

$hide_button=$displayData['hide_button'];
$hide_tags=$displayData['hide_tags'];
$redirect_uri=( isset($displayData['redirect_uri']) ) ? $displayData['redirect_uri'] : JUri::getInstance()->toString();

$tags['og:url']=( isset($displayData['og_url']) ) ? $displayData['og_url'] : JUri::getInstance()->toString();;
$tags['og:title']=$displayData['og_title'] ;
$tags['og:description']=$displayData['og_description'];
$tags['og:site_name']=$displayData['og_site_name'];
$tags['og:image']=$displayData['og_image'];
$tags['fb:app_id']=$displayData['og_app_id'];
$tags['og:type']=$displayData['og_type'];
$tags['og:locale']=$displayData['og_locale'];

if( $hide_tags !== true ){
	foreach($tags as $key=>$tag){
		if(!empty($tag)){
			$doc->addCustomTag('<meta property="'.$key.'" content="'.$tag.'">');
		}
	}
}

if( $hide_button !== true ){	
	$link = "https://www.facebook.com/dialog/share?";
	$link .= "app_id=1519342301673374";
	$link .= "&display=popup";
	$link .= "&href=".$tags['og:url'];
	$link .= "&redirect_uri=".$redirect_uri;
	
	echo '<div class="dw-social">';
	echo '<a href="'.$link.'" >Share</a>';
	echo '</div>';
}

?>