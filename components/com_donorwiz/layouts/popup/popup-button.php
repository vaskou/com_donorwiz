<?php
// no direct access
defined('_JEXEC') or die;
$modalSize = ( isset ( $displayData['modalSize'] ) ) ? $displayData['modalSize'] : '' ;
$buttonText = ( isset ( $displayData['buttonText'] ) ) ? $displayData['buttonText'] : '' ;
$buttonTooltip = ( isset ( $displayData['buttonTooltip'] ) ) ? $displayData['buttonTooltip'] : '' ;
$buttonIcon = ( isset ( $displayData['buttonIcon'] ) ) ? $displayData['buttonIcon'] : '' ;
$buttonType = ( isset ( $displayData['buttonType'] ) ) ? $displayData['buttonType'] : 'uk-button-primary' ;
$buttonID = ( isset ( $displayData['buttonID'] ) ) ? $displayData['buttonID'] : uniqid() ;
$popupHeader = ( isset ( $displayData['popupParams']['header'] ) ) ? $displayData['popupParams']['header'] : null ;
$popupFooter = ( isset ( $displayData['popupParams']['footer'] ) ) ? $displayData['popupParams']['footer'] : '' ;
$layoutPath = $displayData['layoutPath'];
$layoutName = $displayData['layoutName'];
$layoutParams = $displayData['layoutParams'];
$buttonLink = ( isset ( $displayData['buttonLink'] ) ) ? $displayData['buttonLink'] : '#' ;
$isAjax = ( isset ( $displayData['isAjax'] ) ) ? true : null ;
$styles=( isset ( $displayData['styles'] ) ) ? $displayData['styles']  : array() ;
$scripts=( isset ( $displayData['scripts'] ) ) ? $displayData['scripts'] : array() ;

if( $isAjax )
{

JHtml::_('jquery.framework');
JHtml::_('behavior.formvalidator');

foreach($styles as $style){
	JHtml::stylesheet($style);
}
foreach($scripts as $script){
	JHtml::script($script);
}

$script = array();

$script[] = 'jQuery(function($) {';
	
$script[] = '	var $ = jQuery.noConflict();';
	
$script[] = '	$(document).ready(function() {';

$script[] = '		$( "#modal-'.$buttonID.'.uk-modal" ).on({';

$script[] = '			"show.uk.modal": function(){';

$script[] = '				var layoutWrapperIsEmpty=( $( "#modal-'.$buttonID.'.uk-modal .modal-content .layout-wrapper" ).children().length=="0" ) ? true : false ;';

$script[] = '				if( layoutWrapperIsEmpty == true ){';

$script[] = '					var postdata={';
$script[] = '						"'.JSession::getFormToken().'":"1",';
$script[] = '						"layout":"'.$layoutName.'",';
$script[] = '						"layoutPath":"'.base64_encode ( $layoutPath ).'",';
$script[] = '						"layoutParams":"'.htmlspecialchars ( json_encode( $layoutParams ) ) .'",';
$script[] = '						"return":"'.base64_encode ( JFactory::getURI()->toString() ) .'"';
$script[] = '					};';

$script[] = '					$.ajax({';
$script[] = '						type: "POST",';
$script[] = '						url: "index.php?option=com_donorwiz&task=ajax.getLayout",';
$script[] = '						data: postdata';
$script[] = '					}).done( function(response) {';

$script[] = '						try{';
$script[] = '							var response = jQuery.parseJSON( response );';
$script[] = '							$( "#modal-'.$buttonID.'.uk-modal .modal-content .spinner-wrapper" ).toggleClass("uk-hidden");';
$script[] = '							$( "#modal-'.$buttonID.'.uk-modal .modal-content .layout-wrapper" ).html(response.data);';
$script[] = '							document.formvalidator = new JFormValidator();';
$script[] = '							$( "#modal-'.$buttonID.'.uk-modal .modal-content .layout-wrapper" ).toggleClass("uk-hidden");';
$script[] = '						}';
$script[] = '						catch(err) {';

$script[] = '							$( "#modal-'.$buttonID.'.uk-modal" ).hide();';
$script[] = '							$.UIkit.notify( "<i class=uk-icon-warning></i> '.JText::_('COM_DONORWIZ_POPUP_ERROR').'" , { timeout:2000 } );';

$script[] = '					}';

$script[] = '					})';
$script[] = '					.fail(function() {';
$script[] = '						$( "#modal-'.$buttonID.'.uk-modal" ).hide();';
$script[] = '						$.UIkit.notify( "<i class=uk-icon-warning></i> '.JText::_('COM_DONORWIZ_POPUP_ERROR').'" , { timeout:2000 } );';
$script[] = '					});';

$script[] = '				}';
$script[] = '			},';
$script[] = '			"hide.uk.modal": function(){';

$script[] = '			 }';

$script[] = '		});';

$script[] = '	});';

$script[] = '});';

JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

}

?>

<a href="<?php echo $buttonLink;?>" class="<?php echo $buttonType;?>" data-uk-modal="{target:'#modal-<?php echo $buttonID;?>'}" 

	<?php if ( $buttonTooltip ) : ?>
	title="<?php echo $buttonTooltip;?>"
	data-uk-tooltip
	<?php endif; ?>

>

<i class="<?php echo $buttonIcon;?>"></i><?php echo $buttonText;?></a>

<div id="modal-<?php echo $buttonID;?>" class="uk-modal" style="display:none;">

	<div class="uk-modal-dialog <?php echo $modalSize;?>">
		
		<a class="uk-modal-close uk-close"></a>
		
		<?php if ( $popupHeader ) : ?>
		<div class="uk-modal-header">
			<?php echo $popupHeader;?>
		</div>		
		<?php endif; ?>
		
		<div class="modal-content" data-uk-observe>
			
			<?php if( $isAjax ):?>
				<div class="uk-text-center uk-margin-large-top spinner-wrapper">
					<i class="uk-icon-spinner uk-icon-spin uk-icon-large"></i>
					<h3><?php echo JText::_('COM_DONORWIZ_MODAL_PLEASE_WAIT');?></h3>
				</div>
				<div class="layout-wrapper uk-hidden"></div>
			<?php else:?>
				<?php echo JLayoutHelper::render($layoutName, $layoutParams , $layoutPath , null ); ?>
			<?php endif;?>
			
		</div>
	
	</div>

</div>