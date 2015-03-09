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
class JFormFieldUikitdatepicker extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'uikitdatepicker';

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
		
		$date_value  = ( $value == '0000-00-00' || $value == '' ) ? '' : JFactory::getDate($value) ;
		$date_pretty = ( $value == '0000-00-00' || $value == '' ) ? '' : $date_value -> format('d-m-Y') ;
		$checked = ( $value == '0000-00-00'  || $value == '' ) ? '' : 'checked="checked"' ;
		$disabled = ( $value == '0000-00-00' || $value == '' ) ? 'disabled="disabled"' : '' ;
		
		$html[] = '<input type="hidden" id="datepicker_'.$this->getAttribute("name").'" value="'.$date_value.'" name="jform['.$this->getAttribute("name").']">';
		$html[] = '<input type="checkbox" id="use_'.$this->getAttribute("name").'" '.$checked.'> ';
		
		$html[] = '<div class="uk-form-icon">';
		$html[] = '<i class="uk-icon-calendar"></i>';
		$html[] = '<input type="text" id="datepicker_pretty_'.$this->getAttribute("name").'" value="'.$date_pretty.'" '.$disabled.' size="10" maxlength="10" data-uk-datepicker>';
		$html[] = '</div>';
	
		// Build the script.
		$script = array();
		
		$script[] = '	jQuery(function($) {';
		
		$script[] = '		var $ = jQuery.noConflict();';
		
		$script[] = '		var dateinput = $("#datepicker_'.$this->getAttribute("name").'");';
		$script[] = '		var dateinput_pretty = $("#datepicker_pretty_'.$this->getAttribute("name").'");';
		$script[] = '		var datepicker = $.UIkit.datepicker( dateinput_pretty , {format:"DD-MM-YYYY"});';
		
		$script[] = '		dateinput_pretty.change(function() {';
		
		$script[] = '			var date  = new Date( $(this).val().split("-").reverse().join("-") );';
		$script[] = '			var sqldate = date.getFullYear() + "-" + (1+date.getMonth()) + "-" + date.getDate();';
		$script[] = '			dateinput.val( sqldate );';
		
		$script[] = '		});';

		$script[] = '		var use_checkbox = $("#use_'.$this->getAttribute("name").'"); ';
		
		$script[] = '		use_checkbox.click(function() {';
		
		$script[] = '			dateinput_pretty.attr("disabled", !$(this).attr("checked"));';
		
		$script[] = '			if (!$(this).attr("checked")){';
		$script[] = '				dateinput_pretty.val("");';
		$script[] = '				dateinput.val("");';
		$script[] = '			}';
		
		$script[] = '		});';

		
		$script[] = '	});';
		
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		
		return implode($html);
	}
}