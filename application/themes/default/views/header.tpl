<!DOCTYPE html>

<!--

 This website is powered by
  ______         _              _____ __  __  _____ 
 |  ____|       (_)            / ____|  \/  |/ ____|
 | |__ _   _ ___ _  ___  _ __ | |    | \  / | (___  
 |  __| | | / __| |/ _ \| '_ \| |    | |\/| |\___ \ 
 | |  | |_| \__ \ | (_) | | | | |____| |  | |____) |
 |_|   \__,_|___/_|\___/|_| |_|\_____|_|  |_|_____/ 

 https://github.com/FusionWowCMS/FusionCMS

-->

<html lang="zxx">
	<head>
		<title>{$title}</title>
		<meta charset="UTF-8">
		<meta name="description" content="{$description}">
		<meta name="keywords" content="{$keywords}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta property="og:title" content="{$title}">
		<meta property="og:type" content="website">
		<meta property="og:image" content="{$url}application/images/misc/preview-thumbnail.png">
		<meta property="og:url" content="{$url}">
		<meta property="og:description" content="{$description}">
		<meta property="og:site_name" content="{$serverName}">
		
		<meta name="twitter:card" content="summary">
		<meta name="twitter:image:alt" content="{$title}">
		<meta name="twitter:image" content="{$url}application/images/misc/preview-thumbnail.png">
		<meta name="twitter:site" content="@{$social_media['twitter']}">

		<link href="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/images/favicon.ico" rel="shortcut icon">

		<!-- Header CSS.Start -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

		{minify files=array("css/default.css", "css/tooltip.css", "vendor/node_modules/bootstrap/dist/css/bootstrap.min.css", "vendor/node_modules/sweetalert2/dist/sweetalert2.min.css", "{$theme_path}vendor/OwlCarousel2/css/owl.carousel.min.css", "{$theme_path}vendor/OwlCarousel2/css/owl.theme.default.min.css", "{$theme_path}vendor/MagnificPopup/css/magnific-popup.css", "{$theme_path}assets/css/style.css", "{$theme_path}assets/css/custom.css") type='css' output='cache/data/minify/all.min.css' disable={$minify_css}}

		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css">

		{if $extra_css}<link rel="stylesheet" href="{$path}{$extra_css}" />{/if}
		{*	{if !is_array($extra_css)}
				<link rel="stylesheet" href="{$path}{$extra_css}">
			{else}
				{strip}
					{foreach from=$extra_css item=css}
						<link rel="stylesheet" href="{$path}{$css}">
					 {/foreach}
				{/strip}
			{/if}
		{/if} *}

		<!-- Header CSS.End -->

		<!-- Header JS.Start -->
		{minify files=array("{$theme_path}assets/js/jquery-3.6.0.min.js", "js/jquery.placeholder.min.js", "js/jquery.sort.js", "vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js", "vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js", "{$theme_path}vendor/Marquee/jquery.marquee.min.js", "{$theme_path}vendor/OwlCarousel2/js/owl.carousel.js", "{$theme_path}vendor/MagnificPopup/js/jquery.magnific-popup.min.js", "js/main.js", "js/cookie.js", "{$theme_path}assets/js/slider.js", "js/ui.js", "js/language.js", "js/tooltip.js") type='js' output='cache/data/minify/all.min.js' disable={$minify_js}}

		<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>

		{if $extra_js}<script type="text/javascript" src="{$path}{$extra_js}"></script>{/if}
		{*	{if !is_array($extra_js)}
				<script type="text/javascript" src="{$path}{$extra_js}"></script>
			{else}
				{strip}
					{foreach from=$extra_js item=js}
						<script type="text/javascript" src="{$path}{$js}"></script>
					 {/foreach}
				{/strip}
			{/if}
		{/if} *}
		
		<!-- Header JS.End -->

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<script type="text/javascript">
			var isIE = isIE();
			var Config = {
				URL: "{$url}",			
				image_path: "{$image_path}",
				CSRF: getCookie('csrf_cookie_name'),
				language: "{$activeLanguage}",
				UseFusionTooltip: 1,
				
				Slider: {
					interval: {$slider_interval},
					effect: {if $slider_style}{$slider_style}{else}""{/if}
					
				}
			};
			
			$(document).ready(function() {
				{if $client_language}Language.set("{addslashes($client_language)}");{/if}
				Tooltip.initialize();
			});
			UI.initialize();
			
			{if $analytics}
				// Google Analytics
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', '{$analytics}']);
				_gaq.push(['_trackPageview']);

				(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			{/if}
		</script>
	</head>