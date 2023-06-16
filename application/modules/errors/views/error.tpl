<div class="text-center">
	{if isset($is404) && $is404}

		<h2 class="h1 mt-5">4 <i class="fas fa-cog fa-spin"></i> 4</h1>
		<h4 class="h4 mb-5">{lang("lost", "error")}</h4>
		<p class="my-3">
			{lang("404_long", "error")}
		</p>
	{else}
		<h2 class="h2 my-5">{lang("lost", "error")}</h2>
		<p class="my-3">
			{$errorMessage}
		</p>
	{/if}

	<a href="{$url}" class="mt-3 nice_button">{lang("button_home", "error")}</a>
</div>