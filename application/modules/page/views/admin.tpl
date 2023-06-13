<div class="card">
    <header class="card-header">Pages(<div style="display:inline;" id="page_count">{if !$pages}0{else}{count($pages)}{/if}</div>)
	{if hasPermission("canAdd")}
		<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}page/admin/new">Create page</a>
    </header>
	{/if}
	<div class="card-body">
	<table class="table table-responsive-md table-hover">
		<thead>
			<tr>
				<th scope="col" class="name">Page</th>
				<th scope="col" class="items">Name</th>
				<th scope="col" style="text-align:center;" class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			{if $pages}
			{foreach from=$pages item=page}
						<tr>
							<td width="25%"><a href="{$url}page/{$page.identifier}/" target="_blank">/page/{$page.identifier}/</a></td>
							<td width="60%"><b>{$page.name}</b></td>
							<td style="text-align:right;">
								{if hasPermission("canEdit")}
								<a href="{$url}page/admin/edit/{$page.id}"><button type="button" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Edit</button></a>&nbsp;
								{/if}
	
								{if hasPermission("canRemove")}
									<a href="javascript:void(0)" onClick="Pages.remove({$page.id}, this)"><button type="button" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Remove</button></a>
								{/if}
							</td>
						</tr>
			{/foreach}
			{/if}
		</tbody>
	</table>
	</div>
</div>