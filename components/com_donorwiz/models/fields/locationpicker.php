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
		
		$address = $this ->value;
		$lat='';
		$lng='';
		
		if( $form -> getValue('lat') && $form -> getValue('lng') )
		{
			$lat=$form -> getValue('lat');
			$lng=$form -> getValue('lng');
		}
		else
		{
			$user = JFactory::getUser();
			$donorwizuser = new DonorwizUser($user->id);
			$coordinates = $donorwizuser -> getUserCoordinates($user->id);	
			$lat=$coordinates['lat'];
			$lng=$coordinates['lng'];
			$address=$coordinates['address'];
		}
		

		$DonorwizGooglemaps = new DonorwizGooglemaps();
		$DonorwizGooglemaps ->loadGoogleMapsApi();

		JHtml::_('jquery.framework');
		$doc = JFactory::getDocument();
		$doc->addScript(JUri::base() . 'components/com_donorwiz/models/fields/locationpicker/locationpicker.jquery.js');
				
		// Build the script.
		$script = array();
		
		$script[] = '		jQuery(function($) {';
		
		$script[] = '			var $ = jQuery.noConflict();';
		
		$script[] = '			$(document).ready(function () {';
		
		$script[] = '				$("#'.$this->getAttribute("id").'").locationpicker({';
		
		$script[] = '					location: {latitude: '.$lat.' , longitude: '.$lng.'},';
		$script[] = '					radius: '.$this->getAttribute("radius").',';
		$script[] = '					enableAutocomplete: true,';
		$script[] = '					enableReverseGeocode: false,';
		$script[] = '					draggable: false,';
		$script[] = '					scrollwheel: false,';

		$script[] = '					inputBinding: {';
		$script[] = '						latitudeInput: $("#'.$this->getAttribute("latname").'_elm"),';
		$script[] = '						longitudeInput: $("#'.$this->getAttribute("lngname").'_elm"),';
		$script[] = '						radiusInput: $("#'.$this->getAttribute("radiusname").'_elm"),';
		$script[] = '						locationNameInput: $("#'.$this->getAttribute("name").'_elm"),';
		$script[] = '					}';
		
		$script[] = '				});';
		
		$script[] = '				$("#address_elm").blur(function(){';
			
		$script[] = '					$(this).val( $.trim ( $(this).val() ) ) ;';
		
		$script[] = '					if( $(this).val() == "" ){';
		
		$script[] = '						var value = "'. trim ( $address ) .'"; ';
		$script[] = '						$(this).val(value); ';

		
		$script[] = '					};';
		$script[] = '				});';
		
		$script[] = '			});';
		
		$script[] = '		});';
		
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		// Initialize variables.
		$html = array();
		
		$required = ( $form -> getValue('category')=='COM_VOLUNTEERS_LOCAL' ) ? 'required' : '' ;
		
		$html[] = '<input type="text" class="uk-width-1-1" name="jform['.$this->getAttribute("name").']" id="'.$this->getAttribute("name").'_elm" placeholder="" value="'.$address.'" '.$class.' '.$required.'>';
		$html[] = '<p class="uk-article-meta">'.JText::_( $form ->getFieldAttribute( 'address' , 'tooltip'  , '' , '' ) ).'</p>';
		
	
		$html[] = '<input type="hidden" id="lat_elm" name="jform[lat]" value='.$lat.' />';
		$html[] = '<input type="hidden" id="lng_elm" name="jform[lng]" value='.$lng.' />';
		$html[] = '<div id="'.$this->getAttribute("id").'" class="uk-margin-top uk-width-1-1" style="height: 335px; display:block;" ></div>';

		return implode($html);
	}

	
}