<form onSubmit="Auth.login(true); return false;">
    <div class="card-body">
        <div class="alert alert-danger text-center error-feedback d-none" role="alert"></div>

        <div class="input-group p-0 flex-row">
            <label for="floatingUser" class="input-group-text" id="username" style="width:45px;"><i class="fas fa-user"></i></label>
            <input type="text" class="form-control username-input border-0" id="floatingUser" placeholder="{lang('login_label_user', 'sidebox_info_login')}" aria-describedby="username">
        </div>

        <div class="input-group p-0 mt-3 flex-row">
            <label class="input-group-text cursor-pointer" id="password" style="width:45px;" data-input-id="floatingPassword" data-show="false" onClick="Auth.showPassword(this);"><i class="fas fa-eye-slash"></i></label>
            <input type="password" class="form-control password-input border-0" id="floatingPassword" placeholder="{lang('login_label_password', 'sidebox_info_login')}" aria-describedby="password">
        </div>

        <div class="captcha-field {if !$use_captcha}d-none{/if}">
            <div class="input-group mt-3">
                <label for="floatingCaptcha" class="input-group-text w-100 rounded-0 rounded-top text-center d-block" id="captcha">
                    <img src="{$url}auth/getCaptcha?{time()}" alt="captcha" width="150" height="30" id="captchaImage">
                </label>

                <span class="input-group-text cursor-pointer ms-0 rounded-0 rounded-bottom-start" id="captcha" style="width:40px;" data-captcha-id="captchaImage" onClick="Auth.refreshCaptcha(this);">
                    <i class="fas fa-rotate"></i>
                </span>

                <div class="form-floating ms-0 flex-grow-1">
                    <input type="text" class="form-control captcha-input border-0 rounded-0 rounded-bottom-end" id="floatingCaptcha" placeholder="{lang('login_label_captcha', 'sidebox_info_login')}" aria-describedby="captcha">
                    <label for="floatingCaptcha">{lang("login_label_captcha", "sidebox_info_login")}</label>
                </div>
            </div>
        </div>

        <div class="card-links mt-3 d-flex justify-content-between">
            <div class="form-check form-switch">
                <input class="form-check-input remember-check" type="checkbox" id="checkRemember">
                <label class="form-check-label" for="checkRemember">{lang("login_label_remember", "sidebox_info_login")}</label>
            </div>

            {if $has_smtp}
                <a href="{$url}password_recovery" class="card-link">{lang("login_link_password_forgot", "sidebox_info_login")}</a>
            {/if}
        </div>
    </div>
    
    <div class="form-group text-center mt-4">
    <button class="card-footer nice_button">
        {lang("login_button", "sidebox_info_login")}
    </button>
    </div>
</form>

<script>
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
</script>