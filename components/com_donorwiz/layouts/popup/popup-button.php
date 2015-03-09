<?php

// no direct access
defined('_JEXEC') or die;

$buttonText = ( isset ( $displayData['buttonText'] ) ) ? $displayData['buttonText'] : '' ;
$buttonIcon = ( isset ( $displayData['buttonIcon'] ) ) ? $displayData['buttonIcon'] : '' ;
$buttonType = ( isset ( $displayData['buttonType'] ) ) ? $displayData['buttonType'] : 'uk-button-primary' ;
$buttonID = ( isset ( $displayData['buttonID'] ) ) ? $displayData['buttonID'] : uniqid() ;

$popupHeader = ( isset ( $displayData['popupParams']['header'] ) ) ? $displayData['popupParams']['header'] : null ;
$popupFooter = ( isset ( $displayData['popupParams']['footer'] ) ) ? $displayData['popupParams']['footer'] : '' ;

$layoutPath = $displayData['layoutPath'];
$layoutName = $displayData['layoutName'];
$layoutParams = $displayData['layoutParams'];

?>

<a href="#modal-<?php echo $buttonID;?>" class="<?php echo $buttonType;?>" data-uk-modal ><i class="<?php echo $buttonIcon;?>"></i><?php echo $buttonText;?></a>

<div id="modal-<?php echo $buttonID;?>" class="uk-modal" style="display:none;">

	<div class="uk-modal-dialog">
		
		<a class="uk-modal-close uk-close"></a>
		
		<?php if ( $popupHeader ) : ?>
		<div class="uk-modal-header">
			<?php echo $popupHeader;?>
		</div>		
		<?php endif; ?>

		<?php echo JLayoutHelper::render($layoutName, $layoutParams , $layoutPath , null ); ?>

	</div>

</div>