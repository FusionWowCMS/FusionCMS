<style>
input + span[id] {
    top: unset;
}
</style>

<div class="page-subbody mt-0">
	<div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
			<div class="card-body p-5">
			{form_open('register')}
			
			<div class="mb-3">
			<label for="register_username">{lang("username", "register")}</label>
				<input class="form-control" type="text" name="register_username" id="register_username" autocomplete="username" value="{set_value('register_username')}" onChange="Validate.checkUsername()"/>
			<span id="username_error">{$username_error}</span>
			</div>
	
			<div class="mb-3">
			<label for="register_email">{lang("email", "register")}</label>
				<input class="form-control" type="email" name="register_email" id="register_email" value="{set_value('register_email')}" onChange="Validate.checkEmail()"/>
			<span id="email_error">{$email_error}</span>
			</div>
	
			<div class="mb-3">
			<label for="register_password">{lang("password", "register")}</label>
				<input class="form-control" type="password" name="register_password" id="register_password" autocomplete="new-password" value="{set_value('register_password')}" onChange="Validate.checkPassword()"/>
			<span id="password_error">{$password_error}</span>
			</div>
	
			<div class="mb-3">
			<label for="register_password_confirm">{lang("confirm", "register")}</label>
				<input class="form-control" type="password" name="register_password_confirm" autocomplete="new-password" id="register_password_confirm" value="{set_value('register_password_confirm')}" onChange="Validate.checkPasswordConfirm()"/>
			<span id="password_confirm_error">{$password_confirm_error}</span>
			</div>
	
			{if $use_captcha && $captcha_type == 'inbuilt'}
				<label for="captcha"><img src="{$url}register/getCaptcha?{time()}" /></label>
	
				<input class="form-control" type="text" name="register_captcha" id="register_captcha"/>
	
				<span id="captcha_error">{$captcha_error}</span>
			{/if}

		<div class="form-group text-center mt-4">
			<button class="card-footer nice_button" type="submit" name="login_submit">{lang("submit", "register")}</button>
		</div>

{form_close()}