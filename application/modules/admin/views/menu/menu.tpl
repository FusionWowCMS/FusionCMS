<script type="text/javascript">
    var customPages = JSON.parse('{json_encode($pages)}');
</script>
<div class="row" id="main_link">
    <div class="col-12">
        <div class="card">
            <header class="card-header">
                Menu Links (
                <div style="display:inline;">{if !$links}0{else}{count($links)}{/if}</div>
                )
                {if hasPermission("addMenuLinks")}<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Menu.add()">Create link</button>{/if}
            </header>
            <div class="card-body">
                <table class="table table-responsive-md table-hover">
                    <thead>
                        <tr>
                            <th>Sort</th>
                            <th>Position</th>
                            <th>Name</th>
                            <th>Link</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $links}
                        {foreach from=$links item=link}
                        <tr>
                            <td>
                                {if hasPermission("editMenuLinks")}
                                <a href="javascript:void(0)" onClick="Menu.move('up', {$link.id}, this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Move up"><i class="fas fa-chevron-circle-up"></i></a>
                                <a href="javascript:void(0)" onClick="Menu.move('down', {$link.id}, this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Move down"><i class="fas fa-chevron-circle-down"></i></a>
                                {/if}
                            </td>
                            <td>{$link.side}</td>
                            <td>{langColumn($link.name)}</td>
                            <td><a href="{$link.link}" target="_blank">{$link.link_short}</a></td>
                            <td style="text-align: center;">
                                {if hasPermission("editMenuLinks")}
                                <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}admin/menu/edit/{$link.id}">Edit</a>
                                {/if}
                                {if hasPermission("deleteMenuLinks")}
                                <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Menu.remove({$link.id}, this)">Delete</a>
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
            <div class="card-header">New Menu</div>
            <div class="card-body">
                <div class="col-12">
                    <form role="form" onSubmit="Menu.create(this); return false" id="submit_form">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name" id="languages">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name" placeholder="My link" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="type" data-toggle="tooltip" data-placement="bottom" title="External links must begin with http://">URL (or <a href="javascript:void(0)" onClick="Menu.selectCustom()">select from custom pages</a>) <a>(?)</a></label>
                            <div class="col-sm-10">
                                <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="link" id="link" placeholder="http://"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="side">Menu location</label>
                            <div class="col-sm-10">
                                <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="side" id="side">
                                    <option value="top">Top</option>
                                    <option value="side">Side</option>
                                    <option value="bottom">Bottom</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="lrd">LRD <a data-toggle="tooltip" data-placement="bottom" title="Left, Right or Dropdown?">(?)</a></label>
                            <div class="col-sm-10">
                                <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="lrd" id="lrd">
                                    <option value="L">Left</option>
                                    <option value="R">Right</option>
                                    <option value="D">Dropdown</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="dropdown_id">Dropdown  <a data-toggle="tooltip" data-placement="bottom" title="The Name from the dropdown">(?)</a></label>
                            <div class="col-sm-10">
                                <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="dropdown_id" id="dropdown_id">
                                    <option value="0">-</option>
                                    {foreach from=$links item=link}
                                    {if $link.lrd == "D"}
                                    <option value="{$link.id}">{langColumn($link.name)}</option>
                                    {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="visibility">Visibility mode</label>
                            <div class="col-sm-10">
                                <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
                                    <option value="everyone" selected>Visible to everyone</option>
                                    <option value="group">Controlled per group</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="groups" style="display:none;">
                            Please manage the group visibility via <a href="{$url}admin/aclmanager/groups"> the group manager</a> once you have created the link
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