<div class="row">
<div class="tabs">
    <ul class="nav nav-tabs mb-2">
	    <li class="nav-item">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl active" href="#DB" data-bs-target="#DB" data-bs-toggle="tab">Database</a>
        </li>
        <!--<li class="nav-item">
			<a class="nav-link" href="#files" data-bs-target="#files" data-bs-toggle="tab">Files</a>
        </li>-->
    </ul>
    <div class="tab-content border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-xl p-6">
	    <div class="tab-pane active" id="DB">
			<div class="row">
			<div class="col-lg-4 mb-3">
			<section class="card">
				<header class="card-header">General</header>
				<div class="card-body">
					<div class="col-sm-12">
					<form onSubmit="Backups.saveSettings(); return false">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label align-self-center" for="auto_backups">Auto generate?</label>
							<div class="col-sm-8">
								<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="auto_backups" name="auto_backups" {if !hasPermission("editBackupSettings", "admin")}disabled{/if}>
									<option value="1" {if $config.auto_backups}selected{/if}>Yes</option>
									<option value="0" {if !$config.auto_backups}selected{/if}>No</option>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-4 col-form-label" for="backups_interval">Interval</label>
							<div class="col-sm-4">
								<div data-plugin-spinner>
									<div class="input-group">
										<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="backups_interval" name="backups_interval" value="{$config.backups_interval}" {if !hasPermission("editBackupSettings", "admin")}disabled{/if}>
										<div class="spinner-buttons input-group-btn btn-group-vertical">
											<button type="button" class="btn spinner-up btn-xs btn-default" {if !hasPermission("editBackupSettings", "admin")}disabled{/if}>
												<i class="fas fa-angle-up"></i>
											</button>
											<button type="button" class="btn spinner-down btn-xs btn-default" {if !hasPermission("editBackupSettings", "admin")}disabled{/if}>
												<i class="fas fa-angle-down"></i>
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-4">
								<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="backups_time" name="backups_time" {if !hasPermission("editBackupSettings", "admin")}disabled{/if}>
									<option value="hour" {if $config.backups_time == "hour"}selected{/if}>Hours</option>
									<option value="day" {if $config.backups_time == "day"}selected{/if}>Days</option>
								</select>
							</div>
						</div>

						<div class="form-group row mb-3">
							<label class="col-sm-4 col-form-label" for="backups_max_keep">Max keep</label>
							<div class="col-sm-8">
								<div data-plugin-spinner>
									<div class="input-group">
										<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="backups_max_keep" name="backups_max_keep" value="{$config.backups_max_keep}" {if !hasPermission("editBackupSettings", "admin")}disabled{/if}>
										<div class="spinner-buttons input-group-btn btn-group-vertical">
											<button type="button" class="btn spinner-up btn-xs btn-default" {if !hasPermission("editBackupSettings", "admin")}disabled{/if}>
												<i class="fas fa-angle-up"></i>
											</button>
											<button type="button" class="btn spinner-down btn-xs btn-default" {if !hasPermission("editBackupSettings", "admin")}disabled{/if}>
												<i class="fas fa-angle-down"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
	
						{if hasPermission("editBackupSettings", "admin")}<input class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit" value="Save">{/if}
						{if hasPermission("generateBackup", "admin")}<a href="javascript:void(0)" onClick="Backups.generate(this);" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right">Generate Backup</a>{/if}
					</form>
					</div>
				</div>
			</section>
			</div>
			<div class="col-lg-8 mb-3">
			<section class="card">
				<header class="card-header">Backups</header>
				<div class="card-body">
				{if $backups}
				<table class="table table-responsive-md table-hover">
					<thead>
						<tr>
							<th>Backup ID</th>
							<th>Name</th>
							<th>Date</th>
							<th style="text-align: center;">Action</th>
						</tr>
					</thead>
					<tbody>
					{foreach from=$backups item=backup}
						<tr>
							<td><b>{$backup.id}</b></td>
							<td>{$backup.backup_name}.zip</td>
							<td>{$backup.created_date}</td>
							<td style="text-align:center;">
								<a class="btn btn-success btn-sm {if !hasPermission("executeBackupActions", "admin")}disabled{/if}" href="{$url}admin/backups/download/{$backup.id}">Download</a>
								<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md {if !hasPermission("executeBackupActions", "admin")}disabled{/if}" href="javascript:void(0)" onClick="Backups.restore({$backup.id})">Restore</a>
								<a class="btn btn-danger btn-sm {if !hasPermission("executeBackupActions", "admin")}disabled{/if}" href="javascript:void(0)" onClick="Backups.remove({$backup.id}, this)">Delete</a>
							</td>
						</tr>
					{/foreach}
					</tbody>
					</table>
				{/if}
				</div>
			</section>
			</div>
			</div>
		</div>
        <div class="tab-pane" id="files">
			<section class="card">
				<header class="card-header"></header>
					<div class="card-body">
					</div>
			</section>
        </div>
    </div>
</div>
</div>