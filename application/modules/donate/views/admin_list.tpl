{if $type == "paypal"}
	{foreach from=$results item=paypal_log}
		<tr>
			<th width="20%">{date("Y/m/d H:i:s", $paypal_log.create_time)}</th>
			<td width="15%">
				<a href="{$url}admin/accounts/get/{$paypal_log.user_id}" target="_blank">
					{$paypal_log.nickname}
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
                    <span class="text-danger" data-toggle="tooltip" title="Canceled"><i class="fa-regular fa-circle-check fa-xl"></i></span>
                {/if}
            </td>
		</tr>
	{/foreach}
{/if}