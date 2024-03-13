<div class="page-subbody">
	<div class="page_form">
		<h4 class="font-weight-semibold text-uppercase mb-0">{lang('lost_password', 'recovery')}</h4>
		<p class="text-2 opacity-7">{lang('enter_your_email', 'recovery')}</p>
		<form onSubmit="Recovery.request(); return false">
			<div class="alert text-center error-feedback d-none" role="alert"></div>

			<label>{lang('email', 'recovery')}</label>
			<input type="email" class="email-input mb-3" required>

            <div class="captcha-field {if !$use_captcha}d-none{/if}">
                <div class="input-group mt-3 mb-3">
                    {if $captcha_type == 'inbuilt'}
                        <label for="floatingCaptcha" class="input-group-text w-100 rounded-0 rounded-top text-center d-block" id="captcha">
                            <img src="{$url}auth/getCaptcha?{time()}" alt="captcha" width="150" height="30" id="captchaImage">
                        </label>

                        <span class="input-group-text cursor-pointer ms-0 rounded-0 rounded-bottom-start" id="captcha" style="width:40px;" data-captcha-id="captchaImage" onClick="Recovery.refreshCaptcha(this);">
                            <i class="fa-duotone fa-rotate"></i>
                        </span>

                        <div class="form-floating ms-0 flex-grow-1">
                            <input type="text" class="form-control captcha-input border-0 rounded-0 rounded-bottom-end" id="floatingCaptcha" placeholder="{lang('login_label_captcha', 'auth')}" aria-describedby="captcha">
                            <label for="floatingCaptcha">{lang("login_label_captcha", "auth")}</label>
                        </div>
                    {elseif $captcha_type == 'recaptcha' || $captcha_type == 'recaptcha3'}
                        <div class="captcha">
                            {$recaptcha_html}
                        </div>
                    {/if}
                </div>
            </div>

			<input type="submit" value="{lang('recover', 'recovery')}" class="nice_button text-center">
		</form>
	</div>
</div>

{if $use_captcha}
    {if $captcha_type == 'inbuilt'}
        <script>
            $(window).on("load", function() {
                Recovery.useCaptcha = true;
            });
        </script>
    {elseif $captcha_type == 'recaptcha'}
        <script>
            $(window).on("load", function() {
                Recovery.useRecaptcha = true;
            });
        </script>
    {elseif $captcha_type == 'recaptcha3'}
        <script>
            $(window).on("load", function() {
                Recovery.useRecaptcha3 = true;
            });
        </script>
    {/if}
{/if}