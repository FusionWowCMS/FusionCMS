{strip}

{* Define: News *}
{$news = [
	1 => false,
	2 => false,
	3 => false
]}

{* Define: Iterator *}
{$iterator = 0}

{* Define: is single *}
{$is_single = !isset($single)}

{* Format articles *}
{foreach from=$articles key=key item=item}
	{*----------------------------------------------------------------------*}
	{*---------------------------- FORMAT.START ----------------------------*}
	{*----------------------------------------------------------------------*}

	{* Define: SEOurl *}
	{$item.SEOurl = urlencode(str_replace('/', '-', $item.headline))}

	{* Define: thumbnail *}
	{$item.thumbnail = ($item.type && $item.type == '1' && isset($item.type_content[0])) ? ($url|cat:'writable/uploads/news/'|cat:$item.type_content[0]) : false}

	{* Set default thumbnail *}
	{if !$item.thumbnail}{$item.thumbnail = ($iterator == 0) ? ($MY_image_path|cat:'thumbnails/thumbnail-01.jpg') : ($MY_image_path|cat:'thumbnails/thumbnail-02.jpg')}{/if}

	{*----------------------------------------------------------------------*}
	{*----------------------------- FORMAT.END -----------------------------*}
	{*----------------------------------------------------------------------*}

	{*......................................................................*}

	{*----------------------------------------------------------------------*}
	{*--------------- GATHER DATA.START (handles front page) ---------------*}
	{*----------------------------------------------------------------------*}

	{if !$is_single}
		{* Build: Article *}
		{capture append=item}
			<div class="item type-{$ci_module} -compact {if $iterator == 0}-lg{else}-md{/if}" {if $item.thumbnail}style="--thumbnail: url('{$item.thumbnail}');"{/if}>
				<h2 hidden>{$item.headline}</h2>

				{* Article: Thumbnail *}
				{if $item.thumbnail}<div class="item-thumbnail"></div>{/if}

				{* Article: Info *}
				<div class="item-info">
					{* Info: Date *}
					<time datetime="{$item.date}" class="info-date" title="{$item.date}">{$item.date}</time>

					{* Info: Title *}
					<a href="{$url}news/view/{$item.id}/{$item.SEOurl}" class="info-title text-ellipsis" title="{$item.headline}">{$item.headline}</a>

					{* Info: Summary *}
					<div class="info-summary">{strip_tags($item.summary)}</div>

					{* Info: Buttons *}
					<div class="info-buttons">
						<a href="{$url}news/view/{$item.id}/{$item.SEOurl}" class="btn-blue" title="{lang('read_more', 'news')}">{lang('read_more', 'news')}</a>
					</div>
				</div>
			</div>
		{/capture}

		{* Gather: Article *}
		{$news[(($iterator == 0) ? 1 : (($iterator <= 3) ? 2 : 3))] = $news[(($iterator == 0) ? 1 : (($iterator <= 3) ? 2 : 3))]|cat:$item[0]}
	{/if}

	{*----------------------------------------------------------------------*}
	{*---------------- GATHER DATA.END (handles front page) ----------------*}
	{*----------------------------------------------------------------------*}

	{*......................................................................*}

	{*----------------------------------------------------------------------*}
	{*--------------- GATHER DATA.START (handles single page) --------------*}
	{*----------------------------------------------------------------------*}

	{if $is_single}
		{* Build: Article *}
		{capture append=item}
			<div class="item type-{$ci_module} -full">
				<h2 hidden>{$item.headline}</h2>

				{* Article: Head *}
				<div class="item-head">
					<a href="{$url}news/view/{$item.id}/{$item.SEOurl}" class="head-title text-ellipsis" title="{$item.headline}">{$item.headline}</a>
					<span class="head-metadata">{lang('posted_by', 'news')} <a href="{$url}profile/{$item.author_id}" data-tip="{lang('view_profile', 'news')}">{$item.author}</a> {lang('on', 'news')} {$item.date}</span>
				</div>

				{* Article: Body *}
				<div class="item-body">
					{if $item.type}
						<div class="body-thumbnail type-{$item.type}">
							{if $item.type == '1'}
								{*--------------------- Image ---------------------*}

								{if count($item.type_content) >= 2}
									<div class="owl-carousel owl-theme owl-dots-inside[pos:bottom]" owl>
										{foreach from=$item.type_content item=thumbnail}
											<div class="thumbnail-item" style="background-image: url('{$writable_path}uploads/news/{$thumbnail}');"></div>
										{/foreach}
									</div>
								{else}
									<div class="thumbnail-item" style="background-image: url('{$writable_path}uploads/news/{$item.type_content[0]}');"></div>
								{/if}
							{elseif $item.type == '2'}
								{*--------------------- Video ---------------------*}

								<iframe class="thumbnail-item" width="100%" height="100%" alt="" src="{$item.type_content}" allowfullscreen></iframe>
							{/if}
						</div>
					{/if}

					<div class="body-content">{$item.content}</div>

					{if $item.tags && is_array($item.tags)}
						<div class="body-tags">
							{foreach from=$item.tags item=tag}
								<a href="{$url}/news/{$tag.name}">{$tag.name}</a>
							{/foreach}
						</div>
					{/if}

					{if $item.comments != -1}<div {$item.comments_id} class="body-comments" news-comments></div>{/if}
				</div>
			</div>
		{/capture}

		{* Gather: Article *}
		{$news = $item[0]}
	{/if}

	{*----------------------------------------------------------------------*}
	{*---------------- GATHER DATA.END (handles single page) ---------------*}
	{*----------------------------------------------------------------------*}

	{$iterator = $iterator + 1}
{/foreach}

<div class="page-{$ci_module}">
	{if !$is_single}<div class="page-head -type-home text-ellipsis" title="{lang('news_pageTitle', 'theme')}">{formatTitle title=lang('news_pageTitle', 'theme')}</div>{/if}

	<div class="page-body">
		<div class="{$ci_module}-items">
			{if $is_single}
				{$news}
			{else}
				<div class="row g-3">
					<div class="col-xl-12 {if $news[2]}col-xxl-5{/if}">
						{$news[1]}
					</div>

					{if $news[2]}
						<div class="col-xl-12 col-xxl-7">
							{$news[2]}
						</div>
					{/if}

					{if $news[3]}
						<div class="col-xl-12">
							{$news[3]}
						</div>
					{/if}
				</div>
			{/if}
		</div>

		{if $pagination}{str_replace('class="pagination', 'class="pagination '|cat:$ci_module|cat:'-pagination', $pagination)}{/if}
	</div>
</div>

{/strip}