{if $menus.side && $theme_configs.config.sidebox_menu.enabled && (($theme_configs.config.sidebox_menu.visibility == 'home' && $isHomePage) || ($theme_configs.config.sidebox_menu.visibility == 'always'))}
	{capture assign=html}
		<!-- Navbar.Start -->
		<nav class="navbar">
			<ul class="navbar-nav">{$menus.side}</ul>
		</nav>
		<!-- Navbar.End -->
	{/capture}

	{$data      = [['name' => '', 'data' => {$html}, 'type' => 'menu', 'location' => 'side']]}
	{$sideboxes = array_merge(array_slice($sideboxes, 0, $theme_configs.config.sidebox_menu.order), $data, array_slice($sideboxes, $theme_configs.config.sidebox_menu.order))}
{/if}