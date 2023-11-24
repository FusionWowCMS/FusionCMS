<div class="container">
	<div class="row">
		{$link_active = "security"}
		{include file="../../ucp/views/ucp_navigation.tpl"}
		
		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<div class="section-header">{lang("two_factor", "ucp")}</div>
			<div class="section-body">
				<p>{lang("two_factor_description", "ucp")}</p>
				{if $security_enabled == false}
					<div class="row g-2 mt-2 align-items-center" id="security_help" style="display: none;">
						<p>{lang("two_factor_help", "ucp")}</p>
						<div class="col-md-12 text-center"><img class="mx-auto bg-light qr-two-factor" src="{$qr_code}" alt="{lang("qr_code", "ucp")}"></div>
						<div class="col-md-12"><p class="text-center">{lang("qr_code_help_1", "ucp")} {$secret_key} {lang("qr_code_help_2", "ucp")}</p></div>
					</div>
				{/if}

				<form onSubmit="Security.submit(); return false" class="page_form">
					<div class="row g-2 align-items-center">
						<div class="col-md-12 col-lg-4"><label>{lang("select_authentication", "ucp")}</label></div>
						<div class="col-md-12 col-lg-8">
							<select class="form-select" aria-label="{lang("select_authentication", "ucp")}" name="security_enabled" id="security_enabled" onChange="Security.onChange(this.value)">
								<option value="false" {if $security_enabled == false}selected="selected"{/if}>{lang("disabled", "ucp")}</option>
								<option value="true" {if $security_enabled == true}selected="selected"{/if}>{lang("google_authenticator", "ucp")}</option>
							</select>
						</div>
					</div>

					{if $security_enabled == false}
						<div class="row g-2 mt-2 align-items-center" id="security_code" style="display: none;">
							<div class="col-md-12 col-lg-4"><label for="auth_code">{lang("six_digit_auth_code", "ucp")}</label></div>
							<div class="col-md-12 col-lg-8"><input class="form-control" type="text" id="auth_code" name="auth_code" placeholder="{lang("six_digit_auth_code", "ucp")}"><input type="hidden" id="secret" name="secret" value="{$secret_key}"></div>
						</div>
					{/if}

					<input class="nice_button mt-3" type="submit" value="{lang("save_changes", "ucp")}">

					<div id="security_ajax" class="text-center py-3"></div>
				</form>

			</div>
		</div>
	</div>
</div>