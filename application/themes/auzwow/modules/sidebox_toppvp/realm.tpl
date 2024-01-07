<table class="toppvp_table">
	{if $characters}
		<thead>
			<tr>
				<td class="head_char-rating">{lang('sidebox_pvp_N', 'theme_auzwow')}</td>
				<td class="head_char-name">{lang('sidebox_pvp_charname', 'theme_auzwow')}</td>
				<td class="head_char-class">{lang('sidebox_pvp_charclass', 'theme_auzwow')}</td>
				<td class="head_char-kills">{lang('sidebox_pvp_charkills', 'theme_auzwow')}</td>
			</tr>
		</thead>

		<tbody>
			{foreach from=$characters key=key item=character}
				<tr class="{if (($key + 1) %2) == 0}even{else}odd{/if}">
					<td class="char-rating">{$key + 1}</td>
					<td class="char-name"><a href="{$url}character/{$realm}/{$character.guid}" data-tip="{lang('view_profile', 'sidebox_toppvp')}">{$character.name}</a></td>
					<td class="char-class color-c{$character.class}">{$CI->realms->getClass($character.class)}</td>
					<td class="char-kills">{$character.totalKills} <span>{lang('kills', 'sidebox_toppvp')}</span></td>
				</tr>
			{/foreach}
		</tbody>
	{else}
		<tbody>
			<tr>
				<td class="no_stats">{lang('no_stats', 'sidebox_toppvp')}</td>
			</tr>
		</tbody>
	{/if}
</table>