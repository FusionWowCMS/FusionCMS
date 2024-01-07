{strip}

<!-- Socials.Start -->
<section class="sidebox social_buttons">
	<h4 class="sidebox_title dotted_separator border_box overflow_ellipsis" title="{preg_replace('/<[^>]*>/', '', sprintf(lang('sidebox_socials_title', 'theme_auzwow'), $CI->config->item('server_name')))}">{sprintf(lang('sidebox_socials_title', 'theme_auzwow'), $CI->config->item('server_name'))}</h4>
	<div class="sidebox_body">
		{if $theme_configs.config.social.facebook.enabled}
			<a href="{$theme_configs.config.social.facebook.link}" target="_blank" class="social_btn facebook_btn anti_blur">
				<div class="social_btn_icon"></div>
				<div class="social_btn_text">{lang('sidebox_socials_facebook', 'theme_auzwow')}</div>
			</a>
		{/if}

		{if $theme_configs.config.social.twitter.enabled}
			<a href="{$theme_configs.config.social.twitter.link}" target="_blank" class="social_btn twitter_btn anti_blur">
				<div class="social_btn_icon"></div>
				<div class="social_btn_text">{lang('sidebox_socials_twitter', 'theme_auzwow')}</div>
			</a>
		{/if}

		{if $theme_configs.config.social.youtube.enabled}
			<a href="{$theme_configs.config.social.youtube.link}" target="_blank" class="social_btn youtube_btn anti_blur">
				<div class="social_btn_icon"></div>
				<div class="social_btn_text">{lang('sidebox_socials_youtube', 'theme_auzwow')}</div>
			</a>
		{/if}
	</div>
</section>
<!-- Socials.End -->

{/strip}