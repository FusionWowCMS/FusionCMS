{TinyMCE()}
<div class="card">
    <div class="card-header">
        New Sidebox<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 bg-white border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}admin/sidebox">Back</a>
    </div>
    <div class="card-body">
        <form role="form" onSubmit="Sidebox.create(this); return false" id="submit_form">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="displayName">Headline</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="displayName" id="displayName" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="type">Sidebox module</label>
                <div class="col-sm-10">
                    <select class="form-control" id="type" name="type" onChange="Sidebox.toggleCustom(this)">
                        {foreach from=$sideboxModules item=module key=name}
                        <option value="{$name}">{$module.name}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="visibility">Visibility mode</label>
                <div class="col-sm-10">
                    <select class="form-control" name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
                        <option value="everyone" selected>Visible to everyone</option>
                        <option value="group">Controlled per group</option>
                    </select>
                    <div style="display:none" id="groups">
                        Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a> once you have created the sidebox
                    </div>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label" for="location">Location</label>
                <div class="col-sm-10">
                    <select class="form-control" name="location" id="location">
                        <option value="side" selected>Side</option>
                        <option value="top">Top (Before the news)</option>
                        <option value="bottom">Bottom (After the news)</option>
                    </select>
                </div>
            </div>
            <div class="mb-3" id="custom_field">
                <textarea name="content" class="form-control tinymce" id="customContent"></textarea>
            </div>
            <button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 bg-white border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Submit sidebox</button>
        </form>
    </div>
</div>
<script>
    require([Config.URL + "application/themes/admin/assets/js/mli.js"], function()
    {
    	new MultiLanguageInput($("#displayName"));
    });
</script>