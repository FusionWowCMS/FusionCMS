<!DOCTYPE html>
<html>
	<head>
		<title>{if $title}{$title}{/if}{$serverName}</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.gstatic.com/">
        <link rel="preload" as="style" onload="this.rel='stylesheet'" href="https://fonts.googleapis.com/css2?family=Roboto%20Flex&amp;family=Inter&amp;family=Karla&amp;family=Fira%20Code&amp;display=swap">
        <link rel="icon" type="image/png" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/images/favicon.png">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@cssninjaStudio">
        <meta name="og:image:type" content="image/png">
        <meta name="og:image:width" content="1200">
        <meta name="og:image:height" content="630">
        <meta name="og:image" content="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/images/fusionico.png">
        <meta property="og:url" content="{$url}">
        <meta property="og:locale" content="en">
        <meta property="og:site_name" content="{if $title}{$title}{/if}{$serverName}">
        <meta name="description" content="Admin Panel {$serverName}">
        <meta property="og:description" content="Admin Panel {$serverName}">
        <meta property="og:type" content="website">
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
        <meta property="og:title" content="{$serverName}">
		
		<link rel="shortcut icon" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/images/fusionico.png">

		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/animate/animate.compat.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/fonts/fontawesome/v6.6.0/css/all.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/magnific-popup/magnific-popup.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/owl.carousel/assets/owl.carousel.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/owl.carousel/assets/owl.theme.default.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery-ui/jquery-ui.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery-ui/jquery-ui.theme.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/morris/morris.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/sweetalert2/css/sweetalert2-dark.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/select2/css/select2.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/datatables/media/css/dataTables.bootstrap5.min.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/codemirror/lib/codemirror.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/codemirror/theme/ayu-mirage.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/imagesloader/jquery.imagesloader.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/dropzone/basic.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/dropzone/dropzone.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/css/theme.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/css/custom.css">
		{if $extra_css}<link rel="stylesheet" href="{$url}application/{$extra_css}" type="text/css">{/if}

		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery/jquery.min.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/modernizr/modernizr.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/common/common.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery-ui/jquery-ui.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/intercooler-js/intercooler.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/bootstrapv5-multiselect/js/bootstrap-multiselect.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/flot/jquery.flot.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/flot.tooltip/jquery.flot.tooltip.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/raphael/raphael.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/morris/morris.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/gauge/gauge.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/snap.svg/snap.svg.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/owl.carousel/owl.carousel.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/sweetalert2/js/sweetalert2.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/select2/js/select2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/fuelux/js/spinner.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/codemirror/lib/codemirror.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/codemirror/addon/selection/active-line.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/codemirror/addon/edit/matchbrackets.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/codemirror/mode/javascript/javascript.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/codemirror/mode/xml/xml.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/codemirror/mode/css/css.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery-idletimer/idle-timer.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/dropzone/dropzone.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/js/theme.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/imagesloader/jquery.imagesloader-1.0.1.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/js/custom.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/apexcharts/apexcharts.min.js"></script>

		<script type="text/javascript">
		function getCookie(c_name) {
			var i, x, y, ARRcookies = document.cookie.split(";");

			for(i = 0; i < ARRcookies.length;i++) {
				x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
				y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
				x = x.replace(/^\s+|\s+$/g,"");
				
				if(x == c_name) {
					return unescape(y);
				}
			}
		}

		var Config = {
			URL: "{$url}",
			CSRF: getCookie('csrf_cookie_name'),
			isACP: true,
			defaultLanguage: "{$defaultLanguage}",
			languages: [ {foreach from=$languages item=language}"{$language}",{/foreach} ]
		};
	</script>

	<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/js/router.js"></script>
	<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/js/adminMenu.js"></script>
	<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/js/mli.js"></script>
	<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/js/login.js"></script>
	<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/js/require.js" type="text/javascript"></script>
	<script type="text/javascript">
		var scripts = [
			"{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/js/jquery.placeholder.min.js",
			"{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/js/jquery.transit.min.js"
			{if $extra_js},"{$url}application/{$extra_js}"{/if}
		];
			require(scripts, function()
		{
			$(document).ready(function()
			{
				{if $extra_css}
					Router.loadedCSS.push("{$extra_css}");
				{/if}
				{if $extra_js}
					Router.loadedJS.push("{$extra_js}");
				{/if}

				$('[data-bs-toggle=tooltip],[rel=tooltip]').tooltip({ container: 'body' });
				$(".nano").nanoScroller();
				$(".nano-pane").show();
			});
		});
	</script>
	<script type="text/javascript">let theme=localStorage.getItem("mode")||" dark";document.documentElement.classList.add(theme);</script>

    <link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/css/layouts/layout.css">
	</head>
    <body class="">
        <div class="bg-muted-100 dark:bg-muted-900 pb-20">
			<div class="dark:bg-muted-800 border-muted-200 dark:border-muted-700 fixed left-0 top-0 z-[60] flex h-full flex-col border-r bg-white transition-all duration-300 w-[280px] lg:translate-x-0" __sidebar__>
				<div class="flex h-16 w-full items-center justify-between px-6">
					<img src="{$url}application/themes/admin/assets/images/fusion.svg" class="fusion-logo mt-4"/>
					<button type="button" class="nui-mask nui-mask-blob hover:bg-muted-200 dark:hover:bg-muted-800 text-muted-700 dark:text-muted-400 flex h-10 w-10 cursor-pointer items-center justify-center transition-colors duration-300 lg:hidden" __sidebartogglermobile__>
						<svg data-v-cd102a71="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" width="1em" height="1em" viewBox="0 0 24 24">
							<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7l-7-7l7-7"></path>
						</svg>
					</button>
				</div>
				<div class="slimscroll relative w-full grow overflow-y-auto py-6 px-6">
					<ul id="sidebar-menu" class="space-y-2">
						<li>
							<a href="{$url}admin" class="nui-focus text-muted-500 dark:text-muted-400/80 hover:bg-muted-100 dark:hover:bg-muted-700/60 hover:text-muted-600 dark:hover:text-muted-200 flex cursor-pointer items-center gap-4 rounded-lg py-3 transition-colors duration-300 px-4">
								<i class="fa-duotone fa-home {if $current_page == "admin"}text-primary-500{/if}"></i>
								<span class="whitespace-nowrap font-sans text-sm block {if $current_page == "admin"}text-primary-500{/if}">Dashboard</span>
							</a>
						</li>
						
						{foreach from=$menu item=group key=text}
						{if count($group.links)}
						<li>
							<div class="group">
                                <button onclick="AdminMenu.openSection({$group.nr})" nr="{$group.nr}" class="nui-focus text-muted-500 dark:text-muted-400/80 hover:bg-muted-100 dark:hover:bg-muted-700/60 hover:text-muted-600 dark:hover:text-muted-200 flex w-full cursor-pointer items-center rounded-lg py-3 transition-colors duration-300 gap-4 px-4 {if isset($group.active)}open{/if}">
                                    <i class="fa-duotone fa-{$group.icon} {if isset($group.active)}text-primary-500{/if}" aria-hidden="true"></i>
                                    <span class="block whitespace-nowrap font-sans text-sm {if isset($group.active)}text-primary-500{/if} block">{$text}</span>
                                    <span class="ms-auto items-center justify-center flex">
                                        
                                        <svg data-v-cd102a71="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-4 w-4 transition-transform duration-200 {if !isset($group.active)}rotate-180{/if}" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m18 15l-6-6l-6 6"></path>
                                        </svg>
                                    </span>
                                </button>
                                <ul class="border-muted-200 relative block ps-4 after:border-muted-200 max-h-max opacity-100" nr="{$group.nr}" {if !isset($group.active)}style="display: none;"{/if}>
                                    {foreach from=$group.links item=link}
                                    <li class="border-muted-300 dark:border-muted-700 border-s-2 first:mt-2">
                                        <a aria-current="page" href="{$url}{$link.module}/{$link.controller}" class="{if isset($link.active)}router-link-active !border-primary-500 !text-primary-500 dark:!text-primary-500 -left-0.5 {/if} nui-focus text-muted-500 hover:text-muted-600 dark:text-muted-400/80 dark:hover:text-muted-200 relative flex cursor-pointer items-center gap-2 border-s-2 border-transparent py-2 ps-4 transition-colors duration-300">
                                            <i class="fa-duotone fa-{$link.icon}"></i>
                                            <span class="whitespace-nowrap font-sans text-[0.85rem] block">{$link.text}</span>
                                        </a>
                                    </li>
                                    {/foreach}
                                </ul>
							</div>
						</li>
						{/if}
						{/foreach}

						{if hasPermission("toggleModules", "admin")}
						<li>
							<a href="{$url}admin/modules" class="nui-focus text-muted-500 dark:text-muted-400/80 hover:bg-muted-100 dark:hover:bg-muted-700/60 hover:text-muted-600 dark:hover:text-muted-200 flex w-full cursor-pointer items-center gap-4 rounded-lg py-3 transition-colors duration-300 px-4">
								<i class="fa-duotone fa-sitemap {if $current_page == "modules"}text-primary-500{/if}"></i>
								<span class="whitespace-nowrap font-sans text-sm block {if $current_page == "modules"}text-primary-500{/if}">Modules</span>
							</a>
						</li>
						{/if}
						{if hasPermission("viewBackups", "admin")}
						<li>
							<a href="{$url}admin/backups" class="nui-focus text-muted-500 dark:text-muted-400/80 hover:bg-muted-100 dark:hover:bg-muted-700/60 hover:text-muted-600 dark:hover:text-muted-200 flex w-full cursor-pointer items-center gap-4 rounded-lg py-3 transition-colors duration-300 px-4">
								<i class="fa-duotone fa-hard-drive {if $current_page == "backups"}text-primary-500{/if}"></i>
								<span class="whitespace-nowrap font-sans text-sm block {if $current_page == "backups"}text-primary-500{/if}">Backups</span>
							</a>
						</li>
						{/if}
						<li>
							<div class="group">
								<button onclick="AdminMenu.openSection('theme')" nr="theme" class="nui-focus text-muted-500 dark:text-muted-400/80 hover:bg-muted-100 dark:hover:bg-muted-700/60 hover:text-muted-600 dark:hover:text-muted-200 flex w-full cursor-pointer items-center rounded-lg py-3 transition-colors duration-300 gap-4 px-4 {if $current_page == "theme" || $current_page == "edittheme"}open{/if}">
									<i class="fa-duotone fa-brush {if $current_page == "theme" || $current_page == "edittheme"}text-primary-500{/if}" aria-hidden="true"></i>
									<span class="block whitespace-nowrap font-sans text-sm {if $current_page == "theme" || $current_page == "edittheme"}text-primary-500{/if} block">Theme</span>
									<span class="ms-auto items-center justify-center flex">

                                        <svg data-v-cd102a71="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-4 w-4 transition-transform duration-200 {if $current_page != "theme" &&  $current_page != "edittheme"}rotate-180{/if}" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m18 15l-6-6l-6 6"></path>
                                        </svg>
                                    </span>
								</button>
								<ul class="border-muted-200 relative block ps-4 after:border-muted-200 max-h-max opacity-100" nr="theme" {if $current_page != "theme" &&  $current_page != "edittheme"}style="display: none;"{/if}>
									<li class="border-muted-300 dark:border-muted-700 border-s-2 first:mt-2">
										<a aria-current="page" href="{$url}admin/theme" class="{if $current_page == "theme"}router-link-active !border-primary-500 !text-primary-500 dark:!text-primary-500 -left-0.5 {/if} nui-focus text-muted-500 hover:text-muted-600 dark:text-muted-400/80 dark:hover:text-muted-200 relative flex cursor-pointer items-center gap-2 border-s-2 border-transparent py-2 ps-4 transition-colors duration-300">
											<i class="fa-duotone fa-palette"></i>
											<span class="whitespace-nowrap font-sans text-[0.85rem] block">Change theme</span>
										</a>
									</li>
									<li class="border-muted-300 dark:border-muted-700 border-s-2 first:mt-2">
										<a aria-current="page" href="{$url}admin/theme/edit" class="{if $current_page == "edittheme"}router-link-active !border-primary-500 !text-primary-500 dark:!text-primary-500 -left-0.5 {/if} nui-focus text-muted-500 hover:text-muted-600 dark:text-muted-400/80 dark:hover:text-muted-200 relative flex cursor-pointer items-center gap-2 border-s-2 border-transparent py-2 ps-4 transition-colors duration-300">
											<i class="fa-duotone fa-fill-drip"></i>
											<span class="whitespace-nowrap font-sans text-[0.85rem] block">Theme settings</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						{if hasPermission("editSystemSettings", "admin")}
						<li>
							<a href="{$url}admin/settings" class="nui-focus text-muted-500 dark:text-muted-400/80 hover:bg-muted-100 dark:hover:bg-muted-700/60 hover:text-muted-600 dark:hover:text-muted-200 flex w-full cursor-pointer items-center gap-4 rounded-lg py-3 transition-colors duration-300 px-4">
								<i class="fa-duotone fa-cog {if $current_page == "settings"}text-primary-500{/if}"></i>
								<span class="whitespace-nowrap font-sans text-sm block {if $current_page == "settings"}text-primary-500{/if}">Settings</span>
							</a>
						</li>
						{/if}
						<li>
							<a href="{$url}install/upgrade" class="nui-focus text-muted-500 dark:text-muted-400/80 hover:bg-muted-100 dark:hover:bg-muted-700/60 hover:text-muted-600 dark:hover:text-muted-200 flex w-full cursor-pointer items-center gap-4 rounded-lg py-3 transition-colors duration-300 px-4">
								<i class="fa-duotone fa-arrow-up-from-arc"></i>
								<span class="whitespace-nowrap font-sans text-sm block">Importer data (Upgrade)</span>
							</a>
						</li>
						{if hasPermission("updateCms", "admin")}
						<li>
							<a href="{$url}admin/updater" class="nui-focus text-muted-500 dark:text-muted-400/80 hover:bg-muted-100 dark:hover:bg-muted-700/60 hover:text-muted-600 dark:hover:text-muted-200 flex w-full cursor-pointer items-center gap-4 rounded-lg py-3 transition-colors duration-300 px-4">
								<i class="fa-duotone fa-sync {if $current_page == "updater"}text-primary-500{/if}"></i>
								<span class="whitespace-nowrap font-sans text-sm block {if $current_page == "updater"}text-primary-500{/if}">Update</span>
							</a>
						</li>
						{/if}
					</ul>
				</div>
			</div>

            <div class="bg-muted-100 dark:bg-muted-900 relative min-h-screen w-full overflow-x-hidden px-4 transition-all duration-300 xl:px-10 xl:max-w-[calc(100%_-_280px)] xl:ms-[280px]" __mainbar__>
                <div class="mx-auto w-full max-w-7xl">
                    <div class="relative z-50 mb-5 flex h-16 items-center gap-2">
                        <button type="button" class="flex h-10 w-10 items-center justify-center -ms-3" __sidebartoggler__>
                            <div class="scale-90 relative h-5 w-5"><span class="-rotate-45 rtl:rotate-45 max-w-[75%] top-1 bg-primary-500 absolute block h-0.5 w-full transition-all duration-300"></span><span class="opacity-0 translate-x-4 bg-primary-500 absolute top-1/2 block h-0.5 w-full max-w-[50%] transition-all duration-300"></span><span class="rotate-45 rtl:-rotate-45 max-w-[75%] bottom-1 bg-primary-500 absolute block h-0.5 w-full transition-all duration-300"></span></div>
                        </button>
                        <h1 class="font-heading text-2xl font-light leading-normal text-muted-800 dark:text-white md:block">
                            {$headline}
                        </h1>
                        <div class="ms-auto"></div>
                        <div class="flex items-center gap-2 h-16">
                            <label for="mode" class="nui-focus relative block h-9 w-9 shrink-0 overflow-hidden rounded-full transition-all duration-300 focus-visible:outline-2 dark:ring-offset-muted-900">
                                <input type="checkbox" id="mode" class="absolute start-0 top-0 z-[2] h-full w-full cursor-pointer opacity-0">
                                <span class="bg-white dark:bg-muted-800  border border-muted-300 dark:border-muted-700 relative block h-9 w-9 rounded-full">
                                    <svg id="sun" viewbox="0 0 24 24" class="pointer-events-none absolute start-1/2 top-1/2 block h-5 w-5 text-yellow-400 transition-all duration-300 translate-x-[-50%] opacity-0 rtl:translate-x-[50%] translate-y-[-150%]">
                                        <g fill="currentColor" stroke="currentColor" class="stroke-2">
                                            <circle cx="12" cy="12" r="5"></circle>
                                            <path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                                        </g>
                                    </svg>
                                    <svg id="moon" viewbox="0 0 24 24" class="pointer-events-none absolute start-1/2 top-1/2 block h-5 w-5 text-yellow-400 transition-all duration-300 translate-x-[-45%] opacity-100 rtl:translate-x-[45%] -translate-y-1/2">
                                        <path fill="currentColor" stroke="currentColor" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" class="stroke-2"></path>
                                    </svg>
                                </span>
                            </label>
							<script type="text/javascript">var Theme={
							    moon:$("#moon"),sun:$("#sun"),Light:function(){
							   document.documentElement.classList.remove("dark"),document.documentElement.classList.add("light"),window.localStorage.setItem("mode","light"),Theme.moon.removeClass("-translate-y-1/2").addClass("translate-y-[-150%]").removeClass("opacity-100").addClass("opacity-0"),Theme.sun.removeClass("translate-y-[-150%]").addClass("-translate-y-1/2").removeClass("opacity-0"),theme="light"},Dark:function(){
							   document.documentElement.classList.remove("light"),document.documentElement.classList.add("dark"),window.localStorage.setItem("mode","dark"),Theme.moon.addClass("-translate-y-1/2").removeClass("translate-y-[-150%]").addClass("opacity-100").removeClass("opacity-0"),Theme.sun.addClass("translate-y-[-150%]").removeClass("-translate-y-1/2").addClass("opacity-0"),theme="dark"}};"dark"==theme?Theme.Dark():Theme.Light();
							</script>
                            <div class="group inline-flex items-center justify-center text-right">
                                <div data-headlessui-state class="relative h-9 w-9 text-left">
									<a href="#" data-bs-toggle="dropdown">
										<button class="border-muted-200 hover:ring-muted-200 dark:hover:ring-muted-700 dark:border-muted-700 dark:bg-muted-800 dark:ring-offset-muted-900 flex h-9 w-9 items-center justify-center rounded-full border ring-1 ring-transparent transition-all duration-300 hover:ring-offset-4">
											<div class="relative inline-flex h-9 w-9 items-center justify-center rounded-full"><img class="h-7 w-7 rounded-full" src="{$url}application/images/flags2/{$abbreviationLanguage}.svg" alt="flag icon"></div>
										</button>
									</a>
									<div role="menu" tabindex="0" data-headlessui-state="open" class="dropdown-menu divide-muted-100 border-muted-200 dark:divide-muted-700 dark:border-muted-700 dark:bg-muted-800 absolute end-0 mt-2 w-64 origin-top-right divide-y rounded-md shadow-lg" id="language_picker">
										<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 border fixed top-0 z-[100] w-96 end-0">
											<div class="flex h-16 w-full items-center justify-between px-10">
												<h2 class="font-heading text-muted-700 text-lg font-semibold dark:text-white"> Select language </h2>
											</div>
											<div class="relative h-[calc(100%_-_64px)] w-full px-10">
												<div class="grid grid-cols-3 py-6">
													{foreach from=$languages item=language key=flag}
														<div class="relative my-4 flex items-center justify-center language-selector">
															<a {if $abbreviationLanguage == $flag}href="#"{else}href="javascript:void(0)" onClick="setLanguage('{$language}', this)"{/if} class="text-muted-500 dark:text-muted-400 group-hover:text-primary-500 transition-colors duration-300">
																<div class="relative">
																	<div class="border-muted-200 peer-checked:border-primary-500 dark:border-muted-600 flex h-14 w-14 items-center justify-center rounded-full border-2 shadow-lg transition-all duration-300"><img class="h-10 w-10 rounded-full" src="{$url}application/images/flags2/{$flag}.svg" alt="{$flag} flag icon"></div>
																	<div class="bg-primary-500 dark:border-muted-800 absolute -end-1 -top-1 h-7 w-7 items-center justify-center rounded-full border-4 text-white peer-checked:flex{if $abbreviationLanguage != $flag} hidden{/if}">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" role="img" class="icon h-3 w-5" width="1em" height="1em" viewBox="0 0 24 24">
																			<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
																		</svg>
																	</div>
																</div>
																{ucfirst($language)}
															</a>
														</div>
													{/foreach}
												</div>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                            <div class="group inline-flex items-center justify-center text-right">
                                <div data-headlessui-state class="relative h-9 w-9 text-left">
									<a href="#" data-bs-toggle="dropdown">
										<button class="group-hover:ring-muted-200 dark:group-hover:ring-muted-700 dark:ring-offset-muted-900 inline-flex h-9 w-9 items-center justify-center rounded-full ring-1 ring-transparent transition-all duration-300 group-hover:ring-offset-4">
											<span class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 flex h-9 w-9 items-center justify-center rounded-full border bg-white">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon text-muted-400 h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
													<g fill="currentColor">
														<path d="M208 192H48a8 8 0 0 1-6.88-12C47.71 168.6 56 139.81 56 104a72 72 0 0 1 144 0c0 35.82 8.3 64.6 14.9 76a8 8 0 0 1-6.9 12Z" opacity=".2"/>
														<path d="M221.8 175.94c-5.55-9.56-13.8-36.61-13.8-71.94a80 80 0 1 0-160 0c0 35.34-8.26 62.38-13.81 71.94A16 16 0 0 0 48 200h40.81a40 40 0 0 0 78.38 0H208a16 16 0 0 0 13.8-24.06ZM128 216a24 24 0 0 1-22.62-16h45.24A24 24 0 0 1 128 216Zm-80-32c7.7-13.24 16-43.92 16-80a64 64 0 1 1 128 0c0 36.05 8.28 66.73 16 80Z"/>
													</g>
												</svg>
											</span>
											<div id="notifications" class="hidden absolute -end-0.5 top-0.5"><span class="relative flex h-2 w-2"><span class="bg-primary-400 absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"></span><span class="bg-primary-500 relative inline-flex h-2 w-2 rounded-full"></span></span></div>
										</button>
									</a>
									<div role="menu" tabindex="0" data-headlessui-state="open" class="dropdown-menu divide-muted-100 border-muted-200 dark:divide-muted-700 dark:border-muted-700 dark:bg-muted-800 absolute end-0 mt-2 w-72 origin-top-right divide-y rounded-md border bg-white shadow-lg focus:outline-none">
										<div class="p-4" role="none">
											<div class="relative flex items-center justify-between" role="none">
												<h4 class="font-heading text-muted-500 dark:text-muted-200 text-xs uppercase" role="none"> Notifications </h4>
												<a aria-current="page" href="javascript:void(0)" onClick="Notify.markAllRead()" class="router-link-active router-link-exact-active font-alt text-primary-500 text-sm font-semibold" role="none"> Mark all read </a>
											</div>
										</div>
										<div id="content"></div>
									</div>
                                </div>
                            </div>
                            <div class="group inline-flex items-center justify-center text-right">
                                <div data-headlessui-state class="relative h-9 w-9 text-left">
									<a href="#" data-bs-toggle="dropdown">
										<button class="group-hover:ring-primary-500 dark:ring-offset-muted-900 inline-flex h-9 w-9 items-center justify-center rounded-full ring-1 ring-transparent transition-all duration-300 group-hover:ring-offset-4">
											<div class="relative inline-flex h-9 w-9 items-center justify-center rounded-full"><img src="{$avatar}" class="max-w-full rounded-full object-cover shadow-sm dark:border-transparent" alt></div>
										</button>
									</a>
									<div role="menu" tabindex="0" data-headlessui-state="open" class="dropdown-menu divide-muted-100 border-muted-200 dark:divide-muted-700 dark:border-muted-700 dark:bg-muted-800 absolute end-0 mt-2 w-64 origin-top-right divide-y rounded-md border bg-white shadow-lg focus:outline-none">
										<div class="p-6 text-center" role="none">
											<div class="relative mx-auto flex h-20 w-20 items-center justify-center rounded-full" role="none"><img src="{$avatar}" class="max-w-full rounded-full object-cover shadow-sm dark:border-transparent" alt="" role="none"></div>
											<div class="mt-3" role="none">
												<h6 class="font-heading text-muted-800 text-sm font-medium dark:text-white mb-2" role="none"> {$nickname} </h6>
												<a href="{$url}gm" type="button" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md w-full" role="none"> GM Panel </a>
											</div>
										</div>
										<div class="px-6 py-1.5" role="none">
											<a href="{$url}ucp" type="button" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md w-full mb-2" role="none"> UCP </a>
											<a href="javascript:void(0)" type="button" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md w-full mb-2" onClick="Custom.destroySession()" role="none"> Lock Screen </a>
										</div>
										<div class="p-6" role="none">
											<a href="{$url}logout" type="button" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md w-full" role="none"> Logout </a>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <main>
				        {$page}
                    </main>
                </div>
            </div>
            <div>
                
                <div class="opacity-0 pointer-events-none bg-muted-800/60 fixed start-0 top-0 z-[99] h-full w-full cursor-pointer transition-opacity duration-300"></div>
            </div>
            <div class="after:bg-primary-600 after:shadow-primary-500/50 dark:after:shadow-muted-800/10 fixed end-[1em] top-[0.6em] z-[90] transition-transform duration-300 after:absolute after:end-0 after:top-0 after:block after:h-12 after:w-12 after:rounded-full after:shadow-lg after:transition-transform after:duration-300 after:content-[&#39;&#39;] -translate-y-24">
                <button type="button" class="bg-primary-500 shadow-primary-500/50 dark:shadow-muted-800/10 relative z-30 flex h-12 w-12 items-center justify-center rounded-full text-white shadow-lg"><span class="-top-0.5 relative block h-3 w-3 transition-all duration-300"><span class="top-0.5 bg-muted-50 absolute block h-0.5 w-full transition-all duration-300"></span><span class="bg-muted-50 absolute top-1/2 block h-0.5 w-full transition-all duration-300"></span><span class="bottom-0 bg-muted-50 absolute block h-0.5 w-full transition-all duration-300"></span></span></button>
                <div>
                    
                    <div class="translate-x-0 translate-y-0 absolute end-[0.2em] top-[0.2em] z-20 flex items-center justify-center transition-all duration-300">
                        <label class="nui-focus relative block h-9 w-9 shrink-0 overflow-hidden rounded-full transition-all duration-300 focus-visible:outline-2 ring-offset-muted-500 dark:ring-offset-muted-400 ms-auto">
                            <input type="checkbox" class="absolute start-0 top-0 z-[2] h-full w-full cursor-pointer opacity-0">
                            <span class="bg-primary-700 relative block h-9 w-9 rounded-full">
                                <svg aria-hidden="true" viewbox="0 0 24 24" class="pointer-events-none absolute start-1/2 top-1/2 block h-5 w-5 text-yellow-400 transition-all duration-300 -translate-y-1/2 translate-x-[-50%] opacity-100 rtl:translate-x-[50%]">
                                    <g fill="currentColor" stroke="currentColor" class="stroke-2">
                                        <circle cx="12" cy="12" r="5"></circle>
                                        <path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                                    </g>
                                </svg>
                                <svg aria-hidden="true" viewbox="0 0 24 24" class="pointer-events-none absolute start-1/2 top-1/2 block h-5 w-5 text-yellow-400 transition-all duration-300 translate-x-[-45%] translate-y-[-150%] opacity-0 rtl:translate-x-[45%]">
                                    <path fill="currentColor" stroke="currentColor" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" class="stroke-2"></path>
                                </svg>
                            </span>
                        </label>
                    </div>

                    <div class="translate-x-0 translate-y-0 absolute end-[0.2em] top-[0.2em] z-20 flex items-center justify-center transition-all duration-300">
                        <a aria-current="page" href="analytics.html#" class="router-link-active router-link-exact-active inline-flex h-9 w-9 items-center justify-center rounded-full transition-all duration-300">
                            <span class="bg-primary-700 flex h-9 w-9 items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5 text-white" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                    <g fill="currentColor">
                                        <path d="M208 192H48a8 8 0 0 1-6.88-12C47.71 168.6 56 139.81 56 104a72 72 0 0 1 144 0c0 35.82 8.3 64.6 14.9 76a8 8 0 0 1-6.9 12Z" opacity=".2"/>
                                        <path d="M221.8 175.94c-5.55-9.56-13.8-36.61-13.8-71.94a80 80 0 1 0-160 0c0 35.34-8.26 62.38-13.81 71.94A16 16 0 0 0 48 200h40.81a40 40 0 0 0 78.38 0H208a16 16 0 0 0 13.8-24.06ZM128 216a24 24 0 0 1-22.62-16h45.24A24 24 0 0 1 128 216Zm-80-32c7.7-13.24 16-43.92 16-80a64 64 0 1 1 128 0c0 36.05 8.28 66.73 16 80Z"/>
                                    </g>
                                </svg>
                            </span>
                        </a>
                    </div>
                    
                    <div class="translate-x-0 translate-y-0 absolute end-[0.2em] top-[0.2em] z-20 flex items-center justify-center transition-all duration-300">
                        <button type="button" class="bg-primary-700 flex h-9 w-9 items-center justify-center rounded-full transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5 text-white" style="" width="1em" height="1em" viewBox="0 0 256 256" data-v-cd102a71>
                                <g fill="currentColor">
                                    <path d="M112 80a32 32 0 1 1-32-32a32 32 0 0 1 32 32Zm64 32a32 32 0 1 0-32-32a32 32 0 0 0 32 32Zm-96 32a32 32 0 1 0 32 32a32 32 0 0 0-32-32Zm96 0a32 32 0 1 0 32 32a32 32 0 0 0-32-32Z" opacity=".2"/>
                                    <path d="M80 40a40 40 0 1 0 40 40a40 40 0 0 0-40-40Zm0 64a24 24 0 1 1 24-24a24 24 0 0 1-24 24Zm96 16a40 40 0 1 0-40-40a40 40 0 0 0 40 40Zm0-64a24 24 0 1 1-24 24a24 24 0 0 1 24-24Zm-96 80a40 40 0 1 0 40 40a40 40 0 0 0-40-40Zm0 64a24 24 0 1 1 24-24a24 24 0 0 1-24 24Zm96-64a40 40 0 1 0 40 40a40 40 0 0 0-40-40Zm0 64a24 24 0 1 1 24-24a24 24 0 0 1-24 24Z"/>
                                </g>
                            </svg>
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>
	<script type="text/javascript">
	var Notify = {
		notifyField: $("#content"),
		countField: $("#notifications"),
	
		update: function()
		{
			$.get(Config.URL + "admin/notifications", function(data)
			{
				Notify.notifyField.html(data);
			});

			$.get(Config.URL + "admin/notifications/count", function(data)
			{
				if (data > 0)
					Notify.countField.removeClass("hidden");
				else
					Notify.countField.addClass("hidden");

			});
		},
		
		markRead: function(id, element)
		{
			element = $(element);
			$.get(Config.URL + "admin/markReadNotification/" + id)
			element.removeClass("font-semibold");
			Notify.countField.addClass("hidden");
		},
		
		markAllRead: function()
		{
			$.get(Config.URL + "admin/markReadNotification/" + false + "/" + true)
		}
	}
	
	Notify.update();
	setInterval(Notify.update, 10000);
	</script>

	<script type="text/javascript">const modeBtn=document.getElementById("mode");modeBtn.onchange=e=>{
	"dark"==theme?Theme.Light():Theme.Dark()};</script>
	<script type="text/javascript">
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>

	<script type="text/javascript">
		function setLanguage(language, field)
		{
			$("#language_picker").fadeOut(250, function()
			{
				$(this).html('<div class="fa-2x text-center text-white"><i class="fa-duotone fa-spinner fa-spin"></i></div>').fadeIn(250, function()
				{
					$.get(Config.URL + "sidebox_language_picker/language_picker/set/" + language, function()
					{
						window.location.reload(true);
					});
				});
			})
		}
	</script>
    </body>
</html>