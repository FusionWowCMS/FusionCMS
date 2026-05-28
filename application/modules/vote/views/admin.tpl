<div class="card">
	<div class="card-header">
		{lang('topsites', 'vote')} (<div style="display:inline;" id="topsites_count">{if !$topsites}0{else}{count($topsites)}{/if}</div>){if hasPermission("canCreate")}<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}vote/admin/new">{lang('create_topsite', 'vote')}</a>{/if}
	</div>

	<div class="card-body">
		{if $topsites}
			<table class="table table-responsive-md table-hover">
				<thead>
				<tr>
					<th>{lang('image', 'vote')}</th>
					<th>{lang('name', 'vote')}</th>
					<th>{lang('interval', 'vote')}</th>
					<th style="text-align: center;">{lang('action', 'vote')}</th>
				</tr>
				</thead>
				<tbody>
				{foreach from=$topsites item=vote_site}
					<tr>
						<td>{if $vote_site.vote_image}<img src="{$vote_site.vote_image}" style="opacity:1;" />{else}{$vote_site.vote_sitename}{/if}</td>
						<td class="align-middle">{$vote_site.points_per_vote} {lang('voting_point_s', 'vote')}</td>
						<td class="align-middle">{$vote_site.hour_interval} {lang('hours', 'vote')}</td>
						<td class="align-middle" style="text-align:center;">
							{if hasPermission("canEdit")}
								<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}vote/admin/edit/{$vote_site.id}">{lang('edit', 'vote')}</a>
							{/if}

							{if hasPermission("canDelete")}
								<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Topsites.remove({$vote_site.id}, this)">{lang('delete', 'vote')}</a>
							{/if}
						</td>
					</tr>
				{/foreach}
			</table>
		{/if}
	</div>
</div>