{strip}

{* Initialize sideboxes to bake them later *}
{$MY_sideboxes = ['top' => null, 'side' => null, 'bottom' => null, 'status' => null]}

{* Include theme sideboxes *}
{if file_exists("{$T_ROOT_PATH}modules{$DS}sidebox_menu{$DS}menu.tpl")}{include file="{$T_ROOT_PATH}modules{$DS}sidebox_menu{$DS}menu.tpl" scope="parent"}{/if}

{foreach from=array_merge($sideboxes, $sideboxes_top, $sideboxes_bottom) key=key item=item}
	{* Set default location *}
	{if !isset($item.location) || !$item.location}{$item.location = 'side'}{/if}

	{* Item attr *}
	{$item.attr = 'widget="'|cat:$item.location|cat:'"'}

	{* Prevent possible conflict *}
	{if strtolower($item.type) === 'custom'}{$item.type = $item.type|cat:'-'|cat:$key}{/if}

	{* Append status *}
	{if in_array(strtolower($item.type), ['status', 'online_players_extended'])}
		{$MY_sideboxes.status = $item.data}
		{continue}
	{/if}

	{* Build item *}
	{capture assign=html}
		<div class="sidebox sidebox-{$item.type}" {$item.attr}>
			{if $item.name}<h4 class="sidebox-head text-ellipsis" title="{$item.name}">{formatTitle title=$item.name}</h4>{/if}
			<div class="sidebox-body">{$item.data}</div>
		</div>
	{/capture}

	{* Append item *}
	{$MY_sideboxes[$item.location][$item.type] = $html}
{/foreach}

{/strip}