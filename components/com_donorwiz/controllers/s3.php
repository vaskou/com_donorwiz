<?php

// No direct access
defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

class DonorwizControllerS3 extends DonorwizController {

    public function upload() {
		
		$DonorwizS3 = new DonorwizS3();
		$DonorwizS3->upload();
		jexit();
		
	}
	
	public function delete() {
		
		$DonorwizS3 = new DonorwizS3();
		$DonorwizS3->delete();
		jexit();
		
	}
}