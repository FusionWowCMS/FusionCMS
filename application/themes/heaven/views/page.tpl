<div class="page-{$ci_module} g-0">
	{if $headline}<h2 class="page-head -type-page text-ellipsis" title="{trim(preg_replace('/<[^>]*>/', '', preg_replace('/\s+/', ' ', $headline)))}">{$headline}</h2>{/if}
	<div class="page-body">{$content}</div>
</div>