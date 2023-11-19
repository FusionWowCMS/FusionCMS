{literal}<?xml version='1.0' encoding='utf-8'?>{/literal}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>{$domain}</title>
		<link>{$link}</link>
		<description>{$page_description}</description>
		<language>{$page_language}</language>
		<category domain="{$domain}">NewsFeed</category>
		<generator>{$domain} Site</generator>
		<docs>http://www.rssboard.org/rss-specification</docs>
		<atom:link href="{$feed_url}" rel="self" type="application/rss+xml" />
		{foreach from=$articles item=article}
		<item>
			<guid isPermaLink='false'>{$article.id}</guid>
			<link>{$article.link}</link>
			<title>{$article.title}</title>
			<author>{$article.author}</author>
			<description>{$article.content}</description>
			<pubDate>{$article.date}</pubDate>
		</item>
		{/foreach}
	</channel>
</rss>