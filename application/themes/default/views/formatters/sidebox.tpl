{strip}

{* Initialize sideboxes to bake them later *}
{$MY_sideboxes = ['side' => null, 'top' => null, 'bottom' => null]}

{* Include theme sideboxes *}
{if file_exists("{$theme_path}modules{$DS}sidebox_menu{$DS}menu.tpl")}{include file="{$theme_path}modules{$DS}sidebox_menu{$DS}menu.tpl" scope="parent"}{/if}

{* Layout *}
{$layout.type = "sm"}
{$layout.file = "{$theme_path}views{$DS}layouts{$DS}box.tpl"}

{foreach from=array_merge($sideboxes, $sideboxes_top, $sideboxes_bottom) key=key item=item}
	{* Set default location *}
	{if !isset($item.location) || !$item.location}{$item.location = 'side'}{/if}

	{* Item attr *}
	{$item.attr = 'widget="'|cat:$item.location|cat:'"'}

	{* Prevent possible conflict *}
	{if strtolower($item.type) === 'custom'}{$item.type = $item.type|cat:'-'|cat:$key}{/if}

	{* Build item *}
	{capture assign=html}
		{include file=$layout.file _type=$layout.type _module=$item.type _head=$item.name _body=$item.data _attr=$item.attr}
	{/capture}

	{* Append item *}
	{$MY_sideboxes[$item.location][$item.type] = $html}
{/foreach}

{/strip}