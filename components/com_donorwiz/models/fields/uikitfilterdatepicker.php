<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldUikitfilterdatepicker extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'uikitfilterdatepicker';

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
		
		$jinput = JFactory::getApplication()->input;
		$input_filters=$jinput->get('filter','','ARRAY');
		
		$name=$this->getAttribute("name");
		
		$value = (isset($input_filters[$this->getAttribute("filter")]))?$input_filters[$this->getAttribute("filter")]:'';
		
		$date = JFactory::getDate($value);
		
		$date_value  = ( $value == '0000-00-00' || $value == '' ) ? '' : $date -> format('Y-m-d') ;
		$date_pretty = ( $value == '0000-00-00' || $value == '' ) ? '' : $date -> format('d-m-Y') ;
		
		$html[] = '<input type="hidden" id="datepicker_'.$name.'" value="'.$date_value.'" name="filter['.$this->getAttribute("filter").']">';
		
		$html[] = '<div class="uk-form-icon">';
		$html[] = '	<i class="uk-icon-calendar"></i>';
		$html[] = '	<input type="text" id="datepicker_pretty_'.$name.'" value="'.$date_pretty.'"  class="uk-form-large" data-uk-datepicker>';
		$html[] = '</div>';
	
		// Build the script.
		$script = array();
		
		$script[] = '	jQuery(function($) {';
		
		$script[] = '		var $ = jQuery.noConflict();';
		
		$script[] = '		var dateinput = $("#datepicker_'.$name.'");';
		$script[] = '		var dateinput_pretty = $("#datepicker_pretty_'.$this->getAttribute("name").'");';
		
		
				
		$script[] = '		var datepicker = $.UIkit.datepicker( dateinput_pretty , { format:"DD-MM-YYYY", offsettop:0 });';
		
		$script[] = '		dateinput_pretty.change(function() {';
		
		$script[] = '			var filter_date=$(this).val().split("-").reverse().join("-");';
		$script[] = '			dateinput.val( filter_date );';
		
		$script[] = '		});';

		$script[] = '	});';
		
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		
		return implode($html);
	}
}