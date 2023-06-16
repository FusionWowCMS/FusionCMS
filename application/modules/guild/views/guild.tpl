<div class="row">
	{if !$guild}
		<div class="text-center h1 my-5">{lang("doesnt_exist", "guild")}</div>
	{else}
		<div class="col-lg-4 py-5 pe-lg-5">
			<div class="section-header d-flex justify-content-between">
				{$guild.guildName}
			</div>
			<div class="setion-body">
				<div class="mb-4 motd">
					<div class="motd">
						{if $guildMotd}
							"{nl2br(trim($guildMotd))}"
						{else}
							{lang("no_motd", "guild")}
						{/if}
					</div>
					<div class="mt-4">
						<span class="fw-bold">{if $members}{count($members)}{/if}</span> {lang("members", "guild")}, {$realmName}
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<div class="section-header">{lang("members", "guild")}</div>
			<div class="section-body">
				<table class="table table-responsive text-nowrap nice_table">
					<thead>
						<tr>
							<th>{lang("members", "guild")}</th>
							<th>{lang("race", "guild")}</th>
							<th>{lang("class", "guild")}</th>
							<th>{lang("faction", "guild")}</th>
							<th>{lang("level", "guild")}</th>
							<th>{lang("rank", "guild")}</th>
						</tr>
					</thead>
					<tbody>
					<tr>
                        {if $leader}
                            <td><a href="{$url}character/{$realmId}/{$leader.guid}">{$leader.name}</a> <i class="fa-solid fa-crown"></i></td>
                            <td><img src="{$url}application/images/stats/{$leader.raceId}-{$leader.gender}.gif" width="20px"></td>
                            <td><img src="{$url}application/images/stats/{$leader.classId}.gif" width="20px"></td>
                            <td><img src="{$url}application/images/factions/{$leader.faction}.png" width="20px"></td>
                            <td>{$leader.level}</td>
                            <td>{lang("leader", "guild")}</td>
						{/if}
						{if $members}
							{foreach from=$members item=character}
								{if $character.guid != $guild.leaderguid}
								<tr>
									<td><a href="{$url}character/{$realmId}/{$character.guid}">{$character.name}</a></td>
									<td><img src="{$url}application/images/stats/{$character.raceId}-{$character.gender}.gif" width="20px"></td>
									<td><img src="{$url}application/images/stats/{$character.classId}.gif" width="20px"></td>
									<td><img src="{$url}application/images/factions/{$character.faction}.png" width="20px"></td>
									<td>{$character.level}</td>
									<td>{$character.rname}</td>
								</tr>
								{/if}
							{/foreach}
						{/if}
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	{/if}
</div>
