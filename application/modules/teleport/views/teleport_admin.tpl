<div class="card">
	<div class="card-header">
		{lang('teleport_locations', 'teleport')} (<div style="display:inline;" id="teleport_count">{if !$teleport_locations}0{else}{count($teleport_locations)}{/if}</div>){if hasPermission("canAdd")}<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}teleport/admin/new">{lang('create_teleport_location', 'teleport')}</a>{/if}
	</div>

	<div class="card-body">
		{if $teleport_locations}
			<table class="table table-responsive-md table-hover">
				<thead>
				<tr>
					<th>{lang('name', 'teleport')}</th>
					<th>{lang('description', 'teleport')}</th>
					<th>{lang('realm', 'teleport')}</th>
					<th>{lang('cost', 'teleport')}</th>
					<th style="text-align: center;">{lang('action', 'teleport')}</th>
				</tr>
				</thead>
				<tbody>
				{foreach from=$teleport_locations item=teleport_location}
					<tr>
						<td><b>{$teleport_location.name}</b></td>
						<td>{$teleport_location.description}</td>
						<td>{$teleport_location.realmName}</td>
						<td>
							{if $teleport_location.vpCost}
								<img src="{$url}application/images/icons/lightning.png" style="opacity:1;" /> {$teleport_location.vpCost} {lang('vp', 'teleport')}
							{elseif $teleport_location.dpCost}
								<img src="{$url}application/images/icons/coins.png" style="opacity:1;"/>
								{$teleport_location.dpCost} {lang('dp', 'teleport')}
							{elseif $teleport_location.goldCost}
								<img src="{$url}application/images/icons/coins.png" style="opacity:1;"/>
								{$teleport_location.goldCost} {lang('gold', 'teleport')}
							{else}
								{lang('free', 'teleport')}
							{/if}
						</td>
						<td style="text-align:center;">
							{if hasPermission("canEdit")}
								<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}teleport/admin/edit/{$teleport_location.id}">{lang('edit', 'teleport')}</a>
							{/if}
							{if hasPermission("canRemove")}
								<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Teleport.remove({$teleport_location.id}, this)">{lang('delete', 'teleport')}</a>
							{/if}
						</td>
					</tr>
				{/foreach}
			</table>
		{/if}
	</div>
</div>