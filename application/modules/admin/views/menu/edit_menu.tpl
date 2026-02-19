<section class="card">
	<div class="card-header">{lang('edit_link', 'admin')}</div>
	
<div class="card-body">
	<form role="form" onSubmit="Menu.save(this, {$link.id}); return false" id="submit_form">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name" id="languages">{lang('title', 'admin')}</label>
		<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name" placeholder="{lang('link_placeholder', 'admin')}" value="{htmlspecialchars($link.name)}">
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="type" data-toggle="tooltip" data-placement="bottom" title="{lang('external_links_http', 'admin')}">{lang('url', 'admin')} <a>(?)</a></label>
		<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="link" id="link" placeholder="{lang('http_placeholder', 'admin')}" value="{$link.link}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="type">{lang('menu_location', 'admin')}</label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="type" id="type">
			<option value="top" {if $link.type == "top"}selected{/if}>{lang('location_top', 'admin')}</option>
			<option value="side" {if $link.type == "side"}selected{/if}>{lang('location_side', 'admin')}</option>
			<option value="bottom" {if $link.type == "bottom"}selected{/if}>{lang('location_bottom', 'admin')}</option>
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="side">{lang('side', 'admin')} <a data-toggle="tooltip" data-placement="bottom" title="{lang('side_tooltip', 'admin')}">(?)</a></label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="side" id="side">
			<option value="L" {if $link.side == "L"}selected{/if}>{lang('left', 'admin')}</option>
			<option value="R" {if $link.side == "R"}selected{/if}>{lang('right', 'admin')}</option>
		</select>
		</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="dropdown">{lang('dropdown', 'admin')} <a data-toggle="tooltip" data-placement="bottom" title="{lang('dropdown_tooltip', 'admin')}">(?)</a></label>
			<div class="col-sm-10">
				<select onChange="if(this.value == '0'){ $('#parent_name').fadeIn(150); } else { $('#parent_name').fadeOut(150); }" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="dropdown" id="dropdown">
					<option value="0" {if $link.dropdown == "0"}selected{/if}>{lang('no', 'admin')}</option>
					<option value="1" {if $link.dropdown == "1"}selected{/if}>{lang('yes', 'admin')}</option>
				</select>
			</div>
		</div>
		
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="parent_id">{lang('parent', 'admin')} <a data-toggle="tooltip" data-placement="bottom" title="{lang('parent_dropdown_name', 'admin')}">(?)</a></label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="parent_id" id="parent_id">
			<option value="0">{lang('none', 'admin')}</option>
			{foreach from=$links item=menu}
				{if $menu.dropdown}<option {if $menu.id == $link.parent_id}selected{/if} value="{$menu.id}">{langColumn($menu.name)}</option>{/if}
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="visibility">{lang('visibility_mode', 'admin')}</label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
			<option value="everyone" {if $link.permission != $link.id}selected{/if}>{lang('visible_to_everyone', 'admin')}</option>
			<option value="group" {if $link.permission == $link.id}selected{/if}>{lang('controlled_per_group', 'admin')}</option>
		</select>
		</div>
		</div>

		<div style="display:none" id="groups">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">
					{lang('manage_group_visibility_prefix', 'admin')} <a href="{$url}admin/aclmanager/groups">{lang('group_manager', 'admin')}</a> {lang('after_create_sidebox', 'admin')}
				</div>
			</div>
		</div>

		<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-100 rounded-md">{lang('save', 'admin')}</button>
	</form>
</div>
</section>

<script>
	require([Config.URL + "application/themes/admin/assets/js/mli.js"], function()
	{
		new MultiLanguageInput($("#name"));
	});
</script>
