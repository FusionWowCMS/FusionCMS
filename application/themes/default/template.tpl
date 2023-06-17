{include file="{$theme_path}configure/global.tpl" scope="parent"}
{include file="{$theme_path}views/header.tpl" scope="parent"}

<body class="gb ltr is-homepage is-compact is-fullwidth has-padding has-slider">
	{include file="{$theme_path}views/parts/topbar.tpl"}
	{include file="{$theme_path}views/parts/header.tpl"}

	{if $show_slider}{include file="{$theme_path}views/parts/slider.tpl"}{/if}

	<section class="section section-content" content>
		{$showSidebox = in_array($moduleName, $sidebox_modules)}
		{if isset($is404) && in_array("errors", $sidebox_modules)}{$showSidebox = true}{/if}
		<div class="container">
			<div class="row">
				<div id="left" class="col-sm-12 col{if $showSidebox}-lg-8{/if}" mainbar="">
					{include file="{$theme_path}views/parts/topbox.tpl"}
					{$page}
				</div>

				{if $showSidebox}
				<div id="right" class="col-sm-12 col-lg-4" sidebar="">
					<nav class="navbar navbar-side">
					<ul class="navbar-nav">
						{foreach from=$menu_side item=menu}
							<li class="nav-item">
								<a {$menu.link} class="nav-link {if $menu.active}nav-active{/if}" title="{$menu.name}" data-hasevent="1">
									<i class="arrow"></i>
									<span>{$menu.name}</span>
								</a>
							</li>
						{/foreach}
					</ul>
					</nav>

					{include file="{$theme_path}views/parts/sidebox.tpl"}
				</div>
				{/if}
			</div>
		</div>
	</section>

	{include file="{$theme_path}views/parts/bottombox.tpl"}
	{include file="{$theme_path}views/parts/footer.tpl"}

</body>
</html>
