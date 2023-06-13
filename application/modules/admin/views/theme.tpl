{foreach from=$themes item=manifest key=id}
	{if $manifest.folderName == $current_theme}
		<script type="text/javascript">
			
			function checkForTheme()
			{
				if(typeof Theme != "undefined")
				{
					Theme.scroll({$id});
				}
				else
				{
					setTimeout(checkForTheme, 50);
				}
			}

			checkForTheme();
		</script>
	{/if}
{/foreach}

<div class="owl-carousel owl-theme" id="theme_list">
		{foreach from=$themes item=manifest key=id}
		<div id="item theme_overflow">
			<img class="img-thumbnail" src="{$url}application/themes/{$manifest.folderName}/{$manifest.screenshot}" onClick="Theme.select('{strtolower($manifest.folderName)}')"/>
		</div>
		{/foreach}
</div>

<script type="text/javascript">
	$('.owl-carousel').owlCarousel({
		"dots": true,
		"autoplay": true,
		"autoplayTimeout": 3000,
		"loop": true,
		"margin": 10,
		"nav": false,
		"responsive": {
			"0": {
				"items":1 
			}, 
			"600":{
				"items":3
			},
			"1000":{
				"items":6
			}
		} 
	})

</script>


<div class="ltablet:grid-cols-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
	{foreach from=$themes item=manifest key=id}
		<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-xl p-4">
			<div class="mb-3 flex items-center gap-3">
				<div class="relative inline-flex shrink-0 items-center justify-center outline-none h-8 w-8 rounded-full bg-muted-500/20 text-muted-500">
					<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300 rounded-full">
						<img src="{$url}application/themes/{$manifest.folderName}/{$manifest.screenshot}" class="max-h-full max-w-full object-cover shadow-sm dark:border-transparent h-8 w-8">
					</div>
				</div>
				<div class="leading-none">
					<h4 class="text-muted-800 dark:text-muted-100 font-sans text-sm font-medium">Author: {$manifest.author}</h4>
					<p class="text-muted-400 font-sans text-xs">Date: {if isset($manifest.date)} {$manifest.date} {else} 2023-01-01 {/if}</p>
				</div>
			</div>
			<div><img src="{$url}application/themes/{$manifest.folderName}/{$manifest.screenshot}" alt="{ucfirst($manifest.name)}" class="theme"></div>
			<div class="my-4 flex items-center justify-between">
				<div>
					<h4 class="text-muted-800 dark:text-muted-100 font-sans text-base font-medium">{ucfirst($manifest.name)}</h4>
					<div class="text-muted-400 flex items-center gap-1">
						<svg data-v-cd102a71="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-4 w-4" width="1em" height="1em" viewBox="0 0 256 256">
							<g fill="currentColor">
								<path d="M216 48v40H40V48a8 8 0 0 1 8-8h160a8 8 0 0 1 8 8Z" opacity=".2"></path>
								<path d="M208 32h-24v-8a8 8 0 0 0-16 0v8H88v-8a8 8 0 0 0-16 0v8H48a16 16 0 0 0-16 16v160a16 16 0 0 0 16 16h160a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16ZM72 48v8a8 8 0 0 0 16 0v-8h80v8a8 8 0 0 0 16 0v-8h24v32H48V48Zm136 160H48V96h160v112Z"></path>
							</g>
						</svg>
						<p class="font-sans text-sm">Version: {if isset($manifest.version)} {$manifest.version} {else} 1.0.0 {/if}</p>
					</div>
				</div>
				<div>
					<div class="flex">
						<div class="dark:bg-muted-800 relative flex shrink-0 items-center justify-center rounded-full bg-white transition-all duration-100 ease-in h-8 w-8 hover:-ms-2 hover:me-2 focus:-ms-2 focus:me-2">
							<div class="relative inline-flex shrink-0 items-center justify-center outline-none h-8 w-8 rounded-full bg-primary-500/20 text-primary-500 !scale-90" tooltip="Html5" data-tooltip="Html5">
								<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300 rounded-full">
									<img src="{$url}application/themes/admin/assets/images/html5.svg" class="max-h-full max-w-full object-cover shadow-sm dark:border-transparent h-8 w-8">
								</div>
								
							</div>
						</div>
						<div class="dark:bg-muted-800 relative flex shrink-0 items-center justify-center rounded-full bg-white transition-all duration-100 ease-in h-8 w-8 hover:-ms-2 hover:me-2 focus:-ms-2 focus:me-2 -ms-2 hover:-ms-4 hover:me-2 focus:-ms-4 focus:me-2">
							<div class="relative inline-flex shrink-0 items-center justify-center outline-none h-8 w-8 rounded-full bg-primary-500/20 text-primary-500 !scale-90" tooltip="Javascript" data-tooltip="Javascript">
								<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300 rounded-full">
									<img src="{$url}application/themes/admin/assets/images/js.svg" class="max-h-full max-w-full object-cover shadow-sm dark:border-transparent h-8 w-8">
								</div>
								
							</div>
						</div>
						<div class="dark:bg-muted-800 relative flex shrink-0 items-center justify-center rounded-full bg-white transition-all duration-100 ease-in h-8 w-8 hover:-ms-2 hover:me-2 focus:-ms-2 focus:me-2 -ms-2 hover:-ms-4 hover:me-2 focus:-ms-4 focus:me-2">
							<div class="relative inline-flex shrink-0 items-center justify-center outline-none h-8 w-8 rounded-full bg-primary-500/20 text-primary-500 !scale-90" tooltip="Css" data-tooltip="Css">
								<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300 rounded-full">
									<img src="{$url}application/themes/admin/assets/images/css.svg" class="max-h-full max-w-full object-cover shadow-sm dark:border-transparent h-8 w-8">
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="flex items-center gap-2">
				<a target="_blank" href="{$manifest.website}" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md w-full">Website</a>
				{if $manifest.folderName == $current_theme}
					<button type="button" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full" disabled> Current </button>
				{else}
					<button type="button" onClick="Theme.select('{strtolower($manifest.folderName)}');Theme.scroll({$id});" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 w-full"> Enable </button>
				{/if}
			</div>
		</div>
	{/foreach}
</div>