{$first = true}

{foreach from=$realms key=key item=realm}
	<div class="realm type-status is-{if $realm->isOnline()}online{else}offline{/if}" __realmStatus__="{$realm->getId()}" {if !$first}style="display:none"{/if}>
		<div class="realm-name" title="{$realm->getName()}">{$realm->getName()}</div>
		<div class="realm-online" title="{if $realm->isOnline()}{$realm->getOnline()}{else}{lang('general_offline', 'theme')}{/if}">{if $realm->isOnline()}{$realm->getOnline()}{else}{lang('general_offline', 'theme')}{/if}</div>
	</div>

	{$first = false}
{/foreach}

{if is_array($realms) && count($realms) > 1}
	<div class="toggler-group">
		{$first = true}

		{foreach from=$realms key=key item=realm}
			<a href="javascript:void(0)" class="toggler {if $first}active{/if}" data-toggle="[__realmStatus__]" data-target="[__realmStatus__='{$realm->getId()}']"></a>

			{$first = false}
		{/foreach}
	</div>
{/if}