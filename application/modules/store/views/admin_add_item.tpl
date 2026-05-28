<div class="card">
    <div class="card-header"><a href='{$url}store/admin_items' data-bs-toggle="tooltip" data-placement="top" title="{lang('return_to_items', 'store')}">{lang('items', 'store')}</a> &rarr; {lang('new_item', 'store')}</div>
    <div class="card-body">
        <form>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label" for="item_type">{lang('item_type', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="item_type" name="item_type" onChange="Items.changeType(this)">
                        <option value="item" selected>{lang('item', 'store')}</option>
                        <option value="command">{lang('console_command', 'store')}</option>
                        <option value="query">{lang('query', 'store')}</option>
                    </select>
                </div>
            </div>
        </form>
        <form onSubmit="Items.create(this); return false" id="command_form" style="display:none;">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">{lang('name', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="description">{lang('description_short', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="description" id="description" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="quality">{lang('item_quality', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="quality" name="quality">
                        <option value="0" class="q0">{lang('poor', 'store')}</option>
                        <option value="1" class="q1">{lang('common', 'store')}</option>
                        <option value="2" class="q2">{lang('uncommon', 'store')}</option>
                        <option value="3" class="q3">{lang('rare', 'store')}</option>
                        <option value="4" class="q4">{lang('epic', 'store')}</option>
                        <option value="5" class="q5">{lang('legendary', 'store')}</option>
                        <option value="6" class="q6">{lang('artifact', 'store')}</option>
                        <option value="7" class="q7">{lang('heirloom', 'store')}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{lang('need_character', 'store')}</label>
                <div class="col-sm-10 align-self-center">
                    <label for="command_need_character" class="flex cursor-pointer items-center">
				    	<span class="relative block">
				    		<input type="checkbox" id="command_need_character" name="command_need_character" class="form-control peer absolute z-0 h-full w-full cursor-pointer opacity-0" checked="yes" value="1"><span class="border-muted-300 dark:border-muted-600 dark:bg-muted-700 absolute start-0.5 top-1/2 z-10 flex h-5 w-5 -translate-y-1/2 items-center justify-center rounded-full border bg-white shadow transition focus:w-6 peer-checked:-translate-y-1/2 peer-checked:translate-x-full rtl:peer-checked:-translate-x-full"></span><span class="bg-muted-300 peer-focus:outline-muted-300 dark:bg-muted-600 dark:peer-focus:outline-muted-600 block h-6 w-11 rounded-full shadow-inner outline-1 outline-transparent transition-all duration-300 peer-focus:outline-dashed peer-focus:outline-offset-2 peer-focus:ring-0 peer-checked:bg-primary-400"></span>
				    		<svg aria-hidden="true" viewBox="0 0 17 12" class="pointer-events-none absolute start-2 top-1/2 z-10 h-2.5 w-2.5 translate-y-0 fill-current text-white opacity-0 transition duration-300 peer-checked:-translate-y-1/2 peer-checked:opacity-100">
				    			<path fill="currentColor" d="M16.576.414a1.386 1.386 0 0 1 0 1.996l-9.404 9.176A1.461 1.461 0 0 1 6.149 12c-.37 0-.74-.139-1.023-.414L.424 6.998a1.386 1.386 0 0 1 0-1.996 1.47 1.47 0 0 1 2.046 0l3.68 3.59L14.53.414a1.47 1.47 0 0 1 2.046 0z"></path>
				    		</svg>
				    	</span>
                        <span class="text-muted-400 relative ms-3 cursor-pointer select-none font-sans text-sm"></span>
                        {lang('make_user_select_character', 'store')}
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{lang('require_offline', 'store')}</label>
                <div class="col-sm-10 align-self-center">
                    <label for="require_character_offline" class="flex cursor-pointer items-center">
				    	<span class="relative block">
				    		<input type="checkbox" id="require_character_offline" name="require_character_offline" class="form-control peer absolute z-0 h-full w-full cursor-pointer opacity-0" value="1"><span class="border-muted-300 dark:border-muted-600 dark:bg-muted-700 absolute start-0.5 top-1/2 z-10 flex h-5 w-5 -translate-y-1/2 items-center justify-center rounded-full border bg-white shadow transition focus:w-6 peer-checked:-translate-y-1/2 peer-checked:translate-x-full rtl:peer-checked:-translate-x-full"></span><span class="bg-muted-300 peer-focus:outline-muted-300 dark:bg-muted-600 dark:peer-focus:outline-muted-600 block h-6 w-11 rounded-full shadow-inner outline-1 outline-transparent transition-all duration-300 peer-focus:outline-dashed peer-focus:outline-offset-2 peer-focus:ring-0 peer-checked:bg-primary-400"></span>
				    		<svg aria-hidden="true" viewBox="0 0 17 12" class="pointer-events-none absolute start-2 top-1/2 z-10 h-2.5 w-2.5 translate-y-0 fill-current text-white opacity-0 transition duration-300 peer-checked:-translate-y-1/2 peer-checked:opacity-100">
				    			<path fill="currentColor" d="M16.576.414a1.386 1.386 0 0 1 0 1.996l-9.404 9.176A1.461 1.461 0 0 1 6.149 12c-.37 0-.74-.139-1.023-.414L.424 6.998a1.386 1.386 0 0 1 0-1.996 1.47 1.47 0 0 1 2.046 0l3.68 3.59L14.53.414a1.47 1.47 0 0 1 2.046 0z"></path>
				    		</svg>
				    	</span>
                        <span class="text-muted-400 relative ms-3 cursor-pointer select-none font-sans text-sm"></span>
                        {lang('make_sure_character_offline', 'store')}
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="command">{lang('command', 'store')}</label>
                <div class="col-sm-10">
                    <textarea class="form-control max-h-52 nui-focus border-muted-300 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full border bg-white font-monospace transition-all duration-300 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 min-h-[2.5rem] text-sm leading-[1.6] rounded-xl resize-none p-2" id="command" name="command"></textarea>
                    <span class="help-block">
                    {literal}
                        <b>{ACCOUNT}</b> = {/literal}{lang('account_name', 'store')},
                    {literal}<b>{CHARACTER}</b> = {/literal}{lang('character_name', 'store')}
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="realm">{lang('realm', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="realm" id="realm">
                        {foreach from=$realms item=realm}
                            <option value="{$realm->getId()}">{$realm->getName()}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="group">{lang('item_group', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="group" id="group">
                        <option value="0">{lang('none', 'store')}</option>
                        {foreach from=$groups item=group}
                            <option value="{$group.id}">{$group.title}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="vp_price form-group row">
                <label class="col-sm-2 col-form-label" for="vpCost">{lang('vp_price', 'store')}</label>
                <div class="col-sm-10">
                    <div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
                        <div class="input-group">
                            <input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="vpCost" id="vpCost" value="0">
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
            <div class="dp_price form-group row">
                <label class="col-sm-2 col-form-label" for="dpCost">{lang('dp_price', 'store')}</label>
                <div class="col-sm-10">
                    <div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
                        <div class="input-group">
                            <input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="dpCost" id="dpCost" value="0"/>
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
                <label class="col-sm-2 col-form-label" for="icon">{lang('icon_name', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="icon" id="icon" value="" />
                </div>
            </div>
            <input type="hidden" id="item_type" name="item_type" value="command">
            <button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">{lang('submit_command', 'store')}</button>
        </form>
        <form onSubmit="Items.create(this); return false" id="query_form" style="display:none;">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">{lang('name', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="description">{lang('description_short', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="description" id="description" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="quality">{lang('item_quality', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="quality" name="quality">
                        <option value="0" class="q0">{lang('poor', 'store')}</option>
                        <option value="1" class="q1">{lang('common', 'store')}</option>
                        <option value="2" class="q2">{lang('uncommon', 'store')}</option>
                        <option value="3" class="q3">{lang('rare', 'store')}</option>
                        <option value="4" class="q4">{lang('epic', 'store')}</option>
                        <option value="5" class="q5">{lang('legendary', 'store')}</option>
                        <option value="6" class="q6">{lang('artifact', 'store')}</option>
                        <option value="7" class="q7">{lang('heirloom', 'store')}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="query_database">{lang('database', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="query_database" name="query_database">
                        <option value="cms">{lang('cms', 'store')}</option>
                        <option value="realm">{lang('realm_characters', 'store')}</option>
                        <option value="realmd">{lang('realmd_accounts', 'store')}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{lang('need_character', 'store')}</label>
                <div class="col-sm-10 align-self-center">
                    <label for="query_need_character" class="flex cursor-pointer items-center">
				    	<span class="relative block">
				    		<input type="checkbox" id="query_need_character" name="query_need_character" class="form-control peer absolute z-0 h-full w-full cursor-pointer opacity-0" checked="yes" value="1"><span class="border-muted-300 dark:border-muted-600 dark:bg-muted-700 absolute start-0.5 top-1/2 z-10 flex h-5 w-5 -translate-y-1/2 items-center justify-center rounded-full border bg-white shadow transition focus:w-6 peer-checked:-translate-y-1/2 peer-checked:translate-x-full rtl:peer-checked:-translate-x-full"></span><span class="bg-muted-300 peer-focus:outline-muted-300 dark:bg-muted-600 dark:peer-focus:outline-muted-600 block h-6 w-11 rounded-full shadow-inner outline-1 outline-transparent transition-all duration-300 peer-focus:outline-dashed peer-focus:outline-offset-2 peer-focus:ring-0 peer-checked:bg-primary-400"></span>
				    		<svg aria-hidden="true" viewBox="0 0 17 12" class="pointer-events-none absolute start-2 top-1/2 z-10 h-2.5 w-2.5 translate-y-0 fill-current text-white opacity-0 transition duration-300 peer-checked:-translate-y-1/2 peer-checked:opacity-100">
				    			<path fill="currentColor" d="M16.576.414a1.386 1.386 0 0 1 0 1.996l-9.404 9.176A1.461 1.461 0 0 1 6.149 12c-.37 0-.74-.139-1.023-.414L.424 6.998a1.386 1.386 0 0 1 0-1.996 1.47 1.47 0 0 1 2.046 0l3.68 3.59L14.53.414a1.47 1.47 0 0 1 2.046 0z"></path>
				    		</svg>
				    	</span>
                        <span class="text-muted-400 relative ms-3 cursor-pointer select-none font-sans text-sm"></span>
                        {lang('make_user_select_character', 'store')}
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{lang('require_offline', 'store')}</label>
                <div class="col-sm-10 align-self-center">
                    <label for="require_character_offline" class="flex cursor-pointer items-center">
				    	<span class="relative block">
				    		<input type="checkbox" id="require_character_offline" name="require_character_offline" class="form-control peer absolute z-0 h-full w-full cursor-pointer opacity-0" value="1"><span class="border-muted-300 dark:border-muted-600 dark:bg-muted-700 absolute start-0.5 top-1/2 z-10 flex h-5 w-5 -translate-y-1/2 items-center justify-center rounded-full border bg-white shadow transition focus:w-6 peer-checked:-translate-y-1/2 peer-checked:translate-x-full rtl:peer-checked:-translate-x-full"></span><span class="bg-muted-300 peer-focus:outline-muted-300 dark:bg-muted-600 dark:peer-focus:outline-muted-600 block h-6 w-11 rounded-full shadow-inner outline-1 outline-transparent transition-all duration-300 peer-focus:outline-dashed peer-focus:outline-offset-2 peer-focus:ring-0 peer-checked:bg-primary-400"></span>
				    		<svg aria-hidden="true" viewBox="0 0 17 12" class="pointer-events-none absolute start-2 top-1/2 z-10 h-2.5 w-2.5 translate-y-0 fill-current text-white opacity-0 transition duration-300 peer-checked:-translate-y-1/2 peer-checked:opacity-100">
				    			<path fill="currentColor" d="M16.576.414a1.386 1.386 0 0 1 0 1.996l-9.404 9.176A1.461 1.461 0 0 1 6.149 12c-.37 0-.74-.139-1.023-.414L.424 6.998a1.386 1.386 0 0 1 0-1.996 1.47 1.47 0 0 1 2.046 0l3.68 3.59L14.53.414a1.47 1.47 0 0 1 2.046 0z"></path>
				    		</svg>
				    	</span>
                        <span class="text-muted-400 relative ms-3 cursor-pointer select-none font-sans text-sm"></span>
                        {lang('make_sure_character_offline', 'store')}
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="query" data-bs-toggle="tooltip" data-placement="top" title="{lang('query_example_tooltip', 'store')}">{lang('sql_query', 'store')} <a>(?)</a></label>
                <div class="col-sm-10">
                    <textarea class="form-control max-h-52 nui-focus border-muted-300 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full border bg-white font-monospace transition-all duration-300 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 min-h-[2.5rem] text-sm leading-[1.6] rounded-xl resize-none p-2" id="query" name="query"></textarea>
                    <span class="help-block">
                    {literal}
                        <b>{ACCOUNT}</b> = {/literal}{lang('account_id', 'store')},
                    {literal}<b>{CHARACTER}</b> = {/literal}{lang('character_id', 'store')},
                    {literal}<b>{REALM}</b> = {/literal}{lang('realm_id', 'store')}
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="realm">{lang('realm', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="realm" id="realm">
                        {foreach from=$realms item=realm}
                            <option value="{$realm->getId()}">{$realm->getName()}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="group">{lang('item_group', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="group" id="group">
                        <option value="0">{lang('none', 'store')}</option>
                        {foreach from=$groups item=group}
                            <option value="{$group.id}">{$group.title}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="vp_price form-group row">
                <label class="col-sm-2 col-form-label" for="vpCost">{lang('vp_price', 'store')}</label>
                <div class="col-sm-10">
                    <div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
                        <div class="input-group">
                            <input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="vpCost" id="vpCost" value="0">
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
            <div class="dp_price form-group row">
                <label class="col-sm-2 col-form-label" for="dpCost">{lang('dp_price', 'store')}</label>
                <div class="col-sm-10">
                    <div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
                        <div class="input-group">
                            <input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="dpCost" id="dpCost" value="0"/>
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
                <label class="col-sm-2 col-form-label" for="icon">{lang('icon_name', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="icon" id="icon" value="">
                </div>
            </div>
            <input type="hidden" id="item_type" name="item_type" value="query">
            <button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">{lang('submit_query', 'store')}</button>
        </form>
        <form onSubmit="Items.create(this); return false" id="item_form">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">{lang('name_multiple_items', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name" placeholder="{lang('name_multiple_items_placeholder', 'store')}" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="itemid">{lang('item_id', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="itemid" id="itemid" placeholder="12345" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="itemcount">{lang('count', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="itemcount" id="itemcount" placeholder="1">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="description">{lang('description_short', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="description" id="description" placeholder="{lang('description_placeholder', 'store')}" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="realm">{lang('realm', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="realm" id="realm">
                        {foreach from=$realms item=realm}
                            <option value="{$realm->getId()}">{$realm->getName()}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="group">{lang('item_group', 'store')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="group" id="group">
                        <option value="0">{lang('none', 'store')}</option>
                        {foreach from=$groups item=group}
                            <option value="{$group.id}">{$group.title}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="vp_price form-group row">
                <label class="col-sm-2 col-form-label" for="vpCost">{lang('vp_price', 'store')}</label>
                <div class="col-sm-10">
                    <div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
                        <div class="input-group">
                            <input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="vpCost" id="vpCost" value="0">
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
            <div class="dp_price form-group row">
                <label class="col-sm-2 col-form-label" for="dpCost">{lang('dp_price', 'store')}</label>
                <div class="col-sm-10">
                    <div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
                        <div class="input-group">
                            <input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="dpCost" id="dpCost" value="0"/>
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
                <label class="col-sm-2 col-form-label" for="icon">{lang('icon_name', 'store')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="icon" id="icon" placeholder="{lang('icon_placeholder', 'store')}" />
                </div>
            </div>
            <input type="hidden" id="item_type" name="item_type" value="item">
            <button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">{lang('submit_item', 'store')}</button>
        </form>
    </div>
</div>