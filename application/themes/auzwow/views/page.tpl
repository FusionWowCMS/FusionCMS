{strip}

<div id="page_{$ci_module}" class="page page_{$ci_module}">
	<div class="content_header dotted_separator self_clear">
		<div class="content_header-left wide"><span class="content_header-title overflow_ellipsis"><i class="icon icon-pageinfo"></i> {if $headline == strip_tags($headline)}{'<i>'|cat:substr_replace($headline, '</i>', strpos($headline, ' '), 0)}{else}{$headline}{/if}</span></div>
	</div>

	<div class="page_body border_box self_clear">{$content}</div>
</div>

{/strip}