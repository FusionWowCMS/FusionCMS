<style type="text/css">
	.collapse                         { visibility: inherit; }
	#logs-tab .nav-item button        { border-color: transparent; }
	#logs-tab .nav-item button.active { border-color: rgb(var(--color-primary-500) / var(--tw-border-opacity)); }
</style>

<div class="grid grid-cols-12 gap-6">
	{* Top *}
	<div class="col-span-12">
		<div class="flex flex-col gap-6">
			{* General info *}
			<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6">
				<div class="flex flex-col items-center md:flex-row">
					<div class="ltablet:flex-row ltablet:items-center flex flex-col items-center gap-4 text-center md:items-start text-md-start lg:flex-row lg:items-center">
						<div class="text-center text-md-start">
							<h2 class="font-heading text-xl font-light leading-tight text-muted-800 dark:text-white"><span>{if $response.available}{count($response.packages)} Updates available{else}{$response.message}{/if}</span></h2>
							<p class="font-alt text-base font-normal leading-normal leading-normal"><span class="text-muted-400">Last checked: {$last_checked} | Last updated: {($last_updated) ? $last_updated : 'Never'}</span></p>
						</div>
					</div>

					<div class="ltablet:flex-row ltablet:items-center ms-auto me-auto flex flex-col gap-6 text-center text-md-start lg:flex-row lg:items-center mt-4 mt-md-0 me-md-0">
						<div class="flex-1">
							<a href="{$releases_url}" target="_blank"><button type="button" class="btn btn-large is-button rounded is-button-default"><span>View on GitHub</span></button></a>

							{if $response.available}
								<button type="button" class="btn btn-large is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500" __update_install_button__>
									<span>Install updates</span>
									<div class="spinner-border spinner-border-sm text-light align-middle" role="status" style="display: none;" __update_install_button_spinner__><span class="sr-only">Loading...</span></div>
								</button>
							{/if}
						</div>
					</div>
				</div>
			</div>

			{* Trace installation *}
			<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6" style="display: none;" __update_trace___>
				<div class="mb-8 flex items-center justify-between">
					<h3 class="font-heading text-base font-semibold leading-tight text-muted-800 dark:text-white"><span>Trace installation</span></h3>
				</div>

				<div class="space-y-6">
					<div class="group/prose-code relative">
						<div class="absolute end-2 top-2 inline-flex items-center gap-1 text-xs opacity-40 transition-opacity duration-200 group-hover/prose-code:opacity-60 dark:group-hover/prose-code:opacity-80">
							<span>Trace</span>
						</div>

						<div class="prose prose-primary prose-muted dark:prose-invert prose-th:p-4 prose-td:p-4 prose-table:bg-white dark:prose-table:bg-muted-800 prose-table:border prose-table:border-muted-200 dark:prose-table:border-muted-700 prose-base markdown max-w-none doc-markdown">
							<textarea class="nui-focus border-muted-300 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full border bg-white font-monospace transition-all duration-300 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 min-h-[2.5rem] text-sm leading-[1.6] rounded placeholder:text-transparent dark:placeholder:text-transparent resize-none p-2" rows="15" readonly __update_trace_textarea__>Working...</textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{* Main *}
	<div class="ltablet:col-span-8 col-span-12 lg:col-span-8">
		<div class="flex flex-col gap-6">
			{if $response.available}
				{* Available updates *}
				<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6">
					<div class="mb-8 flex items-center justify-between">
						<h3 class="font-heading text-base font-semibold leading-tight text-muted-800 dark:text-white"><span>Available updates ({count($response.packages)})</span></h3>
					</div>

					<div class="space-y-6">
						{foreach from=$response.packages key=key item=item}
							<div class="flex w-full flex-col sm:flex-row sm:items-center">
								<div class="relative mb-4 flex items-center gap-2 px-6 mb-sm-0 sm:px-2 h-10">
									{* <div class="relative inline-flex shrink-0 items-center justify-center outline-none h-12 w-12 rounded-full bg-primary-500/20 text-primary-500">
										<div class="flex h-full w-full items-center justify-center overflow-hidden text-center transition-all duration-300 rounded-full">
											<img src="{$item.asset.author.avatar}" class="max-h-full max-w-full object-cover shadow-sm dark:border-transparent h-12 w-12">
										</div>
									</div> *}

									<div>
										<h4 class="font-heading text-sm font-medium leading-tight text-muted-700 dark:text-muted-100"><span>{$item.release.name}</span></h4>
										<p class="font-alt text-xs font-normal leading-tight text-muted-500 dark:text-muted-400"><span>Author: <a href="{$item.asset.author.html_url}" target="_blank">{$item.asset.author.name}</a></span></p>
									</div>
								</div>

								<div class="flex flex-col grow justify-end gap-2 sm:flex-row sm:items-center">
									<div class="relative flex h-8 items-center justify-end px-6 sm:h-10 sm:justify-center sm:px-2 w-full sm:w-40">
										<span class="text-muted-400 absolute start-8 top-1/2 mx-auto -translate-y-1/2 text-center font-sans text-xs font-medium uppercase sm:inset-x-0 sm:-top-10 sm:translate-y-0 sm:hidden">Created at</span>
										<span class="text-muted-500 dark:text-muted-400 line-clamp-1 font-sans text-sm" data-bs-html="true" data-bs-toggle="tooltip" data-bs-title="Created at <b>{$item.asset.created_at}</b>">{$item.asset.created_at}</span>
									</div>

									<div class="relative flex h-8 items-center justify-end px-6 sm:h-10 sm:justify-center sm:px-2 w-full sm:w-40">
										<span class="text-muted-400 absolute start-8 top-1/2 mx-auto -translate-y-1/2 text-center font-sans text-xs font-medium uppercase sm:inset-x-0 sm:-top-10 sm:translate-y-0 sm:hidden">Updated at</span>
										<span class="text-muted-500 dark:text-muted-400 line-clamp-1 font-sans text-sm" data-bs-html="true" data-bs-toggle="tooltip" data-bs-title="Updated at <b>{$item.asset.updated_at}</b>">{$item.asset.updated_at}</span>
									</div>

									<div class="relative flex h-8 items-center justify-end px-6 sm:h-10 sm:justify-center sm:px-2">
										<span class="text-muted-400 absolute start-8 top-1/2 mx-auto -translate-y-1/2 text-center font-sans text-xs font-medium uppercase sm:inset-x-0 sm:-top-10 sm:translate-y-0 sm:hidden">GitHub</span>
										<a href="{$item.release.html_url}" target="_blank"><button type="button" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 bg-white border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">View</button></a>
									</div>
								</div>
							</div>
						{/foreach}
					</div>
				</div>
			{/if}

			{* Update logs *}
			<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6">
				<div class="mb-8 flex items-center justify-between">
					<h3 class="font-heading text-base font-semibold leading-tight text-muted-800 dark:text-white"><span>Update logs</span></h3>
				</div>

				<div class="space-y-6">
					{if $logs && $logs|is_array}
						{$first = true}

						<ul id="logs-tab" class="nav nav-pills" role="tablist">
							{foreach from=$logs key=key item=item}
								<li class="nav-item" role="presentation">
									<button class="cursor-pointer text-base transition-all duration-300 border-primary-500 text-muted-800 dark:text-muted-100 text-muted-400 border-b-2 px-3 py-2 {if $first}active{/if}" id="logs-{$key}-tab" data-bs-toggle="pill" data-bs-target="#logs-{$key}" type="button" role="tab" aria-controls="logs-{$key}" aria-selected="{if $first}true{else}false{/if}">{$key}</button>
								</li>

								{$first = false}
							{/foreach}
						</ul>

						{$first = true}

						<div id="logs-tabContent" class="tab-content bg-transparent p-0">
							{foreach from=$logs key=key item=item}
								<div class="tab-pane fade {if $first}show active{/if}" id="logs-{$key}" role="tabpanel" aria-labelledby="logs-{$key}-tab" tabindex="0">
									<div class="group/prose-code relative">
										<div class="absolute end-2 top-2 inline-flex items-center gap-1 text-xs opacity-40 transition-opacity duration-200 group-hover/prose-code:opacity-60 dark:group-hover/prose-code:opacity-80">
											<span>{$key}</span>
										</div>

										<div class="prose prose-primary prose-muted dark:prose-invert prose-th:p-4 prose-td:p-4 prose-table:bg-white dark:prose-table:bg-muted-800 prose-table:border prose-table:border-muted-200 dark:prose-table:border-muted-700 prose-base markdown max-w-none doc-markdown">
											<textarea class="nui-focus border-muted-300 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full border bg-white font-monospace transition-all duration-300 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 min-h-[2.5rem] text-sm leading-[1.6] rounded placeholder:text-transparent dark:placeholder:text-transparent resize-none p-2" rows="30" readonly>{$item}</textarea>
										</div>
									</div>
								</div>

								{$first = false}
							{/foreach}
						</div>
					{else}
						There are no logs available.
					{/if}
				</div>
			</div>
		</div>
	</div>

	{* Side *}
	<div class="ltablet:col-span-4 col-span-12 lg:col-span-4">
		<div class="ptablet:grid-cols-2 grid gap-6 lg:flex lg:flex-col">
			{* Frameworks *}
			<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6">
				<div class="mb-8 flex items-center justify-between">
					<h3 class="font-heading text-base font-semibold leading-tight text-muted-800 dark:text-white"><span>Frameworks info</span></h3>
				</div>

				<div class="space-y-5">
					<div class="flex items-center gap-3">
						<div><h4 class="font-heading text-sm font-light leading-tight text-muted-800 dark:text-white"><span>FusionCMS:</span></h4></div>
						<div class="ms-auto text-end">v{$cms_version}</div>
					</div>

					<div class="flex items-center gap-3">
						<div><h4 class="font-heading text-sm font-light leading-tight text-muted-800 dark:text-white"><span>Smarty:</span></h4></div>
						<div class="ms-auto text-end">v{$smarty_version}</div>
					</div>

					<div class="flex items-center gap-3">
						<div><h4 class="font-heading text-sm font-light leading-tight text-muted-800 dark:text-white"><span>CodeIgniter:</span></h4></div>
						<div class="ms-auto text-end">v{$ci_version}</div>
					</div>
				</div>
			</div>

			{* Server *}
			<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6">
				<div class="mb-8 flex items-center justify-between">
					<h3 class="font-heading text-base font-semibold leading-tight text-muted-800 dark:text-white"><span>Server info</span></h3>
				</div>

				<div class="space-y-5">
					<div class="flex flex-column gap-3">
						<div><h4 class="font-heading text-sm font-light leading-tight text-muted-800 dark:text-white"><span>Software:</span></h4></div>
						<div>{$server_software}</div>
					</div>

					<div class="flex flex-column gap-3">
						<div><h4 class="font-heading text-sm font-light leading-tight text-muted-800 dark:text-white"><span>Modules:</span></h4></div>
						<div class="overflow-x-hidden overflow-y-auto" style="height: 206px;">
							{if $server_modules && $server_modules|is_array}
								{foreach from=$server_modules key=key item=item}
									<span class="text-muted-500 dark:text-muted-400 bg-muted-200 dark:bg-muted-700/40 inline-flex h-6 items-center justify-center rounded-full px-3 font-sans text-xs font-medium m-1">{$item}</span>
								{/foreach}
							{else}
								Unable to list server modules.
							{/if}
						</div>
					</div>
				</div>
			</div>

			{* PHP *}
			<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-md p-6">
				<div class="mb-8 flex items-center justify-between">
					<h3 class="font-heading text-base font-semibold leading-tight text-muted-800 dark:text-white"><span>PHP info</span></h3>
				</div>

				<div class="space-y-5">
					<div class="flex flex-column gap-3">
						<div><h4 class="font-heading text-sm font-light leading-tight text-muted-800 dark:text-white"><span>Version:</span></h4></div>
						<div>{$php_version}</div>
					</div>

					<div class="flex flex-column gap-3">
						<div><h4 class="font-heading text-sm font-light leading-tight text-muted-800 dark:text-white"><span>Extensions:</span></h4></div>
						<div class="overflow-x-hidden overflow-y-auto" style="height: 206px;">
							{if $php_extensions && $php_extensions|is_array}
								{foreach from=$php_extensions key=key item=item}
									<span class="text-muted-500 dark:text-muted-400 bg-muted-200 dark:bg-muted-700/40 inline-flex h-6 items-center justify-center rounded-full px-3 font-sans text-xs font-medium m-1">{$item}</span>
								{/foreach}
							{else}
								Unable to list php extensions.
							{/if}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>