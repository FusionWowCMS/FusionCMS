{if $cache.item && (($trans && $cache.trans) || !$trans)}
	<span class="get_icon_{$item}">
		<div class="item" {if $cache.item.displayid}equiplist="[{$cache.item.InventoryType}, {if $trans && $cache.trans}{$cache.trans.displayid}{else}{$cache.item.displayid}{/if}]{/if}">
			{if $trans}<a href="{$url}item/{$realm}/{$trans}" class="item-trans" rel="item={$trans}" data-realm="{$realm}"></a>{/if}
			<a href="{$url}item/{$realm}/{$item}" rel="item={$item}{if $trans && $cache.trans}&transmog={$cache.trans.name}{/if}" data-realm="{$realm}"></a>
			<img src="{$CI->config->item('api_item_icons')}/large/{$cache.item.icon}.jpg" />
		</div>
	</span>
{else}
	<span class="get_icon_{$item}">
		<div class="item">
			<a></a>
			<div class="text-center fa-2x" style="height:56px; width:56px;">
				<i class="fa-duotone fa-spinner fa-spin align-middle"></i>
			</div>
		</div>
	</span>

	<script type="text/javascript">
		function Interval{$item}()
		{
			if(typeof Character != "undefined")
			{
				Character.getItem({$item}, {($trans) ? $trans : 'false'}, {$realm}, '{$CI->config->item('api_item_icons')}');
			}
			else
			{
				setTimeout(Interval{$item}, 100);
			}
		}

		$(document).ready(function()
		{
			Interval{$item}();
		});
	</script>
{/if}