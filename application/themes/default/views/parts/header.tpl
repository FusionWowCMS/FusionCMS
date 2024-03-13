{strip}

{* Layout *}
{$layout = "{$theme_path}views{$DS}layouts{$DS}nav_item.tpl"}

{capture assign=user_nickname}
	{sprintf(lang('global_user_avatar', 'theme'), ($CI->user->isOnline()) ? $CI->user->getNickname() : lang('guest', 'sidebox_visitors'))}
{/capture}

{capture assign=user_avatar}
	<img width="25" height="25" alt="{$user_nickname}" src="{if $CI->user->isOnline()}{$CI->user->getAvatar()}{else}{$url}{basename($APPPATH)}/images/avatars/default.gif{/if}" />
{/capture}

{capture assign=user_dropdown}
	<ul class="dropdown-menu">
		{if $CI->user->isOnline()}
			<li><a href="{$url}ucp" class="dropdown-item" title="{lang('account', 'main')}">{lang('account', 'main')}</a></li>
			<li><a href="{$url}logout" class="dropdown-item" title="{lang('logout', 'main')}">{lang('logout', 'main')}</a></li>
		{else}
			<li><a href="{$url}login" class="dropdown-item" title="{lang('login', 'main')}">{lang('login', 'main')}</a></li>
			<li><a href="{$url}register" class="dropdown-item" title="{lang('register', 'main')}">{lang('register', 'main')}</a></li>
		{/if}
	</ul>
{/capture}

{capture assign=user_bar}
	<div class="userbar">
		<div class="userbar-avatar">
			<a href="{$url}ucp/avatar" title="{$user_nickname}">{$user_avatar}</a>
		</div>

		<div class="userbar-info">
			<div class="info-username">{($CI->user->isOnline()) ? $CI->user->getNickname() : lang('guest', 'sidebox_visitors')}</div>
			<div class="info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-duotone fa-bars"></i></a>
					{$user_dropdown}
				</div>
			</div>
		</div>
	</div>
{/capture}

{capture assign=user_menu}
	{* Set item *}
	{$item = ['id' => '999', 'link' => false, 'name' => $user_nickname, 'content' => $user_avatar, 'dropdown' => true, 'dropdownMenu' => $user_dropdown]}

	{* Build item *}
	{include file=$layout _item=$item}
{/capture}

{/strip}

<!-- Mobile menu.Start -->
<div id="mobileMenu" class="offcanvas offcanvas-end" aria-labelledby="mobileMenuLabel">
	<div class="offcanvas-header">
		<h5 id="mobileMenuLabel" class="offcanvas-title">{lang('nav', 'theme')}</h5>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>

	<div class="offcanvas-body">
		{$user_bar}

		<!-- Navbar.Start -->
		<nav class="navbar">
			<!-- Nav.Start -->
			<ul class="navbar-nav">{$menus.top}</ul>
			<!-- Nav.End -->
		</nav>
		<!-- Navbar.End -->
	</div>
</div>
<!-- Mobile menu.End -->

<!-- Header.Start -->
<header class="header" header>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<!-- Navbar.Start -->
				<nav class="navbar navbar-expand-xl">
					<h1 hidden>{$serverName}</h1>

					<!-- Brand.Start -->
					<a href="{$url}" class="navbar-brand" title="{sprintf(lang('logo', 'theme'), $serverName)}"></a>
					<!-- Brand.End -->

					<!-- Toggler.Start -->
					<button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
						<span class="navbar-toggler-icon"></span>
					</button>
					<!-- Toggler.End -->

					<!-- Collapse.Start -->
					<div class="navbar-collapse collapse">
						<!-- Nav.Start -->
						<ul class="navbar-nav ms-auto">{$menus.top}{$user_menu}</ul>
						<!-- Nav.End -->
					</div>
					<!-- Collapse.End -->
				</nav>
				<!-- Navbar.End -->
			</div>
		</div>
	</div>
</header>
<!-- Header.End -->