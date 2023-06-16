<div class="page-subbody mt-0">
<div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
    <form onSubmit="Auth.login(true); return false;">
        <div class="card-body">
            <div class="alert alert-danger text-center error-feedback d-none" role="alert"></div>

            <div class="input-group p-0 flex-row">
                <label for="floatingUser" class="input-group-text" id="username" style="width:45px;"><i class="fas fa-user"></i></label>
                <input type="text" class="form-control username-input border-0" id="floatingUser" placeholder="{lang('login_label_user', 'auth')}" aria-describedby="username">
            </div>

            <div class="input-group p-0 mt-3 flex-row">
                <label class="input-group-text cursor-pointer" id="password" style="width:45px;" data-input-id="floatingPassword" data-show="false" onClick="Auth.showPassword(this);"><i class="fas fa-eye-slash"></i></label>
                <input type="password" class="form-control password-input border-0" id="floatingPassword" placeholder="{lang('login_label_password', 'auth')}" aria-describedby="password">
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
                        <input type="text" class="form-control captcha-input border-0 rounded-0 rounded-bottom-end" id="floatingCaptcha" placeholder="{lang('login_label_captcha', 'auth')}" aria-describedby="captcha">
                        <label for="floatingCaptcha">{lang("login_label_captcha", "auth")}</label>
                    </div>
                </div>
            </div>

            <div class="card-links mt-3 d-flex justify-content-between">
                <div class="form-check form-switch">
                    <input class="form-check-input remember-check" type="checkbox" id="checkRemember">
                    <label class="form-check-label" for="checkRemember">{lang("login_label_remember", "auth")}</label>
                </div>

                {if $has_smtp}
                    <a href="{$url}password_recovery" class="card-link">{lang("login_link_password_forgot", "auth")}</a>
                {/if}
            </div>
        </div>
        
        <div class="form-group text-center mt-4">
        <button class="card-footer nice_button">
            {lang("login_button", "auth")}
        </button>
        </div>
    </form>
</div>
</div>

{if $use_captcha && $captcha_type == 'inbuilt'}
<script>
    $(window).on("load", function() {
        Auth.useCaptcha = true;
    });
</script>
{/if}