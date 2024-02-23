<script type="text/javascript">
	{* Create a link element *}
	const link = document.createElement('link');

	{* Set link properties *}
	link.rel  = 'stylesheet';
	link.type = 'text/css';
	link.href = '{$moduleUrl}assets/css/latest.css';

	{* Append our link to head *}
	document.getElementsByTagName('head')[0].appendChild(link);
</script>

<section>
<div >
{if $news}
	{foreach from=$news item=article}

    <a href="{$url}news/view/{$article.id}"  title="Go to News" >{$article.headline}</a>
        <p id="news_date">{$article.date}</p>
           <hr id="hr_news">
   {/foreach}

{/if}
</div>

</section>




      