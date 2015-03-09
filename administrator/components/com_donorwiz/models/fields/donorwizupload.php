<?php
/**
 * @version     1.0.0
 * @package     com_volunteers
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldDonorwizupload extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'donorwizupload';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	 
	 
	 
	 
	protected function getInput()
	{

		$actionurl= JUri::base().'index.php?option='.$this->getAttribute("actionoption").'&view='.$this->getAttribute("actionview").'&task='.$this->getAttribute("actiontask");
		
		$params=array();
		$_params=explode(',',$this->getAttribute("params"));
		
		foreach ($_params as $key => $param) {
			$_param = explode('=',$param);
			$params[$_param[0]]=intval($_param[1]);
		}
		
		// Include jQuery
		JHtml::_('jquery.framework');
		
		// Build the script.
		$script = array();

		
		$script[] = '		jQuery(function($) {';
		
		$script[] = '		var $ = jQuery.noConflict();';
		
		$script[] = '		var progressbar = $("#progressbar"),';
		
		$script[] = '			bar         = progressbar.find(".uk-progress-bar"),';
		
		$script[] = '			settings    = {';
		$script[] = '				type: "json",';
		$script[] = '				action: "'.$actionurl.'",';
		$script[] = '				allow : "'.$this->getAttribute("allow").'",';
		$script[] = '				param : "'.$this->getAttribute("param").'",';

		//$script[] = '				params : '.json_encode($params).',';
		$script[] = '				params : "",';
			
		$script[] = '				loadstart: function() {';
		$script[] = '					bar.css("width", "0%").text("0%");';
		$script[] = '					progressbar.removeClass("uk-hidden");';
		$script[] = '				},';
				
		$script[] = '				progress: function(percent) {';
		$script[] = '					percent = Math.ceil(percent);';
		$script[] = '					bar.css("width", percent+"%").text(percent+"%");';
		$script[] = '				},';
			
		$script[] = '				allcomplete: function(response, xhr) {';
		
		$script[] = '					console.log(response);';
		$script[] = '					bar.css("width", "100%").text("100%");';
		$script[] = '					setTimeout(function(){';
		$script[] = '						progressbar.addClass("uk-hidden");';
		$script[] = '					}, 250);';
		
		$script[] = '					if(!response) alert("The file is too big.");';
		$script[] = '					var info = response.info;';
		$script[] = '					$("#jform_'.$this->getAttribute("name").'").val(info);';
		$script[] = '					$("#upload-thumbnail img").attr("src",info);';

		$script[] = '				},';
			
		$script[] = '				error: function(event){';
		$script[] = '					$.UIkit.notify( "<i class=uk-icon-warning></i>'.$this->getAttribute("message_file_upload_error").'", { timeout:5000} );';
		$script[] = '					console.log(event);';
		$script[] = '				},';
		$script[] = '				notallowed: function(file, settings){';
		
		
		
		$script[] = '					$.UIkit.notify( "<i class=uk-icon-warning></i>'.$this->getAttribute("message_file_not_allowed").'", { timeout:5000} );';
		$script[] = '					console.log(file);';
		$script[] = '					console.log(settings);';
		$script[] = '				}';
		$script[] = '			};';

		$script[] = '		var select = $.UIkit.uploadSelect($("#upload-select"), settings),';
		
		$script[] = '		drop   = $.UIkit.uploadDrop($("#upload-drop"), settings);';
		
		$script[] = '		});';

	
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		
		// Initialize variables.
		$html = array();
		
		$html[] = '<div id="upload-drop" class="uk-placeholder uk-text-center">';
		$html[] = '<input type="hidden" name="jform['.$this->getAttribute("name").']" id="jform_'.$this->getAttribute("name").'" value="'. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') .'">';
		$html[] = '<span id="upload-thumbnail" class="uk-thumbnail uk-thumbnail-mini uk-width" style="width:64px;margin-right:20px;"><img src="'. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') .'"></span><i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-margin-small-right"></i> Drag & frop your image or <a class="uk-form-file">select one from your Computer. <input id="upload-select" type="file"></a>.';
		$html[] = '</div>';
		$html[] = '<div id="progressbar" class="uk-progress uk-hidden">';
		$html[] = '<div class="uk-progress-bar" style="width: 0%;">0%</div>';
		$html[] = '</div>';
				
		return implode($html);
	}
}