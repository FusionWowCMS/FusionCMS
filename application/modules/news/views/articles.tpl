{strip}

{* is single? *}
{$is_single = !isset($single)}

{* Required css codes *}
{if $is_single}<style type="text/css">[content] > .container > .row { display: block; } [mainbar] { width: 100%; max-width: 100%; } [notifications], [sidebar], [widgets] { display: none; }</style>{/if}

<div class="news-header">
	<div class="row">
		<div class="col-sm-12">
			{if $is_single}
				<a href="{$url}news" class="nice_button" title="See all news">See all news</a>
			{else}
				<h3 class="header-text" title="NEWS">{str_replace('&', '<span>&</span>', NEWS)}</h3>
			{/if}
		</div>
	</div>
</div>

{foreach from=$articles key=key item=article}
	{* Check for read more *}
	{if !$is_single && $article.content|count_characters >= 255}
		{$article.readMore = true}
	{/if}

	<article class="pagebody news-article {if $is_single}is-single{/if} {if $article.comments != -1}has-comments{/if} {if $article.tags}has-tags{/if} {if key(reset($articles)) == $key}first-item{/if} {if !isset($articles[$key + 1])}last-item{/if}">
		<div glow><div glow-lines></div></div>

			<div class="row">
			{if $article.type == '1'}
				{if count($article.type_content) >= 2}
					<div class="col-md-12 col-lg-4" thumbnail>
							<div class="owl-carousel news-carousel owl-theme show-nav-hover dots-inside nav-inside nav-style-1 nav-light mb-0">
								{foreach from=$article.type_content item=image}
									<figure class="article-thumbnail">
										<img  src="{$url}uploads/news/{$image}" height="auto" width="inherit">
									</figure>
								{/foreach}
							</div>
					</div>
				{else}
					<div class="col-md-12 col-lg-4" thumbnail>
						<figure class="article-thumbnail">
							<img src="{$url}uploads/news/{$article.type_content[0]}" width="100%" height="auto">
						</figure>
					</div>
				{/if}
			{elseif $article.type == '2'}
				<div class="article-thumbnail"><iframe src="{$article.type_content}" width="100%" height="100%" allowfullscreen></iframe></div>
			{/if}

				<div class="col-md-12 {if $article.type == '0'}col-lg-12{else}col-lg-8{/if}">
					<div class="article-head">
						<div class="article-title text-ellipsis"><a href="{$url}news/view/{$article.id}" title="{$article.headline}">{$article.headline}</a></div>
						<div class="article-metadata">{lang('posted_by', 'news')} <a href="{$url}profile/{$article.author_id}" data-tip="{lang('view_profile', 'news')}">{$article.author}</a>, {lang('on', 'news')} <time datetime="{$article.date}">{date('F j, Y', strtotime($article.date))}</time> {if $is_single && $article.comments != -1} - <a {$article.link} {$article.comments_button_id}>{lang('comments', 'news')} {$article.comments}</a>{/if}</div>
					</div>

					{if $is_single}<div class="divider"></div>{/if}

					<div class="article-body">
						<div class="article-content">{$article.content}</div>
					</div>

					{if isset($article.readMore)}
						<div class="article-foot">
							<a href="{$url}news/view/{$article.id}" class="nice_button btn-readmore" title="{lang("read_more", "news")}">{lang("read_more", "news")} <i class="icon-readmore"></i></a>
						</div>
					{/if}
				</div>
			</div>
	</article>

	{if $is_single && $article.comments != -1}<div class="news-comments" {$article.comments_id}></div>{/if}
{/foreach}

{if $pagination}{$pagination}{/if}

{/strip}

<script type="text/javascript">
	$('.news-carousel').owlCarousel({
		'items': 1,
		"dots": true,
		"loop": false,
		"margin": 10,
		"nav": false,
	})
</script>