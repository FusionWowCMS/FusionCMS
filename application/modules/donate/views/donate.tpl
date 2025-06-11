	<div class="row justify-content-center">

		<div class="col-lg-12">
			<div class="section-header text-center">{lang("payment_methods", "donate")}</span></div>
			<div class="section-body">

				{if $use_paypal || $additionalGateways|@count}

					<div id="donate-methods" class="donate-animated donate-visible d-flex flex-wrap justify-content-center gap-4 mt-4">

						{if $use_paypal}
							<a href="javascript:void(0);" onclick="Donate.showPaypal()" class="donate-card text-decoration-none">
								<div class="card text-center shadow border-0 p-3 h-100">
									<img src="{$url}application/modules/donate/images/paypal.png" alt="PayPal" class="donate-img mx-auto mb-2">
									<h6>PayPal</h6>
								</div>
							</a>
						{/if}

						{foreach from=$additionalGateways key=key item=item}
							<a href="{$item.url}" class="donate-card text-decoration-none">
								<div class="card text-center shadow border-0 p-3 h-100">
									<img src="{$item.icon}" alt="{$item.name}" class="donate-img mx-auto mb-2">
									<h6>{$item.name|capitalize}</h6>
								</div>
							</a>
						{/foreach}

					</div>

				{else}
					<div class="text-center fw-bold py-5">
						{lang("no_methods", "donate")}
					</div>
				{/if}

				{if $use_paypal}
					<div class="donate-animated tab-pane mt-5 d-none" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
						<div class="row row-cols-xs-1 row-cols-sm-2 row-cols-md-3 my-3 text-center justify-content-center">
							{foreach from=$paypal.values item=data key=key}
								<form class="col" action="" method="post">
									<div class="card mb-4 rounded-3 shadow-sm">
										<div class="card-header py-3">
											<h4 class="my-0 fw-normal">{$currency_sign}{$data.price}</h4>
										</div>
										<div class="card-body">
											<div class="overlay" id="overlay_{$data.id}">
												<div class="w-100 d-flex justify-content-center align-items-center">
													<div class="spinner"></div>
												</div>
											</div>
											<h1 class="card-title pricing-card-title">{$data.points}</h1>
											<p>{lang("dp", "donate")}</p>
											<input type="hidden" name="donation_type" value="paypal">
											<input type="hidden" name="data_id" value="{$data.id}" id="option_{$data.id}">
											<input type='submit' class="w-100 nice_button" value='{lang("donate", "donate")}' onclick="Donate.disableButton({$data.id})">
										</div>
									</div>
								</form>
							{/foreach}
						</div>
					</div>
				{/if}

			</div>
		</div>
	</div>
