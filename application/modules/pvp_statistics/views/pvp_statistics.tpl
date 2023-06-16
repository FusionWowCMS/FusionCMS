{if $realms_count > 0}
	<ul class="nav nav-pills mb-3" id="pvp-tab" role="tablist">
	<li class="nav-item" role="presentation">
		<button class="nav-link active" id="pvp-kills-tab" data-bs-toggle="pill" data-bs-target="#pvp-kills" type="button" role="tab" aria-controls="pvp-kills" aria-selected="true">Top Kills</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="pvp-2v2-tab" data-bs-toggle="pill" data-bs-target="#pvp-2v2" type="button" role="tab" aria-controls="pvp-2v2" aria-selected="false">2v2</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="pvp-3v3-tab" data-bs-toggle="pill" data-bs-target="#pvp-3v3" type="button" role="tab" aria-controls="pvp-3v3" aria-selected="false">3v3</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="pvp-5v5-tab" data-bs-toggle="pill" data-bs-target="#pvp-5v5" type="button" role="tab" aria-controls="pvp-5v5" aria-selected="false">5v5</button>
	</li>
	<li class="nav-item" role="presentation">
        <select style="width: 200px;" id="realm-changer" onchange="return RealmChange();">
            {foreach from=$realms item=realm key=realmId}
                <option value="{$realmId}" {if $selected_realm == $realmId}selected="selected"{/if}>{$realm.name}</option>
            {/foreach}
        </select>
    </li>
	</ul>
	<div class="tab-content" id="pills-tabContent">
	<div class="tab-pane fade show active" id="pvp-kills" role="tabpanel" aria-labelledby="pvp-kills-tab">
		<table class="nice_table">
			{if $TopHK}
				<tr>
					<td>{lang("rank", "pvp_statistics")}</td>
					<td>{lang("character", "pvp_statistics")}</td>
					<td>{lang("level", "pvp_statistics")}</td>
					<td>{lang("kills", "pvp_statistics")}</td>
					<td>{lang("race", "pvp_statistics")}</td>
					<td>{lang("class", "pvp_statistics")}</td>
				</tr>
				{foreach from=$TopHK item=character}
				<tr>
					<td>{$character.rank}</td>
					<td><a data-tip="View character 2v2" href="{$url}character/{$selected_realm}/{$character.guid}">{$character.name}</a></td>
					<td>{$character.level}</td>
					<td>{$character.kills}</td>
					<td><img src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif" width="20" height="20"></td>
					<td><img src="{$url}application/images/stats/{$character.class}.gif" width="20" height="20"></td>
				</tr>
				{/foreach}
			{else}
				<tr>
					<td colspan="5"><center>{lang("no_kills", "pvp_statistics")}</center></td>
				</tr>
			{/if}
		</table>
	</div>
	<div class="tab-pane fade" id="pvp-2v2" role="tabpanel" aria-labelledby="pvp-2v2-tab">
		{if $Teams2}
        <table class="nice_table">
			<tr>
				<td>{lang("rank", "pvp_statistics")}</td>
				<td>{lang("name", "pvp_statistics")}</td>
				<td>{lang("rating", "pvp_statistics")}</td>
				<td>{lang("members", "pvp_statistics")}</td>
			</tr>
			{foreach from=$Teams2 key=key item=team}
                <tr>
					<td>{$key + 1}</td>
                	<td>{$team.name}</td>
                	<td>{$team.rating} Rating</td>
                    <td>{if $team.members}
                        {foreach from=$team.members key=key item=member}
                            <a href="{$url}character/{$selected_realm}/{$member.guid}" data-tip="<font style='font-weight: bold;'>{$member.name}</font><br />Games played: {$member.games}<br />Games won: {$member.wins}<br />Personal Rating: {$member.rating}" id="team-member">
                                <img src='{$url}application/images/stats/{$member.class}.gif' align='absbottom'/>
                            </a>
                        {/foreach}
                    {/if}</td>
				</tr>
            {/foreach}
        {else}
            {lang("no_2v2", "pvp_statistics")}
        {/if}
		</table>
	</div>
	<div class="tab-pane fade" id="pvp-3v3" role="tabpanel" aria-labelledby="pvp-3v3-tab">
		{if $Teams3}
        <table class="nice_table">
			<tr>
				<td>{lang("rank", "pvp_statistics")}</td>
				<td>{lang("name", "pvp_statistics")}</td>
				<td>{lang("rating", "pvp_statistics")}</td>
				<td>{lang("members", "pvp_statistics")}</td>
			</tr>
			{foreach from=$Teams3 key=key item=team}
                <tr>
					<td>{$key + 1}</td>
                	<td>{$team.name}</td>
                	<td>{$team.rating} Rating</td>
                    <td>{if $team.members}
                        {foreach from=$team.members key=key item=member}
                            <a href="{$url}character/{$selected_realm}/{$member.guid}" data-tip="<font style='font-weight: bold;'>{$member.name}</font><br>Games played: {$member.games}<br>Games won: {$member.wins}<br>Personal Rating: {$member.rating}" id="team-member">
                                <img src='{$url}application/images/stats/{$member.class}.gif' align='absbottom'>
                            </a>
                        {/foreach}
                    {/if}</td>
				</tr>
            {/foreach}
        {else}
            {lang("no_3v3", "pvp_statistics")}
        {/if}
		</table>
	</div>
	<div class="tab-pane fade" id="pvp-5v5" role="tabpanel" aria-labelledby="pvp-5v5-tab">
		{if $Teams5}
        <table class="nice_table">
			<tr>
				<td>{lang("rank", "pvp_statistics")}</td>
				<td>{lang("name", "pvp_statistics")}</td>
				<td>{lang("rating", "pvp_statistics")}</td>
				<td>{lang("members", "pvp_statistics")}</td>
			</tr>
			{foreach from=$Teams5 key=key item=team}
                <tr>
					<td>{$key + 1}</td>
                	<td>{$team.name}</td>
                	<td>{$team.rating} Rating</td>
                    <td>{if $team.members}
                        {foreach from=$team.members key=key item=member}
                            <a href="{$url}character/{$selected_realm}/{$member.guid}" data-tip="<font style='font-weight: bold;'>{$member.name}</font><br />Games played: {$member.games}<br />Games won: {$member.wins}<br />Personal Rating: {$member.rating}" id="team-member">
                                <img src='{$url}application/images/stats/{$member.class}.gif' align='absbottom'>
                            </a>
                        {/foreach}
                    {/if}</td>
				</tr>
            {/foreach}
        {else}
            {lang("no_5v5", "pvp_statistics")}
        {/if}
		</table>
	</div>
	</div>
{/if}