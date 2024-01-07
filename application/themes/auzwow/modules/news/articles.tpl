<div class="content_header dotted_separator">
	<div class="content_header-left {if !isset($single)}wide{/if}"><span class="content_header-title overflow_ellipsis" title="{preg_replace('/<[^>]*>/', '', sprintf(lang('news_latest_news', 'theme_auzwow'), $CI->config->item('server_name')))}"><i class="icon icon-pageinfo"></i> {sprintf(lang('news_latest_news', 'theme_auzwow'), $CI->config->item('server_name'))}</span></div>
	{if isset($single)}<div class="content_header-right">{str_replace('&nbsp;', '', $pagination)}</div>{/if}
	<div class="clear"></div>
</div>

{foreach from=$articles key=key item=article}
	{$rank = $CI->acl_model->getGroupsByUser($article.author_id)}
	{$rank = end($rank)}

	<article id="post_{$article.id}" class="post post_{$article.id} {if $article.comments != -1}has_comments{/if} {if $article.avatar}has_avatar{/if} {if isset($single)}expandable {if $key != 0}collapsed{/if}{/if} self_clear">
		<div class="post-left" {if isset($single)}style="{if $key != 0}height:1px;opacity:0{else}height:auto;opacity:1{/if}"{/if}>
			<div class="post_author-avatar"><img src="{$CI->user->getAvatar($article.author_id)}" width="120" height="120" alt="{sprintf(lang('global_user_avatar', 'theme_auzwow'), $article.author)}" /></div>
			<div class="post_author-name overflow_ellipsis"><a href="{$url}profile/{$article.author_id}" data-tip="{lang('view_profile', 'news')}">{$article.author}</a></div>
			{if isset($rank)}<div class="post_author-rank overflow_ellipsis" {if $rank.color}style="background-color:{$rank.color}"{/if}><span title="{$rank.name}">{$rank.name}</span></div>{/if}
			<div class="post_author-sendpm overflow_ellipsis"><a href="{$url}messages/create/{$article.author_id}" title="{sprintf(lang('news_send_pm', 'theme_auzwow'), $article.author)}">{sprintf(lang('news_send_pm', 'theme_auzwow'), $article.author)}</a></div>
		</div>

		<div class="post-right">
			<div class="post_header border_box">
				<h2 class="post_title overflow_ellipsis"><a href="{$url}news/view/{$article.id}" title="{$article.headline}">{if (strpos($article.headline, ' ') !== false)}{substr_replace($article.headline, '<i>', strpos($article.headline, ' ') + 1, 0)|cat:'</i>'}{else}{$article.headline}{/if}</a></h2>
				<span class="post_author">{lang('posted_by', 'news')} <a href="{$url}profile/{$article.author_id}" data-tip="{lang('view_profile', 'news')}">{$article.author}</a></span>
				<span class="post_date">{$article.date}</span>
				{if $article.comments != -1}<span class="post_comment"><a {$article.link} class="comments_button" {$article.comments_button_id} data-comments-container="#comments_{$article.id}"><i>{$article.comments}</i> {lang('comments', 'news')}</a></span>{/if}
				{if isset($single)}<a href="javascript:void(0)" class="icon icon-expand"></a>{/if}
			</div>

			<div class="post_body" {if isset($single)}style="{if $key == 0}display:block{else}display:none{/if}"{/if}>
				<div class="post_body-inner border_box">
					<div class="post_content self_clear">{$article.content}</div>

					{if $article.tags}<div class="post_tags">{foreach from=$article.tags item=tag}<a href="{$url}/news/{$tag.name}">{$tag.name}</a>{/foreach}</div>{/if}
				</div>

				<div class="comments" {$article.comments_id}></div>
			</div>

			{if isset($single)}<div class="border_fix" {if $key == 0}style="display:none"{/if}></div>{/if}
		</div>
	</article>
{/foreach}