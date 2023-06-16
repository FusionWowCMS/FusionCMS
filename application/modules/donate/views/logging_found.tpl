<table class="table table-hover mb-0">
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
                    <span class="text-info" data-toggle="tooltip" title="Ongoing"><i class="fa-regular fa-circle-check fa-xl"></i></span>
                {elseif $paypal_log.status == 1}
                    <span class="text-success" data-toggle="tooltip" title="Success"><i class="fa-regular fa-circle-check fa-xl"></i></span>
                {elseif $paypal_log.status == 2}
                    <span class="text-warning" data-toggle="tooltip" title="Canceled"><i class="fa-regular fa-circle-check fa-xl"></i></span>
                {elseif $paypal_log.status == 3}
                    <span class="text-danger" data-toggle="tooltip" title="Error"><i class="fa-regular fa-circle-check fa-xl"></i></span>
                {/if}
            </td>
		</tr>
	{/foreach}
</table>
<span id="show_more_count" {if $show_more <= 0}style="display:none;"{/if}>
	<!-- Instead of pagination, just use a "show more" button that will show next X logs every time you press it -->
	<a id="button_log_count" class="btn btn-primary btn-sm" style="display:block" onClick="Donate.loadMore(); return false;">Show more ({$show_more})</a>
	<input type="hidden" id="js_load_more" value="{$show_more}">
</span>