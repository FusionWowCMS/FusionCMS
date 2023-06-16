<div class="box big">
	<div class="card-header">Edit change</div>
	<div class="card-body">
	<form onSubmit="Changelog.save(this, {$changelog.change_id}); return false" id="submit_form">
	<div class="form-group row mb-3">
	<label class="col-sm-2 col-form-label" for="text">Message</label>
	<div class="col-sm-10">
		<textarea class="form-control" id="text" name="text" rows="4">{$changelog.changelog}</textarea>
	</div>
	</div>
	<input class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit" value="Save change" />
	</form>
	</div>
</div>