<div class="row g-0">
	<div class="col-md-12 col-lg-5" col-l>
		<div class="register-banner">
			<a href="{$url}login" class="btn-gray" title="{lang('login', 'main')}">{lang('login', 'main')}</a>
		</div>
	</div>

	<div class="col-md-12 col-lg-7" col-r>
		<div class="register-content">
			<h3 class="register-title" title="{lang('register', 'register')}">{lang('register', 'register')}</h3>

			{form_open('register')}
				<div class="form-group">
					<input type="text" name="register_username" id="register_username" class="form-control" value="{set_value('register_username')}" placeholder="{lang('username', 'register')}" onChange="Validate.checkUsername()" />
					<span id="username_error">{$username_error}</span>
				</div>

				<div class="form-group mt-3">
					<input type="email" name="register_email" id="register_email" class="form-control" value="{set_value('register_email')}" placeholder="{lang('email', 'register')}" onChange="Validate.checkEmail()" />
					<span id="email_error">{$email_error}</span>
				</div>

				<div class="form-group mt-3">
					<input type="password" name="register_password" id="register_password" class="form-control" value="{set_value('register_password')}" placeholder="{lang('password', 'register')}" onChange="Validate.checkPassword()" />
					<span id="password_error">{$password_error}</span>
				</div>

				<div class="form-group mt-3">
					<input type="password" name="register_password_confirm" id="register_password_confirm" class="form-control" value="{set_value('register_password_confirm')}" placeholder="{lang('confirm', 'register')}" onChange="Validate.checkPasswordConfirm()" />
					<span id="password_confirm_error">{$password_confirm_error}</span>
				</div>

				{if $use_captcha}
					<div class="form-group mt-3">
						{if $captcha_type == 'inbuilt'}
							<input type="text" name="register_captcha" id="register_captcha" class="form-control" value="" placeholder="{lang('login_label_captcha', 'sidebox_info_login')}" />
							<img width="150" height="30" alt="{lang('login_label_captcha', 'sidebox_info_login')}" src="{$url}register/getCaptcha?{time()}" />
							<span id="captcha_error">{$captcha_error}</span>
						{elseif $captcha_type == 'recaptcha' || $captcha_type == 'recaptcha3'}
							<div class="captcha {if $captcha_error}alert-captcha{/if}">
								{$recaptcha_html}
							</div>
						{/if}
					</div>
				{/if}

				<div class="form-group mt-5">
					<button type="submit" name="login_submit" class="btn-blue d-block w-100">{lang('submit', 'register')}</button>
				</div>
			{form_close()}
		</div>
	</div>
</div>