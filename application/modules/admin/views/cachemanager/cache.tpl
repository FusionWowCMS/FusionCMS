<script type="text/javascript">
	$(document).ready(function()
	{
		function checkIfLoaded()
		{
			if(typeof Fusion_Cache != "undefined")
			{
				Fusion_Cache.load();
			}
			else
			{
				setTimeout(checkIfLoaded, 50);
			}
		}
		checkIfLoaded();
	});
</script>

<section class="card">
	<header class="card-header">{lang('cache', 'admin')}</header>
	<div class="card-body">
	<span>
		{lang('cache_description', 'admin')}
	</span>

	<span id="cache_data">
		<li>{lang('loading_cache', 'admin')}<span style="padding:0px;display:inline;" id="loading_dots">...</span></li>
	</span>

	{if hasPermission("emptyCache")}
		<span>
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Fusion_Cache.clear('item')">{lang('clear_item_cache', 'admin')}</a>&nbsp;
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Fusion_Cache.clear('website')">{lang('clear_website_cache', 'admin')}</a>&nbsp;
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Fusion_Cache.clear('theme')">{lang('clear_theme_cache', 'admin')}</a>&nbsp;
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Fusion_Cache.clear('all')">{lang('clear_all_cache', 'admin')}</a>
		</span>
	{/if}
	</div>
</section>
