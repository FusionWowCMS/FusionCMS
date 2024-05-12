{if $shouts}
	{foreach from=$shouts item=shout}
		<div class="shout">
			<span class="shout_date">{$shout.date} {lang("ago", "sidebox_shoutbox")} {if $user_is_gm}<a href="javascript:void(0)" onClick="Shoutbox.remove(this, {$shout.id})"><img src="{$url}application/images/icons/delete.png" align="absmiddle"/></a>{/if}</span>
			<div class="shout_author {if $shout.is_gm}shout_staff{/if}"><a href="{$url}profile/{$shout.author}" data-tip="{lang("view_profile", "sidebox_shoutbox")}">{if $shout.is_gm}<img src="{$url}application/images/icons/icon_blizzard.gif" align="absmiddle"/>&nbsp;{/if} {$shout.nickname}</a> {lang("said", "sidebox_shoutbox")}:</div>{word_wrap($shout.content, 35)}</div>
	{/foreach}
{/if}