<div class="page-subbody">
	<div class="page_form">
		<form onSubmit="Recovery.reset(); return false">
            <div class="alert text-center error-feedback d-none" role="alert"></div>

			<label>{lang('token', 'recovery')}</label>
			<input type="text" value="{$token}" class="token-input mb-3" required>

			<label>{lang('new_password', 'recovery')}</label>
			<input type="password" class="password-input mb-3"required>

			<input type="submit" value="{lang('reset_password', 'recovery')}" class="nice_button text-center">
		</form>
	</div>
</div>
