var Recovery = {	
	timeout: null,
	useCaptcha: false,

	request: function() {
		var postData = {
			"email": $(".email-input").val(),
			"csrf_token_name": Config.CSRF,
			"token": Config.CSRF
		};

		clearTimeout (Recovery.timeout);
		Recovery.timeout = setTimeout (function()
		{
			$.post(Config.URL + "password_recovery/create_request", postData, function(data) {
				try {
					data = JSON.parse(data);
					console.log(data);

					if(data["messages"]["error"]) {
						if($(".email-input").val() != "") {
							$(".error-feedback").addClass("invalid-feedback alert-danger d-block").removeClass("d-none").html(data["messages"]["error"]);
						}
					}
					else if(data["messages"]["success"]) {
						if($(".email-input").val() != "") {
							$(".error-feedback").addClass("valid-feedback alert-success d-block").removeClass("d-none").html(data["messages"]["success"]);
							$(".email-input").val('');
						}
					}
					
				} catch(e) {
					console.error(e);
					console.log(data);
				}				
			});

			console.log(postData);

		}, 500);
	},
    
    reset: function() {
		var postData = {
			"token": $(".token-input").val(),
            "new_password": $(".password-input").val(),
			"csrf_token_name": Config.CSRF,
			"csrf_token": Config.CSRF
		};

		clearTimeout (Recovery.timeout);
		Recovery.timeout = setTimeout (function()
		{
			$.post(Config.URL + "password_recovery/reset_password", postData, function(data) {
				try {
					data = JSON.parse(data);
					console.log(data);

					if(data["messages"]["error"]) {
						if($(".password-input").val() != "") {
							$(".error-feedback").addClass("invalid-feedback alert-danger d-block").removeClass("d-none").html(data["messages"]["error"]);
						}
					}
					else if(data["messages"]["success"]) {
						if($(".password-input").val() != "") {
							$(".error-feedback").addClass("valid-feedback alert-success d-block").removeClass("invalid-feedback alert-danger d-none").html(data["messages"]["success"]);
							$(".password-input, .token-input").val('');
						}
					}
					
				} catch(e) {
					console.error(e);
					console.log(data);
				}				
			});

			console.log(postData);

		}, 500);
	}
}