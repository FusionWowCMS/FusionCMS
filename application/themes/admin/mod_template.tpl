<!DOCTYPE html>
<html class="fixed dark">
	<head>
		<title>{if $title}{$title}{/if}{$serverName}</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="{$url}application/themes/admin/assets/images/fusionico.png">

		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/animate/animate.compat.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/owl.carousel/assets/owl.carousel.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/owl.carousel/assets/owl.theme.default.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/jquery-ui/jquery-ui.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/jquery-ui/jquery-ui.theme.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/morris/morris.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/sweetalert2/css/sweetalert2-dark.css">
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/select2/css/select2.css">
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/datatables/media/css/dataTables.bootstrap5.min.css">
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/codemirror/lib/codemirror.css">
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/vendor/codemirror/theme/ayu-mirage.css">
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/css/theme.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/css/skins/default.css" />
		<link rel="stylesheet" href="{$url}application/themes/admin/assets/css/custom.css">
		{if $extra_css}<link rel="stylesheet" href="{$url}application/{$extra_css}" type="text/css" />{/if}

		<script type="text/javascript" src="{$url}application/themes/admin/assets/vendor/jquery/jquery.min.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/modernizr/modernizr.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/popper/umd/popper.min.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/common/common.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/jquery-ui/jquery-ui.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/bootstrapv5-multiselect/js/bootstrap-multiselect.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/flot/jquery.flot.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/flot.tooltip/jquery.flot.tooltip.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/raphael/raphael.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/morris/morris.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/gauge/gauge.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/snap.svg/snap.svg.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/owl.carousel/owl.carousel.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/sweetalert2/js/sweetalert2.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/select2/js/select2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/fuelux/js/spinner.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/codemirror/lib/codemirror.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/codemirror/addon/selection/active-line.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/codemirror/addon/edit/matchbrackets.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/codemirror/mode/javascript/javascript.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/codemirror/mode/xml/xml.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/codemirror/mode/css/css.js"></script>
		<script src="{$url}application/themes/admin/assets/vendor/jquery-idletimer/idle-timer.js"></script>
		<script src="{$url}application/themes/admin/assets/js/countTo.js"></script>
		<script src="{$url}application/themes/admin/assets/js/theme.js"></script>
		<script src="{$url}application/themes/admin/assets/js/theme.init.js"></script>
		<script src="{$url}application/themes/admin/assets/js/theme.admin.extension.js"></script>
		
		<link href="{$url}application/themes/admin/assets/vendor/imagesloader/jquery.imagesloader.css" rel="stylesheet">
		<script src="{$url}application/themes/admin/assets/vendor/imagesloader/jquery.imagesloader-1.0.1.js"></script>

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

	<script src="{$url}application/themes/admin/assets/js/router.js" type="text/javascript"></script>
	<script src="{$url}application/themes/admin/assets/js/adminMenu.js" type="text/javascript"></script>
	<script src="{$url}application/js/require.js" type="text/javascript"></script>
	<script type="text/javascript">
		var scripts = [
			"{$url}application/js/jquery.placeholder.min.js",
			"{$url}application/js/jquery.transit.min.js",
			"{$url}application/js/tooltip.js",
			"{$url}application/js/ui.js",
			"{$url}application/js/fusioneditor.js"
			{if $extra_js},"{$url}application/{$extra_js}"{/if}
		];
			require(scripts, function()
		{
			$(document).ready(function()
			{
				UI.initialize();
					{if $extra_css}
					Router.loadedCSS.push("{$extra_css}");
				{/if}
					{if $extra_js}
					Router.loadedJS.push("{$extra_js}");
				{/if}
				
				$('[data-toggle="tooltip"]').tooltip();
				$(".nano").nanoScroller();
				$(".nano-pane").show();
			});
		});

	</script>
	</head>

	<body>
	<section class="body">
		<header class="header">
			<div class="logo-container">
				<a href="{$url}mod" class="logo">
					<img src="{$url}application/themes/admin/assets/images/fusion.svg">
					<span class="text-light font-weight-normal">{$serverName}</span>
				</a>
				<div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
					<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</div>
			<!-- start: search & user box -->
			<div class="header-right">
				<ul class="notifications">
					<a href="{$url}" target="_blank"><i class="fa-solid fa-house fa-2x"></i></a>
				</ul>

				<span class="separator"></span>

				<div id="userbox" class="userbox">
					<a href="#" data-bs-toggle="dropdown">
						<figure class="profile-picture">
							<img src="{$avatar}" alt="{$nickname}" class="rounded-circle">
						</figure>
						<div class="profile-info" data-lock-name="{$nickname}">
							<span class="name">{$nickname}</span>
							<span class="role">{foreach from=$groups item=group} ({$group.name}) {/foreach}</span>
						</div>

						<i class="fa custom-caret"></i>
					</a>

					<div class="dropdown-menu">
						<ul class="list-unstyled mb-2">
							<li class="divider"></li>
							{if hasPermission("view", "admin")}
							<li>
								<a role="menuitem" tabindex="-1" href="{$url}admin"><i class="fas fa-shield"></i> Admin Panel</a>
							</li>
							{/if}
							<li>
								<a role="menuitem" tabindex="-1" href="{$url}ucp"><i class="fas fa-user-circle"></i> UCP</a>
							</li>
							<li>
								<a role="menuitem" tabindex="-1" href="{$url}logout"><i class="fas fa-power-off"></i> Logout</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- end: search & user box -->
		<!-- end: header -->
		</header>
	<div class="inner-wrapper">
		
		<div class="modal fade" id="modalui" tabindex="-1" role="dialog" aria-labelledby="modaluititle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modaluititle">Modal title</h5>
					</div>
					<div class="modal-body" id="modaluibody"> Modal body </div>
					<div class="modal-footer" id="modaluifooter"> Modalfooter </div>
				</div>
			</div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="confirm">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<h5 class="modal-title" id="modaluititle">Question...</h5>
					</div>
					<div class="modal-body" id="modaluibody">
						<h5 class="popup_question" id="confirm_question"></h5>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer" id="popup_links">
						<button type="button" a href="javascript:void(0)" class="btn btn-primary" id="confirm_button"></a></button>
						<button type="button" a href="javascript:void(0)" class="btn btn-secondary" id="confirm_hide" onClick="UI.hidePopup()">Cancel</a></button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="alert">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<h5 class="modal-title" id="modaluititle">Warning</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="UI.hidePopup()"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body" id="modaluibody">
						<h5 class="popup_message" id="alert_message"></h5>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer" id="popup_links">
						<button type="button" a href="javascript:void(0)" class="btn btn-primary" id="alert_button">Okay</a></button>
					</div>
				</div>
			</div>
		</div>
		<!-- ./modal -->
		<!-- Main Sidebar Container -->
		<aside id="sidebar-left" class="sidebar-left">

			<div class="sidebar-header">
			    <div class="sidebar-title">
			        Navigation
			    </div>
			    <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			        <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
			    </div>
			</div>

			<div class="nano">
			    <div class="nano-content">
			        <nav id="menu" class="nav-main" role="navigation">
			            <ul class="nav nav-main">
						<li {if $current_page == "mod/"}class="nav-active" style="background-color: #225890;"{/if}>
							<a class="nav-link {if $current_page == "mod/"}nav-active{/if}" href="{$url}mod"> <i class="fas fa-home"></i> <span>Dashboard</span> </a>
						</li>

						<li {if $current_page == "mod/tickets"}class="nav-active" style="background-color: #225890;"{/if}>
							<a class="nav-link {if $current_page == "mod/tickets"}nav-active{/if}" href="{$url}mod/tickets"> <i class="fas fa-comments"></i> <span>Tickets</span> </a>
						</li>
						
						<li {if $current_page == "mod/bans"}class="nav-active" style="background-color: #225890;"{/if}>
							<a class="nav-link {if $current_page == "mod/bans"}nav-active{/if}" href="{$url}mod/bans"> <i class="fas fa-list"></i> <span>Ban list</span> </a>
						</li>

						{foreach from=$menu item=group key=text}
						{if count($group.links)}
						<li onclick="AdminMenu.openSection({$group.nr})" nr="{$group.nr}" class="nav-parent {if isset($group.active)}nav-expanded{/if} admin_section_icon" {if isset($group.active)}style="background-color: #225890;"{/if}>
							<a href="#" class="nav-link">
							<i class="fa-solid fa-{$group.icon}" aria-hidden="true"></i>
							<span>{$text}</span>
							</a>
						
						<ul class="nav nav-children admin_section" nr="{$group.nr}" style="display:{if isset($group.active)}block{/if};">
							{foreach from=$group.links item=link}
								<li {if isset($link.active)}class="nav-active"{/if}>
									<a class="nav-link {if isset($link.active)}nav-active{/if}" href="{$url}{$link.module}/{$link.controller}"> <i class="fa-solid fa-{$link.icon}"></i> <span>{$link.text}</span> </a>
								</li>
							{/foreach}
						</ul>
						{/if}
						{/foreach}
						</li>
						</ul>
					</nav>
				</div>
				
				<script>
					if (typeof localStorage !== 'undefined') {
						if (localStorage.getItem('sidebar-left-position') !== null) {
							var initialPosition = localStorage.getItem('sidebar-left-position'),
								sidebarLeft = document.querySelector('#sidebar-left .nano-content');
				
							sidebarLeft.scrollTop = initialPosition;
						}
					}
				</script>
				
				<div class="nano-pane" style="opacity: 1; visibility: visible;"><div class="nano-slider" style="height: 412px; transform: translate(0px, 0px);"></div></div>
			</div>
		</aside>
		<section role="main" class="content-body">
			<header class="page-header">
				<h2>{$headline}</h2>
			</header>
			{$page}
		</section>
	</div>
	</section>
	</body>
</html>