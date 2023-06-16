<div id="checkout_info">
	{lang("buying", "store")} <b>{$count} items</b> {lang("total_of", "store")}
	
	{if $vp}<img src="{$url}application/images/icons/lightning.png" align="absmiddle" /> <b>{$vp} {lang("vp", "store")}</b>{/if}
	{if $vp && $dp}and{/if}
	{if $dp}<img src="{$url}application/images/icons/coins.png" align="absmiddle" /> <b>{$dp} {lang("dp", "store")}</b>{/if}
	
	<div class="mb-3 d-flex justify-content-between">
	<a href="javascript:void(0)" onClick="Store.Cart.back()" class="nice_button button_left"><i class="fa-solid fa-circle-left"></i> {lang("go_back", "store")}</a>
	<a href="javascript:void(0)" onClick="Store.Cart.pay()" class="nice_button button_right">{lang("checkout", "store")} <i class="fa-solid fa-circle-right"></i></a>
	</div>
</div>

{foreach from=$realms item=realm key=realmId}

	<div class="card mb-3">
		<div class="card-header">{$realm.name}</div>
		<div class="card-body">

		{foreach from=$realm.items item=item}
			<div class="row store_item" id="checkout_item_{$item.id}">

				<div class="col-md-1 mt-1">
				<img class="item_icon" src="https://icons.wowdb.com/retail/medium/{$item.icon}.jpg" align="absmiddle" {if $item.tooltip}data-realm="{$item.realm}" rel="item={$item.itemid}"{/if}>
				</div>
				<div class="col-md-8 mt-1">
				<a {if $item.tooltip}href="{$url}item/{$item.realm}/{$item.itemid}" data-realm="{$item.realm}" rel="item={$item.itemid}"{/if} class="item_name q{$item.quality}">
					{$item.name}
				</a>
					<br>{$item.description}
				</div>
				
				{if ($item.query && $item.query_need_character) || !$item.query}
					<div class="col-md-3">
						{if $realm.characters}
							<select data-id="{$item.id}" data-available="1">
								{foreach from=$realm.characters item=character}
									<option value="{$character.guid}">{$character.name} (Lvl {$character.level})</option>
								{/foreach}
							</select>
						{else}
							<div style="height:10px;"></div>
							<b>{lang("no_character", "store")}</b>
						{/if}
					</div>
				{/if}
			</div>
		{/foreach}
		</div>
	</div>

{/foreach}