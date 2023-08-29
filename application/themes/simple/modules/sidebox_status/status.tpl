{foreach from=$realms key=key item=realm}
	<div class="realm type-status is-{if $realm->isOnline()}online{else}offline{/if}">
		<div class="row align-items-center">
			<div class="col text-start"><span class="realm-name" title="{$realm->getName()}">{$realm->getName()}</span></div>
			<div class="col text-end"><span class="realm-status" title="{if $realm->isOnline()}{$realm->getOnline()} / {$realm->getCap()}{else}{lang('global_offline', 'theme')}{/if}">{if $realm->isOnline()}{$realm->getOnline()} / {$realm->getCap()}{else}{lang('global_offline', 'theme')}{/if}</span></div>
		</div>

		<div class="row align-items-center">
			<div class="col">
				<div class="realm_bar">
					<div class="realm_bar_fill" style="width:{$realm->getPercentage()}%"></div>
				</div>
			</div>
		</div>
	</div>
{/foreach}

<div class="realm type-list">
	<div class="realm-list" title="set realmlist {$realmlist}">set realmlist <span>{$realmlist}</span></div>
</div>