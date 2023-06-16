<div class="card">
	<div class="card-header">New slide</div>
	<div class="card-body">
	<form onSubmit="Slider.create(this); return false">
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="image">Image URL</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="image" id="image" placeholder="http://"/>
			</div>
		</div>

		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="text_header">Text Header (optional)</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="text_header" id="text_header"/>
			</div>
		</div>

		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="text_body">Text Body (optional)</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="text_body" id="text_body"/>
			</div>
		</div>

		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="text_footer">Text Footer (optional)</label>
			<div class="col-sm-10">
				<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="text_footer" id="text_footer"/>
			</div>
		</div>

		<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Submit slider</button>
	</form>
	</div>
</div>