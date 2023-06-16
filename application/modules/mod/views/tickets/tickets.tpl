<div class="card mb-3">
	<header class="card-header">
		{$realmName}

		{if $hasConsole}
			<a href="javascript:void(0)" onClick="Mod.kick({$realmId})" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right mx-1">
			<img src="{$url}application/images/icons/door_out.png" align="absmiddle">
				Kick
			</a>
		{/if}
	</header>
	<div class="card-body">
		<table class="table table-responsive-md table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>From</th>
					<th>Time</th>
					<th>Message</th>
					<th style="text-align:center;">Action</th>
				</tr>
			</thead>
			<tbody>
			{if $tickets}
				{foreach from=$tickets item=ticket}
					<tr>
						<td>#{$ticket.ticketId}</td>
						<td><a href="{$url}character/{$realmId}/{$ticket.guid}" target="_blank">{$ticket.name}</a></td>
						<td>{$ticket.ago}</td>
						<td>{$ticket.message_short}</td>
						<td style="text-align:center;">
							<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}mod/tickets/view/{$realmId}/{$ticket.ticketId}"> View</a>
						</td>
					</tr>
				{/foreach}
			{/if}
			</tbody>
		</table>
	</div>
</div>