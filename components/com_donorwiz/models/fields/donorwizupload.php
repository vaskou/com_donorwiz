<?php

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

		
		$uploadURL= JURI::base().'index.php?option='.$this->getAttribute("actionoption").'&task='.$this->getAttribute("uploadtask");
		$deleteURL= JURI::base().'index.php?option='.$this->getAttribute("actionoption").'&task='.$this->getAttribute("deletetask");
		
		$value = htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');
		
		$src = ( $value ) ? $value : "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" ;
		
		$valueURL = JURI::getInstance( $value );
		$valuePath = $valueURL->getPAth();
		
		$Key =  ltrim ($valuePath, '/') ;

		$app =& JFactory::getApplication();
		

		$params=array();
		$params['objecttype']=$this->getAttribute("objecttype");
		$params['objectid']= JFactory::getApplication() -> input -> get('id', '', 'int') ;
		$params['field']= $this->getAttribute("name") ;
		$params['formpath']= base64_encode ( $this->getAttribute("formpath") );
		$params[JSession::getFormToken()]="1";
		
		// Include jQuery
		JHtml::_('jquery.framework');


		
		// Build the script.
		$script = array();

		
		$script[] = '		jQuery(function($) {';
		
		$script[] = '		var $ = jQuery.noConflict();';
		
		$script[] = '		var progressbar_'.$this->getAttribute("name").' = $("#progressbar.'.$this->getAttribute("name").'"),';
		$script[] = '		upload_wrapper_'.$this->getAttribute("name").' = $("#upload-wrapper.'.$this->getAttribute("name").'"),';
		$script[] = '		preview_wrapper_'.$this->getAttribute("name").' = $("#preview-wrapper.'.$this->getAttribute("name").'");';
		
		$script[] = '			bar         = progressbar_'.$this->getAttribute("name").'.find(".uk-progress-bar"),';
		
		$script[] = '			settings    = {';
		$script[] = '				type: "json",';
		$script[] = '				action: "'.$uploadURL.'",';
		$script[] = '				allow : "*.('.$this->getAttribute("allow").')",';
		$script[] = '				filelimit : 1,';

		$script[] = '				params : '.json_encode($params).',';
			
		$script[] = '				loadstart: function() {';
		$script[] = '					bar.css("width", "0%").text("0%");';
		$script[] = '					progressbar_'.$this->getAttribute("name").'.removeClass("uk-hidden");';
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
		

		$script[] = '					console.log("response log");';
		$script[] = '					console.log(response);';
		//$script[] = '					console.log(response.data.File.error);';//0
		//$script[] = '					console.log(response.data.File.name);';//"sdfsfdfd.jpg"
		//$script[] = '					console.log(response.data.File.size);';//105439
		//$script[] = '					console.log(response.data.File.tmp_name);';//"c:/wamp/tmp/php8ACB.tmp"
		//$script[] = '					console.log(response.data.File.type);';//"image/jpeg"


		$script[] = '					bar.css("width", "100%").text("100%");';
		$script[] = '					setTimeout(function(){';
		$script[] = '						progressbar_'.$this->getAttribute("name").'.addClass("uk-hidden");';
		$script[] = '					}, 250);';
		
		$script[] = '					if( !response || response.success == false) { ';
		$script[] = '						UIkit.notify("'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_ERROR').'", {status:"danger", timeout:"3000"});';
		$script[] = '						return false;';
		$script[] = '					}';
		

		$script[] = '					if (response.success == true){';
		
		$script[] = '						var src=response.data.FileFullPath';
		
		$script[] = '						$("#jform_'.$this->getAttribute("name").'").val(src);';
		$script[] = '						$("#jform_'.$this->getAttribute("name").'").closest("form").submit();';
		
		$script[] = '					}';

		$script[] = '				},';
			
		$script[] = '				error: function(event){';
		$script[] = '					UIkit.notify("'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_ERROR').'", {status:"danger", timeout:"3000"});';
		$script[] = '					console.log(event);';
		$script[] = '				},';
		$script[] = '				notallowed: function( file , settings){';
		$script[] = '					UIkit.notify("'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_FILE_TYPE_NOT_ALLOWED').'", {status:"danger", timeout:"3000"});';
		$script[] = '					console.log(settings);';
		$script[] = '				}';
		$script[] = '			};';

		$script[] = '		var select = $.UIkit.uploadSelect($("#upload-select.'.$this->getAttribute("name").'"), settings);';
		$script[] = '		var drop   = $.UIkit.uploadDrop($("#upload-drop.'.$this->getAttribute("name").'"), settings);';
		
		$script[] = '		$("#upload-thumbnail-delete.'.$this->getAttribute("name").' a").click( function(e) {';
		
		$script[] = '			e.preventDefault();';

		$script[] = '			var confirmDialog = confirm("'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_CONFIRM_DELETE').'");';
		$script[] = '			if( !confirmDialog ){ return false; }';
		
		$script[] = '			var uploadModalHTML = "";';
		$script[] = '			uploadModalHTML += "<div id=\"dw-upload-modal\" class=\"uk-modal\">";';
		$script[] = '			uploadModalHTML += "<div class=\"uk-modal-dialog\">";';
		$script[] = '			uploadModalHTML += "<div class=\"uk-text-center uk-margin-top\"><i class=\"uk-icon-spinner uk-icon-spin uk-icon-large\"></i><h3>'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_PLEASE_WAIT').'</h3></div>";';
		$script[] = '			uploadModalHTML += "</div>";';
		$script[] = '			uploadModalHTML += "</div>";';
		$script[] = '			$("body").append( $( uploadModalHTML ) )';
		$script[] = '			uploadModal = $.UIkit.modal("#dw-upload-modal" , { bgclose : false } ).show()';
		$script[] = '			uploadModal.show();';

		$script[] = '			var deletePost = $.post( "'.$deleteURL.'", { ';
		$script[] = '				"'.JSession::getFormToken().'": "1" , ';
		$script[] = '				"objecttype" : "'. $this->getAttribute("objecttype").'" , ';
		$script[] = '				"objectid" : "'. JFactory::getApplication() -> input -> get('id', '', 'int').'" , ';
		$script[] = '				"imgsrc" : "'.base64_encode( $value ).'" ';

		$script[] = '			} );';		
		$script[] = '			deletePost. done(function( data ) {';
		
		$script[] = '				console.log(data);';
		
		$script[] = '				try {';
		
		$script[] = '					var dataObject = $.parseJSON (data);';
		
		$script[] = '					if(dataObject.success==true){';
		
		$script[] = '						$("#jform_'.$this->getAttribute("name").'").val("");';
		$script[] = '						$("#jform_'.$this->getAttribute("name").'").attr("Key","");';
		$script[] = '						$("#jform_'.$this->getAttribute("name").'").closest("form").submit();';
		$script[] = '						uploadModal.hide();';
		$script[] = '					}';
		
		$script[] = '					else{';
		
		$script[] = '						uploadModal.hide();';
		$script[] = '						UIkit.notify("'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_ERROR').'", {status:"danger", timeout:"3000"});';
		$script[] = '					}';
		
		
		$script[] = '				}';
		
		$script[] = '				catch(e) {';
		$script[] = '					uploadModal.hide();';
		$script[] = '					UIkit.notify("'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_ERROR').'", {status:"danger", timeout:"3000"});';
		
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
		
		$html[] = 	'<div class="uk-grid uk-grid-preserve">';
			
		$html[] = 	'	<div class="uk-width-1-5">';
		$html[] = 	'		<div id="upload-thumbnail" class="uk-thumbnail '.$this->getAttribute("name").'">';
		$html[] = 	'			<img src="'. $src .'" style="width:64px;height:auto;min-height:54px;max-height:54px;">';
		$html[] = 	'		</div>';


		$html[] = 	'	</div>';
		
		$html[] = 	'	<div id="preview-wrapper" class="uk-width-4-5'.$previewHide.' '.$this->getAttribute("name").'">';
		
		$html[] = 	'		<div id="upload-thumbnail-preview" class="'.$this->getAttribute("name").'">';
		$html[] = 	'			<a href="'. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') .'" data-lightbox title="">'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_PREVIEW').'</a>';
		$html[] = 	'		</div>';
		
		$html[] = 	'		<div id="upload-thumbnail-delete" class="'.$this->getAttribute("name").'" ">';
		$html[] = 	'			<a href="#" title="">'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_DELETE').'</a>';
		$html[] = 	'		</div>';

		$html[] = 	'	</div>';
		
		$html[] = 	'	<div id="upload-wrapper" class="uk-width-4-5'.$uploadHide.' '.$this->getAttribute("name").'">';
		$html[] = 	'		<div id="upload-drop" class="uk-placeholder uk-text-center '.$this->getAttribute("name").'">';
		$html[] = 	'			<i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-margin-small-right"></i>'.JText::_('COM_DONORWIZ_FIELD_DONORWIZUPLOAD_DRAG_AND_DROP_OR_SELECT_FILE').'(max. '.$this->getAttribute("sizetext").')';
		$html[] = 	'			</br><input id="upload-select" class="'.$this->getAttribute("name").'" type="file">.';
		$html[] = 	'		</div>';
		$html[] = 	'	</div>';

		$html[] = 	'</div>';
		
		$html[] = 	'<div id="progressbar" class="uk-progress uk-hidden '.$this->getAttribute("name").'">';
		$html[] = 	'	<div class="uk-progress-bar" style="width: 0%;">0%</div>';
		$html[] = 	'</div>';
		$html[] = 	'<input type="hidden" name="jform['.$this->getAttribute("name").']" id="jform_'.$this->getAttribute("name").'" value="'. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') .'">';
				
		return implode($html);
	}
}