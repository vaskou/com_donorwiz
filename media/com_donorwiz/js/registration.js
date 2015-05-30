//jQuery(function($) {

function fn_registration_form_init(errorText)
{
	var $ = jQuery.noConflict();
	
	$('#jform_email1').on('input',function() {
		
		var value= $(this).val();
		
		$('#jform_email2,#jform_username').val(value);

	});
	
	$('#jform_password1').on('input',function() {
		
		var value= $(this).val();
		
		$('#jform_password2').val(value);

	});
	
	$('#jform_password1,#login_password').on('blur',function() {
		
		var value = $(this).val();
		var length = value.length;
		
		if (length<8) {
			$(this).val("");
			$(this).addClass("invalid");
			UIkit.notify({
				message : $(this).parent().attr("title"),
				status  : 'danger',
				timeout : 10000,
				pos     : 'top-center'
			});
		}
	
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
	
	$("#dw-registration-form button").click(function(e){
		var check_recaptcha=grecaptcha.getResponse();
		if(!check_recaptcha){
			e.preventDefault();
			$.UIkit.notify(errorText,{status:"danger",timeout:2000,pos:"top-center"});
		}
	});
	
	$('#dw-login-form,#dw-registration-form').on('submit',function(){
		$(this).find('button').attr('disabled','disabled');
		$(this).css('opacity','0.5');
	});

}