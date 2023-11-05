{if $theme_configs.config.banners.enabled && (($theme_configs.config.banners.visibility == 'home' && $isHomePage) || ($theme_configs.config.banners.visibility == 'always'))}
	<!-- Featured banner.Start -->
	<div class="col-md-12 col-lg-6" featured-banner>
		<div class="featured-banner">
			<h3 class="banner-title text-ellipsis" title="{langColumn($theme_configs.config.banners.banner_01.title)}">{formatTitle title=langColumn($theme_configs.config.banners.banner_01.title)}</h3>
			<time class="banner-date" datetime="{$theme_configs.config.banners.banner_01.date}" title="{$theme_configs.config.banners.banner_01.date}">{$theme_configs.config.banners.banner_01.date}</time>
			<p class="banner-desc">{langColumn($theme_configs.config.banners.banner_01.text)}</p>
			{if $theme_configs.config.banners.banner_01.link}<div class="banner-readmore"><a href="{$theme_configs.config.banners.banner_01.link}" class="btn-blue" title="{lang('general_readMore', 'theme')}">{lang('general_readMore', 'theme')}</a></div>{/if}
		</div>
	</div>

	<div class="col-md-12 col-lg-6" featured-banner>
		<div class="featured-banner">
			<h3 class="banner-title text-ellipsis" title="{langColumn($theme_configs.config.banners.banner_02.title)}">{formatTitle title=langColumn($theme_configs.config.banners.banner_02.title)}</h3>
			<time class="banner-date" datetime="{$theme_configs.config.banners.banner_02.date}" title="{$theme_configs.config.banners.banner_02.date}">{$theme_configs.config.banners.banner_02.date}</time>
			<p class="banner-desc">{langColumn($theme_configs.config.banners.banner_02.text)}</p>
			{if $theme_configs.config.banners.banner_02.link}<div class="banner-readmore"><a href="{$theme_configs.config.banners.banner_02.link}" class="btn-blue" title="{lang('general_readMore', 'theme')}">{lang('general_readMore', 'theme')}</a></div>{/if}
		</div>
	</div>
	<!-- Featured banner.End -->
{/if}