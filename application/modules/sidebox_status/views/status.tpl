{foreach from=$realms item=realm}
	<div class="card mb-3">
		<div class="card-header fw-bold">{$realm->getName()}</div>
		<div class="card-body {if !$realm->isOnline()}text-center{/if}">
			{if $realm->isOnline()}
				<p>{$realm->getOnline()} / {$realm->getCap()}</p>
				
				<div class="progress">
					<div class="progress-bar" role="progressbar bg-success" style="width: {$realm->getPercentage()}%" aria-valuenow="{$realm->getPercentage()}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			{else}
				Offline
			{/if}
		</div>
	</div>
{/foreach}

	<!--
		Other values, for designers:

		$realm->getOnline("horde")
		$realm->getPercentage("horde")

		$realm->getOnline("alliance")
		$realm->getPercentage("alliance")

	-->

<div class="card text-center">
	<div class="card-body border-0">set realmlist {$realmlist}</div>
</div>