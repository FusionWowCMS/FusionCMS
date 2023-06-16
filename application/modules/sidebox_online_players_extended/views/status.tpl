{foreach from=$realms item=realm key=index name=count}
	<div class="card sidebox mb-3">
		<div class="card-header d-flex justify-content-between align-items-center">
		{$realm->getName()} {if $realm->isOnline()} ({$realm->getOnline()}) {/if}
			{if $realm->isOnline()}
                {if $show_uptime}
                    <span data-tip="Uptime">
                        {$uptimes[$realm->getId()]}
                    </span>
                {/if}
            {else}
                <span>Offline</span>
            {/if}
        </div>
		
		{if $realm->isOnline()}
		<div class="card-body">
        <div class="realm-bar-wrapper">
            <div class="realm_bar">
                    <div data-tip="Horde: {$realm->getOnline('horde')} players" class="realm_bar_fill horde text-center" style="width:{$realm->getPercentage('horde')}%; height: {$bar_height} !important">
                    {if $realm->getOnline('horde') >= 1}<span>{$realm->getOnline('horde')}<span>{/if}</div>
                    <div data-tip="Alliance: {$realm->getOnline('alliance')} players" class="realm_bar_fill alliance text-center" style="width:{$realm->getPercentage('alliance')}%; height: {$bar_height} !important">
                    {if $realm->getOnline('alliance') >= 1}<span>{$realm->getOnline('alliance')}<span>{/if}</div>
            </div>
        </div>
        </div>
		{/if}

		<!--
			Other values, for designers:

			$realm->getOnline("horde")
			$realm->getPercentage("horde")

			$realm->getOnline("alliance")
			$realm->getPercentage("alliance")

		-->
	</div>
{/foreach}

<div class="sidebox text-center">
	<div class="sidebox-body border-0"> Total players online: {$total}</div>
</div>

<div class="sidebox text-center">
	<div class="sidebox-body border-0">set realmlist {$realmlist}</div>
</div>

<script>
    Tooltip.refresh();
</script>
