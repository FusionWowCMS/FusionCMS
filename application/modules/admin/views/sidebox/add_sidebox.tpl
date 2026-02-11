{TinyMCE()}
<div class="card">
    <div class="card-header">
        {lang('new_sidebox', 'admin')}<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}admin/sidebox">{lang('back', 'admin')}</a>
    </div>
    <div class="card-body">
        <form role="form" onSubmit="Sidebox.create(this); return false" id="submit_form">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="displayName">{lang('headline', 'admin')}</label>
                <div class="col-sm-10">
                    <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="displayName" id="displayName" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="type">{lang('sidebox_module', 'admin')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="type" name="type" onChange="Sidebox.toggleCustom(this)">
                        {foreach from=$sideboxModules item=module key=name}
                        <option value="{$name}">{$module.name}</option>
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
                    <div style="display:none" id="groups">
                        {lang('manage_group_visibility_prefix', 'admin')} <a href="{$url}admin/aclmanager/groups">{lang('group_manager', 'admin')}</a> {lang('after_create_sidebox', 'admin')}
                    </div>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label" for="location">{lang('location', 'admin')}</label>
                <div class="col-sm-10">
                    <select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="location" id="location">
                        <option value="side" selected>{lang('location_side', 'admin')}</option>
                        <option value="top">{lang('location_top_before_news', 'admin')}</option>
                        <option value="bottom">{lang('location_bottom_after_news', 'admin')}</option>
                    </select>
                </div>
            </div>

            {* Pages.Start *}
            {if isset($pages) && $pages|is_array && count($pages)}
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">{lang('pages', 'admin')}</label>
                    <div class="col-sm-10">
                        <div class="row row-cols-2 row-cols-md-6">
                            {foreach from=$pages item=item}
                                <div class="col">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="pages[]" id="page_{$item}" value="{$item}" checked />
                                        <label class="form-check-label" for="page_{$item}">{$item}</label>
                                    </div>
                                </div>
                            {/foreach}
                        </div>

                        <hr class="my-3" />

                        <div class="row row-cols-2 row-cols-md-6 justify-content-md-end">
                            <div class="col">
                                <a href="javascript:void(0)" onclick="[...document.querySelectorAll('input[name=\'pages[]\']')].map(el => { if(el.value === '*') { return; } el.checked = true; })"><i class="fa-duotone fa-toggle-on align-top"></i> {lang('check_all', 'admin')}</a>
                            </div>

                            <div class="col">
                                <a href="javascript:void(0)" onclick="[...document.querySelectorAll('input[name=\'pages[]\']')].map(el => { if(el.value === '*') { return; } el.checked = false; })"><i class="fa-duotone fa-toggle-off align-top"></i> {lang('uncheck_all', 'admin')}</a>
                            </div>

                            <div class="col">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="pages[]" id="page_*" value="*" onclick="[...document.querySelectorAll('input[name=\'pages[]\']')].map(el => { if(el.value === '*') { return; } if(this.checked) { el.disabled = true; } else { el.disabled = false; } })" />
                                    <label class="form-check-label" for="page_*">{lang('visible_all_pages', 'admin')}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            {* Pages.End *}

            <div class="mb-3" id="custom_field">
                <textarea name="content" class="form-control tinymce" id="customContent"></textarea>
            </div>
            <button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-100 rounded-md">{lang('submit_sidebox', 'admin')}</button>
        </form>
    </div>
</div>
<script>
    require([Config.URL + "application/themes/admin/assets/js/mli.js"], function()
    {
    	new MultiLanguageInput($("#displayName"));
    });
</script>
