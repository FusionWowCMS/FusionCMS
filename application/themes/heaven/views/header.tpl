<!DOCTYPE html>

<!--

 This website is powered by
  ______         _              _____ __  __  _____
 |  ____|       (_)            / ____|  \/  |/ ____|
 | |__ _   _ ___ _  ___  _ __ | |    | \  / | (___
 |  __| | | / __| |/ _ \| '_ \| |    | |\/| |\___ \
 | |  | |_| \__ \ | (_) | | | | |____| |  | |____) |
 |_|   \__,_|___/_|\___/|_| |_|\_____|_|  |_|_____/

 www.fusion-hub.com

-->

<html dir="{if lang('isRTL', 'theme') === 1}rtl{else}ltr{/if}" lang="{lang('abbreviation', 'main')}">
	<head>
		<title>{$title}</title>
		<link rel="shortcut icon" href="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}{str_replace($full_theme_path, '', $favicon)}" />

		<!-- Responsive meta tag -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

		<!-- Search engine related -->
		<meta charset="UTF-8" />
		<meta name="keywords" content="{$keywords}" />
		<meta name="description" content="{$description}" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<!-- Address bar color -->
		<meta name="theme-color" content="{$theme_configs.config.theme_color}" />

		<!-- Open Graph meta tags -->
		<meta property="og:url" content="{$url}" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="{$title}" />
		<meta property="og:image" content="{$url}application/images/misc/preview-thumbnail.png" />
		<meta property="og:site_name" content="{$serverName}" />
		<meta property="og:description" content="{$description}" />

		<!-- Twitter card meta tags -->
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:site" content="@{$social_media['twitter']}" />
		<meta name="twitter:image" content="{$url}application/images/misc/preview-thumbnail.png" />
		<meta name="twitter:image:alt" content="{$title}" />

		<!-- Load styles -->
		{minify type="css" files=$assets.css.parts.all.files output="{$assets.css.path}{$assets.css.parts.all.name}?v={$theme_configs.config.version}" disable="{$minify_css}"}
		{foreach from=$assets.css.parts.module.files item=file}<link type="text/css" rel="stylesheet" href="{if $cdn_link != false}{str_replace(base_url(), $cdn_link, $file)}{else}{$file}{/if}?v={$theme_configs.config.version}" />{/foreach}

		{if $extra_css}
			{if !is_array($extra_css)}
				<link type="text/css" rel="stylesheet" href="{$path}{$extra_css}?v={$theme_configs.config.version}">
			{else}
				{strip}
					{foreach from=$extra_css item=css}
						<link type="text/css" rel="stylesheet" href="{$path}{$css}?v={$theme_configs.config.version}">
					{/foreach}
				{/strip}
			{/if}
		{/if}

		<!-- Load scripts -->
		{minify type="js" files=$assets.js.parts.all.files output="{$assets.js.path}{$assets.js.parts.all.name}?v={$theme_configs.config.version}" disable="{$minify_js}"}
		{foreach from=$assets.js.parts.module.files item=file}<script type="text/javascript" src="{if $cdn_link != false}{str_replace(base_url(), $cdn_link, $file)}{else}{$file}{/if}?v={$theme_configs.config.version}"></script>{/foreach}

		<!--[if lt IE 9]>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<script type="text/javascript">
			var isIE = isIE();

			var Config = {
				URL: '{$url}',
				CSRF: getCookie('csrf_cookie_name'),
				version: '{$theme_configs.config.version}',
				language: '{$activeLanguage}',
				image_path: '{$MY_image_path}',
				theme_path: '{str_replace(basename($APPPATH)|cat:'/', '', $theme_path)}',
				UseFusionTooltip: true,

				Slider: {
					effect: {($slider_style) ? $slider_style : "''"},
					interval: {$slider_interval}
				}
			};

			$(document).ready(function()
			{
				{* Set client language strings *}
				{if $client_language && $client_language !== 'null'}Language.set('{addslashes($client_language)}');{/if}

				{* Initialize tooltip *}
				Tooltip.initialize();
			});

			{* Initialize UI *}
			UI.initialize();
		</script>

		{if $extra_js}
			{if !is_array($extra_js)}
				<script type="text/javascript" src="{$path}{$extra_js}?v={$theme_configs.config.version}"></script>
			{else}
			    {strip}
			        {foreach from=$extra_js item=js}
			        	<script type="text/javascript" src="{$path}{$js}?v={$theme_configs.config.version}"></script>
			        {/foreach}
			    {/strip}
			{/if}
		{/if}

		{if $analytics}
			<!-- Google tag (gtag.js) -->
			<script async src="https://www.googletagmanager.com/gtag/js?id={$analytics}"></script>

			<script type="text/javascript">
				window.dataLayer = window.dataLayer || [];
				function gtag(){ dataLayer.push(arguments); }
				gtag('js', new Date());

				gtag('config', '{$analytics}');
			</script>
		{/if}
	</head>