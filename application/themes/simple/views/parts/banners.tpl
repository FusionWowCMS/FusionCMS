<!-- Banners.Start -->
<div class="banners">
	<div class="banner banner-1">
		<div class="flex-row flex-row-1">
			<div class="flex-col flex-col-1">
				{if $isOnline}
					<a href="{$url}ucp" class="nice_button type-special" title="{lang('account', 'theme')}">{lang('account', 'theme')}</a>
				{else}
					<a href="{$url}register" class="nice_button type-special" title="{lang('register', 'theme')}">{lang('register', 'theme')}</a>
				{/if}
			</div>

			<div class="flex-col flex-col-2">
				<div class="banner-text banner-text-1" title="{sprintf(lang('banner01_text01', 'theme'), $serverName)}">{sprintf(lang('banner01_text01', 'theme'), '<strong>'|cat:$serverName|cat:'</strong>')}</div>
			</div>
		</div>

		<div class="flex-row flex-row-2">
			<div class="flex-col">
				<div class="banner-text banner-text-2" title="{lang('banner01_text02', 'theme')}">{lang('banner01_text02', 'theme')}</div>
			</div>
		</div>
	</div>

	<div class="banner banner-2">
		<div class="flex-row flex-row-1">
			<div class="flex-col">
				<div class="banner-text banner-text-1">{lang('banner02_text01', 'theme')}</div>
			</div>
		</div>

		<div class="flex-row flex-row-2">
			<div class="flex-col">
				<div class="banner-text banner-text-2">{lang('banner02_text02', 'theme')}</div>
			</div>
		</div>

		<div class="flex-row flex-row-3">
			<div class="flex-col">
				<div class="banner-text banner-text-3">{lang('banner02_text03', 'theme')}</div>
			</div>
		</div>

		<div class="flex-row flex-row-4">
			<div class="flex-col">
				<div class="banner-text banner-text-4">{lang('banner02_text04', 'theme')}</div>
			</div>
		</div>

		<a href="{$url}page/connect" class="banner-link" title="{lang('banner02_text01', 'theme')} {lang('banner02_text02', 'theme')} {lang('banner02_text03', 'theme')} ({lang('banner02_text04', 'theme')})"></a>
	</div>

	<div class="simple_border type-2"></div>
</div>
<!-- Banners.End -->