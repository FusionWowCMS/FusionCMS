{strip}

{* Initialize menus to bake them later *}
{$menus = ['top' => null, 'side' => null, 'bottom' => null]}

{* Layout *}
{$layout = "{$theme_path}views{$DS}layouts{$DS}nav_item.tpl"}

{foreach from=array_merge($menu_top, $menu_side, $menu_bottom) item=item}
	{* Modify `side` item *}
	{if $item.type === 'side'}
		{$item.icon    = 'dot'}
		{$item.wrapper = ['<span>', '</span>']}
	{/if}

	{* Build item *}
	{capture assign=html}
		{include file=$layout item=$item}
	{/capture}

	{* Append item *}
	{if $item.parent_id}
		{if $pos = strpos($menus[$item.type], "<!-- submenus-{$item.parent_id} -->")}
			{$menus[$item.type] = substr_replace($menus[$item.type], $html, $pos, 0)}

			{if $item.active && strpos($menus[$item.type], "[active-{$item.parent_id}]") !== FALSE}
				{$menus[$item.type] = str_replace("[active-{$item.parent_id}]", 'active', $menus[$item.type])}
			{/if}
		{/if}
	{else}
		{$menus[$item.type] = $menus[$item.type]|cat:$html}
	{/if}
{/foreach}

{/strip}