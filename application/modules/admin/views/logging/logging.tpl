<div class="card">
	<div class="card-header">Logs</div>
	<div class="card-body table-responsive">
	<form class="row" onSubmit="Logging.search(); return false">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-1">
		<div class="input-group">
			<select id="module" name="module" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
				<option selected="selected" value="">-- All modules --</option>
				{foreach from=$modules item=module key=key}
					<option value="{$key}">{ucfirst($key)}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
		<div class="input-group">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="search" id="search" placeholder="Search by username, IP address or user ID">
			<button class="input-group-text" type="submit">Search</button>
		</div>
	</div>
	</form>

	<span id="log_list">
        {if $logs}
		<table class="table table-hover mb-0">
			<thead>
				<tr>
					<th>Module</th>
					<th>Date</th>
					<th>IP</th>
					<th>User</th>
					<th class="text-center">Status</th>
					<th>Message</th>
				</tr>
			</thead>
            {foreach from=$logs item=log}
				<tr>
					<td width="15%"><b>{ucfirst($log.module)}</b></td>
					<td width="20%">{date("Y-m-d H:i:s", $log.time)}</td>
					<td width="15%">{$log.ip}</td>
					<td width="10%">
						{if $log.user_id == 0}
							Guest
						{else}
							<a data-toggle="tooltip" title="View profile" href="../profile/{$log.user_id}" target="_blank">{$CI->user->getUsername($log.user_id)}</a>
						{/if}
					</td>
					<td class="text-center" width="15%">
					{if $log.status == 'succeed'}
						<span class="text-success"><i class="fa-regular fa-circle-check fa-xl"></i></span>
					{else}
						<span class="text-danger"><i class="fa-regular fa-circle-xmark fa-xl"></i></span>
					{/if}
					</td>
					<td>{$log.message}
					{if $log.custom}
						<span class="text-nowrap"><br>
						{foreach $log.custom as $key => $value}
							<b>{ucfirst($key)}</b>:
							{foreach $value as $subKey => $subValue}
								{if $subKey == 'old'}
									{$subValue} ->
								{elseif $subKey == 'new'}
									{$subValue}
								{else}
									{$subValue}
								{/if}
							{/foreach}<br>
						{/foreach}
						</span>
					{/if}
					</td>
				</tr>
            {/foreach}
		</table>
            <span id="show_more_count" {if $show_more <= 0}style="display:none;"{/if}>
                <!-- Instead of pagination, just use a "show more" button that will show next X logs every time you press it -->
                <a id="button_log_count" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" style="display:block" onClick="Logging.loadMore();">Show more ({$show_more})</a>
                <input type="hidden" id="js_load_more" value="{$show_more}"/>
            </span>
        {/if}
	</span>
	</div>
</div>