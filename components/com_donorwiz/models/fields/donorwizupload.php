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
class JFormFieldDonorwizupload extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'donorwizupload';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */

	protected function getInput()
	{
		$form = $this->form->getName();
		$type = $this->getAttribute("type");
		$field = $this->getAttribute("name");

		
		$uploadURL= JRoute::_('index.php?option='.$this->getAttribute("actionoption").'&task='.$this->getAttribute("uploadtask"));
		$deleteURL= JRoute::_('index.php?option='.$this->getAttribute("actionoption").'&task='.$this->getAttribute("deletetask"));
		
		
		$value = htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');
		
		$src = ( $value ) ? $value : "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" ;
		
		$valueURL = JURI::getInstance( $value );
		$valuePath = $valueURL->getPAth();
		
		$Key =  ltrim ($valuePath, '/') ;

		$app =& JFactory::getApplication();
		$sessionKey = $app->setUserState( $form.".".$type.".".$field.".sessionKey", $Key );

		$params=array();
		$params['objecttype']=$this->getAttribute("objecttype");
		$params['objectid']=$objectid = JFactory::getApplication() -> input -> get('id', '', 'string') ;
		$params['form']=$form;
		$params['type']=$type;
		$params['field']=$field;
		$params[JSession::getFormToken()]="1";
		
		// Include jQuery
		JHtml::_('jquery.framework');
		
		// Build the script.
		$script = array();

		
		$script[] = '		jQuery(function($) {';
		
		$script[] = '		var $ = jQuery.noConflict();';
		
		$script[] = '		var progressbar = $("#progressbar"),';
		
		$script[] = '			bar         = progressbar.find(".uk-progress-bar"),';
		
		$script[] = '			settings    = {';
		$script[] = '				type: "json",';
		$script[] = '				action: "'.$uploadURL.'",';
		$script[] = '				allow : "'.$this->getAttribute("allow").'",';

		$script[] = '				params : '.json_encode($params).',';
			
		$script[] = '				loadstart: function() {';
		$script[] = '					bar.css("width", "0%").text("0%");';
		$script[] = '					progressbar.removeClass("uk-hidden");';
		$script[] = '				},';
				
		$script[] = '				progress: function(percent) {';
		$script[] = '					percent = Math.ceil(percent);';
		$script[] = '					bar.css("width", percent+"%").text(percent+"%");';
		$script[] = '				},';
			
		$script[] = '				before: function(settings, files) {';
		$script[] = '					console.log(settings);';
		$script[] = '					console.log(files);';
		$script[] = '				},';
		$script[] = '				allcomplete: function(response, xhr) {';
		

		$script[] = '					console.log(response);';


		$script[] = '					bar.css("width", "100%").text("100%");';
		$script[] = '					setTimeout(function(){';
		$script[] = '						progressbar.addClass("uk-hidden");';
		$script[] = '					}, 250);';
		
		$script[] = '					if(!response || response.success == false) { ';
		$script[] = '						alert("Παρουσιάστηκε σφάλμα κατά την μεταφόρτωση του αρχείου.");';
		$script[] = '						return false;';
		$script[] = '					}';
		

		$script[] = '					if (response.success == true){';
		$script[] = '						var src=response.data.FileFullPath';
		
		$script[] = '						$("#jform_'.$this->getAttribute("name").'").val(src);';
		$script[] = '						$("#upload-thumbnail img").attr("src",src);';
		$script[] = '						$("#upload-wrapper, #preview-wrapper").toggleClass("uk-hidden");';
		$script[] = '						$("#upload-thumbnail-preview a").attr("href",src);';

		
		$script[] = '						$("#jform_'.$this->getAttribute("name").'").closest("form").submit();';
		$script[] = '					}';

		$script[] = '				},';
			
		$script[] = '				error: function(event){';
		$script[] = '					$.UIkit.notify( "<i class=uk-icon-warning></i>'.$this->getAttribute("message_file_upload_error").'", { timeout:5000} );';
		$script[] = '					console.log(event);';
		$script[] = '				},';
		$script[] = '				notallowed: function(file, settings){';
		
		
		
		//$script[] = '					$.UIkit.notify( "<i class=uk-icon-warning></i>'.$this->getAttribute("message_file_not_allowed").'", { timeout:5000} );';
		//$script[] = '					console.log(file);';
		$script[] = '					console.log(settings);';
		$script[] = '				}';
		$script[] = '			};';

		$script[] = '		var select = $.UIkit.uploadSelect($("#upload-select"), settings),';
		
		$script[] = '		drop   = $.UIkit.uploadDrop($("#upload-drop"), settings);';
		
		$script[] = '		$("#upload-thumbnail-delete a").click( function(e) {';
		
		$script[] = '			e.preventDefault();';

		$script[] = '			var confirmDialog = confirm("Είστε σίγουρη/ος ότι θέλετε να διαγράψετε το αρχείο;");';
		
		$script[] = '			if(!confirmDialog){ return false; }';
		
		
		$script[] = '			var modal = $.UIkit.modal(".uk-modal.donorwizupload");';
		$script[] = '			if ( modal.isActive() ) {modal.hide();}else{modal.show();}';

		
		$script[] = '			var deletePost = $.post( "'.$deleteURL.'", { "'.JSession::getFormToken().'": "1" , form : "'. $form.'" ,type : "'. $type.'" , field : "'.$field.'" } );';
		
		$script[] = '			deletePost. done(function( data ) {';
		
		$script[] = '				console.log(data);';
		$script[] = '				var dataObject = $.parseJSON (data);';
		
		$script[] = '				if(dataObject.success==true){';
		

		
		$script[] = '					$("#jform_'.$this->getAttribute("name").'").val("");';
		$script[] = '					$("#jform_'.$this->getAttribute("name").'").attr("Key","");';
		$script[] = '					$("#upload-thumbnail img").attr("src","");';
		$script[] = '					$("#upload-wrapper, #preview-wrapper").toggleClass("uk-hidden");';
		$script[] = '					$("#jform_'.$this->getAttribute("name").'").closest("form").submit();';
		
		$script[] = '					var modal = $.UIkit.modal(".uk-modal.donorwizupload");';
		$script[] = '					if ( modal.isActive() ) {modal.hide();}else{modal.show();}';



		$script[] = '				}';
		$script[] = '			});';
		$script[] = '		});';
		
		$script[] = '		});';

	
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		
		$previewHide = ( $value =='' ) ? ' uk-hidden' : '' ;
		$uploadHide = ( $value =='' ) ? '' : ' uk-hidden' ;

		
		// Initialize variables.
		$html = array();
		$html[] = 	'<div  class="uk-grid uk-grid-preserve">';
		
		
		$html[] = 	'	<div class="uk-width-1-5">';
		$html[] = 	'		<div id="upload-thumbnail" class="uk-thumbnail">';
		$html[] = 	'			<img src="'. $src .'" style="width:64px;height:auto;min-height:54px;max-height:54px;">';
		$html[] = 	'		</div>';


		$html[] = 	'	</div>';
		
		$html[] = 	'	<div id="preview-wrapper" class="uk-width-4-5'.$previewHide.'">';
		
		$html[] = 	'		<div id="upload-thumbnail-preview">';
		$html[] = 	'			<a href="'. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') .'" data-lightbox title="">Preview</a>';
		$html[] = 	'		</div>';
		
		$html[] = 	'		<div id="upload-thumbnail-delete">';
		$html[] = 	'			<a href="#" title="">Delete</a>';
		$html[] = 	'		</div>';

		$html[] = 	'	</div>';
		
		$html[] = 	'	<div id="upload-wrapper" class="uk-width-4-5'.$uploadHide.'">';
		$html[] = 	'		<div id="upload-drop" class="uk-placeholder">';
		$html[] = 	'			<i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-margin-small-right"></i>Drag & drop your image or ';
		$html[] = 	'			<a class="uk-form-file">Select a file<input id="upload-select" type="file"></a>.';
		$html[] = 	'		</div>';
		$html[] = 	'	</div>';

		$html[] = 	'</div>';
		
		$html[] = 	'<div id="progressbar" class="uk-progress uk-hidden">';
		$html[] = 	'	<div class="uk-progress-bar" style="width: 0%;">0%</div>';
		$html[] = 	'</div>';
		$html[] = 	'<input type="hidden" name="jform['.$this->getAttribute("name").']" id="jform_'.$this->getAttribute("name").'" value="'. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') .'">';
		
		$html[] = 	'<div class="uk-modal donorwizupload">';
		$html[] = 	'	<div class="uk-modal-dialog">';
        $html[] = 	'		<div class="uk-modal-spinner">Παρακαλώ περιμένετε...</div>';
		$html[] = 	'	</div>';
		$html[] = 	'</div>';
				
		return implode($html);
	}
}