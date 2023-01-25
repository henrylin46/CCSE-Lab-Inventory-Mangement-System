$(document).ready(function(){
	
	// Listen to login button
	$('#login').on('click', function(){
		login();
	});
});


// Function to login a user
function login(){
	var loginUsername = $('#loginUsername').val();
	var loginPassword = $('#loginPassword').val();
	
	$.ajax({
		url: 'model/login/checkLogin.php',
		method: 'POST',
		data: {
			loginUsername:loginUsername,
			loginPassword:loginPassword,
		},
		success: function(data){
			$('#loginMessage').html(data);
			
			if(data.indexOf('Redirecting') >= 0){
				window.location = 'index.php';
			}
		}
	});
}