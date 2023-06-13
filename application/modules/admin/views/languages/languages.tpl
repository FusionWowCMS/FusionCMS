<section class="card" id="main_link">
	<header class="card-header">
		Languages (<div style="display:inline;" id="logs_count">{if !$languages}0{else}{count($languages)}{/if}</div>)
	</header>

<div class="card-body">
<table class="table table-responsive-md table-hover mb-0" id="log_list">
	<thead>
		<tr>
			<th>Language</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	{if $languages}
		{foreach from=$languages item=language key=flag}
				<tr>
				<td><img src="{$url}application/images/flags/{$flag}.png" alt="{$flag}"> {ucfirst($language)}</td>
				
				<td>{if $language == $default}
						<div style="color:green" class="pull-right">Default language</div>
					{elseif hasPermission("changeDefaultLanguage")}
						<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Languages.set('{$language}')">Set as default</a>
					{/if}
				</td>
				</tr>
		{/foreach}
	{/if}
	</tbody>
</table>
</div>
</div>