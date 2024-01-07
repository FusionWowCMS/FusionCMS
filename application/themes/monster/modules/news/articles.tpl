{foreach from=$articles item=article}
<div class="post box-shadow-inset">
   <div class="post_header clearfix">
      <div id="title"><a>{langColumn($article.headline)}</a></div>
      <div id="admin"></div>
   </div>
   <div class="post_body_news">
   {langColumn($article.content)}
   <hr></hr>
      <div id="info" class="clearfix text-shadow">
	  {if $article.comments != -1}
					<a {$article.link} class="comments_button" {$article.comments_button_id}>
						{lang("comments", "news")} ({$article.comments})
					</a>
		{/if}
		{lang("posted_by", "news")} <a href="{$url}profile/{$article.author_id}" data-tip="{lang("view_profile", "news")}">{$article.author}</a> {lang("on", "news")} {$article.date}
         <div style="width: 100%; text-align: left; display: inline-block;"></div>
      </div>
	  <div class="comments" {$article.comments_id}></div>
   </div>
</div>
{/foreach}
{$pagination}