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
class JFormFieldUikittimepicker extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'uikitimepicker';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	 
	protected function getInput()
	{
		// Initialize variables.
		$html = array();
		
		$value = $this->value;
		
		$_value  = ( $value == '00:00:00' || $value == '' ) ? '' : $value ;
		$date_pretty = ( $value == '00:00:00' || $value == '' ) ? '' : $value ;
		$checked = ( $value == '00:00:00'  || $value == '' ) ? '' : 'checked="checked"' ;
		$disabled = ( $value == '00:00:00' || $value == '' ) ? 'disabled="disabled"' : '' ;
		
		$html[] = '<input type="checkbox" id="use_'.$this->getAttribute("name").'" '.$checked.'> ';
		
		$html[] = '<div class="uk-form-icon">';
		$html[] = '<i class="uk-icon-clock-o"></i>';
		$html[] = '<input class="uk-icon-clock-o" type="text" id="timepicker_'.$this->getAttribute("name").'" value="'. substr($_value, 0, -3) .'" name="jform['.$this->getAttribute("name").']" size="5" maxlength="5" data-uk-timepicker>';
		$html[] = '</div>';
	
		// Build the script.
		$script = array();

		
		$script[] = '	jQuery(function($) {';
		
		$script[] = '		var $ = jQuery.noConflict();';
		
		$script[] = '		var timeinput = $("#timepicker_'.$this->getAttribute("name").'");';
		$script[] = '		var timepicker = $.UIkit.timepicker($("#timepicker_'.$this->getAttribute("name").'"), { format:"24h" });';
		
		
		$script[] = '		var use_checkbox = $("#use_'.$this->getAttribute("name").'"); ';
		
		$script[] = '		use_checkbox.click(function() {';
		
		//$script[] = '			timeinput.attr("disabled", !$(this).attr("checked"));';
		
		$script[] = '			if (!$(this).attr("checked")){';
		$script[] = '				timeinput.val("");';
		$script[] = '			}';
		
		$script[] = '		});';		
		
		$script[] = '	});';
		
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
					
		
		return implode($html);
	}
}