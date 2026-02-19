{if $sessions}
	{assign var=session_count value=$sessions|count}
{else}
	{assign var=session_count value=0}
{/if}

<div class="col-12">
	<div class="card">
		<div class="card-header">
		{lang('users_past_30_minutes', 'admin', [$session_count])}
		<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Session.delete()">{lang('clear_sessions', 'admin')}</button>
		</div>
		<div class="card-body">
			<table class="table table-responsive-md table-hover">
			<thead>
				<tr>
					<th scope="col">{lang('time', 'admin')}</th>
					<th scope="col">{lang('name', 'admin')}</th>
					<th scope="col">{lang('ip', 'admin')}</th>
					<th scope="col">{lang('browser', 'admin')}</th>
					<th scope="col">{lang('os', 'admin')}</th>
				</tr>
			</thead>
			<tbody>
				{if $sessions}
					{foreach from=$sessions item=visitor}
						<tr>
							<td width="15%">
								{$visitor.date}
							</td>
							<td width="20%">
								{if isset($visitor.nickname)}
									<a href="{$url}profile/{$visitor.uid}" target="_blank">{$visitor.nickname}</a>
								{else}
									{lang('guest', 'admin')}
								{/if}
							</td>
							<td>
								{$visitor.ip_address}
							</td>
							<td width="20%">
								<img src="{$url}application/images/browsers/{$visitor.browser}.png" style="opacity:1;position:absolute;margin-top:2px;"/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ucfirst($visitor.browserName)}
							</td>
							<td width="20%">
								<img src="{$url}application/images/platforms/{$visitor.os}.png" style="opacity:1;position:absolute;margin-top:2px;"/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ucfirst($visitor.osName)}
							</td>
						</tr>
					{/foreach}
				{/if}
			</tbody>
			</table>
		</div>
    </div>
</div>
