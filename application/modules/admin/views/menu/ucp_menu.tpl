<script type="text/javascript">
    const customPages = JSON.parse('{json_encode($pages)}');
</script>
<style>
    .iconpicker-popover.popover {
        width: auto;
    }
</style>
<div class="row" id="main_link">
    <div class="col-12">
        <div class="card">
            <header class="card-header">
                UCP Menu Links (
                <div style="display:inline;">{if !$links}0{else}{count($links)}{/if}</div>
                )
                {if hasPermission("addMenuLinks")}<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="UcpMenu.add()">Create link</button>{/if}
            </header>
            <div class="card-body">
                <table class="table table-responsive-md table-hover">
                    <thead>
                        <tr>
                            <th>Sort</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Link</th>
                            <th>Group</th>
                            <th>Permission</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $links}
                        {foreach from=$links item=link}
                        <tr>
                            <td>
                                {if hasPermission("editMenuLinks")}
                                <a href="javascript:void(0)" onClick="UcpMenu.move('up', {$link.id}, this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Move up"><i class="fa-duotone fa-up-from-bracket"></i></a>
                                <a href="javascript:void(0)" onClick="UcpMenu.move('down', {$link.id}, this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Move down"><i class="fa-duotone fa-down-to-bracket"></i></a>
                                {/if}
                            </td>
                            <td>{$link.icon}</td>
                            <td>{langColumn($link.name)}</td>
                            <td><a href="{$link.link}" target="_blank">{$link.link_short}</a></td>
                            <td>{$link.group}</td>
                            <td>{$link.permission} - {$link.permissionModule}</td>
                            <td style="text-align: center;">
                                {if hasPermission("editMenuLinks")}
                                <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}admin/ucpmenu/edit/{$link.id}">Edit</a>
                                {/if}
                                {if hasPermission("deleteMenuLinks")}
                                <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="UcpMenu.remove({$link.id}, this)">Delete</a>
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
            <div class="card-header">New Ucp Menu</div>
            <div class="card-body">
                <div class="col-12">
                    <form role="form" onSubmit="UcpMenu.create(this); return false" id="submit_form">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name" id="languages">Title</label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name" placeholder="My link" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="description">Description</label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="description" id="description" placeholder="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="icon">Icon</label>
                            <div class="col-sm-10">
                                <input data-placement="top" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded icp" type="text" name="icon" id="icon"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="link" data-toggle="tooltip" data-placement="bottom" title="External links must begin with https://">URL (or <a href="javascript:void(0)" onClick="UcpMenu.selectCustom()">select from custom pages</a>) <a>(?)</a></label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="link" id="link" placeholder="https://"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="group">Group</label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="number" name="group" id="group" value="1"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="permission">Permission</label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="permission" id="permission" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="permissionModule">Permission Module</label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="permissionModule" id="permissionModule" />
                            </div>
                        </div>
                        <button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Submit link</button>
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
