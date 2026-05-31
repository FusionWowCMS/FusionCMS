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
                <div class="mb-3">
                {if $use_captcha}
                    {if $captcha_type == 'image_captcha'}
                        <label for="captcha"><img src="{$url}register/getCaptcha?{time()}" /></label>
                        <input class="form-control" type="text" name="register_captcha" id="register_captcha"/>
                        <span id="captcha_error">{$captcha_error}</span>
                    {elseif $captcha_type == 'recaptcha' || $captcha_type == 'recaptcha3'}
                        <div class="captcha {if $captcha_error && $captcha_type == 'recaptcha'} alert-captcha {/if}">
                            {$recaptcha_html}
                        </div>
                    {elseif $captcha_type == 'fusion_captcha'}
                        <script type="text/javascript" src="{$url}application/js/captcha/cap_widget.min.js"></script>
                        <cap-widget
                                data-cap-api-endpoint="/captcha/"
                                data-cap-hidden-field-name="cap-token"
                                data-cap-background="#1e1e1e"
                                data-cap-color="#f0f0f0"
                                data-cap-direction="{if $isRTL}rtl{else}ltr{/if}"
                                {if $captcha_error}data-cap-error="true"{/if}
                                data-cap-i18n-initial-state="{lang('initial_state', 'captcha')}"
                                data-cap-i18n-verifying-label="{lang('verifying_label', 'captcha')}"
                                data-cap-i18n-solved-label="{lang('solved_label', 'captcha')}"
                                data-cap-i18n-error-label="{lang('error_label', 'captcha')}"
                                data-cap-i18n-wasm-disabled="{lang('wasm_disabled', 'captcha')}"
                                data-cap-i18n-verify-aria-label="{lang('verify_aria_label', 'captcha')}"
                                data-cap-i18n-verifying-aria-label="{lang('verifying_aria_label', 'captcha')}"
                                data-cap-i18n-verified-aria-label="{lang('verified_aria_label', 'captcha')}"
                                data-cap-i18n-error-aria-label="{lang('error_aria_label', 'captcha')}">
                        </cap-widget>
                    {/if}
                {/if}
                </div>
                <div class="form-group text-center mt-4">
                    <button class="card-footer nice_button" type="submit" name="login_submit">{lang("submit", "register")}</button>
                </div>
            {form_close()}
        </div>
    </div>
</div>