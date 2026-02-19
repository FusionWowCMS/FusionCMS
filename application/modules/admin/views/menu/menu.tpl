<script type="text/javascript">
    var customPages = JSON.parse('{json_encode($pages)}');
</script>
<div class="row" id="main_link">
    <div class="col-12">
        <div class="card">
            <header class="card-header">
                {lang('menu_links', 'admin')} (
                <div style="display:inline;">{if !$links}0{else}{count($links)}{/if}</div>
                )
                {if hasPermission("addMenuLinks")}<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Menu.add()">{lang('create_link', 'admin')}</button>{/if}
            </header>
            <div class="card-body">
                <table class="table table-responsive-md table-hover">
                    <thead>
                        <tr>
                            <th>{lang('sort', 'admin')}</th>
                            <th>{lang('position', 'admin')}</th>
                            <th>{lang('name', 'admin')}</th>
                            <th>{lang('link', 'admin')}</th>
                            <th>{lang('dropdown', 'admin')}</th>
                            <th style="text-align: center;">{lang('action', 'admin')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $links}
                        {foreach from=$links item=link}
                        <tr>
                            <td>
                                {if hasPermission("editMenuLinks")}
                                <a href="javascript:void(0)" onClick="Menu.move('up', {$link.id}, this)" data-bs-toggle="tooltip" data-bs-placement="top" title="{lang('move_up', 'admin')}"><i class="fa-duotone fa-up-from-bracket"></i></a>
                                <a href="javascript:void(0)" onClick="Menu.move('down', {$link.id}, this)" data-bs-toggle="tooltip" data-bs-placement="top" title="{lang('move_down', 'admin')}"><i class="fa-duotone fa-down-to-bracket"></i></a>
                                {/if}
                            </td>
                            <td>{$link.type}</td>
                            <td>{langColumn($link.name)}</td>
                            <td><a href="{$link.link}" target="_blank">{$link.link_short}</a></td>
                            <td>{if $link.dropdown}{lang('yes', 'admin')}{else}{lang('no', 'admin')}{/if}</td>
                            <td style="text-align: center;">
                                {if hasPermission("editMenuLinks")}
                                <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}admin/menu/edit/{$link.id}">{lang('edit', 'admin')}</a>
                                {/if}
                                {if hasPermission("deleteMenuLinks")}
                                <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Menu.remove({$link.id}, this)">{lang('delete', 'admin')}</a>
                                {/if}
                            </td>
                        </tr>
                        {/foreach}
                        {/if}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card mt-4" id="add_link" style="display:none;">
            <div class="card-header">{lang('new_menu', 'admin')}</div>
            <div class="card-body">
                <div class="col-12">
                    <form role="form" onSubmit="Menu.create(this); return false" id="submit_form">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name" id="languages">{lang('name', 'admin')}</label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name" placeholder="{lang('link_placeholder', 'admin')}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="type" data-toggle="tooltip" data-placement="bottom" title="{lang('external_links_http', 'admin')}">{lang('url', 'admin')} ({lang('or', 'admin')} <a href="javascript:void(0)" onClick="Menu.selectCustom()">{lang('select_from_custom_pages', 'admin')}</a>) <a>(?)</a></label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="link" id="link" placeholder="{lang('http_placeholder', 'admin')}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="type">{lang('menu_location', 'admin')}</label>
                            <div class="col-sm-10">
                                <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="type" id="type">
                                    <option value="top">{lang('location_top', 'admin')}</option>
                                    <option value="side">{lang('location_side', 'admin')}</option>
                                    <option value="bottom">{lang('location_bottom', 'admin')}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="side">{lang('side', 'admin')} <a data-toggle="tooltip" data-placement="bottom" title="{lang('side_tooltip', 'admin')}">(?)</a></label>
                            <div class="col-sm-10">
                                <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="side" id="side">
                                    <option value="L">{lang('left', 'admin')}</option>
                                    <option value="R">{lang('right', 'admin')}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="dropdown">{lang('dropdown', 'admin')} <a data-toggle="tooltip" data-placement="bottom" title="{lang('dropdown_tooltip', 'admin')}">(?)</a></label>
                            <div class="col-sm-10">
                                <select onChange="if(this.value == '0'){ $('#parent_name').fadeIn(150); } else { $('#parent_name').fadeOut(150); }" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="dropdown" id="dropdown">
                                    <option value="0">{lang('no', 'admin')}</option>
                                    <option value="1">{lang('yes', 'admin')}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="parent_name">
                            <label class="col-sm-2 col-form-label" for="parent_id">{lang('parent', 'admin')} <a data-toggle="tooltip" data-placement="bottom" title="{lang('parent_dropdown_name', 'admin')}">(?)</a></label>
                            <div class="col-sm-10">
                                <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="parent_id" id="parent_id">
                                    <option value="0">{lang('none', 'admin')}</option>
                                    {foreach from=$links item=link}
                                        {if $link.dropdown}
                                        <option value="{$link.id}">{langColumn($link.name)}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="visibility">{lang('visibility_mode', 'admin')}</label>
                            <div class="col-sm-10">
                                <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
                                    <option value="everyone" selected>{lang('visible_to_everyone', 'admin')}</option>
                                    <option value="group">{lang('controlled_per_group', 'admin')}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="groups" style="display:none;">
                            {lang('manage_group_visibility_prefix', 'admin')} <a href="{$url}admin/aclmanager/groups">{lang('group_manager', 'admin')}</a> {lang('after_create_link', 'admin')}
                        </div>
                        <button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-100 rounded-md">{lang('submit_link', 'admin')}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    require([Config.URL + "application/themes/admin/assets/js/mli.js"], function()
    {
    	new MultiLanguageInput($("#name"));
    });
</script>
