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

		{minify files=array("application/css/default.css", "application/css/tooltip.css", "application/fonts/fontawesome/v6.6.0/css/all.css", "node_modules/bootstrap/dist/css/bootstrap.min.css", "node_modules/sweetalert2/dist/sweetalert2.min.css", "node_modules/owl.carousel/dist/assets/owl.carousel.min.css", "node_modules/owl.carousel/dist/assets/owl.theme.default.min.css", "{$full_theme_path}vendor/MagnificPopup/css/magnific-popup.css", "{$full_theme_path}assets/css/style.css", "{$full_theme_path}assets/css/custom.css") type='css' output='writable/cache/data/minify/all.min.css' disable={$minify_css}}

		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css">

		{if $extra_css}
			{if !is_array($extra_css)}
				<link type="text/css" rel="stylesheet" href="{$path}{$extra_css}">
			{else}
				{strip}
					{foreach from=$extra_css item=css}
						<link type="text/css" rel="stylesheet" href="{$path}{$css}">
					{/foreach}
				{/strip}
			{/if}
		{/if}

		<!-- Header CSS.End -->

		<!-- Header JS.Start -->
		{minify files=array("application/js/jquery-3.6.0.min.js", "application/js/jquery.placeholder.min.js", "application/js/jquery.sort.js", "node_modules/bootstrap/dist/js/bootstrap.bundle.min.js", "node_modules/sweetalert2/dist/sweetalert2.all.min.js", "node_modules/owl.carousel/dist/owl.carousel.min.js", "{$full_theme_path}vendor/Marquee/jquery.marquee.min.js", "{$full_theme_path}vendor/MagnificPopup/js/jquery.magnific-popup.min.js", "application/js/main.js", "application/js/cookie.js", "{$full_theme_path}assets/js/slider.js", "application/js/ui.js", "application/js/language.js", "application/js/tooltip.js") type='js' output='writable/cache/data/minify/all.min.js' disable={$minify_js}}

		<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>


		<!-- Header JS.End -->

		<!--[if lt IE 9]>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<script type="text/javascript">
			var isIE = isIE();
			var Config = {
				URL: "{$url}",			
				image_path: "{$image_path}",
				CSRF: getCookie('csrf_cookie_name'),
				language: "{$activeLanguage}",
				UseFusionTooltip: true,
				
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
		{if $extra_js}
			{if !is_array($extra_js)}
				<script type="text/javascript" src="{$path}{$extra_js}"></script>
			{else}
			    {strip}
			        {foreach from=$extra_js item=js}
			            <script type="text/javascript" src="{$path}{$js}"></script>
			        {/foreach}
			    {/strip}
			{/if}
		{/if}
	</head>