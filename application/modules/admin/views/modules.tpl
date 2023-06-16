<div class="wrapper">
	<section class="container-fluid inner-page">
		<div class="row">
			<div class="col-xl-12 full-dark-bg bg-muted-50 dark:bg-muted-800/70 border-muted-200 dark:border-muted-700 p-10 rounded-lg">
				<!-- Files section -->
				<form class="dropzone files-container nui-focus border-muted-300 dark:border-muted-700 hover:border-muted-400 focus:border-muted-400 dark:hover:border-muted-600 dark:focus:border-muted-700 group cursor-pointer rounded-lg border-[3px] border-dashed p-8 transition-colors duration-300">
					<div class="fallback">
					<i class="fa-solid fa-cloud-arrow-up"></i>
						<input name="module" id="module" type="file">
					</div>
				</form>

				<span>Only ZIP file type is supported.</span>

				<h4 class="section-sub-title"><span>Uploaded</span> module</h4>
				<span class="no-files-uploaded">No modules uploaded yet.</span>

				<div class="preview-container dz-preview uploaded-files">
					<div id="previews">
						<div id="FGEN-dropzone-template">
							<div class="FGEN-dropzone-info">
								<div class="details">
									<div>
										<span data-dz-name></span> <span data-dz-size></span>
									</div>
									<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
									<div class="dz-error-message"><span data-dz-errormessage></span></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<div class="border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-xl p-6 mb-3">
    <div>
        <div class="mb-4 flex items-center justify-between">
            <h3 class="font-heading text-sm font-semibold leading-tight text-muted-800 dark:text-white"><span>Important</span></h3>
            <div class="relative">
                <svg data-v-cd102a71="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon text-muted-400 h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9m4.3 13a1.94 1.94 0 0 0 3.4 0"></path>
                </svg>
                <div class="absolute -end-0.5 top-0.5"><span class="relative flex h-2 w-2"><span class="bg-primary-400 absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"></span><span class="bg-primary-500 relative inline-flex h-2 w-2 rounded-full"></span></span></div>
            </div>
        </div>
        <div>
            <p class="font-alt text-xs font-normal leading-normal leading-normal"><span class="text-muted-400">Third-party modules are not supported! Use at your own risk<br>You can download tested modules <a href="https://github.com/FusionWowCMS/Modules" class="alert-link" target="_blank">here</a></span></p>
        </div>
        <div></div>
    </div>
</div>

<script>
    Dropzone.autoDiscover = false;
	$(window).on('load', function() {
		FGEN.init();
	});
</script>

<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<header class="card-header"> 
				<div class="card-actions">
					<span class="badge badge-success align-right" id="enabled_count">{count($enabled_modules)}</span>
				</div>
				<h2 class="card-title text-muted-800 dark:text-white"">Installed modules</h2>
			</header>
			<div class="card-body p-0">
				<table class="table m-0">
					<tbody id="enabled_modules">
						{foreach from=$enabled_modules item=module key=key}
							<tr class="border-top">
								<td class="font-weight-bold border-0 w-70 align-middle text-muted-800 dark:text-white">{ucfirst($module.name)} <span class="font-weight-normal">by</span> <a href="{$module.author.website}" target="_blank">{$module.author.name}</a><br><small class="font-weight-normal" style="color:#97989d;">{$module.description}</small><br><small>Version: {if isset($module.version)} {$module.version} {else} 1.0.0 {/if} | Date: {if isset($module.date)} {$module.date} {else} 1.0.0 {/if}</small></td>
								<td class="pull-right">
									<div class="flex flex-col gap-2 sm:flex-row">
										{if $module.has_configs && hasPermission("editModuleConfigs")}
											<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}admin/edit/{$key}">Edit Configs</a>
										{/if}
										{if hasPermission("toggleModules")}
											<a href="javascript:void(0)" onClick="Modules.disableModule('{$key}', this);" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500">Disable</a>
										{/if}
									</div>
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="card">
			<header class="card-header"> 
				<div class="card-actions">
					<span class="badge badge-danger align-right" id="disabled_count">{count($disabled_modules)}</span>
				</div>
				<h2 class="card-title text-muted-800 dark:text-white"">Disabled modules</h2>
			</header>
			<div class="card-body p-0">
				<table class="table m-0">
					<tbody id="disabled_modules">
						{foreach from=$disabled_modules item=module key=key}
							<tr class="border-top">
								<td class="font-weight-bold border-0 w-70 align-middle text-muted-800 dark:text-white">{ucfirst($module.name)} <span class="font-weight-normal">by</span> <a href="{$module.author.website}" target="_blank">{$module.author.name}</a><br><small class="font-weight-normal" style="color:#97989d;">{$module.description}</small><br><small>Version: {if isset($module.version)} {$module.version} {else} 1.0.0 {/if} | Date: {if isset($module.date)} {$module.date} {else} 2023.01.01 {/if}</small></td>
								<td class="pull-right">
									<div class="flex flex-col gap-2 sm:flex-row">
										{if $module.has_configs && hasPermission("editModuleConfigs")}
											<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}admin/edit/{$key}">Edit Configs</a>
										{/if}
										{if hasPermission("toggleModules")}
											<a href="javascript:void(0)" onClick="Modules.enableModule('{$key}', this);" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500">Enable</a>
										{/if}
									</div>
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
