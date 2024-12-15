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

<html>
	<head>
		<title>{$title}</title>

		<link rel="shortcut icon" href="{$favicon}" />

		<!-- Search engine related -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="{$description}" />
		<meta name="keywords" content="{$keywords}" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<!-- Header CSS.Start -->
		<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" />
		{minify files=array("application/css/default.css", "application/css/tooltip.css", "node_modules/bootstrap/dist/css/bootstrap.min.css", "node_modules/sweetalert2/dist/sweetalert2.min.css", "node_modules/owl.carousel/dist/assets/owl.carousel.min.css", "node_modules/owl.carousel/dist/assets/owl.theme.default.min.css", "{$APPPATH}{$theme_path}css/cms.css", "{$APPPATH}{$theme_path}css/main.css") type='css' output='writable/cache/data/minify/all.min.css' disable={$minify_css}}
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
		{minify files=array("application/js/jquery.min.js", "application/js/jquery.placeholder.min.js", "application/js/jquery.transit.min.js", "application/js/jquery.sort.js", "node_modules/bootstrap/dist/js/bootstrap.bundle.min.js", "node_modules/sweetalert2/dist/sweetalert2.all.min.js", "node_modules/owl.carousel/dist/owl.carousel.min.js", "application/js/main.js", "application/js/cookie.js", "application/js/ui.js", "application/js/language.js", "application/js/tooltip.js") type='js' output='writable/cache/data/minify/all.min.js' disable={$minify_js}}

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
					effect: "{$slider_style}",
					id: "{$slider_id}"
				},

				voteReminder: {if $vote_reminder}1{else}0{/if},

				Theme: {
					next: "{$slider.next}",
					previous: "{$slider.previous}"
				}
			};

			$(document).ready(function() {
				{if $client_language}Language.set("{addslashes($client_language)}");{/if}
				Tooltip.initialize();
			});
			UI.initialize();
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

		{if $analytics}
		<script type="text/javascript">
		// Google Analytics
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '{$analytics}']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

		</script>
		{/if}

	</head>