{strip}

{* Format item *}
{$item = [
	'id'           => (isset($item.id)           && $item.id)           ? $item.id           : false,
	'link'         => (isset($item.link)         && $item.link)         ? $item.link         : false,
	'name'         => (isset($item.name)         && $item.name)         ? $item.name         : false,
	'side'         => (isset($item.side)         && $item.side)         ? $item.side         : false,
	'type'         => (isset($item.type)         && $item.type)         ? $item.type         : false,
	'active'       => (isset($item.active)       && $item.active)       ? $item.active       : false,
	'dropdown'     => (isset($item.dropdown)     && $item.dropdown)     ? $item.dropdown     : false,
	'parent_id'    => (isset($item.parent_id)    && $item.parent_id)    ? $item.parent_id    : false,

	'isChild'      => (isset($item.parent_id)    && $item.parent_id)    ? true               : false,
	'isDropdown'   => (isset($item.dropdown)     && $item.dropdown)     ? true               : false,

	'icon'         => (isset($item.icon)         && $item.icon)         ? $item.icon         : false,
	'classes'      => (isset($item.classes)      && $item.classes)      ? $item.classes      : false,
	'content'      => (isset($item.content)      && $item.content)      ? $item.content      : false,
	'dropdownMenu' => (isset($item.dropdownMenu) && $item.dropdownMenu) ? $item.dropdownMenu : false,

	'wrapper'      => [
		0 => (isset($item.wrapper) && is_array($item.wrapper) && count($item.wrapper) == 2 && isset($item.wrapper[0])) ? $item.wrapper[0] : false,
		1 => (isset($item.wrapper) && is_array($item.wrapper) && count($item.wrapper) == 2 && isset($item.wrapper[1])) ? $item.wrapper[1] : false
	]
]}

{if $item.id}
	<li {if !$item.isChild || $item.classes}class="{if !$item.isChild}nav-item {if $item.isDropdown}dropdown{/if}{/if} {if $item.classes}{(is_array($item.classes)) ? implode(' ', $item.classes) : $item.classes}{/if}"{/if}>
		<a {if $item.isDropdown}href="#"{else}{if $item.link}{$item.link}{/if}{/if} class="{if $item.isChild}dropdown-item{else}nav-link{/if} {if $item.isDropdown}dropdown-toggle [active-{$item.id}]{/if} {if $item.active}active{/if}" title="{$item.name}" {if $item.isDropdown}role="button" data-bs-toggle="dropdown" aria-expanded="false"{/if} {if $item.active}aria-current="page"{/if}>
			{* Item: icon *}
			{if $item.icon}<i class="{$item.icon}"></i>{/if}

			{* Item: wrapper (open) *}
			{if $item.wrapper[0] && $item.wrapper[1]}{$item.wrapper[0]}{/if}

			{* Item: name *}
			{($item.content) ? $item.content : $item.name}

			{* Item: wrapper (close) *}
			{if $item.wrapper[0] && $item.wrapper[1]}{$item.wrapper[1]}{/if}

			{* Item: dropdown arrow *}
			{if $item.isDropdown}<i class="dropdown-arrow"></i>{/if}
		</a>

		{if $item.isDropdown}
			{if $item.dropdownMenu}
				{$item.dropdownMenu}
			{else}
				<ul class="dropdown-menu">
					<!-- submenus-{$item.id} -->
				</ul>
			{/if}
		{/if}
	</li>
{/if}

{/strip}