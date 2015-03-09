<?php
/**
 * @version     1.0.0
 * @package     com_volunteers
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// no direct access
defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_users/models', 'UsersModel');
$registration_model = JModelLegacy::getInstance('Registration', 'UsersModel', array('ignore_request' => true));
JForm::addFormPath(JPATH_SITE . '/components/com_users' . '/models/forms');
JForm::addFieldPath(JPATH_SITE . '/components/com_users'. '/models/fields');
$form = $registration_model->getForm();

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_users', JPATH_SITE);			

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
?>

<article class="uk-article" style="margin-top:-10px">

<h4><i class="uk-icon-smile-o uk-icon-medium"></i> ΓΙΝΕ ΜΕΛΟΣ</h4>
<p>Κάνε άμεση εγγραφή στο DONORwiz και γίνε μέλος της κοινότητας.</p>


<form id="member-registration" class="uk-form uk-form-horizontal" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">

	<div class="uk-form-row">
		<label class="uk-form-label" for=""><?php echo $form->getLabel('name'); ?></label>
		<div class="uk-form-controls"><?php echo $form->getInput('name'); ?></div>
	</div>	


	<div class="uk-form-row">
		<label class="uk-form-label" for="">Email</label>
		<div class="uk-form-controls"><?php echo $form->getInput('email1'); ?></div>
	</div>	

	<div class="uk-form-row">
		<label class="uk-form-label" for=""><?php echo $form->getLabel('password1'); ?></label>
		<div class="uk-form-controls"><?php echo $form->getInput('password1'); ?></div>
	</div>	
	
	<div class="uk-form-row">
		<label class="uk-form-label" for=""><?php echo $form->getLabel('password2'); ?></label>
		<div class="uk-form-controls"><?php echo $form->getInput('password2'); ?></div>
	</div>	

	<div class="uk-form-row">
		<label class="uk-form-label" for=""><?php echo $form->getLabel('capthca'); ?></label>
		<div class="uk-form-controls"><?php echo $form->getInput('capthca'); ?></div>
	</div>
	
		<input type="hidden" name="jform[username]" id="jform_username" value="" class="validate-username required" size="30" required="" aria-required="true">																				
	<input type="hidden" name="jform[email2]" id="jform_username" value="" class="validate-username required" size="30" required="" aria-required="true">																				

	
	<div class="uk-form-row" data-uk-margin>
		<button type="submit" class="validate uk-button uk-button-primary uk-button-large"><?php echo JText::_('JREGISTER');?></button>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="registration.register" />
	</div>
	<?php echo JHtml::_('form.token');?>

</form>

</article>