<?php

defined('JPATH_PLATFORM') or die;

class DonorwizSocial {
	
	public function setSocialTags( $tags )
	{
		$document = JFactory::getDocument();
		
		//General parameters
		$fb_tags['og:url'] = $twt_tags['twitter:url'] = ( isset($tags['url']) ) ? $tags['url'] : JFactory::getURI()->toString();
		$fb_tags['og:title'] = $twt_tags['twitter:title'] = $tags['title'] ;
		$fb_tags['og:description'] = $twt_tags['twitter:description'] = $tags['description'];
		$fb_tags['og:image'] = $twt_tags['twitter:image'] = $tags['image'];
		
		//Facebook parameters
		$fb_tags['og:site_name'] = $tags['og_site_name'];
		$fb_tags['fb:app_id'] = $tags['fb_app_id'];
		$fb_tags['og:type'] = $tags['og_type'];
		$fb_tags['og:locale'] = $tags['og_locale'];
		
		//Twitter parameters
		$twt_tags['twitter:card'] = $tags['twt_type'];
		$twt_tags['twitter:site'] = $tags['twt_site'];
		
		foreach($fb_tags as $key=>$tag){
			if(!empty($tag)){
				$document->addCustomTag('<meta property="'.$key.'" content="'.$tag.'">');
			}
		}
		
		foreach($twt_tags as $key=>$tag){
			if(!empty($tag)){
				$document->setMetaData($key,$tag);
			}
		}
	}

}