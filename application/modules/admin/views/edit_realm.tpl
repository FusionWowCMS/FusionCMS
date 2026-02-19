<div class="card">
	<div class="card-header">{lang('realm_settings', 'admin')}</div>
	<div class="card-body">
	<form onSubmit="Settings.saveRealm({$realm->getId()}); return false">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realmName">{lang('realm_name', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="realmName" name="realmName" value="{$realm->getName()}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realmName">{lang('hostname_ip_emulator', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="hostname" value="{$realm->getConfig('hostname')}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_hostname_char">{lang('characters_db_hostname', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_hostname_char" value="{$hostname_char}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_username_char">{lang('characters_db_username', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_username_char" value="{$username_char}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_password_char">{lang('characters_db_password', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="override_password_char" value="{$password_char}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_port_char">{lang('characters_db_port', 'admin')}</label>
		<div class="col-sm-10">
		<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 65535 }'>
			<div class="input-group">
				<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_port_char" value="{$port_char}"/>
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
		<label class="col-sm-2 col-form-label" for="override_hostname_world">{lang('world_db_hostname', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_hostname_world" value="{$hostname_world}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_username_world">{lang('world_db_username', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_username_world" value="{$username_world}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_password_world">{lang('world_db_password', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="password" id="override_password_world" value="{$password_world}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_port_world">{lang('world_db_port', 'admin')}</label>
		<div class="col-sm-10">
		<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 65535 }'>
			<div class="input-group">
				<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="override_port_world" value="{$port_world}"/>
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
		<label class="col-sm-2 col-form-label" for="characters">{lang('characters_database', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="characters" name="characters" value="{$realm->getConfig('characters_database')}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="world">{lang('world_database', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="world" name="world" value="{$realm->getConfig('world_database')}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="cap">{lang('max_players_online', 'admin')}</label>
		<div class="col-sm-10">
		<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 99999 }'>
			<div class="input-group">
				<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="cap" name="cap" value="{$realm->getCap()}"/>
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
			<label class="col-sm-2 col-form-label" for="expansion">{lang('expansion_realm_hint', 'admin')}</label>
			<div class="col-sm-10">
				<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="expansion">
					{foreach $expansions as $key => $value}
						<option value="{$key}" {if $realm->getConfig('expansion') == $key}selected{/if}>{$value}</option>
					{/foreach}
				</select>
			</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="port">{lang('realm_port_hint', 'admin')}</label>
		<div class="col-sm-10">
		<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 65535 }'>
			<div class="input-group">
				<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="port" name="port" value="{$realm->getConfig('realm_port')}"/>
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
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="emulator" name="emulator">
			{foreach from=$emulators key=emu_id item=emu_name}
			<option value="{$emu_id}" {if $emu_id == $realm->getConfig('emulator')}selected{/if}>{$emu_name}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="console_port">{lang('console_port_hint', 'admin')}</label>
		<div class="col-sm-10">
		<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 65535 }'>
			<div class="input-group">
				<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="console_port" name="console_port" value="{$realm->getConfig('console_port')}"/>
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
		<label class="col-sm-2 col-form-label" for="console_username" data-tip="{lang('console_account_tooltip', 'admin')}">{lang('console_username_hint', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="console_username" name="console_username" value="{$realm->getConfig('console_username')}"/>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="console_password" data-tip="{lang('console_account_tooltip', 'admin')}">{lang('console_password_hint', 'admin')}</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="console_password" name="console_password" placeholder="{lang('enter_new_password', 'admin')}"/>
		</div>
		</div>

		<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit">{lang('save_realm', 'admin')}</button>
	</form>
	</div>
</div>