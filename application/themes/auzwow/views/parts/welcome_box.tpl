{strip}

<!-- Welcome.Start -->
<div id="welcome_box" class="welcome_box border_box">
	<h3 class="welcome_title overflow_ellipsis" title="{preg_replace('/<[^>]*>/', '', sprintf(lang('welcome_title', 'theme_auzwow'), $CI->config->item('server_name')))}">{sprintf(lang('welcome_title', 'theme_auzwow'), $CI->config->item('server_name'))}</h3>

	<div class="welcome_content">
		<p>{langColumn($theme_configs.config.welcome_box.text)}</p>
	</div>

	<div class="welcome_actions self_clear">
		{if $isOnline}
			<div class="welcome_col">
				<a href="{$url}logout" class="nice_button">{lang('welcome_btn_1', 'theme_auzwow')}</a>
				<a href="{$url}ucp" class="nice_button nice_active_2">{lang('welcome_btn_2', 'theme_auzwow')}</a>
			</div>

			<div class="welcome_col">
				<a href="{$url}page/connect" class="u_link">{lang('welcome_link_1', 'theme_auzwow')}</a><br />
				<a href="{$url}" class="u_link">{lang('welcome_link_2', 'theme_auzwow')}</a>
			</div>
		{else}
			<div class="welcome_col">
				<a href="{$url}login" class="nice_button">{lang('nlwelcome_btn_1', 'theme_auzwow')}</a>
				<a href="{$url}register" class="nice_button nice_active_2">{lang('nlwelcome_btn_2', 'theme_auzwow')}</a>
			</div>

			<div class="welcome_col">
				<a href="{$url}page/connect" class="u_link">{lang('nlwelcome_link_1', 'theme_auzwow')}</a><br />
				<a href="{$url}password_recovery" class="u_link">{lang('nlwelcome_link_2', 'theme_auzwow')}</a>
			</div>
		{/if}
	</div>
</div>
<!-- Welcome.End -->

{/strip}