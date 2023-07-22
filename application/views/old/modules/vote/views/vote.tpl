<table id="vote" class="nice_table" cellspacing="0" cellpadding="0">
	<tr>
		<td width="30%">{lang("topsite", "vote")}</td>
		<td width="30%">{lang("value", "vote")}</td>
		<td width="40%">&nbsp;</td>
	</tr>

	{if $vote_sites}
	{foreach from=$vote_sites item=vote_site}
		<tr>
			<td>{if $vote_site.vote_image}<img src="{$vote_site.vote_image}" />{else}{$vote_site.vote_sitename}{/if}</td>
			<td>{$vote_site.points_per_vote}
				{if $vote_site.points_per_vote > 1}
					{lang("voting_points", "vote")}
				{else}
					{lang("voting_point", "vote")}
				{/if}
			</td>
			<td id="vote_field_{$vote_site.id}">
				{if $vote_site.canVote}
					{form_open("vote/site/", $formAttributes)}
						<input type="hidden" name="id" value="{$vote_site.id}" />
						<input type="submit" onClick="Vote.open({$vote_site.id}, {$vote_site.hour_interval});" value="{lang("vote_now", "vote")}"/>
					</form>
				{else}
					{$vote_site.nextVote} {lang("remaining", "vote")}
				{/if}
			</td>
		</tr>
	{/foreach}
	{/if}
</table>

<div class="firefox" style="display:none;text-align:center;padding:10px;font-style:italic;">
	Please allow pop-up windows from this website to be able to vote.
</div>
