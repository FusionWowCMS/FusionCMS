<!-- Header.Start -->
<header class="header" header>
	<div gradient gradient-1></div>
	<div gradient gradient-2></div>

	<div line line-l></div>
	<div line line-r></div>

	<div arrow></div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<!-- Navbar.Start -->
				<nav class="navbar navbar-expand-xl">
					<h1 hidden>{$serverName}</h1>

					<!-- Brand.Start -->
					<a href="{$url}" class="navbar-brand" title="{$serverName} - {$CI->config->item('title')}">
						<img width="55" height="48" alt="{$serverName}" src="{$MY_image_path}graphics/logo.png" />
						<span class="text-ellipsis">
							<b>{$serverName}</b>
							<i>{$CI->config->item('title')}</i>
						</span>
					</a>
					<!-- Brand.End -->

					<!-- Collapse.Start -->
					<div class="navbar-collapse collapse-primary collapse" collapse="navbar-primary">
						<ul class="navbar-nav mx-auto">
							{$menus.top}
						</ul>
					</div>

					<div class="navbar-collapse collapse-secondary collapse">
						<ul class="navbar-nav ms-auto">
							<li class="nav-item"><a href="{$url}page/download" class="btn-blue -outline -noise text-ellipsis" title="{lang('btn_downloadLauncher', 'theme')}">{lang('btn_downloadLauncher', 'theme')}</a></li>
						</ul>
					</div>
					<!-- Collapse.End -->

					<!-- Toggler.Start -->
					<a href="javascript:void(0)" class="navbar-toggler" onclick="$('[collapse=navbar-primary]').stop(true, true).slideToggle('fast', function() { ($(this).is(':visible') ? $('.navbar-toggler').addClass('open') : $('.navbar-toggler').removeClass('open')) })"><span line line-t></span><span line line-m></span><span line line-b></span></a>
					<!-- Toggler.End -->
				</nav>
				<!-- Navbar.End -->
			</div>
		</div>
	</div>
</header>
<!-- Header.End -->