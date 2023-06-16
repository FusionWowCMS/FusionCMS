<div class="card">
	<div class="card-header">New topsite</div>
	<div class="card-body">
	<form role="form" onSubmit="Topsites.create(this); return false" id="submit_form">

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="vote_url">Your vote link</label>
	<div class="col-lg-9">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="url" name="vote_url" id="vote_url" placeholder="http://" onChange="Topsites.check(this)"/>
	</div>
	</div>

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="vote_sitename">Site title</label>
	<div class="col-lg-9">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="vote_sitename" id="vote_sitename"/>
	</div>
	</div>

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="vote_image">Vote site image (will be auto-completed if URL is recognized)</label>
	<div class="col-lg-9">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="vote_image" id="vote_image" placeholder="(optional)" onChange="Topsites.updateImagePreview(this.value)"/>

	<div id="vote_image_preview" style="display:none">
		<small>Preview:</small><br/>
		<img alt="Loading..."/>
	</div>
	</div>
	</div>

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="hour_interval">Hour interval</label>
	<div class="col-lg-9">
	<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 9999 }'>
		<div class="input-group">
			<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="hour_interval" id="hour_interval" value="12"/>
			<div class="spinner-buttons input-group-btn btn-group-vertical">
				<button type="button" class="btn spinner-up btn-xs btn-default">
					<i class="fas fa-angle-up"></i>
				</button>
				<button type="button" class="btn spinner-down btn-xs btn-default">
					<i class="fas fa-angle-down"></i>
				</button>
			</div>
		</div>
	</div>
	</div>
	</div>

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="points_per_vote">Vote points per vote</label>
	<div class="col-lg-9">
	<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 9999 }'>
		<div class="input-group">
			<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="points_per_vote" id="points_per_vote" value="1"/>
			<div class="spinner-buttons input-group-btn btn-group-vertical">
				<button type="button" class="btn spinner-up btn-xs btn-default">
					<i class="fas fa-angle-up"></i>
				</button>
				<button type="button" class="btn spinner-down btn-xs btn-default">
					<i class="fas fa-angle-down"></i>
				</button>
			</div>
		</div>
	</div>
	</div>
	</div>

	<div class="form-group row mb-3">
	<label class="col-lg-3 col-form-label form-control-label" for="callback_enabled" data-toggle="tooltip" data-placement="bottom" title="If enabled, vote points are only credited if the user has actually voted. Not all topsites support this feature.">Enable vote verification (<a>?</a>)</label>
	<div class="col-lg-9">
	<div id="callback_form">
		<div class="not-supported">This topsite is not supported.</div>

		<div class="form" style="display:none">
			<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="callback_enabled" name="callback_enabled" onChange="Topsites.updateLinkFormat()">
				<option value="0" selected>No</option>
				<option value="1">Yes</option>
			</select>
			
			<div class="dropdown help">
				<h3>How to configure vote verification for </h3>
			</div>
		</div>
	</div>
	</div>
	</div>

	<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Submit topsite</button>
	</form>
	</div>
</div>