jQuery(function($) {
	
	var $ = jQuery.noConflict();
	
	
	
		$('#jform_email1').on('input',function() {
			
			var value= $(this).val();
			
			$('#jform_email2,#jform_username').val(value);

		});
		
		$('#jform_password1').on('input',function() {
			
			var value= $(this).val();
			
			$('#jform_password2').val(value);

		});		
		
		$('#jform_jsfirstname,#jform_jslastname').on('input',function() {
		
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
		
		//Prevent form submit when Enter is pressed
        var registerFormInputs = $('#dw-registration-form').find( 'input' );
       
        registerFormInputs.keypress(function(event)
        {
            return event.keyCode != 13;
        });
		
	
	
});