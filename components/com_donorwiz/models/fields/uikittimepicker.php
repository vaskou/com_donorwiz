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
		$checked = ( $value == '00:00:00'  || $value == '' ) ? '' : 'checked="checked"' ;
		$disabled = ( $value == '00:00:00' || $value == '' ) ? 'disabled="disabled"' : '' ;
		
		$dateelement_value = $this->form->getValue($this->getAttribute("datelement"));

		$use_time_disabled = ( $dateelement_value == '0000-00-00' || $dateelement_value == '' ) ? 'disabled="disabled"' : '' ;
		
		$html[] = '<input type="hidden" id="timepicker_'.$this->getAttribute("name").'" value="'.$_value.'" name="jform['.$this->getAttribute("name").']">';
		$html[] = '<input type="checkbox" id="use_'.$this->getAttribute("name").'" '.$checked.' '.$use_time_disabled .'> ';
		
		$html[] = '<div class="uk-form-icon">';
		$html[] = '<i class="uk-icon-clock-o" style="z-index:100"></i>';
		$html[] = '<input class="uk-icon-clock-o" style="padding-left:30px!important" type="text" id="timepicker_pretty_'.$this->getAttribute("name").'" value="'. substr($_value, 0, -3) .'" name="jform['.$this->getAttribute("name").']" '.$disabled.'  size="5" maxlength="5" data-uk-timepicker>';
		$html[] = '</div>';
	
		// Build the script.
		$script = array();

		
		$script[] = '	jQuery(function($) {';
		
		$script[] = '		var $ = jQuery.noConflict();';
		
		$script[] = '		var timeinput = $("#timepicker_'.$this->getAttribute("name").'");';
		$script[] = '		var timeinput_pretty = $("#timepicker_pretty_'.$this->getAttribute("name").'");';

		$script[] = '		var timepicker = $.UIkit.timepicker($("#timepicker_pretty_'.$this->getAttribute("name").'"), { format:"24h" });';
		
		
		$script[] = '		var use_checkbox = $("#use_'.$this->getAttribute("name").'"); ';
		
		$script[] = '		use_checkbox.click(function() {';
		
		
		$script[] = '			if (!$(this).attr("checked")){';
		$script[] = '				timeinput_pretty.val("");';
		$script[] = '			}';
		
		$script[] = '			timeinput_pretty.attr("disabled", !$(this).attr("checked"));';

		$script[] = '		});';		
		
		$script[] = '	});';
		
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
					
		
		return implode($html);
	}
}