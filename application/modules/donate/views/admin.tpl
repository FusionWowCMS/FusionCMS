{if $use_paypal}
	<div class="card" id="donate_articles">
		<header class="card-header">
			{lang('last_10_paypal_donations', 'donate')}
			<a href="{$url}donate/admin/settings" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right">{lang('settings', 'donate')}</a>
		</header>

		<div class="card-body">
			<form style="margin-top:0px;" onSubmit="Donate.search('paypal'); return false">
				<div class="input-group mb-3">
					<input class="form-control" type="text" name="search_paypal" id="search_paypal" placeholder="{lang('search_placeholder', 'donate')}">
					<input class="btn btn-primary" type="submit" value="{lang('search', 'donate')}" />
				</div>
			</form>

			<span id="donate_list_paypal">
		{if $paypal_logs}
			<div class="table-responsive">
			<table class="table table-hover" style="margin-bottom:0;">
				<thead>
					<tr>
						<th>{lang('date', 'donate')}</th>
						<th>{lang('username', 'donate')}</th>
						<th>{lang('price', 'donate')}</th>
						<th>{lang('points', 'donate')}</th>
						<th>{lang('payment_id', 'donate')}</th>
						<th class="text-center">{lang('status', 'donate')}</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$paypal_logs item=paypal_log}
						<tr id="paypal_id_{$paypal_log.id}">
							<th width="20%">{date("Y/m/d H:i:s", $paypal_log.create_time)}</th>
							<td width="15%">
								<a href="{$url}admin/accounts/get/{$paypal_log.user_id}" target="_blank">
									{$CI->user->getUsername($paypal_log.user_id)}
								</a>
							</td>
							<td width="15%">{$paypal_log.total} {$paypal_log.currency}</td>
							<td width="10%">{$paypal_log.points}</td>
							<td width="25%">{$paypal_log.payment_id}</td>
							<td class="text-center" width="15%">
                                {if $paypal_log.status == 0}
									<span class="text-default" data-toggle="tooltip" title="{lang('ongoing', 'donate')}"><i class="fa-duotone fa-hourglass-half"></i></span>
                                {elseif $paypal_log.status == 1}
                                    <span class="text-success" data-toggle="tooltip" title="{lang('success', 'donate')}"><i class="fa-duotone fa-circle-check"></i></span>
                                {elseif $paypal_log.status == 2}
                                    <span class="text-dark" data-toggle="tooltip" title="{lang('canceled', 'donate')}"><i class="fa-duotone fa-xmark"></i></span>
                                {elseif $paypal_log.status == 3}
                                    <span class="text-danger" data-toggle="tooltip" title="{lang('error', 'donate')}"><i class="fa-duotone fa-circle-exclamation"></i></span>
								{/if}
                            </td>
						</tr>
					{/foreach}
				</tbody>
			</table>
            <span id="show_more_count" {if $show_more <= 0}style="display:none;"{/if}>
                <a id="button_log_count" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" style="display:block" onClick="Donate.loadMore();">{lang('show_more', 'donate', [$show_more])}</a>
                <input type="hidden" id="js_load_more" value="{$show_more}">
            </span>
			</div>
		{else}
			{lang('no_logs', 'donate')}
		{/if}
    </span>
		</div>
	</div>
{/if}