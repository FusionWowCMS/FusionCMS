{if isset($_wrapper) && is_array($_wrapper) && count($_wrapper) == 2}{$_wrapper[0]}{/if}

<div class="box box-{$_type} type-{$_module} {if isset($_classes) && $_classes}{if is_array($_classes)}{implode(' ', $_classes)}{else}{$_classes}{/if}{/if}" {if isset($_attr) && $_attr}{$_attr}{/if}>
	<div box-overlay {if $_head}with-head{/if}></div>

	{if $_head}
		<h2 hidden>{trim(preg_replace('/<[^>]*>/', '', preg_replace('/\s+/', ' ', $_head)))}</h2>
		<div class="box-head text-ellipsis" title="{trim(preg_replace('/<[^>]*>/', '', preg_replace('/\s+/', ' ', $_head)))}">{$_head}</div>
	{/if}

	<div class="box-body">{$_body}</div>
</div>

{if isset($_wrapper) && is_array($_wrapper) && count($_wrapper) == 2}{$_wrapper[1]}{/if}