<div class="row" id="non_realm">
<div class="tabs">
    <ul class="nav nav-tabs mb-2">
	    <li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl active" href="#realms" data-bs-target="#realms" data-bs-toggle="tab">Realms</a>
        </li>
        <li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#website" data-bs-target="#website" data-bs-toggle="tab">Website</a>
        </li>
        <li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#smtp" data-bs-target="#smtp" data-bs-toggle="tab">SMTP</a>
        </li>
        <li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#performance" data-bs-target="#performance" data-bs-toggle="tab">Performance</a>
        </li>
		<li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#social_media" data-bs-target="#social_media" data-bs-toggle="tab">Social Media</a>
        </li>
		<li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#cdn" data-bs-target="#cdn" data-bs-toggle="tab">CDN</a>
        </li>
		<li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#security" data-bs-target="#security" data-bs-toggle="tab">Security</a>
        </li>
		<li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#wow_db" data-bs-target="#wow_db" data-bs-toggle="tab">Wow Database</a>
		</li>
    </ul>

    <div class="tab-content border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-xl p-6">
	    <div class="tab-pane active" id="realms">
			<section class="card" id="auth_settings">
				<div class="card-header"><p class="font-heading text-base font-medium leading-none text-white">Auth configuration <span style='color: #f00;'>(! important)</span></p><p class="font-sans text-xs font-normal leading-normal text-muted-400">Settings related to Realmd/Logon/Auth database and account password encryption.</p></div>
				<div class="card-body">
					<form role="form" onSubmit="Settings.saveAuthConfig(); return false">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Account password encryption</label>
							<div class="col-sm-10">
								<select id="account_encryption" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="SRP6" {if $config.account_encryption == 'SRP6'}selected{/if}>SRP6</option>
									<option value="SPH" {if $config.account_encryption == 'SPH'}selected{/if}>SPH</option>
									<option value="SRP" {if $config.account_encryption == 'SRP'}selected{/if}>SRP</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label"><span style='color: #f00;'>SRP6:</span>Select this for most modern emulators (with <b>salt</b> and <b>verifier</b> columns in <b>auth.accounts</b> table).<br/><span style='color: #f00;'>SPH:</span> Select this for aged emulators (with <b>sha_pass_hash</b> column in <b>auth.accounts</b> table).<br/><span style='color: #f00;'>SRP:</span> Mostly for <b>cMangos</b> and <b>vMangos</b> emulators.</p>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">RBAC</label>
							<div class="col-sm-10">
								<select id="rbac" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="false" {if $config.rbac == false}selected{/if}>No</option>
									<option value="true" {if $config.rbac == true}selected{/if}>Yes</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label">Set yes for emulators that has RBAC tables.</p>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">BattleNet</label>
							<div class="col-sm-10">
								<select onchange="console.log($('[battle_net_encryption]')[this.value == 'true' ? 'show' : 'hide']())" id="battle_net" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="false" {if $config.battle_net == false}selected{/if}>No</option>
									<option value="true" {if $config.battle_net == true}selected{/if}>Yes</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label">Set yes for emulators that has auth.battlenet_accounts table.</p>
						</div>
						<div class="form-group row" {if $config.battle_net == false}style="display: none;"{/if} battle_net_encryption>
							<label class="col-sm-2 col-form-label">BattleNet password encryption</label>
							<div class="col-sm-10">
								<select id="battle_net_encryption" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="SRP6_V2" {if $config.battle_net_encryption == 'SRP6_V2'}selected{/if}>SRP6 V2</option>
									<option value="SRP6_V1" {if $config.battle_net_encryption == 'SRP6_V1'}selected{/if}>SRP6 V1</option>
									<option value="SPH" {if $config.battle_net_encryption == 'SPH'}selected{/if}>SPH</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label"><span style='color: #f00;'>SRP6 (V1 / V2):</span> Select this for most modern emulators (with <b>salt</b> and <b>verifier</b> columns in <b>auth.battlenet_accounts table</b>).<br/><span style='color: #f00;'>SPH:</span> Select this for aged emulators (with <b>sha_pass_hash</b> column in <b>auth.battlenet_accounts</b> table).</p>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Totp secret</label>
							<div class="col-sm-10">
								<select onchange="console.log($('[totp_secret_name]')[this.value == 'true' ? 'show' : 'hide']())" id="totp_secret" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="false" {if $config.totp_secret == false}selected{/if}>No</option>
									<option value="true" {if $config.totp_secret == true}selected{/if}>Yes</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label">Set yes for emulators that auth.account table has <b>token_key</b> or <b>totp_secret</b> column.</p>
						</div>
						<div class="form-group row" {if $config.totp_secret == false}style="display: none;"{/if} totp_secret_name>
							<label class="col-sm-2 col-form-label">Totp secret field name</label>
							<div class="col-sm-10">
								<select id="totp_secret_name" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="token_key" {if $config.totp_secret_name == 'token_key'}selected{/if}>token_key</option>
									<option value="totp_secret" {if $config.totp_secret_name == 'totp_secret'}selected{/if}>totp_secret</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label"><span style='color: #f00;'>totp_secret:</span> Select this for most modern emulators (with <b>totp_secret</b> column in <b>auth.account table</b>).<br/><span style='color: #f00;'>token_key:</span> Select this for aged emulators (with <b>token_key</b> column in <b>auth.account</b> table).</p>
						</div>
						<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">Save</button>
					</form>
				</div>
			</section>

			<section class="card" id="realm_settings">
			<header class="card-header">Realms (<div style="display:inline;" id="realm_count">{count($realms)}</div>)
			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Settings.showAddRealm()">Add a new realm</button>
			</header>
			<div class="card-body">
			<table class="table table-responsive-md table-hover mb-0">
			<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Host</th>
				<th>Emulator</th>
				<th style="text-align: center;">Actions</th>
			</tr>
			</thead>
			<tbody>
				{foreach from=$realms item=realm}
						<tr>
							<td>ID: {$realm->getId()}</td>
							<td><b>{$realm->getName()}</b></td>
							<td>{$realm->getConfig("hostname")}</td>
							<td>{strtoupper($realm->getConfig("emulator"))}</td>
							<td style="text-align: center;">
								<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}admin/realmmanager/edit/{$realm->getId()}">Edit</a>&nbsp;
								<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Settings.remove({$realm->getId()}, this)">Delete</a>
							</td>
						</tr>
				{/foreach}
			</tbody>
			</table>
			</div>
			<div class="card-footer">
			<div data-toggle="tooltip" data-placement="bottom" title="The logon emulator is the emulator of the first realm"><b>Logon/realmd/auth emulator:</b> {if $realms}{strtoupper($realms[0]->getConfig("emulator"))}{/if}</div>
			</div>
			</section>

			<div class="card" id="add_realm" style="display:none;">
			<div class="card-header">New realm</div>
			<div class="card-body">
			<form role="form" onSubmit="Settings.addRealm(); return false">
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="realmName">Realm name</label>
				<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="realmName"/>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="realmName">Hostname / IP (to your emulator server)</label>
				<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="hostname"/>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label">Server structure (mainly for the bigger private servers with clustered hosts)</label>
				<div class="col-sm-10">
				<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="server_structure" onChange="Settings.changeStructure(this)">
					<option value="1" selected>[All in one] I host emulator and both characters and world databases on the same server (default)</option>
					<option value="2">[Emulator and databases separated] I host the emulator on one server and the databases on another</option>
					<option value="3">[All separate] I host emulator, world and characters on three different servers</option>
				</select>
				</div>
				</div>

				<div id="one">
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="username">Database username</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="username"/>
					</div>
					</div>

					<div class="form-group row mb-3">
					<label class="col-sm-2 col-form-label" for="password">Database password</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="password"/>
					</div>
					</div>
				</div>

				<div id="two" style="display:none;">
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_hostname_char">Characters &amp; world: database hostname</label>
					<div class="col-sm-10">
						<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_hostname_char"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_username_char">Characters &amp; world: database username</label>
					<div class="col-sm-10">
						<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_username_char"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_password_char">Characters &amp; world: database password</label>
					<div class="col-sm-10">
						<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="override_password_char"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_port_char">Characters &amp; world: database port</label>
					<div class="col-sm-10">
					<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 65535 }'>
						<div class="input-group">
							<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_port_char" value="3306"/>
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fa-duotone fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fa-duotone fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
					</div>
					</div>
				</div>

				<div id="three" style="display:none;">
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_hostname_char_three">Characters: database hostname</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_hostname_char_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_username_char_three">Characters: database username</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_username_char_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_password_char_three">Characters: database password</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="override_password_char_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_port_char_three">Characters: database port</label>
					<div class="col-sm-10">
					<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 65535 }'>
						<div class="input-group">
							<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_port_char_three" value="3306"/>
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fa-duotone fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fa-duotone fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_hostname_world_three">World: database hostname</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_hostname_world_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_username_world_three">World: database username</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_username_world_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_password_world_three">World: database password</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="override_password_world_three"/>
					</div>
					</div>

					<div class="form-group row mb-3">
					<label class="col-sm-2 col-form-label" for="override_port_world_three">World: database port</label>
					<div class="col-sm-10">
					<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 65535 }'>
						<div class="input-group">
							<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_port_world_three" value="3306"/>
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fa-duotone fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fa-duotone fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
					</div>
					</div>
				</div>

				<div class="form-group row mt-3">
				<label class="col-sm-2 col-form-label" for="characters">Characters database</label>
				<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="characters"/>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="world">World database</label>
				<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="world"/>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="cap">Max allowed players online</label>
				<div class="col-sm-10">
					<div data-plugin-spinner data-plugin-options='{ "value": 0, "min": 0, "max": 99999 }'>
						<div class="input-group">
							<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="cap"/>
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fa-duotone fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fa-duotone fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="expansion">Expansion (Choose expansion of this realm)</label>
					<div class="col-sm-10">
						<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="expansion">
							{foreach $expansions as $key => $value}
								<option value="{$key}">{$value}</option>
							{/foreach}
						</select>
					</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="port">Realm port (cmangos: 8129, others: 8085)</label>
				<div class="col-sm-10">
					<div data-plugin-spinner data-plugin-options='{ "value": 0, "min": 0, "max": 65535 }'>
						<div class="input-group">
							<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="port"/>
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fa-duotone fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fa-duotone fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="emulator">Emulator</label>
				<div class="col-sm-10">
				<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="emulator">
					{foreach from=$emulators key=emu_id item=emu_name}
						<option value="{$emu_id}">{$emu_name}</option>
					{/foreach}
				</select>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="console_port">Console port (only required for emulators that use RA or SOAP; usually 3443 for RA and 7878 for SOAP)</label>
				<div class="col-sm-10">
					<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 65535 }'>
						<div class="input-group">
							<input class="spinner_input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="console_port"/>
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fa-duotone fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fa-duotone fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="console_username" data-toggle="tooltip" data-placement="bottom" title="For an ingame account with GM level high enough to connect to your&#013;emulator console remotely (see your emulator's config files for more details)">Console username (only required for emulators that use remote console systems) (?)</label>
				<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="console_username"/>
				</div>
				</div>

				<div class="form-group row mb-3">
				<label class="col-sm-2 col-form-label" for="console_password" data-toggle="tooltip" data-placement="bottom" title="For an ingame account with GM level high enough to connect to your&#013;emulator console remotely (see your emulator's config files for more details)">Console password (only required for emulators that use remote console systems) (?)</label>
				<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="console_password"/>
				</div>
				</div>
					<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">Add realm</button>
			</form>
			</div>
			</div>
		</div>
        <div class="tab-pane" id="website">
           <form role="form" onSubmit="Settings.saveWebsiteSettings(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="title">Website title</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="title" placeholder="MyServer" value="{$config.title}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="server_name">Server name</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="server_name" placeholder="MyServer" value="{$config.server_name}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="realmlist">Realmlist</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="realmlist" placeholder="logon.myserver.com" value="{$config.realmlist}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="max_expansion">Max expansion</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="max_expansion">
                {foreach from=$config.expansions key=id item=expansion}
					<option value="{$id}" {if $config.max_expansion == $id}selected{/if}>{$expansion}</option>
				{/foreach}
			</select>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="keywords">Search engine: keywords (separated by comma)</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="keywords" placeholder="world of warcraft,wow,private server,pvp" value="{$config.keywords}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="description">Search engine: description</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="description" placeholder="Best World of Warcraft private server in the entire world!" value="{$config.description}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="analytics"><a href="http://analytics.google.com" target="_blank">Google Analytics</a> website ID for advanced statistics (optional)</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="analytics" placeholder="XX-YYYYYYYY-Z" value="{$config.analytics}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="has_smtp">Enable password recovery (requires SMTP server)</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="has_smtp">
				<option value="1" {if $config.has_smtp}selected{/if}>Yes</option>
				<option value="0" {if !$config.has_smtp}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="vote_reminder">Enable vote reminder popup</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="vote_reminder" onChange="Settings.toggleVoteReminder(this)">
				<option value="1" {if $config.vote_reminder}selected{/if}>Yes</option>
				<option value="0" {if !$config.vote_reminder}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div id="vote_reminder_settings" {if !$config.vote_reminder}style="display:none;"{/if}>
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="vote_reminder_image">Vote reminder image URL</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="vote_reminder_image" placeholder="http://mywebsite.com/images/banner.gif" value="{$config.vote_reminder_image}"/>
			</div>
			</div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="reminder_interval">Vote reminder interval (in hours)</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="reminder_interval" value="{$config.reminder_interval/60/60}" placeholder="12"/>
			</div>
			</div>
			</div>
			
			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">Save</button>
        </form>
        </div>

        <div class="tab-pane" id="smtp">
        <form role="form" onSubmit="Settings.saveSmtpSettings(); return false">
			<div class="form-group row mb-1">
			<label class="col-sm-2 col-form-label" for="use_own_smtp_settings">Use own SMTP settings (enter them below)</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="use_own_smtp_settings" onChange="Settings.toggleSMTPusage(this)">
				<option value="1" {if $config.use_own_smtp_settings}selected{/if}>Yes</option>
				<option value="0" {if !$config.use_own_smtp_settings}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div id="use_smtp" {if !$config.use_own_smtp_settings}style="display:none;"{/if}>
			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="smtp_protocol">Protocol</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="smtp_protocol" onChange="Settings.toggleProtocol(this)">
				<option value="mail" {if $config.smtp_protocol == 'mail'}selected{/if}>Mail</option>
				<option value="sendmail" {if $config.smtp_protocol == 'sendmail'}selected{/if} disabled>SendMail (Linux only)</option>
				<option value="smtp" {if $config.smtp_protocol == 'smtp'}selected{/if}>SMTP</option>
			</select>
			</div>
            </div>
            </div>

			<div id="toggle_protocol" {if $config.smtp_protocol != 'smtp' || !$config.use_own_smtp_settings}style="display:none;"{/if}>
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_sender">SMTP sender</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="smtp_sender" value="{$config.smtp_sender}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_host">SMTP hostname</label>
			<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="smtp_host" value="{$config.smtp_host}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_user">SMTP username</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="smtp_user" value="{$config.smtp_user}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_pass">SMTP password</label>
			<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="smtp_pass" value="{$config.smtp_pass}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_port">SMTP port</label>
			<div class="col-sm-10">
			<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 65535 }'>
				<div class="input-group">
					<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="smtp_port" value="{$config.smtp_port}"/>
					<div class="spinner-buttons input-group-btn btn-group-vertical">
						<button type="button" class="btn spinner-up btn-xs btn-default">
							<i class="fa-duotone fa-angle-up"></i>
						</button>
						<button type="button" class="btn spinner-down btn-xs btn-default">
							<i class="fa-duotone fa-angle-down"></i>
						</button>
					</div>
				</div>
			</div>
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="smtp_crypto">SMTP crypto</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="smtp_crypto">
				<option value="ssl" {if $config.smtp_crypto == 'ssl'}selected{/if}>SSL</option>
				<option value="tls" {if $config.smtp_crypto == 'tls'}selected{/if}>TLS</option>
			</select>
			</div>
            </div>
            </div>

			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">Save</button>
			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" onclick="Settings.mailDebug(); return false">Mail debug</button>
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="../admin/email_template">Email template</a>
            <button onClick="Settings.showHelp()" type="button" class="btn btn-primary pull-right"><i class="fa-duotone fa-circle-info fa-lg"></i></button>
        </form>
        </div>

        <div class="tab-pane" id="performance">
          <form role="form" onSubmit="Settings.savePerformanceSettings(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="disable_visitor_graph" data-toggle="tooltip" data-placement="bottom" title="If you have many visitors, the admin panel will become very slow because of the statistics graph - disabling it will help a lot">Disable dashboard visitor graph <a>(?)</a></label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="disable_visitor_graph" id="disable_visitor_graph">
				<option value="true" {if $config.disable_visitor_graph}selected{/if}>Yes</option>
				<option value="false" {if !$config.disable_visitor_graph}selected{/if}>No</option>
			</select>
			</div>
			</div>
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="disable_realm_status" data-toggle="tooltip" data-placement="bottom" title="If you have many visitors, the admin panel will become very slow because of the statistics graph - disabling it will help a lot">Disable realms status <a>(?)</a></label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="disable_realm_status" id="disable_realm_status">
				<option value="true" {if $config.disable_realm_status}selected{/if}>Yes</option>
				<option value="false" {if !$config.disable_realm_status}selected{/if}>No</option>
			</select>
			</div>
			</div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="cache">Cache on?</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="cache" id="cache">
				<option value="true" {if $config.cache}selected{/if}>Yes</option>
				<option value="false" {if !$config.cache}selected{/if}>No</option>
			</select>
			</div>
			</div>
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="enable_minify_js" data-toggle="tooltip" data-placement="bottom" title="If you have many visitors, the admin panel will become very slow because of the statistics graph - disabling it will help a lot">Enable minify javascript <a>(?)</a></label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="enable_minify_js" id="enable_minify_js">
				<option value="true" {if $config.enable_minify_js}selected{/if}>Yes</option>
				<option value="false" {if !$config.enable_minify_js}selected{/if}>No</option>
			</select>
			</div>
			</div>
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="enable_minify_css" data-toggle="tooltip" data-placement="bottom" title="If you have many visitors, the admin panel will become very slow because of the statistics graph - disabling it will help a lot">Enable minify css <a>(?)</a></label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="enable_minify_css" id="enable_minify_css">
				<option value="true" {if $config.enable_minify_css}selected{/if}>Yes</option>
				<option value="false" {if !$config.enable_minify_css}selected{/if}>No</option>
			</select>
			</div>
			</div>
			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">Save</button>
		</form>
        </div>

		<div class="tab-pane" id="social_media">
          <form role="form" onSubmit="Settings.saveSocialMedia(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="fb_link">Facebook</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="fb_link" placeholder="https://" value="{$config.facebook}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="twitter_link">Twitter</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="twitter_link" placeholder="https://" value="{$config.twitter}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="yt_link">Youtube</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="yt_link" placeholder="https://" value="{$config.youtube}"/>
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="discord_link">Discord</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="discord_link" placeholder="https://" value="{$config.discord}"/>
			</div>
            </div>

			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">Save</button>
		</form>
        </div>

		<div class="tab-pane" id="cdn">
		<form role="form" onSubmit="Settings.saveCDN(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="cdn_value">CDN</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="cdn_value">
				<option value="true" {if $config.cdn_value == '1'}selected{/if}>Yes</option>
				<option value="false" {if $config.cdn_value == '0'}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="cdn_link">CDN URL</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="cdn_link" value="{$config.cdn_link}"/>
			</div>
            </div>

			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">Save</button>
        </form>
        </div>

        <div class="tab-pane" id="security">
        <form role="form" onSubmit="Settings.saveSecurity(); return false">
			<div class="form-group row">
				<div class="col-sm-6 mb-3">
					<label class="col-form-label" for="captcha">Use captcha? (Recommended: yes), Enable <a href="http://www.google.com/recaptcha/admin" target="_blank">Google Captcha</a> (optional)</label>
					<select onChange="if(this.value == 'recaptcha' || this.value == 'recaptcha3'){ $('#captcha_site_key').fadeIn(150); } else { $('#captcha_site_key').fadeOut(150); }if(this.value == 'recaptcha' || this.value == 'recaptcha3'){ $('#captcha_secret_key').fadeIn(150); } else { $('#captcha_secret_key').fadeOut(150); }if(this.value == 'recaptcha'){ $('#captcha_theme').fadeIn(150); } else { $('#captcha_theme').fadeOut(150); }" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="captcha">
						<option value="recaptcha" {if $config.captcha_type == 'recaptcha'}selected{/if}>Google Reaptcha v2</option>
						<option value="recaptcha3" {if $config.captcha_type == 'recaptcha3'}selected{/if}>Google Reaptcha v3</option>
						<option value="inbuilt" {if $config.captcha_type == 'inbuilt'}selected{/if}>Image Captcha</option>
						<option value="disabled" {if !$config.use_captcha}selected{/if}>Disable</option>
					</select>
				</div>
				<div id="captcha_theme" class="col-sm-6 mb-3" {if $config.captcha_type != 'recaptcha'}style="display:none"{/if}>
					<label class="col-form-label" for="recaptcha_theme">Recaptcha Theme</label>
					<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="recaptcha_theme">
						<option value="dark" {if $config.recaptcha_theme == 'dark'}selected{/if}>Dark</option>
						<option value="light" {if $config.recaptcha_theme == 'light'}selected{/if}>Light</option>
					</select>
				</div>

				<div id="captcha_site_key" class="col-sm-6 mb-3" {if $config.captcha_type != 'recaptcha' && $config.captcha_type != 'recaptcha3'}style="display:none"{/if} data-toggle="tooltip" data-placement="bottom" data-bs-original-title="get site key www.google.com/recaptcha/admin">
					<label class="col-form-label" for="recaptcha_site_key">Site key (?)</label>
					<div class="input-group">
						<input type="text" id="recaptcha_site_key" value="{$config.recaptcha_site_key}" class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded"/>
					</div>
				</div>

				<div id="captcha_secret_key" class="col-sm-6 mb-3" {if $config.captcha_type != 'recaptcha' && $config.captcha_type != 'recaptcha3'}style="display:none"{/if} data-toggle="tooltip" data-placement="bottom" data-bs-original-title="get secret key www.google.com/recaptcha/admin">
					<label class="col-form-label" for="recaptcha_secret_key">Secret key (?)</label>
					<div class="input-group">
						<input type="text" id="recaptcha_secret_key" value="{$config.recaptcha_secret_key}" class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded"/>
					</div>
				</div>

				<div class="col-sm-6 mb-3">
					<label class="col-form-label" for="captcha_attemps">Captcha attemps (default: 3)</label>
					<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 9999 }'>
						<div class="input-group">
							<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="captcha_attemps" value="{$config.captcha_attemps}"/>
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fa-duotone fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fa-duotone fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6 mb-3">
					<label class="col-form-label" for="block_attemps">Block attemps</label>
					<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 9999 }'>
						<div class="input-group">
							<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="block_attemps" value="{$config.block_attemps}"/>
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fa-duotone fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fa-duotone fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6 mb-3">
					<label class="col-form-label" for="block_duration">Block duration in minutes (default: 15)</label>
					<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 9999 }'>
						<div class="input-group">
							<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="block_duration" value="{$config.block_duration}"/>
							<div class="spinner-buttons input-group-btn btn-group-vertical">
								<button type="button" class="btn spinner-up btn-xs btn-default">
									<i class="fa-duotone fa-angle-up"></i>
								</button>
								<button type="button" class="btn spinner-down btn-xs btn-default">
									<i class="fa-duotone fa-angle-down"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">Save</button>
        </form>
        </div>

		<div class="tab-pane" id="wow_db">
			<form role="form" onSubmit="Settings.saveWowDatabase(); return false">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="api_item_icons">API link to get item icons</label>
					<div class="col-sm-10">
						<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="api_item_icons" onChange="Settings.toggleWowDB(this)">
							<option disabled>Select a Wow database</option>
							{foreach from=$config.wow_db item=item}
								<option value="{$item.link}" {if ($item.link == $config.api_item_icons) || ($item.link == 'custom' && $config.api_item_custom)}selected{/if}>{$item.name}</option>
							{/foreach}
						</select>
					</div>
				</div>

				<div class="form-group row" id="toggle_wowdb" {if $config.api_item_custom == false}style="display:none;"{/if}>
					<label class="col-sm-2 col-form-label" for="custom_link">Custom DB Link</label>
					<div class="col-sm-10">
						<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="custom_link" placeholder="https://" value="{$config.api_item_icons}"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="api_item_data">API link to get item data</label>
					<div class="col-sm-10">
						<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="api_item_data">
							<option disabled>Select a WowHead database</option>
							{foreach from=$config.wow_item_db item=item}
								<option value="{$item.link}" {if ($item.link == $config.api_item_data)}selected{/if}>{$item.name}</option>
							{/foreach}
						</select>
					</div>
				</div>

				<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">Save</button>
			</form>
		</div>
    </div>
</div>
</div>