{strip}

<!-- Header.Start -->
<header id="header" class="header">
	<div class="aw_container">
		<!-- Logo.Start -->
		<div class="logo_holder">
			<h1><a href="{$url}" class="logo" title="{sprintf(lang('logo_title', 'theme_auzwow'), $serverName)}">{$serverName}</a></h1>
		</div>
		<!-- Logo.End -->

		{* Initializing menus to bake them later *}
		{$menus = ['left' => null, 'right' => null]}

		{foreach from=$menu_top item=item}
			{* Skip dropdown and childs *}
			{if $item.dropdown || $item.parent_id}{continue}{/if}

			{* Build item *}
			{capture assign=html}
				<li><a {$item.link} class='nav_item type-menu {if $item.active}nav_active{/if}'>{$item.name}</a></li>
			{/capture}

			{* Append item *}
			{$menus[($item.side === 'L') ? 'left' : 'right'] = $menus[($item.side === 'L') ? 'left' : 'right']|cat:$html}
		{/foreach}

		<!-- Navigation.Start -->
		<div class="navigation">
			<ul class="nav_menu left_area">{$menus.left}</ul>
			<ul class="nav_menu right_area">{$menus.right}</ul>
			<ul class="nav_menu right_area mobile"><li><a href="#my-menu" class="nav_item type-toggle"></a></li></ul>
		</div>
		<!-- Navigation.End -->
	</div>
</header>
<!-- Header.End -->

{/strip}