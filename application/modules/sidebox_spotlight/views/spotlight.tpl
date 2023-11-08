{strip}

{* Load css *}
<script type="text/javascript">
	{* Create a link element *}
	const link = document.createElement('link');

	{* Set link properties *}
	link.rel  = 'stylesheet';
	link.type = 'text/css';
	link.href = '{$moduleUrl}assets/css/sidebox_spotlight.css';

	{* Append our link to head *}
	document.getElementsByTagName('head')[0].appendChild(link);
</script>

{* Load js *}
<script type="text/javascript" src="{$moduleUrl}assets/js/sidebox_spotlight.js" async></script>

{* Spotlight *}
<div class="spotlight">
	{if $spotlight}
		{foreach from=$spotlight key=key item=item}
			<div class="spotlight-item" spotlight="{$key}" {if $key != 0}style="display: none;"{/if}>
				{if $item.image}<div class="item-image" style="background-image: url('{$item.image}');"></div>{/if}
				{if $item.title}<div class="item-title" title="{$item.title}">{$item.title}</div>{/if}
				{if $item.contents}<div class="item-contents">{$item.contents}</div>{/if}
			</div>
		{/foreach}

		<div class="spotlight-pagination">
			{foreach from=$spotlight key=key item=item}
				<a href="javascript:void(0)" {if $key == 0}class="is-active"{/if} data-spotlight-toggle="[spotlight]" data-spotlight-target="[spotlight='{$key}']"></a>
			{/foreach}
		</div>
	{else}
		<div class="spotlight-error">No data were found.</div>
	{/if}
</div>

{/strip}