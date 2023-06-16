{if $visitors}
	{foreach from=$visitors key=user_id item=nickname}
		<a href="{$url}profile/{$user_id}">{$nickname}</a>
		{if count(array($visitors)) > 1},{/if}
	{/foreach}
{/if}

{if $guests}
	{$guests}

	{if $guests == 1}
		{lang("guest", "sidebox_visitors")}
	{else}
		{lang("guests", "sidebox_visitors")}
	{/if}.
{/if}