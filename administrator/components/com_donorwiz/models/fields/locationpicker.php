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
class JFormFieldLocationpicker extends DonorwizFormJformfield
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'locationpicker';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	 
	protected function getInput()
	{
		$form = $this -> getForm();
		$class        = !empty($this->class) ? ' class="' . $this->class . '"' : '';
		
		
		JHtml::_('jquery.framework');
		$doc = JFactory::getDocument();
		$doc->addScript('http://maps.google.com/maps/api/js?sensor=false&libraries=places');
		$doc->addScript(JUri::base() . 'administrator/components/com_donorwiz/models/fields/locationpicker/locationpicker.jquery.js');
				
		// Build the script.
		$script = array();
		$script[] = '		jQuery(function($) {';
		$script[] = '			var $ = jQuery.noConflict();';
		$script[] = '			$(document).ready(function () {';
		$script[] = '				$("#'.$this->getAttribute("id").'").locationpicker({';
		$script[] = '					location: {latitude: $("#'.$this->getAttribute("latname").'_elm").val() , longitude: $("#'.$this->getAttribute("lngname").'_elm").val()},';
		$script[] = '					radius: '.$this->getAttribute("radius").',';
		$script[] = '					enableAutocomplete: true,';
		$script[] = '					inputBinding: {';
		$script[] = '						latitudeInput: $("#'.$this->getAttribute("latname").'_elm"),';
		$script[] = '						longitudeInput: $("#'.$this->getAttribute("lngname").'_elm"),';
		$script[] = '						radiusInput: $("#'.$this->getAttribute("radiusname").'_elm"),';
		$script[] = '						locationNameInput: $("#'.$this->getAttribute("name").'_elm")';
		$script[] = '					}';
		$script[] = '				});';
		$script[] = '			});';
		$script[] = '		});';
		
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		// Initialize variables.
		$html = array();
		
		$html[] = '<input type="text" name="jform['.$this->getAttribute("name").']" id="'.$this->getAttribute("name").'_elm" placeholder="" value="'.$this->value.'" '.$class.' style="width: 335px;">';
		$html[] = '<input type="hidden" id="lat_elm" name="jform[lat]" value="'.$form -> getValue('lat').'" />';
		$html[] = '<input type="hidden" id="lng_elm" name="jform[lng]" value="'.$form -> getValue('lng').'" />';
		$html[] = '<div id="'.$this->getAttribute("id").'" class="uk-margin-top" style="width: 335px; height: 335px; display:block;" ></div>';

		return implode($html);
	}

	
}