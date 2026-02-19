<div class="row" id="non_realm">
<div class="tabs">
    <ul class="nav nav-tabs mb-2">
	    <li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl active" href="#realms" data-bs-target="#realms" data-bs-toggle="tab">{lang('realms', 'admin')}</a>
        </li>
        <li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#website" data-bs-target="#website" data-bs-toggle="tab">{lang('website', 'admin')}</a>
        </li>
        <li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#smtp" data-bs-target="#smtp" data-bs-toggle="tab">{lang('smtp', 'admin')}</a>
        </li>
        <li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#performance" data-bs-target="#performance" data-bs-toggle="tab">{lang('performance', 'admin')}</a>
        </li>
		<li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#social_media" data-bs-target="#social_media" data-bs-toggle="tab">{lang('social_media', 'admin')}</a>
        </li>
		<li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#cdn" data-bs-target="#cdn" data-bs-toggle="tab">{lang('cdn', 'admin')}</a>
        </li>
		<li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#security" data-bs-target="#security" data-bs-toggle="tab">{lang('security', 'admin')}</a>
        </li>
		<li class="nav-item mx-1">
			<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-xl" href="#wow_db" data-bs-target="#wow_db" data-bs-toggle="tab">{lang('wow_database', 'admin')}</a>
		</li>
    </ul>

    <div class="tab-content border-muted-200 dark:border-muted-700 dark:bg-muted-800 relative w-full border bg-white transition-all duration-300 rounded-xl p-6">
	    <div class="tab-pane active" id="realms">
			<section class="card" id="auth_settings">
				<div class="card-header"><p class="font-heading text-base font-medium leading-none text-white">{lang('auth_configuration', 'admin')} <span style='color: #f00;'>{lang('important_note', 'admin')}</span></p><p class="font-sans text-xs font-normal leading-normal text-muted-400">{lang('auth_settings_help', 'admin')}</p></div>
				<div class="card-body">
					<form role="form" onSubmit="Settings.saveAuthConfig(); return false">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">{lang('settings_account_password_encryption', 'admin')}</label>
							<div class="col-sm-10">
								<select id="account_encryption" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="SRP6" {if $config.account_encryption == 'SRP6'}selected{/if}>SRP6</option>
									<option value="SPH" {if $config.account_encryption == 'SPH'}selected{/if}>SPH</option>
									<option value="SRP" {if $config.account_encryption == 'SRP'}selected{/if}>SRP</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label">{lang('settings_srp6_info', 'admin')}</p>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">{lang('settings_rbac', 'admin')}</label>
							<div class="col-sm-10">
								<select id="rbac" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="false" {if $config.rbac == false}selected{/if}>No</option>
									<option value="true" {if $config.rbac == true}selected{/if}>Yes</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label">{lang('settings_set_rbac_tables', 'admin')}</p>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">{lang('settings_battlenet', 'admin')}</label>
							<div class="col-sm-10">
								<select onchange="console.log($('[battle_net_encryption]')[this.value == 'true' ? 'show' : 'hide']())" id="battle_net" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="false" {if $config.battle_net == false}selected{/if}>No</option>
									<option value="true" {if $config.battle_net == true}selected{/if}>Yes</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label">{lang('settings_set_battlenet_accounts_table', 'admin')}</p>
						</div>
						<div class="form-group row" {if $config.battle_net == false}style="display: none;"{/if} battle_net_encryption>
							<label class="col-sm-2 col-form-label">{lang('settings_battlenet_password_encryption', 'admin')}</label>
							<div class="col-sm-10">
								<select id="battle_net_encryption" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="SRP6_V2" {if $config.battle_net_encryption == 'SRP6_V2'}selected{/if}>SRP6 V2</option>
									<option value="SRP6_V1" {if $config.battle_net_encryption == 'SRP6_V1'}selected{/if}>SRP6 V1</option>
									<option value="SPH" {if $config.battle_net_encryption == 'SPH'}selected{/if}>SPH</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label">{lang('settings_srp6_v2_info', 'admin')}</p>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">{lang('settings_totp_secret', 'admin')}</label>
							<div class="col-sm-10">
								<select onchange="console.log($('[totp_secret_name]')[this.value == 'true' ? 'show' : 'hide']())" id="totp_secret" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="false" {if $config.totp_secret == false}selected{/if}>No</option>
									<option value="true" {if $config.totp_secret == true}selected{/if}>Yes</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label">{lang('settings_set_token_key', 'admin')}</p>
						</div>
						<div class="form-group row" {if $config.totp_secret == false}style="display: none;"{/if} totp_secret_name>
							<label class="col-sm-2 col-form-label">{lang('settings_totp_secret_field_name', 'admin')}</label>
							<div class="col-sm-10">
								<select id="totp_secret_name" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3">
									<option value="token_key" {if $config.totp_secret_name == 'token_key'}selected{/if}>token_key</option>
									<option value="totp_secret" {if $config.totp_secret_name == 'totp_secret'}selected{/if}>totp_secret</option>
								</select>
							</div>
							<p class="col-sm-12 col-form-label">{lang('settings_totp_secret_info', 'admin')}</p>
						</div>
						<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">{lang('save', 'admin')}</button>
					</form>
				</div>
			</section>

			<section class="card" id="realm_settings">
			<header class="card-header">{lang('realms', 'admin')} (<div style="display:inline;" id="realm_count">{count($realms)}</div>)
			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Settings.showAddRealm()">{lang('add_new_realm', 'admin')}</button>
			</header>
			<div class="card-body">
			<table class="table table-responsive-md table-hover mb-0">
			<thead>
			<tr>
				<th>#</th>
				<th>{lang('name', 'admin')}</th>
				<th>{lang('host', 'admin')}</th>
				<th>{lang('settings_emulator', 'admin')}</th>
				<th style="text-align: center;">{lang('actions', 'admin')}</th>
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
				<label class="col-sm-2 col-form-label" for="realmName">{lang('settings_realm_name', 'admin')}</label>
				<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="realmName"/>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="realmName">{lang('settings_hostname_ip_to_your_emulator_server', 'admin')}</label>
				<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="hostname"/>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label">{lang('settings_server_structure', 'admin')}</label>
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
					<label class="col-sm-2 col-form-label" for="username">{lang('settings_database_username', 'admin')}</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="username"/>
					</div>
					</div>

					<div class="form-group row mb-3">
					<label class="col-sm-2 col-form-label" for="password">{lang('settings_database_password', 'admin')}</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="password"/>
					</div>
					</div>
				</div>

				<div id="two" style="display:none;">
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_hostname_char">{lang('settings_characters_and_world_database_hostname', 'admin')}</label>
					<div class="col-sm-10">
						<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_hostname_char"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_username_char">{lang('settings_characters_and_world_database_username', 'admin')}</label>
					<div class="col-sm-10">
						<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_username_char"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_password_char">{lang('settings_characters_and_world_database_password', 'admin')}</label>
					<div class="col-sm-10">
						<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="override_password_char"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_port_char">{lang('settings_characters_and_world_database_port', 'admin')}</label>
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
					<label class="col-sm-2 col-form-label" for="override_hostname_char_three">{lang('settings_characters_database_hostname', 'admin')}</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_hostname_char_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_username_char_three">{lang('settings_characters_database_username', 'admin')}</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_username_char_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_password_char_three">{lang('settings_characters_database_password', 'admin')}</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="override_password_char_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_port_char_three">{lang('settings_characters_database_port', 'admin')}</label>
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
					<label class="col-sm-2 col-form-label" for="override_hostname_world_three">{lang('settings_world_database_hostname', 'admin')}</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_hostname_world_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_username_world_three">{lang('settings_world_database_username', 'admin')}</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_username_world_three"/>
					</div>
					</div>

					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_password_world_three">{lang('settings_world_database_password', 'admin')}</label>
					<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="override_password_world_three"/>
					</div>
					</div>

					<div class="form-group row mb-3">
					<label class="col-sm-2 col-form-label" for="override_port_world_three">{lang('settings_world_database_port', 'admin')}</label>
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
				<label class="col-sm-2 col-form-label" for="characters">{lang('settings_characters_database', 'admin')}</label>
				<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="characters"/>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="world">{lang('settings_world_database', 'admin')}</label>
				<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="world"/>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="cap">{lang('settings_max_allowed_players_online', 'admin')}</label>
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
					<label class="col-sm-2 col-form-label" for="expansion">{lang('settings_expansion_choose_expansion_of_this_realm', 'admin')}</label>
					<div class="col-sm-10">
						<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="expansion">
							{foreach $expansions as $key => $value}
								<option value="{$key}">{$value}</option>
							{/foreach}
						</select>
					</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="port">{lang('settings_realm_port', 'admin')}</label>
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
				<label class="col-sm-2 col-form-label" for="emulator">{lang('settings_emulator', 'admin')}</label>
				<div class="col-sm-10">
				<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="emulator">
					{foreach from=$emulators key=emu_id item=emu_name}
						<option value="{$emu_id}">{$emu_name}</option>
					{/foreach}
				</select>
				</div>
				</div>

				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="console_port">{lang('settings_console_port_only_required', 'admin')}</label>
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
				<label class="col-sm-2 col-form-label" for="console_username" data-toggle="tooltip" data-placement="bottom" title="For an ingame account with GM level high enough to connect to your&#013;emulator console remotely (see your emulator's config files for more details)">{lang('settings_console_username_only_required', 'admin')}</label>
				<div class="col-sm-10">
					<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="console_username"/>
				</div>
				</div>

				<div class="form-group row mb-3">
				<label class="col-sm-2 col-form-label" for="console_password" data-toggle="tooltip" data-placement="bottom" title="For an ingame account with GM level high enough to connect to your&#013;emulator console remotely (see your emulator's config files for more details)">{lang('settings_console_password_only_required', 'admin')}</label>
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
			<label class="col-sm-2 col-form-label" for="title">{lang('settings_website_title', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="title" placeholder="MyServer" value="{$config.title}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="server_name">{lang('settings_server_name', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="server_name" placeholder="MyServer" value="{$config.server_name}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="realmlist">{lang('settings_realmlist', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="realmlist" placeholder="logon.myserver.com" value="{$config.realmlist}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="max_expansion">{lang('settings_max_expansion', 'admin')}</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="max_expansion">
                {foreach from=$config.expansions key=id item=expansion}
					<option value="{$id}" {if $config.max_expansion == $id}selected{/if}>{$expansion}</option>
				{/foreach}
			</select>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="keywords">{lang('settings_search_engine_keywords_separated_by_comma', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="keywords" placeholder="world of warcraft,wow,private server,pvp" value="{$config.keywords}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="description">{lang('settings_search_engine_description', 'admin')}</label>
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
			<label class="col-sm-2 col-form-label" for="has_smtp">{lang('settings_enable_password_recovery_requires_smtp_server', 'admin')}</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="has_smtp">
				<option value="1" {if $config.has_smtp}selected{/if}>Yes</option>
				<option value="0" {if !$config.has_smtp}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="vote_reminder">{lang('settings_enable_vote_reminder_popup', 'admin')}</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="vote_reminder" onChange="Settings.toggleVoteReminder(this)">
				<option value="1" {if $config.vote_reminder}selected{/if}>Yes</option>
				<option value="0" {if !$config.vote_reminder}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div id="vote_reminder_settings" {if !$config.vote_reminder}style="display:none;"{/if}>
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="vote_reminder_image">{lang('settings_vote_reminder_image_url', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="vote_reminder_image" placeholder="http://mywebsite.com/images/banner.gif" value="{$config.vote_reminder_image}"/>
			</div>
			</div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="reminder_interval">{lang('settings_vote_reminder_interval_in_hours', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="reminder_interval" value="{$config.reminder_interval/60/60}" placeholder="12"/>
			</div>
			</div>
			</div>
			
			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">{lang('save', 'admin')}</button>
        </form>
        </div>

        <div class="tab-pane" id="smtp">
        <form role="form" onSubmit="Settings.saveSmtpSettings(); return false">
			<div class="form-group row mb-1">
			<label class="col-sm-2 col-form-label" for="use_own_smtp_settings">{lang('settings_use_own_smtp_settings_enter_them_below', 'admin')}</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="use_own_smtp_settings" onChange="Settings.toggleSMTPusage(this)">
				<option value="1" {if $config.use_own_smtp_settings}selected{/if}>Yes</option>
				<option value="0" {if !$config.use_own_smtp_settings}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div id="use_smtp" {if !$config.use_own_smtp_settings}style="display:none;"{/if}>
			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="smtp_protocol">{lang('settings_protocol', 'admin')}</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="smtp_protocol" onChange="Settings.toggleProtocol(this)">
				<option value="mail" {if $config.smtp_protocol == 'mail'}selected{/if}>Mail</option>
				<option value="sendmail" {if $config.smtp_protocol == 'sendmail'}selected{/if} disabled>SendMail (Linux only)</option>
				<option value="smtp" {if $config.smtp_protocol == 'smtp'}selected{/if}>{lang('smtp', 'admin')}</option>
			</select>
			</div>
            </div>
            </div>

			<div id="toggle_protocol" {if $config.smtp_protocol != 'smtp' || !$config.use_own_smtp_settings}style="display:none;"{/if}>
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_sender">{lang('settings_smtp_sender', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="smtp_sender" value="{$config.smtp_sender}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_host">{lang('settings_smtp_hostname', 'admin')}</label>
			<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="smtp_host" value="{$config.smtp_host}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_user">{lang('settings_smtp_username', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="smtp_user" value="{$config.smtp_user}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_pass">{lang('settings_smtp_password', 'admin')}</label>
			<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="smtp_pass" value="{$config.smtp_pass}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_port">{lang('settings_smtp_port', 'admin')}</label>
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
			<label class="col-sm-2 col-form-label" for="smtp_crypto">{lang('settings_smtp_crypto', 'admin')}</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="smtp_crypto">
				<option value="ssl" {if $config.smtp_crypto == 'ssl'}selected{/if}>SSL</option>
				<option value="tls" {if $config.smtp_crypto == 'tls'}selected{/if}>TLS</option>
			</select>
			</div>
            </div>
            </div>

			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">{lang('save', 'admin')}</button>
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
			<label class="col-sm-2 col-form-label" for="cache">{lang('settings_cache_on', 'admin')}</label>
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
			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">{lang('save', 'admin')}</button>
		</form>
        </div>

		<div class="tab-pane" id="social_media">
          <form role="form" onSubmit="Settings.saveSocialMedia(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="fb_link">{lang('settings_facebook', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="fb_link" placeholder="https://" value="{$config.facebook}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="twitter_link">{lang('settings_twitter', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="twitter_link" placeholder="https://" value="{$config.twitter}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="yt_link">{lang('settings_youtube', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="yt_link" placeholder="https://" value="{$config.youtube}"/>
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="discord_link">{lang('settings_discord', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="discord_link" placeholder="https://" value="{$config.discord}"/>
			</div>
            </div>

			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">{lang('save', 'admin')}</button>
		</form>
        </div>

		<div class="tab-pane" id="cdn">
		<form role="form" onSubmit="Settings.saveCDN(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="cdn_value">{lang('cdn', 'admin')}</label>
			<div class="col-sm-10">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="cdn_value">
				<option value="true" {if $config.cdn_value == '1'}selected{/if}>Yes</option>
				<option value="false" {if $config.cdn_value == '0'}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="cdn_link">{lang('settings_cdn_url', 'admin')}</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="cdn_link" value="{$config.cdn_link}"/>
			</div>
            </div>

			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">{lang('save', 'admin')}</button>
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
					<label class="col-form-label" for="recaptcha_theme">{lang('settings_recaptcha_theme', 'admin')}</label>
					<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="recaptcha_theme">
						<option value="dark" {if $config.recaptcha_theme == 'dark'}selected{/if}>Dark</option>
						<option value="light" {if $config.recaptcha_theme == 'light'}selected{/if}>Light</option>
					</select>
				</div>

				<div id="captcha_site_key" class="col-sm-6 mb-3" {if $config.captcha_type != 'recaptcha' && $config.captcha_type != 'recaptcha3'}style="display:none"{/if} data-toggle="tooltip" data-placement="bottom" data-bs-original-title="get site key www.google.com/recaptcha/admin">
					<label class="col-form-label" for="recaptcha_site_key">{lang('settings_site_key', 'admin')}</label>
					<div class="input-group">
						<input type="text" id="recaptcha_site_key" value="{$config.recaptcha_site_key}" class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded"/>
					</div>
				</div>

				<div id="captcha_secret_key" class="col-sm-6 mb-3" {if $config.captcha_type != 'recaptcha' && $config.captcha_type != 'recaptcha3'}style="display:none"{/if} data-toggle="tooltip" data-placement="bottom" data-bs-original-title="get secret key www.google.com/recaptcha/admin">
					<label class="col-form-label" for="recaptcha_secret_key">{lang('settings_secret_key', 'admin')}</label>
					<div class="input-group">
						<input type="text" id="recaptcha_secret_key" value="{$config.recaptcha_secret_key}" class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded"/>
					</div>
				</div>

				<div class="col-sm-6 mb-3">
					<label class="col-form-label" for="captcha_attemps">{lang('settings_captcha_attemps_default_3', 'admin')}</label>
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
					<label class="col-form-label" for="block_attemps">{lang('settings_block_attemps', 'admin')}</label>
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
					<label class="col-form-label" for="block_duration">{lang('settings_block_duration_in_minutes_default_15', 'admin')}</label>
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

			<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">{lang('save', 'admin')}</button>
        </form>
        </div>

		<div class="tab-pane" id="wow_db">
			<form role="form" onSubmit="Settings.saveWowDatabase(); return false">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="api_item_icons">{lang('settings_api_link_to_get_item_icons', 'admin')}</label>
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
					<label class="col-sm-2 col-form-label" for="custom_link">{lang('settings_custom_db_link', 'admin')}</label>
					<div class="col-sm-10">
						<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" id="custom_link" placeholder="https://" value="{$config.api_item_icons}"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="api_item_data">{lang('settings_api_link_to_get_item_data', 'admin')}</label>
					<div class="col-sm-10">
						<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="api_item_data">
							<option disabled>Select a WowHead database</option>
							{foreach from=$config.wow_item_db item=item}
								<option value="{$item.link}" {if ($item.link == $config.api_item_data)}selected{/if}>{$item.name}</option>
							{/foreach}
						</select>
					</div>
				</div>

				<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">{lang('save', 'admin')}</button>
			</form>
		</div>
    </div>
</div>
</div>