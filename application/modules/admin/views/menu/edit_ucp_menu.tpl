<script type="text/javascript">
	const customPages = JSON.parse('{json_encode($pages)}');
</script>
<section class="card">
	<style>.iconpicker-popover.popover { width: auto; }</style>
	<div class="card-header">Edit UCP link</div>
	
<div class="card-body">
	<form role="form" onSubmit="UcpMenu.save(this, {$link.id}); return false" id="submit_form">
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="name" id="languages">Title</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name" placeholder="My link" value="{htmlspecialchars($link.name)}">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="description">Description</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="description" id="description" placeholder="" value="{htmlspecialchars($link.description)}">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="icon">Icon</label>
			<div class="col-sm-10">
				<input data-placement="bottom" class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded icp" type="text" name="icon" id="icon" value="{$link.icon}"/>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="link" data-toggle="tooltip" data-placement="bottom" title="External links must begin with https://">URL (or <a href="javascript:void(0)" onClick="UcpMenu.selectCustom()">select from custom pages</a>) <a>(?)</a></label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="link" id="link" placeholder="https://" value="{$link.link}"/>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="group">Group</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="number" name="group" id="group" value="{$link.group}"/>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="permission">Permission</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="permission" id="permission" value="{$link.permission}" />
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="permissionModule">Permission Module</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="permissionModule" id="permissionModule" value="{$link.permissionModule}" />
			</div>
		</div>

		<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Save</button>
	</form>
</div>
</section>

<script>
	require([Config.URL + "application/themes/admin/assets/js/mli.js"], function()
	{
		new MultiLanguageInput($("#name"));
	});
</script>