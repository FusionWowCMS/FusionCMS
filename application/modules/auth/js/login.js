var Auth = {
	timeout: null,
	useCaptcha: false,

	login: function(submit = false) {
		var postData = {
			"username": $(".username-input").val(),
			"password": $(".password-input").val(),
			"remember": $(".remember-check").is(":checked"),
			"captcha": $(".captcha-input").val(),
			"submit": submit,
			"csrf_token_name": Config.CSRF,
			"token": Config.CSRF
		};

		var fields = [
			"username", "password"
		];

		if(Auth.useCaptcha) {
			fields.push("captcha");
		}

		console.log("fields", fields);

		clearTimeout (Auth.timeout);
		Auth.timeout = setTimeout (function()
		{
			$.post(Config.URL + "auth/checkLogin", postData, function(data) {
				try {
					data = JSON.parse(data);
					console.log(data);

					if(data["redirect"] === true) {
						window.location.href = Config.URL + "ucp";
						return;
					}

					if(data["showCaptcha"] === true) {
						$(".captcha-field").removeClass("d-none");
					}

					for(var i = 0; i<fields.length;i++)
                    {
						if(data["messages"]["error"] != "")
                        {
							$(".username-input, .password-input, .captcha-input").parents(".input-group").addClass("border border-danger");
							$(".username-input, .password-input, .captcha-input").addClass("is-invalid");
							$(".error-feedback").addClass("invalid-feedback d-block").removeClass("d-none").html(data["messages"]["error"]);
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

	showPassword: function(ele) {
		if($(ele).data("show") == true) {
			$(ele).html('<i class="fas fa-eye-slash"></i>');
			$(ele).data("show", false);

			$("input#"+ $(ele).data("input-id")).attr("type", "password");
		} else if($(ele).data("show") == false) {
			$(ele).html('<i class="fas fa-eye"></i>');
			$(ele).data("show", true);
			
			$("input#"+ $(ele).data("input-id")).attr("type", "text");
		}
		
	},

	refreshCaptcha: function(ele) {
		$(".captcha-input").val('');
		$(".captcha-input").focus();
		var captchaID = $(ele).data("captcha-id");
		var imgField = $("img#"+ captchaID);
		imgField.attr("src", imgField.attr("src") +"&d="+ new Date().getTime());
	}
};