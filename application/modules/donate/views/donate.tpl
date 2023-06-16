<div class="container">
	<div class="row">
		
		{$link_active = "donate"}
		{include file="../../ucp/views/ucp_navigation.tpl"}
		
		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<div class="section-header">Donation <span>Panel</span></div>
			<div class="section-body">
			
				{if $use_paypal}
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					{if $use_paypal}
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="paypal-tab" data-bs-toggle="tab" data-bs-target="#paypal" type="button" role="tab" aria-controls="paypal" aria-selected="true">
								{lang("paypal", "donate")}
							</button>
						</li>
					{/if}
				</ul>
				
				<div class="tab-content">
					{if $use_paypal}
						<div class="tab-pane active" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
						
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
                                                <h1 class="card-title pricing-card-title">{$data.points} </h1>
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
				{else}
					<div class="text-center fw-bold py-5">
						{lang("no_methods", "donate")}
					</div>
				{/if}

			</div>
		</div>
	</div>
</div>