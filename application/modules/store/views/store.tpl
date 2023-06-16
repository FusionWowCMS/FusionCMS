<div class="container">
	<div class="row">
		
		{$link_active = "store"}
		{include file="../../ucp/views/ucp_navigation.tpl"}
		
		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<div id="store_wrapper">
				<script type="text/javascript">
					$(document).ready(function()
					{
						function checkIfLoaded()
						{
							if(typeof Store != "undefined")
							{
								Store.Customer.initialize({$vp}, {$dp});
							}
							else
							{
								setTimeout(checkIfLoaded, 50);
							}
						}

						checkIfLoaded();
					});
				</script>

				<div id="checkout"></div>

				
			<div id="store_wrapper">
				<div id="store">
					<form onSubmit="return false">
					<div class="row align-self-center mb-3">
							<label class="col-sm-1 align-self-center sort" for="sort_by">{lang("sort_by", "store")}</label>
							<div class="col-sm-2">
							<select id="sort_by" name="sort_by" onChange="Store.Filter.sort(this.value)">
								<option value="standard" selected>{lang("default", "store")}</option>
								<option value="name">{lang("name", "store")}</option>
								<option value="priceVp">{lang("price", "store")} ({lang("vp", "store")})</option>
								<option value="priceDp">{lang("price", "store")} ({lang("dp", "store")})</option>
								<option value="quality">{lang("item_quality", "store")}</option>
							</select>
							</div>
						
						<div class="col-sm-3">
							<select id="item_quality" name="item_quality" onChange="Store.Filter.setQuality(this.value)">
								<option value="ALL" selected>{lang("all_items", "store")}</option>
								<option value="0" class="q0">{lang("poor", "store")}</option>
								<option value="1" class="q1">{lang("common", "store")}</option>
								<option value="2" class="q2">{lang("uncommon", "store")}</option>
								<option value="3" class="q3">{lang("rare", "store")}</option>
								<option value="4" class="q4">{lang("epic", "store")}</option>
								<option value="5" class="q5">{lang("legendary", "store")}</option>
								<option value="6" class="q6">{lang("artifact", "store")}</option>
								<option value="7" class="q7">{lang("heirloom", "store")}</option>
							</select>
						</div>
						<div class="col-sm-3">
							<input class="form-control" type="text" id="filter_name" placeholder="{lang("filter", "store")}" onKeyUp="Store.Filter.setName(this.value)">
						</div>
						<div class="col-sm-3">
							<a href="javascript:void(0)" onClick="Store.Filter.toggleVote(this)" class="nice_button">
								<img src="{$url}application/images/icons/lightning.png" align="absmiddle"> {lang("vp", "store")}
							</a>

							<a href="javascript:void(0)" onClick="Store.Filter.toggleDonate(this)" class="nice_button">
								<img src="{$url}application/images/icons/coins.png" align="absmiddle"> {lang("dp", "store")}
							</a>
						</div>
						</div>

					</form>


					<div id="store_content">
						

						<div id="store_realms">
							{foreach from=$data item=realm key=realmId}
							<div class="accordion mb-3" id="realm_parent_{$realmId}">
								<div class="accordion-item">
									<h2 class="accordion-header" id="realm_{$realmId}">
									<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#realm_indicator_{$realmId}" aria-expanded="true" aria-controls="realm_indicator_{$realmId}">
										{$realm.name}
									</button>
									</h2>
									<div id="realm_indicator_{$realmId}" class="accordion-collapse collapse show" aria-labelledby="realm_{$realmId}" data-bs-parent="#realm_parent_{$realmId}">
									<div class="accordion-body">
										{if isset($realm.items.groups)}
											{foreach from=$realm.items.groups item=group}
												<div class="accordion mb-3" id="group_parent_{$group.id}_{$realmId}">
													<div class="accordion-item">
														<h2 class="accordion-header" id="group_{$group.id}">
														<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#group_{$group.id}_realm_{$realmId}" aria-expanded="true" aria-controls="group_{$group.id}_realm_{$realmId}">
															{$group.title}
														</button>
														</h2>
														<div id="group_{$group.id}_realm_{$realmId}" class="accordion-collapse collapse {if !$minimize}show{/if}" aria-labelledby="group_{$group.id}" data-bs-parent="#group_parent_{$group.id}_{$realmId}">
														<div class="accordion-body">
															{foreach from=$group.items item=item}
															<div class="store_item row p-2 border rounded mb-2" id="item_{$item.id}">
																<div class="col-md-1 mt-1">
																	<img class="item_icon img-responsive rounded" src="https://icons.wowdb.com/retail/medium/{$item.icon}.jpg" align="absmiddle" {if $item.tooltip}data-realm="{$item.realm}" rel="item={$item.itemid}"{/if}>
																</div>
																<div class="col-md-8 mt-1">
																	<a {if $item.tooltip}href="{$url}item/{$item.realm}/{$item.itemid}" data-realm="{$item.realm}" rel="item={$item.itemid}"{/if} class="item_name q{$item.quality} align-self-center">
																		{character_limiter($item.name, 20)}
																	</a>
																<p class="text-justify text-truncate mb-0">
																	{character_limiter($item.description, 25)}
																</p>
																</div>
																<div class="store_buttons align-items-center align-content-center col-md-3 border-left mt-1">
																		{if $item.vp_price}
																		<a href="javascript:void(0)" onClick="Store.Cart.add({$item.id}, '{$item.itemid}', '{addslashes($item.name)}', {$item.vp_price}, 'vp', '{addslashes($realm.name)}', {$realmId}, {$item.quality}, {$item.tooltip})" class="nice_button vp_button">
																			<img src="{$url}application/images/icons/lightning.png" align="absmiddle"> <span class="vp_price_value">{$item.vp_price}</span> {lang("vp", "store")}
																		</a>
																		{/if}
							
																		{if $item.dp_price}
																		<a href="javascript:void(0)" onClick="Store.Cart.add({$item.id}, '{$item.itemid}', '{addslashes($item.name)}', {$item.dp_price}, 'dp', '{addslashes($realm.name)}', {$realmId}, {$item.quality}, {$item.tooltip})" class="nice_button dp_button">
																			<img src="{$url}application/images/icons/coins.png" align="absmiddle"> <span class="dp_price_value">{$item.dp_price}</span> {lang("dp", "store")}
																		</a>
																		{/if}
																</div>
															</div>
															{/foreach}
														</div>
														</div>
													</div>
												</div>
											{/foreach}
										{/if}
													
										{if isset($realm.items)}
										{foreach from=$realm.items.items item=item}
										<div class="store_item" id="item_{$item.id}">
											<div class="store_buttons">
												{if $item.vp_price}
													<a href="javascript:void(0)" onClick="Store.Cart.add({$item.id}, '{$item.itemid}', '{addslashes(preg_replace('/"/', "'", $item.name))}', {$item.vp_price}, 'vp', '{addslashes($realm.name)}', {$realmId}, {$item.quality}, {$item.tooltip})" class="nice_button vp_button">
														<img src="{$url}application/images/icons/lightning.png" align="absmiddle"> <span class="vp_price_value">{$item.vp_price}</span> {lang("vp", "store")}
													</a>
													{/if}
					
													{if $item.dp_price}
													<a href="javascript:void(0)" onClick="Store.Cart.add({$item.id}, '{$item.itemid}', '{addslashes(preg_replace('/"/', "'", $item.name))}', {$item.dp_price}, 'dp', '{addslashes($realm.name)}', {$realmId}, {$item.quality}, {$item.tooltip})" class="nice_button dp_button">
														<img src="{$url}application/images/icons/coins.png" align="absmiddle"> <span class="dp_price_value">{$item.dp_price}</span> {lang("dp", "store")}
													</a>
													{/if}
											</div>
					
											<img class="item_icon" src="https://icons.wowdb.com/retail/medium/{$item.icon}.jpg" align="absmiddle" {if $item.tooltip}data-realm="{$item.realm}" rel="item={$item.itemid}"{/if}>
											<a {if $item.tooltip}href="{$url}item/{$item.realm}/{$item.itemid}" data-realm="{$item.realm}" rel="item={$item.itemid}"{/if} class="item_name q{$item.quality}">
												{character_limiter($item.name, 20)}
											</a>
											<br>{character_limiter($item.description, 25)}
											<div class="clear"></div>
										</div>
										{/foreach}
									{/if}
									</div>
									</div>
								</div>
							</div>
						{/foreach}	
						</div>
						
						<div class="card">
							<div id="cart">
								<div class="card-header"><span class="fas fa-shopping-cart"></span> {lang("cart", "store")} (<span id="cart_item_count">0</span> {lang("items", "store")})</div>
								<div class="card-body">
									<div id="empty_cart">{lang("empty_cart", "store")}</div>
									<div id="cart_items"></div>
								</div>
								<div class="card-footer">
									<div id="cart_price" class="d-flex">
										<div id="vp_price_full" class="p-2">
											<img src="{$url}application/images/icons/lightning.png"> <span id="vp_price">0</span> {lang("vp", "store")}
										</div>
				
										<div id="dp_price_full" class="p-2">
											<img src="{$url}application/images/icons/coins.png"> <span id="dp_price">0</span> {lang("dp", "store")}
										</div>

										<div class="ms-auto p-1">
											<a href="javascript:void(0)" onClick="Store.Cart.checkout(this)" class="nice_button">{lang("checkout", "store")}</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>