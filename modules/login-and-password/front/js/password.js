jQuery(document).ready(function($) {
	
	var form = $("#registerform");
	var username = form.find(" > p:first-child");
	$("#dbem_gender_wrap, #first_name_wrap, #last_name_wrap").insertBefore(username);
	username.hide();
	
	$("#nav a:first").text("Create an account");
	
	var input = $("#loginform label[for='user_login']");
	if(input.length) {
		input.html(input.html().replace("Username","Email address"));
	}
	
	$("#registerform #wp-submit").val("Validate");
	
	$("#registerform").submit(function(){
		$("#user_login").val($("#user_email").val());
	});
	
});
