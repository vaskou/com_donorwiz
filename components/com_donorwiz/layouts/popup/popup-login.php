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

JHtml::_('behavior.formvalidation');

?>
<article class="uk-article" >

<h4><i class="uk-icon-sign-in uk-icon-medium"></i> ΕΙΣΟΔΟΣ</h4>

<p>Κάντε είσοδο με το E-mail και τον κωδικό σας</p>

	
<form class="uk-form uk-form uk-form-horizontal" action="<?php echo JFactory::getURI()->toString(); ?>" method="post">
	
	<div class="uk-form-row">
		<label class="uk-form-label required" for="">Email</label>
		<div class="uk-form-controls">
			<input type="email" name="username" class="validate-email required">
		</div>
	</div>	

	<div class="uk-form-row">
		<label class="uk-form-label required" for="">Κωδικός</label>
		<div class="uk-form-controls">
			<input type="password" name="password" class="required">
		</div>
	</div>	
	

	<div class="uk-form-row">
		<label for="modlgn-remember-31626">Να με θυμάσαι</label>
		<input id="modlgn-remember-31626" type="checkbox" name="remember" value="yes" checked="">
	</div>
		
	<div class="uk-form-row">
		<button class="validate uk-button uk-button-secondary uk-button-large" value="Σύνδεση" name="Submit" type="submit">Σύνδεση</button>
	</div>

	<ul class="uk-list uk-margin-bottom-remove">
		<li><a href="/donorwiz/index.php?option=com_users&amp;view=reset&amp;lang=el">Ξεχάσατε τον κωδικό σας;</a></li>
		<!--
		<li><a href="/donorwiz/index.php?option=com_users&amp;view=remind&amp;lang=el">Ξεχάσατε το όνομα χρήστη;</a></li>
		<li><a href="/donorwiz/index.php?option=com_users&amp;view=registration&amp;lang=el">Δημιουργία λογαριασμού</a></li>
		-->
	</ul>
	
		
	<input type="hidden" name="option" value="com_users">
	<input type="hidden" name="task" value="user.login">
	<input type="hidden" name="return" value="<?php echo base64_encode(JFactory::getURI()->toString());?>">
	
	<?php echo JHtml::_('form.token'); ?>

</form>

</article>