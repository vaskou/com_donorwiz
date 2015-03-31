<?php
/**
 * @package     Joomla.Platform
 * @subpackage  User
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.application.component.helper');

class DonorwizVideo {
	
	public function getYouTubeVideoID($url){
		
		if($url){
			
			preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
			
			if( isset ($matches[1]) ){
				
				return $matches[1];
			
			}
			
		}
		
		return false;
		
	}
	public function getYouTubeVideoHTML($url)
	{
		if($url){
			$html = array();
			
			preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
			
			if( isset ($matches[1]) ){
				$id = $matches[1];
				$width = '800px';
				$height = '450px';
			
				$html[] = '<iframe id="ytplayer" type="text/html" width="'.$width.'" height="'.$height.'"';
				$html[] = 'src="https://www.youtube.com/embed/'.$id.'?rel=0&showinfo=0&color=white&iv_load_policy=3"';
				$html[] = 'frameborder="0" allowfullscreen></iframe> ';
				
				return implode($html);
			}
		}
		
		return false;
	
	}
	
	public function getYouTubeVideoHTMLForArticles($url)
	{
		if($url){
			$html = array();
			
			preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
			
			if( isset ($matches[1]) ){
				$id = $matches[1];
				$width = '800px';
				$height = '450px';
				
				$html[] = '<div style="position:relative;padding-bottom:56.25%;padding-top:25px;height:0;">';
				$html[] = '<iframe id="ytplayer" type="text/html" width="'.$width.'" height="'.$height.'" style="position:absolute;top:0;left:0;width:100%;height:100%;" ';
				$html[] = 'src="https://www.youtube.com/embed/'.$id.'?rel=0&showinfo=0&color=white&iv_load_policy=3" ';
				$html[] = 'frameborder="0" allowfullscreen></iframe> ';
				$html[] = '</div>';
				
				return implode($html);
			}
		}
		
		return false;
	
	}
	
}