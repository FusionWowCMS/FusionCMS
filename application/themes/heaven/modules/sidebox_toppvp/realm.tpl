{* Define rank dictionary *}
{$rankDict = [
	1 => 'gold',
	2 => 'silver',
	3 => 'bronze'
]}

<table>
	<thead>
		<tr>
			<th>{lang('toppvp_rank', 'theme')}</th>
			<th>{lang('toppvp_player', 'theme')}</th>
			<th>{lang('toppvp_player_kills', 'theme')}</th>
		</tr>
	</thead>

	<tbody>
		{if $characters}
			{foreach from=$characters key=key item=item}
				<tr {if isset($rankDict[$key + 1])}{$rankDict[$key + 1]}{/if}>
					<td><span class="player-rank">{$key + 1}</span></td>
					<td><a href="{$url}character/{$realm}/{$item.guid}" class="player-name" data-tip="{lang('view_profile', 'sidebox_toppvp')}">{$item.name}</a></td>
					<td><span class="player-kills">{$item.totalKills}</span></td>
				</tr>
			{/foreach}
		{else}
			<tr>
				<td colspan="3">{lang('no_stats', 'sidebox_toppvp')}</td>
			</tr>
		{/if}
	</tbody>
</table>