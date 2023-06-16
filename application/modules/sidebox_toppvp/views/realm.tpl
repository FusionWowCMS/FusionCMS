{if $characters}
<table>
	<tbody>
	{foreach from=$characters key=key item=character}
	<tr>
		<td class="col-1"><span class="char-rank">{$key + 1}</span></td>
		<td class="col-2">
			<div class="char-raceclass">
				<img align="absbottom" src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif">
				<img align="absbottom" src="{$url}application/images/stats/{$character.class}.gif" width="20px">
			</div>
		</td>
		<td class="col-3"><a class="char-name" data-tip="{lang("view_profile", "sidebox_toppvp")}" href="{$url}character/{$realm}/{$character.guid}">{$character.name}</a> </td>
		<td class="col-4 text-right"><span class="char-kills"><i>{$character.totalKills}</i> {lang("kills", "sidebox_toppvp")}</span></td>
	<tr>
	{/foreach}
	</tbody>
</table>
{else}
<br>{lang("no_stats", "sidebox_toppvp")}<br><br>
{/if}