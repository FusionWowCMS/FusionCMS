<!-- Templates.Start -->
{if !$CI->user->isOnline()}
	<login-template hidden>
		<form onKeyUp="Popup.login(); return false;" onSubmit="Popup.login(true); return false;">
			<div class="card-body">	
				<div class="input-group p-0 flex-row">
					<label for="floatingUser2" class="input-group-text" id="username" style="width:40px;"><i class="fa-duotone fa-user"></i></label>
					<input type="text" class="form-control username-input2 border-0" id="floatingUser2" placeholder="Username" aria-describedby="username">
				</div>
				
				<div class="username-feedback2 ps-2"></div>
				
				<div class="input-group p-0 mt-3 flex-row">
					<label class="input-group-text cursor-pointer" id="password" style="width:40px;" data-input-id="floatingPassword2" data-show="false" onClick="Popup.showPassword(this);"><i class="fa-duotone fa-eye-slash"></i></label>
					<input type="password" class="form-control password-input2 border-0" id="floatingPassword2" placeholder="Password" aria-describedby="password">
				</div>
				
				<div class="password-feedback2 ps-2"></div>
		
				
				<div class="captcha-field2 {if !$use_captcha && $captcha_type == 'inbuilt'}d-none{/if}">
					<div class="input-group mt-3">
						<label for="floatingCaptcha2" class="input-group-text w-100 rounded-0 rounded-top text-center d-block" id="captcha">
							<img src="{$url}auth/getCaptcha?{time()}" alt="captcha" width="150" height="30" id="captchaImage2">
						</label>
		
						<span class="input-group-text cursor-pointer ms-0 rounded-0 rounded-bottom-start" id="captcha" style="width:40px;" data-captcha-id="captchaImage2" onClick="Popup.refreshCaptcha(this);">
							<i class="fa-duotone fa-rotate"></i>
						</span>
		
						<div class="form-floating ms-0 flex-grow-1">
							<input type="text" class="form-control captcha-input2 border-0 rounded-0 rounded-bottom-end" id="floatingCaptcha2" placeholder="Captcha" aria-describedby="captcha">
							<label for="floatingCaptcha2">{lang("Captcha", "default")}</label>
						</div>
					</div>
		
					<div class="captcha-feedback2 ps-2"></div>
				</div>
				
				
				<div class="card-links mt-3 d-flex justify-content-between">
					<div class="form-check form-switch">
						<input class="form-check-input remember-check2" type="checkbox" id="checkRemember2">
						<label class="form-check-label" for="checkRemember2">{lang("Remember", "default")}</label>
					</div>
					
					<a href="{$url}password_recovery" class="card-link">{lang("ForgotPassword", "default")}</a>
				</div>
				
			</div>
			
			<div class="form-group text-center mt-4">
			<button class="card-footer nice_button">
				{lang("SignIn", "default")}
			</button>
			</div>
		</form>
	</login-template>
{/if}
<!-- Templates.End -->

<!-- Popup background -->
<div id="popup_bg"></div>

<!-- Confirm box -->
<div id="confirm" class="popup-box confirm-box v-center popup-login" style="display:none">
	<div id="confirm_question" class="popup-content"></div>

	<div class="popup-links">
		<a href="javascript:void(0)" id="confirm_button" class="popup-link nice_button"></a>
		<a href="javascript:void(0)" id="confirm_hide" class="popup-link nice_button" onClick="UI.hidePopup()">{lang("Cancel", "default")}</a>
	</div>
</div>

<!-- Alert box -->
<div id="alert" class="popup-box alert-box v-center" style="display:none">
	<div id="alert_message" class="popup-content"></div>
</div>

{if $vote_reminder}
	<!-- Vote reminder popup -->
	<div id="vote_reminder">
		<a href="{$url}vote"><img width="" height="" alt="" src="{$vote_reminder_image}" /></a>
	</div>
{/if}