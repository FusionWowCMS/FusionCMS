<!DOCTYPE html>

<!--
This website is powered by FusionGEN

https://github.com/FusionGen/FusionGen

Current FusionGEN Version: {$CI->config->item('FusionGENVersion')}
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
		
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Bootstrap/5.1.3/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Sweetalert2/11.4.8/css/sweetalert2.min.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/AnimateCSS/4.1.1/animate.min.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/OwlCarousel2/css/owl.carousel.min.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/OwlCarousel2/css/owl.theme.default.min.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/MagnificPopup/css/magnific-popup.css">
		<link rel="stylesheet" href="{$url}application/css/default.css">
		<link rel="stylesheet" href="{$url}application/css/tooltip.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/css/style.css">
		<link rel="stylesheet" href="{$full_theme_path}assets/css/custom.css">
		
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
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/js/jquery-3.6.0.min.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/js/jquery.placeholder.min.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/js/jquery.sort.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Sweetalert2/11.4.8/js/sweetalert2.all.min.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Marquee/jquery.marquee.min.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/OwlCarousel2/js/owl.carousel.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/MagnificPopup/js/jquery.magnific-popup.min.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/js/main.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/js/cookie.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/js/slider.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/js/ui.js"></script>	
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/js/language.js"></script>
		<script type="text/javascript" src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/js/tooltip.js"></script>
			
		
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
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css">

		<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
		
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