<section class="card">
	<header class="card-header">Email templates</header>
	<div class="card-body">
	{if $templates}
	<table class="table table-responsive-md table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th style="text-align: center;">Action</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$templates item=template}
			<tr>
				<td><b>{$template.id}</b></td>
				<td>{$template.template_name}</td>
				<td style="text-align:center;">
					<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}admin/email_template/edit/{$template.id}">Edit</a>
				</td>
			</tr>
		{/foreach}
		</tbody>
		</table>
	{/if}
	</div>
</section>