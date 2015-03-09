<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class DonorwizViewError extends JViewLegacy {



    /**
     * Display the view
     */
    public function display($tpl = null) {

        $this->_prepareDocument();

        parent::display($tpl);
    }

    /**
     * Prepares the document
     */
    protected function _prepareDocument() {
  
    }

}
