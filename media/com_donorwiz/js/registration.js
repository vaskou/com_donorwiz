jQuery(function($) {
	
	var $ = jQuery.noConflict();
	
	$(document).ready(function() {
	
		$('#jform_email1').blur(function() {
			
			var value= $(this).val();
			
			$('#jform_email2,#jform_username').val(value)

		});
		
		$('#jform_password1').blur(function() {
			
			var value= $(this).val();
			
			$('#jform_password2').val(value)

		});		
		
		$('#jform_jsfirstname,#jform_jslastname').blur(function() {
		
			$(this).val( $.trim($(this).val()) );
			
			if($(this).val()=='')
			{
				$(this).addClass('invalid');
			}
			else
			{
				var name = $('#jform_jsfirstname').val()+' '+$('#jform_jslastname').val();
				$('#jform_name').val(name);			
			}
			
		});	
		
	});
	
});