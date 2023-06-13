<div class="card">
	<div class="card-header">Edit teleport location</div>

	<div class="card-body">
	<form role="form" onSubmit="Teleport.save(this, {$teleport_location.id}); return false" id="submit_form">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name">Location name</label>
		<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name" value="{$teleport_location.name}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="description">Description</label>
		<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="description" id="description" value="{$teleport_location.description}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realm">Realm</label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="realm" name="realm">
			{foreach from=$realms item=realm}
				<option class="form-control" value="{$realm->getId()}" {if $teleport_location.realm == $realm->getId()}selected{/if}>{$realm->getName()}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="priceType">Price type</label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="priceType" name="priceType" onChange="Teleport.changePrice(this)">
			<option value="free" {if !$teleport_location.vpCost && !$teleport_location.dpCost && $teleport_location.goldCost}selected{/if}>Free</option>
			<option value="vp" {if $teleport_location.vpCost}selected{/if}>VP</option>
			<option value="dp" {if $teleport_location.dpCost}selected{/if}>DP</option>
			<option value="gold" {if $teleport_location.goldCost}selected{/if}>Gold</option>
		</select>
		</div>
		</div>

		<div id="vp_price" style="display:none;">
		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="vpCost">VP price</label>
		<div class="col-sm-10">
		<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
			<div class="input-group">
				<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="vpCost" id="vpCost" value="{$teleport_location.vpCost}"/>
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
		</div>

		<div id="dp_price" style="display:none;">
		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="dpCost">DP price</label>
		<div class="col-sm-10">
		<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
			<div class="input-group">
				<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="dpCost" id="dpCost" value="{$teleport_location.dpCost}"/>
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
		</div>

		<div id="gold_price" style="display:none;">
		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="goldCost">Gold price</label>
		<div class="col-sm-10">
		<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 999999999999 }'>
			<div class="input-group">
				<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="goldCost" id="goldCost" value="{$teleport_location.goldCost}"/>
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
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="x">X coordinate</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="x" id="x" value="{$teleport_location.x}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="y">Y coordinate</label>
		<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="y" id="y" value="{$teleport_location.y}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="z">Z coordinate</label>
		<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="z" id="z" value="{$teleport_location.z}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="orientation">Orientation</label>
		<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="orientation" id="orientation" value="{$teleport_location.orientation}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="mapId">Map ID</label>
		<div class="col-sm-10">
		<div data-plugin-spinner data-plugin-options='{ "min": 0, "max": 99999 }'>
			<div class="input-group">
				<input class="spinner-input form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="mapId" id="mapId" value="{$teleport_location.mapId}"/>
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
		<label class="col-sm-2 col-form-label" for="required_faction">Required faction</label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="required_faction" name="required_faction">
			<option value="0" {if $teleport_location.required_faction == 0}selected{/if}>Any</option>
			<option value="1" {if $teleport_location.required_faction == 1}selected{/if}>Alliance</option>
			<option value="2" {if $teleport_location.required_faction == 2}selected{/if}>Horde</option>
		</select>
		</div>
		</div>
		
		<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Save location</button>
	</div>
	</form>
</div>