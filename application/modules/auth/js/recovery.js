var Recovery = {	
	timeout: null,
	useCaptcha: false,
	useRecaptcha: false,

	request: function() {
		var postData = {
			"email": $(".email-input").val(),
			"captcha": $(".captcha-input").val(),
		};

		var fields = [
			"email"
		];

		if(Recovery.useCaptcha) {
			fields.push("captcha");
		}

		if(Recovery.useRecaptcha) {
			postData["recaptcha"] = grecaptcha.getResponse();
		}

		clearTimeout (Recovery.timeout);
		Recovery.timeout = setTimeout (function()
		{
			$.post(Config.URL + "password_recovery/create_request", postData, function(data) {
				try {
					data = JSON.parse(data);

					if(data["showCaptcha"] === true) {
						$(".captcha-field").removeClass("d-none");
					}

					for(var i = 0; i<fields.length;i++)
                    {
						if(data["messages"]["error"] != "")
                        {
							$(".email-input, .captcha-input").parents(".input-group").addClass("border border-danger");
							$(".email-input, .captcha-input").addClass("is-invalid");
							$(".error-feedback").addClass("invalid-feedback d-block").removeClass("d-none").html(data["messages"]["error"]);
						}
					}

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
	},

	refreshCaptcha: function(ele) {
		$(".captcha-input").val('');
		$(".captcha-input").focus();
		var captchaID = $(ele).data("captcha-id");
		var imgField = $("img#"+ captchaID);
		imgField.attr("src", imgField.attr("src") +"&d="+ new Date().getTime());
	}
}