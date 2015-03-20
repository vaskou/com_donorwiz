<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class DonorwizViewDashboard extends JViewLegacy {

	protected $opportunities;
	protected $pagination;
	
	protected $form;
	protected $item;
	

    /**
     * Display the view
     */
    public function display($tpl = null) {
		
		
		$app = JFactory::getApplication();
		
		$donorwizUser = new DonorwizUser( JFactory::getUser() -> id );
		
		$isBeneficiaryVolunteers = $donorwizUser -> isBeneficiary('com_dw_opportunities');
		
		$app -> setUserState ('com_donorwiz.dashboard.isBeneficiary.opportunities', $isBeneficiaryVolunteers);
		
		if ( $this->_layout == 'dwopportunities' )
		{

			//if( !$isBeneficiaryVolunteers )
				//JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_donorwiz&view=dashboard', false));

		} 
		
		if ( $this->_layout == 'volunteerins' )
		{
			
		if( !$isBeneficiaryVolunteers )
				JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_donorwiz&view=dashboard', false));

		}
		
		if ( $this->_layout == 'volunteers_responses' )
		{

	
		} 
		
		if ( $this->_layout == 'dwopportunityform' )
		{
			JFactory::getLanguage()->load('com_dw_opportunities');
			
			$formData = $this->_getDwOpportunityFormData( JFactory::getApplication()->input->get('id', 0, 'int') );
			
			$this -> form = $formData['form'];
			$this -> item = $formData['item'];
		}

		
        $this->_prepareDocument();

        parent::display($tpl);
    }

    /**
     * Prepares the document
     */
    protected function _prepareDocument() {
  
    }
	
	protected function _getVolunteeringOppotunities() {
		
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_volunteers/models', 'VolunteersModel');
		
		$opportunitiesModel = JModelLegacy::getInstance('Opportunitieslist', 'VolunteersModel', array('ignore_request' => true));	
		
		$opportunitiesModel->setState('filter.created_by', JFactory::getUser()->id);
		
		$opportunities = $opportunitiesModel -> getItems();
		
		return $opportunities;
		
    }
	
	protected function _getVolunteeringOppotunitiesPagination() {
		
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_volunteers/models', 'VolunteersModel');
		
		$opportunitiesModel = JModelLegacy::getInstance('Opportunitieslist', 'VolunteersModel', array('ignore_request' => true));	
		
		$opportunitiesModel->setState('filter.created_by', JFactory::getUser()->id);
		
		$opportunities = $opportunitiesModel -> getItems();
		
		return $opportunitiesModel->pagination;
		
    }
	
	protected function _getDwOpportunityFormData( $id = null ) {
		
		//$item = null;
		
		$form = new JForm( 'com_dw_opportunities.opportunity.form' , array( 'control' => 'jform', 'load_data' => true ) );
		$form->loadFile( JPATH_ROOT . '/components/com_dw_opportunities/models/forms/dwopportunityform.xml' );

		//if($id)
		//{
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities/models', 'Dw_opportunitiesModel');
		$opportunityModel = JModelLegacy::getInstance('DwOpportunity', 'Dw_opportunitiesModel', array('ignore_request' => true));
		$item = $opportunityModel -> getData($id);
		$form->bind( $item );
		//}
		
		return array( 'form' => $form , 'item' => $item ) ;
		
		
	}
	
	// protected function _getVolunteeringOpportunityItem( $id =null ) {
		
		// JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_volunteers/models', 'VolunteersModel');
		
		// $opportunityModel = JModelLegacy::getInstance('Opportunityitem', 'VolunteersModel', array('ignore_request' => true));
		
		// $item = $opportunityModel -> getData($id);
		
		// return $item;
	// }

}
