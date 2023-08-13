<!-- Header.Start -->
<header class="header" header>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<!-- Navbar.Start -->
				<nav class="navbar navbar-expand-xl">
					<h1 hidden="">{$serverName}</h1>
					<!-- Brand.Start -->
					<a href="{$url}" class="navbar-brand" title="Welcome to {$serverName}" data-hasevent="1">
						<span gradient=""></span>
						<span glows=""><h1>{$serverName}</h1></span>
					</a>
					<!-- Brand.End -->
					<!-- Toggler.Start -->
					<a href="javascript:void(0)" class="navbar-toggler" onclick="$('[collapse=navbar-top]').stop(true, true).slideToggle('fast', function() { ($(this).is(':visible') ? $('.navbar-toggler').addClass('open') : $('.navbar-toggler').removeClass('open')) })">
					<span line="" line-t=""></span>
					<span line="" line-m=""></span>
					<span line="" line-b=""></span>
					</a>
					<!-- Toggler.End -->
					<!-- Collapse.Start -->
					<div class="navbar-collapse collapse" collapse="navbar-top">
					<ul class="navbar-nav ms-auto">
						{foreach from=$menu_top item=menu}
							{if $menu.parent_id != 0}{continue}{/if}
							{if $menu.dropdown}
								<li class="nav-item dropdown" data-dropdown-initialized="false">
									<a href="#" id="dropdown_2" class="nav-link dropdown-toggle" title="{$menu.name}" data-bs-toggle="dropdown">{$menu.name}</a>
	
									<ul class="dropdown-menu" aria-labelledby="dropdown_2">
										{foreach from=$menu_top item=d_menu}
											{if $d_menu.parent_id != $menu.id}{continue}{/if}
											<li><a {$d_menu.link} class="dropdown-item" title="{$d_menu.name}" data-hasevent="1">{$d_menu.name}</a></li>
										{/foreach}
									</ul>
								</li>
							{else}
								<li class="nav-item">
									<a {$menu.link} class="nav-link {if $menu.active}nav-active{/if}" title="{$menu.name}" data-hasevent="1">{$menu.name}</a>
								</li>
							{/if}
						{/foreach}
					</ul>
					</div>
					<!-- Collapse.End -->
				</nav>
				<!-- Navbar.End -->
			</div>
		</div>
	</div>
</header>
<!-- Header.End -->