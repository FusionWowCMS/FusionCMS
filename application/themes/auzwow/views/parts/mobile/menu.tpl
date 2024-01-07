{strip}

<nav id="my-menu" style="display:none">
	<ul>
		{foreach from=$menu_top item=item}
			{* Skip dropdown and childs *}
			{if $item.dropdown || $item.parent_id}{continue}{/if}

			<li><a {$item.link} class='nav_item type-menu {if $item.active}nav_active{/if}'>{$item.name}</a></li>
		{/foreach}
	</ul>
</nav>

{/strip}