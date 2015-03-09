<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');


class JFormFieldNearbydistance extends JFormField
{

	protected $type = 'nearbydistance';

	public function getInput()
	{

		JHtml::_('jquery.framework');
		
		$html = array();
		
		$jinputGET = JFactory::getApplication()->input->getArray($_GET);
		
		$distance = ( !isset($jinputGET['distance'] ) ) ? '25' : $jinputGET['distance'] ; 
		
		$html[] = '	<select class="uk-form-large uk-width-1-1" name="distance">';
        $html[] = '		<option value="25"'.( $distance == "25"  ? ' selected' : '').'>25 χλμ</option>';
        $html[] = '		<option value="50"'.( $distance == "50"  ? ' selected' : '').'>50 χλμ</option>';
        $html[] = '		<option value="100"'.( $distance == "100"  ? ' selected' : '').'>100 χλμ</option>';
        $html[] = '		<option value="200"'.( $distance == "200"  ? ' selected' : '').'>200 χλμ</option>';
        $html[] = '	</select>';
		
		return implode($html);
		
	}
}