<div class="row">
	<div class="col-lg-3 mb-4 mb-xl-0">
		<section class="card">
			<div class="card-body">
				<div class="thumb-info mb-3">
					<img src="{$avatar}" class="rounded img-fluid" width="199px" height="199px">
					<div class="thumb-info-title">
						<span class="thumb-info-inner">({$external_details.id}) <b>{$external_details.username}</b></span>
						<span class="thumb-info-type">{foreach from=$groups item=group}{$group.name}{/foreach}</span>
					</div>
				</div>

				<ul class="list-group list-group-flush">
					<li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
						<b style="color:#808697;">Displayname</b> <a class="pull-right text-muted-800 dark:text-white"><b>{$internal_details.nickname}</b></a>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
						<b style="color:#808697;">Email</b> <a class="pull-right text-muted-800 dark:text-white"><b>{$external_details.email}</b></a>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
						<b style="color:#808697;">GM Level </b> <a class="pull-right text-muted-800 dark:text-white"><b>{if !$access_id}0{else}{$access_id.gmlevel}{/if}</b> </a>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
						<b style="color:#808697;">Registration </b> <a class="pull-right text-muted-800 dark:text-white word-break"><b>{$external_details.joindate}</b> </a>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
						<b style="color:#808697;">Last login </b> <a class="pull-right text-muted-800 dark:text-white"><b>{$external_details.last_login}</b> </a>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
						<b style="color:#808697;">Last IP </b> <b><a class="pull-right text-muted-800 dark:text-white" href="https://db-ip.com/{$external_details.last_ip}" target="_blank">{$external_details.last_ip}</a></b>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
						<b style="color:#808697;">VP </b> <a class="pull-right text-muted-800 dark:text-white"><b>{$internal_details.vp}</b> </a>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
						<b style="color:#808697;">DP </b> <a class="pull-right text-muted-800 dark:text-white"><b>{$internal_details.dp}</b> </a>
					</li>
				</ul>

				<hr class="dotted short">
			</div>
		</section>
	</div>
	<div class="col-lg-9">
		<div class="tabs">
			<ul class="nav nav-tabs mb-2">
				<li class="nav-item">
					<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 bg-white border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl active" href="#overview" data-bs-target="#overview" data-bs-toggle="tab">Overview</a>
				</li>
				<li class="nav-item">
					<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 bg-white border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl mx-2" href="#edit" data-bs-target="#edit" data-bs-toggle="tab">Edit</a>
				</li>
			</ul>
			<div class="tab-content border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-xl p-6">
				<div id="overview" class="tab-pane active">
					<h4 class="mb-3 font-weight-semibold text-dark">Timeline</h4>

					<div class="timeline timeline-simple">
					{if $logs}
						<div class="tm-body">
						{foreach from=$logs item=log}
							<ol class="tm-items">
								<li>
									<div class="tm-box">
										<p class="text-muted mb-0">{date("d.m.Y H:i:s", $log.time)} <span class="float-end"><a href="https://db-ip.com/{$log.ip}" target="_blank">{$log.ip}</a></span></p>
										<p> {if $log.status == 'succeed'}<i class="fa-regular fa-circle-check text-success"></i>{else}<i class="fa-regular fa-circle-xmark text-danger"></i>{/if} {$log.message}</p>
									</div>
								</li>
							</ol>
						{/foreach}
						</div>
						<div id="show_more_count">
							<div class="timeline-item" >
								<input type="hidden" id="js_load_more" value="{$show_more}">
							</h3>
							</div>
						</div>
					{/if}
					</div>
				</div>
				<script type="text/javascript">
				function isIntoView(elem)
				{
					var documentViewTop = $(window).scrollTop();
					var documentViewBottom = documentViewTop + $(window).height();
				
					var elementTop = $(elem).offset().top;
					var elementBottom = elementTop + $(elem).height();
				
					return ((elementBottom <= documentViewBottom) && (elementTop >= documentViewTop));
				}
				$(window).scroll(function()
				{
					
					if(document.getElementById("show_more_count") !== null)
					{
						if (isIntoView($('#show_more_count')))
						{
							Accounts.loadMore({$external_details.id},true);
						}
					}
				})
				</script>

				<div id="edit" class="tab-pane">
					<h4 class="mb-3 font-weight-semibold text-dark">Account edit</h4>
					<form onSubmit="Accounts.save(this, {$external_details.id}); return false" id="submit_form">

						<div class="row mb-3">
							<div class="form-group col-md-6">
								<label for="nickname">Displayname</label>
								<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="nickname" name="nickname" value="{$internal_details.nickname}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
							</div>
						
							<div class="form-group col-md-6 border-top-0 pt-0">
								<label for="email">Email</label>
								<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="email" name="email" value="{$external_details.email}" disabled="disabled">
							</div>
						</div>

						<div class="row mb-3">
							<div class="form-group col-md-6">
								<label for="gm_level">GM-level</label>
								<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 99 }'>
									<div class="input-group">
										{foreach from=$access_id item=gmlevel}
											<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="gm_level" name="gm_level" value="{if !$gmlevel}0{else}{$gmlevel}{/if}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
										{/foreach}
										<div class="spinner-buttons input-group-btn btn-group-vertical">
											<button type="button" class="btn spinner-up btn-xs btn-default" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
												<i class="fas fa-angle-up"></i>
											</button>
											<button type="button" class="btn spinner-down btn-xs btn-default" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
												<i class="fas fa-angle-down"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						
							<div class="form-group col-md-6 border-top-0 pt-0">
								<label for="expansion">Expansion</label>
								<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="expansion" name="expansion" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
									{foreach from=$expansions key=id item=expansion}
										<option value="{$id}" {if $external_details.expansion == $id}selected{/if}>{$expansion}</option>
									{/foreach}
								</select>
							</div>
						</div>

                        <div class="form-group row mb-3">
							<div class="col-sm-6">
                            <label class="col-sm-6 col-form-label" for="vp">Vote-Points</label>
								<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
									<div class="input-group">
										<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="vp" name="vp" value="{$internal_details.vp}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
										<div class="spinner-buttons input-group-btn btn-group-vertical">
											<button type="button" class="btn spinner-up btn-xs btn-default" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
												<i class="fas fa-angle-up"></i>
											</button>
											<button type="button" class="btn spinner-down btn-xs btn-default" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
												<i class="fas fa-angle-down"></i>
											</button>
										</div>
									</div>
								</div>
							</div>

                            <div class="col-sm-6">
                            <label class="col-sm-6 col-form-label" for="dp">Donation-Points</label>
								<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
									<div class="input-group">
										<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="dp" name="dp" value="{$internal_details.dp}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
										<div class="spinner-buttons input-group-btn btn-group-vertical">
											<button type="button" class="btn spinner-up btn-xs btn-default" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
												<i class="fas fa-angle-up"></i>
											</button>
											<button type="button" class="btn spinner-down btn-xs btn-default" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
												<i class="fas fa-angle-down"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row mb-3">						
							<div class="form-group col-md-6 border-top-0 pt-0">
								<label for="group">Website usergroup</label>
								<div style="border-radius: 5px;padding: 5px 10px;border: 1px solid #282d36;">Please assign groups at the <a href="{$url}admin/aclmanager/groups" style="color:#ffa800">group manager</a></div>
							</div>
						</div>
					
						{if hasPermission("editAccounts")}
							<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Save account</button>
						{/if}
					</form>
				</div>
			</div>
		</div>
	</div>
</div>