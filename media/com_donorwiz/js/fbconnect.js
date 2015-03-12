window.fbAsyncInit = function() {
	
	FB.init({
		appId	: '1524474781110687',
		cookie	: true,
		xfbml  	: true, 
		version : 'v2.1'
	});

};

// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}
(document, 'script', 'facebook-jssdk'));

//Called when user clicks login button
function fbLogin() {

	FB.login(function(response){

		if (response.status === 'connected') 
		{
			// Logged into Facebook and app.
			// Fetch user data from facebook
			FB.api('/me', function(response) {
					
					console.log(response);
					
					//Save facebook response to session
					saveResponseToSession(response);
					
					checkUserName(response)
			
			});
		
		} 
		else if (response.status === 'not_authorized') 
		{
			// Logged into Facebook but not in app.
		} 
		else 
		{
			// Not logged into Facebook, so do not know if connected to app.

		}
	}, 
	{scope: 'public_profile,email'});
} 

function checkUserName(response){
  
	var token = jQuery('a.uk-button.facebook').attr('data-form-token');
	var data = {};
	data['option'] = 'com_donorwiz';
	data['task'] = 'user.emailExists';
	data['email'] = response.email;
	data[token] = '1';
	
 

 jQuery.ajax({
		   
		   type: 'GET',
		   url: 'index.php',
		   data: data,
		   success: function(data){

				var result= JSON.parse(data);
				console.log(result)
				console.log(result.data.id)
				
				if(result.data.id)
				{
					console.log('Now logging in user');
					loginUser(result.data.id, result.data.username);
				}
				
				else
				{
					console.log('Now creating a new user');
					console.log(response);
					registerUser(response);
				}
			}
		  
		 });	
  
  
}

	function loginUser(userID,userName){
		
		console.log('Attempt to login user to joomla');
		var token = jQuery('a.uk-button.facebook').attr('data-form-token');
		
		jQuery.ajax({
		   type: 'POST',
		   url: 'index.php?'+token+'=1',
		   data: {
			 'option': 'com_donorwiz',
			 'task': 'user.socialLogin',
			 'userName': userName,
			 'userID': userID
		  
		   },
		   success: function(data){
		   
				console.log(data);
				//location.reload();
				var result= JSON.parse(data);
				console.log(result)
				console.log(result.data.id)
				
				if(result.data==true)
				{
					console.log('Now use is logged in');
					location.reload();
					
				}
				
				else
				{
					alert('login failed');
				}
			}
		  
		 });
	}

function registerUser(response){
  
		
		var token = jQuery('a.uk-button.facebook').attr('data-form-token');
		
		var data = {};
		data['option'] = 'com_donorwiz';
		data['task'] = 'registration.ajaxRegister';
		data['tmpl'] = 'raw';
		data['jform[jsfirstname]']= response.first_name;
		data['jform[jslastname]']= response.last_name;
		data['jform[name]']= response.name;
		data['jform[email1]']= response.email;
		data['jform[email2]']= response.email;
		data['jform[username]']= response.email;
		// data['jform[password1]']= _temp;
		// data['jform[password2]']= _temp;
		data[token]='1';
			 
		jQuery.ajax({
		   
		   type: 'POST',
		   url: 'index.php',
		   data: data,
		   success: function(data){
				
				location.reload();
				console.log(data);
				console.log('user registered succefully');
			}
		  
		 });
  }


function saveResponseToSession(response){
	
	console.log('Attempt to save fbconnect data to session');
	var token = jQuery('a.uk-button.facebook').attr('data-form-token');
	console.log(token);
	var data = {};
	
	data['option'] = 'com_donorwiz';
	data['task'] = 'user.fbConnectToSession';
	data['response'] = response;
	data[token]='1';

	jQuery.ajax({
		   
		   type: 'POST',
		   url: 'index.php',
		   data: data,
		   success: function(data){
			console.log('FBConnect data saved to session');
				console.log(data);
			}
		  
		 });

}






































// This function is called with the results from from FB.getLoginStatus().
// function statusChangeCallback(response) {
	
	// console.log('statusChangeCallback');
	// console.log(response);
	
	// // Get the current fb login status: connected, not_authorized , unknown

	// if (response.status === 'connected') 
	// {
		// // Logged into Facebook and app.
		// testAPI();
	// } 
	// else if (response.status === 'not_authorized') 
	// {
		// // Logged into Facebook but not in app.
		// document.getElementById('status').innerHTML = 'Please log ' + 'into this app.';
	// } 
	// else 
	// {
		// // Not logged into Facebook, so do not know if connected to app.
		// document.getElementById('facebook-login-button').style.display = 'block';
		// document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';
	// }
// }


// This function is called when someone finishes with the Login Button. 

// function checkLoginState() {
	
	// FB.getLoginStatus(function(response) {
	  // statusChangeCallback(response);
	// });

// }