<div class="page-subbody">
    <div class="page_form text-center">
        <form onSubmit="Security.submit(); return false">
            <div class="alert text-center error-feedback d-none" role="alert"></div>

            <label class="mb-5">{lang('digital_code', 'security')}</label>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 mb-5">
                    <div class="otp" id="otp" name="otp">
                        <input type="tel" name="pass[]" min="0" max="9" maxlength="1" pattern="[0-9]" autocomplete="off" required autofocus>
                        <input type="tel" name="pass[]" min="0" max="9" maxlength="1" pattern="[0-9]" autocomplete="off" required>
                        <input type="tel" name="pass[]" min="0" max="9" maxlength="1" pattern="[0-9]" autocomplete="off" required>
                        <input type="tel" name="pass[]" min="0" max="9" maxlength="1" pattern="[0-9]" autocomplete="off" required>
                        <input type="tel" name="pass[]" min="0" max="9" maxlength="1" pattern="[0-9]" autocomplete="off" required>
                        <input type="tel" name="pass[]" min="0" max="9" maxlength="1" pattern="[0-9]" autocomplete="off" required>
                    </div>
                </div>
                <p class="security_ajax" style="display: none;"></p>
            </div>

            <input type="submit" value="{lang('log_in', 'auth')}" class="nice_button text-center">
        </form>
    </div>
</div>
