{foreach from=$realms key=key item=realm}
	{$realmId = $realm->getId()}

	<div id="realm_{$realmId}" class="realm_{$realmId} realm_holder {strtolower($realm->getExpansionSmallName())} {if $realm->isOnline()}online{else}offline{/if}" {if $key != 0}style="display:none"{/if}>
		<div class="realm_row row-1 border_box">
			<span class="r_name overflow_ellipsis" title="{$realm->getName()}">{if (strpos($realm->getName(), ' ') !== false)}{substr_replace($realm->getName(), '<i>', strpos($realm->getName(), ' ') + 1, 0)|cat:'</i>'}{else}{$realm->getName()}{/if}</span>
			<span class="r_status">{if $realm->isOnline()}{lang('global_online', 'theme_auzwow')}{else}{lang('global_offline', 'theme_auzwow')}{/if}</span>
		</div>

		<div class="realm_row row-2 border_box">
			<span class="r_statistics overflow_ellipsis" title="{if $realm->isOnline()}{$realm->getOnline()} {lang('sidebox_status_onlineplayers', 'theme_auzwow')}{else}{lang('global_offline', 'theme_auzwow')}{/if}">{if $realm->isOnline()}<i>{$realm->getOnline()}</i> {lang('sidebox_status_onlineplayers', 'theme_auzwow')}{else}{lang('global_offline', 'theme_auzwow')}{/if}</span>
		</div>

		<div class="realm_row row-3 border_box">
			<span class="r_list overflow_ellipsis" title="{lang('sidebox_status_setrealmlist', 'theme_auzwow')} {$realmlist}">{lang('sidebox_status_setrealmlist', 'theme_auzwow')} <i>{$realmlist}</i></span>
			{if isset($theme_configs.config.realm_desc[$realmId])}<span class="r_desc overflow_ellipsis" title="{preg_replace('/<[^>]*>/', '', $theme_configs.config.realm_desc[$realmId])}">{$theme_configs.config.realm_desc[$realmId]}</span>{/if}
		</div>
	</div>
{/foreach}

{if count($realms) > 1}
	<div class="realm_pagination">
		{foreach from=$realms key=key item=realm}
			<a {if $key == 0}class="active"{/if} onClick="CustomJS.switchRealm(this, '#realm_{$realm->getId()}')"></a>
		{/foreach}
	</div>
{/if}