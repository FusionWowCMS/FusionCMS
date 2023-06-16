<div class="card" id="main_changelog">
	<div class="card-header">
		Changes (<div style="display:inline;" id="changelog_count">{if !$changes}0{else}{count($changes)}{/if}</div>)
	
	{if hasPermission("canAddCategory")}
		<span>
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Changelog.add()">{lang("new_category", "changelog")}</a>
		</span>
	{/if}
	</div>
	<div class="card-body">
	{if $categories}
	
	{foreach from=$categories item=category}
	<div class="card-header mb-3">
		<table class="table table-responsive-md">
		<tbody style="border-top:none;">
			<tr>
				{if hasPermission("canAddChange")}
					<td style="font-family:tahoma,geneva,sans-serif;font-size:11px" width="5%"><a href="javascript:void(0)" onClick="Changelog.addChange({$category.id})" data-tip="افزودن آپدیت جدید"><i class="fa-solid fa-square-plus"></i></a></td>
				{/if}
				<td><b>{$category.typeName}</b></td>
				
				<td>
					{if hasPermission("canEditCategory")}
						<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Changelog.renameCategory({$category.id}, this)" data-tip="{lang("rename_category", "changelog")}"><i class="fa-solid fa-pen-to-square"></i></a>
					{/if}
					
					{if hasPermission("canRemoveCategory")}
						<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right mx-2" href="javascript:void(0)" onClick="Changelog.removeCategory({$category.id}, this)" data-tip="{lang("delete_category", "changelog")}"><i class="fa-solid fa-trash-can"></i></a>
					{/if}
				</td>
			</tr>
		</tbody>
		</table>

		{if $changes}
			<div class="card-body">
				<table class="table table-responsive-md" id="headline_{$category.id}">
					<thead>
						<tr>
							<th>Change</th>
							<th>User</th>
							<th>Date</th>
							<th style="text-align: center;">Action</th>
						</tr>
					</thead>
					<tbody>
					{foreach from=$changes item=change}
						{if $category.id == $change.type}
							<tr>
								<td>{$change.changelog}</td>
								<td>{$change.author}</td>
								<td>{date('Y/m/d', $change.time)}</td>
								
								<td style="text-align:center;">
									{if hasPermission("canEditChange")}
										<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}changelog/admin/edit/{$change.change_id}" data-tip="{lang("edit", "changelog")}"><i class="fa-solid fa-pen-to-square"></i></a>
									{/if}
		
									{if hasPermission("canRemoveChange")}
										<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Changelog.remove({$change.change_id}, this)" data-tip="{lang("delete", "changelog")}"><i class="fa-solid fa-trash-can"></i></a>
									{/if}
								</td>
							</tr>
						{/if}
					{/foreach}
					</tbody>
				</table>
			</div>
		{/if}
	</div>
	{/foreach}
	{/if}
	</div>
</div>

<div class="box big" id="add_changelog" style="display:none;">
	<div class="card-header"><h2><a href='javascript:void(0)' onClick="Changelog.add()" >{lang("update", "changelog")}</a><i class="fa-solid fa-regular fa-arrow-right px-2"></i>{lang("new_category", "changelog")}</h2></div>
	<div class="card-body">
	<form onSubmit="Changelog.create(this); return false" id="submit_form">
	<div class="form-group row mb-3">
	<label class="col-sm-2 col-form-label" for="text">{lang("category_name", "changelog")}</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="typeName" name="typeName"/>
	</div>
	</div>
		<input class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit" value="{lang("save", "changelog")}" />
	</form>
	</div>
</div>