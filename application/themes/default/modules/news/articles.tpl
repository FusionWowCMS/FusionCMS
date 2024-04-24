{strip}

{* Module name *}
{$module = 'news'}

{* is single? *}
{$is_single = !isset($single)}

{* Layout *}
{$layout.type = "lg"}
{$layout.file = "{$theme_path}views{$DS}layouts{$DS}box.tpl"}

{foreach from=$articles key=key item=item}
	{* Classes *}
	{$classes = [$module|cat:'-'|cat:$item.id]}

	{if $is_single}
		{$classes[] = 'is-single'}
	{/if}

	{if $item.comments != -1}
		{$classes[] = 'has-comments'}
	{/if}

	{if $item.tags && is_array($item.tags)}
		{$classes[] = 'has-tags'}
	{/if}

	{if $item@first}
		{$classes[] = 'first-item'}
	{/if}

	{if $item@last}
		{$classes[] = 'last-item'}
	{/if}

	{* SEO url *}
	{$item.SEOurl = urlencode(str_replace('/', '-', $item.headline))}

	{* Default thumbnail (only for first item) *}
	{if !$item.type && !$is_single && $item@first}
		{* Set type *}
		{$item.type = 1}

		{* Set thumbnail *}
		{$item.type_content = [{$MY_image_path}|cat:'thumbnails/thumbnail-01.jpg']}
	{/if}

	{* Build head *}
	{capture assign=head}
		<a href="{$url}news/view/{$item.id}/{$item.SEOurl}" class="{$module}-title">{$item.headline}</a>
	{/capture}

	{* Build body *}
	{capture assign=body}
		{if $item.type}
			<div class="{$module}-thumbnail type-{$item.type}">
				{if $item.type == '1'}
					{* ========== Image ========== *}
					{if count($item.type_content) >= 2}
						<div class="{$module}-carousel owl-carousel owl-theme owl-dots-inside[pos:bottom]">
							{foreach from=$item.type_content item=image}
								<div class="thumbnail-item" style="background-image:url('{$writable_path}uploads/news/{$image}')"></div>
							{/foreach}
						</div>
					{else}
						<div class="thumbnail-item" style="background-image:url('{if strpos($item.type_content[0], $url) !== false}{$item.type_content[0]}{else}{$writable_path}uploads/news/{$item.type_content[0]}{/if}')"></div>
					{/if}
				{elseif $item.type == '2'}
					{* ========== Video ========== *}
					<iframe class="thumbnail-item" width="100%" height="100%" alt="" src="{$item.type_content}" allowfullscreen></iframe>
				{/if}
			</div>
		{/if}

		<div class="{$module}-content">{if $is_single}{$item.content}{else}{$item.summary}{/if}</div>

		{if !$is_single && isset($item.readMore) && $item.readMore}
			<div class="{$module}-buttons">
				<a href="{$url}news/view/{$item.id}/{$item.SEOurl}" class="nice_button" title="{lang('read_more', 'news')}">{lang('read_more', 'news')} <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/></svg></a>
			</div>
		{/if}

		<div class="{$module}-metadata">
			<div class="metadata-col">{lang('posted_by', 'news')} <a href="{$url}profile/{$item.author_id}" data-tip="{lang('view_profile', 'news')}">{$item.author}</a> {lang('on', 'news')} {$item.date}</div>
			{if $item.comments != -1}<div class="metadata-col"><a {$item.comments_button_id} href="{$url}news/view/{$item.id}/{$item.SEOurl}">{lang('comments', 'news')} ({$item.comments})</a></div>{/if}
		</div>

		{if $item.tags && is_array($item.tags)}
			<div class="{$module}-tags">
				{foreach from=$item.tags item=tag}
					<a href="{$url}/news/{$tag.name}">{$tag.name}</a>
				{/foreach}
			</div>
		{/if}
	{/capture}

	{* RENDER NEWS *}
	{include file=$layout.file _type=$layout.type _module=$module _head=$head _body=$body _classes=$classes}

	{* RENDER COMMENTS *}
	{if $is_single && $item.comments != -1}<div {$item.comments_id} class="{$module}-comments"></div>{/if}
{/foreach}

{if $pagination}{str_replace('class="pagination', 'class="pagination '|cat:$module|cat:'-pagination', $pagination)}{/if}

{/strip}