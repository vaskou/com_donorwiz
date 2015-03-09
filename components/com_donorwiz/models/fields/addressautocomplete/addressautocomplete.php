<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');


class JFormFieldAddressautocomplete extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'addressautocomplete';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	 
	public function getInput()
	{

		JHtml::_('jquery.framework');
		
		//Load the Google Maps JS API Library
		$DonorwizGooglemaps = new DonorwizGooglemaps();
		$DonorwizGooglemaps ->loadGoogleMapsApi();
		
		$doc = JFactory::getDocument();
		$doc->addScript( JUri::base() . 'components/com_donorwiz/models/fields/addressautocomplete/js/addressautocomplete.js');
		
		$html = array();
		
		$jinput = JFactory::getApplication()->input;
	
		$jinputGET = $jinput->getArray($_GET);
									
		foreach ( $jinputGET as $key => $value) {
		
			$html[] = '<input type="hidden" name="'.$key.'" id="nearby_'.$key.'" value="'.$value.'" >';
			
		}
		
		if( !isset($jinputGET['lat']) )
		{
			$html[] = '<input type="hidden" name="lat" id="nearby_lat" value="0" >';
		}

		if( !isset($jinputGET['lng']) )
		{
			$html[] = '<input type="hidden" name="lng" id="nearby_lng" value="0" >';
		}			
	
		if( !isset($jinputGET['nearby_place']) || $jinputGET['nearby_place']=='' )
		{
			$html[] ='<input class="uk-form-large uk-width-1-1" id="autocomplete" onFocus="geolocate()" type="text" name="nearby_place" value="">';
		}
		else
		{	
			$html[] ='<input class="uk-form-large uk-width-1-1" id="autocomplete" onFocus="geolocate()" type="text" name="nearby_place" value="'.$jinputGET['nearby_place'].'">';
		}
	
		return implode($html);
		

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

	}
}