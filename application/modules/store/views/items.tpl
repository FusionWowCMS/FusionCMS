<div class="row">
<div class="tabs">
	<ul class="nav nav-tabs mb-2">
		<li class="nav-item">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl active" href="#items" data-bs-target="#items" data-bs-toggle="tab">Items</a>
		</li>
		<li class="nav-item">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl mx-2" href="#groups" data-bs-target="#groups" data-bs-toggle="tab">Groups</a>
		</li>
	</ul>
	<div class="tab-content border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-xl p-6">
		<div class="tab-pane active" id="items">
			<div class="btn-toolbar justify-content-between">
				<div class="input-group group/nui-input relative">
					<input type="text" id="ItemSeachInput" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-9 rounded-xl pe-24 !bg-muted-100 dark:!bg-muted-700 focus:!bg-white dark:focus:!bg-muted-900" placeholder="Search">
					<div class="text-muted-400 group-focus-within/nui-input:text-primary-500 absolute start-0 top-0 flex items-center justify-center transition-colors duration-300 peer-disabled:cursor-not-allowed peer-disabled:opacity-75 h-10 w-10">
						<svg data-v-cd102a71="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-[1.15rem] w-[1.15rem]" width="1em" height="1em" viewBox="0 0 24 24">
							<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
								<circle cx="11" cy="11" r="8"></circle>
								<path d="m21 21l-4.35-4.35"></path>
							</g>
						</svg>
					</div>
				</div>
				{if hasPermission("canAddItems")}
					<span class="pull-right">
						<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}store/admin_items/add_item">Create item</a>
					</span>
				{/if}
			</div>

			{if $items}
			<table class="table table-responsive-md table-hover">
			<thead>
				<tr>
					<th>Icon</th>
					<th>Name</th>
					<th>Description</th>
					<th>Group</th>
					<th>Price</th>
					<th style="text-align:center;">Actions</th>
				</tr>
			</thead>
			<tbody id="ItemTableResult">
			{foreach from=$items item=item}
				<tr>
					<td><img style="opacity:1;" src="https://icons.wowdb.com/retail/small/{$item.icon}.jpg" /></td>
					<td data-bs-toggle="tooltip" data-placement="top" data-html="true" title="{$item.name}"><b class="q{$item.quality}">{character_limiter($item.name, 30)}</b></td>
					<td data-bs-toggle="tooltip" data-placement="top" data-html="true" title="{$item.description}">{character_limiter($item.description, 20)}</td>
					<td>{if array_key_exists("title", $item) && $item.title}{$item.title}{/if}</td>
					<td>
						{if $item.vp_price}
							<img src="{$url}application/images/icons/lightning.png" style="opacity:1;margin-top:3px;position:absolute;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$item.vp_price} VP
						{/if}
						{if $item.dp_price}
							<img src="{$url}application/images/icons/coins.png" style="opacity:1;margin-top:3px;position:absolute;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							{$item.dp_price} DP
						{/if}
					</td>
					<td style="text-align:center;">
						{if hasPermission("canEditItems")}
							<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}store/admin_items/edit/{$item.id}">Edit</a>
						{/if}
			
						{if hasPermission("canRemoveItems")}
							<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Items.remove({$item.id}, this)">Delete</a>
						{/if}
					</td>
				</tr>
			{/foreach}
			</tbody>
			</table>
			{/if}
      	</div>
      	<div class="tab-pane" id="groups">
			{if hasPermission("canAddGroups")}
			<span class="pull-right">
				<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}store/admin_items/add_group">Create group</a>&nbsp;
			</span>
			{/if}
			<td>{if $groups}
			<table class="table table-responsive-md table-hover">
			<thead>
				<tr>
					<th>Order #</th>
					<th>Name</th>
					<th style="text-align:center;">Actions</th>
				</tr>
			</thead>
			{foreach from=$groups item=group}
				<tr>
					<td>{$group.orderNumber}</td>
					<td>{$group.title}</td>
					<td style="text-align:center;">
						{if hasPermission("canEditGroups")}
							<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}store/admin_items/edit_group/{$group.id}">Edit</a>
						{/if}
			
						{if hasPermission("canRemoveGroups")}
							<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Items.removeGroup({$group.id}, this, true)">Delete</a>
						{/if}
					</td>
				</tr>
			{/foreach}
			</table>
			{/if}
      	</div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
   
        $("#ItemSeachInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();     
            $("#ItemTableResult tr").filter(function () {
                $(this).toggle($(this).text()
                  .toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>