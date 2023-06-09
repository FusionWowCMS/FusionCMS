<div class="card">
	<div class="card-header">New topsite</div>
	<div class="card-body">
	<form role="form" onSubmit="Topsites.create(this); return false" id="submit_form">

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="vote_url">Your vote link</label>
	<div class="col-lg-9">
		<input class="form-control" type="url" name="vote_url" id="vote_url" placeholder="http://" onChange="Topsites.check(this)"/>
	</div>
	</div>

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="vote_sitename">Site title</label>
	<div class="col-lg-9">
		<input class="form-control" type="text" name="vote_sitename" id="vote_sitename"/>
	</div>
	</div>

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="vote_image">Vote site image (will be auto-completed if URL is recognized)</label>
	<div class="col-lg-9">
		<input class="form-control" type="text" name="vote_image" id="vote_image" placeholder="(optional)" onChange="Topsites.updateImagePreview(this.value)"/>

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
			<input class="spinner-input form-control" type="text" name="hour_interval" id="hour_interval" value="12"/>
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
			<input class="spinner-input form-control" type="text" name="points_per_vote" id="points_per_vote" value="1"/>
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
			<select class="form-control" id="callback_enabled" name="callback_enabled" onChange="Topsites.updateLinkFormat()">
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

	<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 bg-white border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Submit topsite</button>
	</form>
	</div>
</div>