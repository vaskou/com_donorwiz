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
		JFactory::getLanguage()->load('com_donorwiz');
		//Load the Google Maps JS API Library
		$DonorwizGooglemaps = new DonorwizGooglemaps();
		$DonorwizGooglemaps ->loadGoogleMapsApi();
		
		$doc = JFactory::getDocument();
		$doc->addScript( JUri::base() . 'components/com_donorwiz/models/fields/addressautocomplete/js/addressautocomplete.js');
		
		$html = array();
		
		$app = JFactory::getApplication();

		$jinput = $app -> input;
		$jinputFilter = $app->input->get('filter','','array');
		
		if( is_array ( $jinput->get('filter','','array') ) )
		{
			foreach ( $jinput->get('filter','','array')  as $key => $value) 
			{
				$html[] = '<input type="hidden" name="filter['.$key.']" id="nearby_'.$key.'" value="'.$value.'" >';
			}
		}
		
		

		if ( !isset ($jinputFilter['lat']) )
		{
			$html[] = '<input type="hidden" name="filter[lat]" id="nearby_lat" value="'.$jinput->get('lat','0','string').'" >';	
		}

		if ( !isset ($jinputFilter['lng']) )
		{
			$html[] = '<input type="hidden" name="filter[lng]" id="nearby_lng" value="'.$jinput->get('lng','0','string').'" >';	
		}

		if( !$jinput->get('nearby_place','','string')  || $jinput->get('nearby_place','','string')=='' )
		{
			$html[] ='<input class="uk-form-large uk-width-1-1" id="autocomplete" onFocus="geolocate()" type="text" name="nearby_place" value="" placeholder="'.JText::_('COM_DONORWIZ_TYPE_LOCATION_AND_SELECT').'">';
		}
		else
		{	
			$html[] ='<input class="uk-form-large uk-width-1-1" id="autocomplete" onFocus="geolocate()" type="text" name="nearby_place" value="'.$jinput->get('nearby_place','','string').'" placeholder="'.JText::_('COM_DONORWIZ_TYPE_LOCATION_AND_SELECT').'">';
		}
	

		$script[] = 'var JText_COM_DONORWIZ_TYPE_LOCATION_AND_SELECT = "'.JText::_('COM_DONORWIZ_TYPE_LOCATION_AND_SELECT').'"';
		
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		
		return implode($html);

	}
}