{foreach from=$results item=order_log}
		<table class="table table-responsive-md table-hover">
			<tr>
				<td width="20%">{date("Y/m/d", $order_log.timestamp)}</td>
				<td width="16%">
					<a href="{$url}profile/{$order_log.user_id}" target="_blank">
						{$order_log.username}
					</a>
				</td>

				<td width="35%">
					{if $order_log.vp_cost}<img src="{$url}application/images/icons/lightning.png" align="absmiddle" style="margin:0px;opacity:1;" /> <b>{$order_log.vp_cost} VP</b>&nbsp;&nbsp;&nbsp;{/if}
					{if $order_log.dp_cost}<img src="{$url}application/images/icons/coins.png" align="absmiddle"  style="margin:0px;opacity:1;"/> <b>{$order_log.dp_cost} DP</b>{/if}
				</td>

				<td>
					<a data-toggle="tooltip" data-placement="top" title="{foreach from=$order_log.json item=item}{$item.itemName} to {$item.characterName}<br />{/foreach}">{count($order_log.json)} items</a>
				</td>

				{if $order_log.completed == '0' && hasPermission("canRefundOrders")}
					<td style="text-align:right;">
						<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Orders.refund({$order_log.id}, this)">Refund</a>
					</td>
				{/if}
			</tr>
		</table>
{/foreach}