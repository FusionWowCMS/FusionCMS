{if hasPermission("toggleMessage")}
<div class="card">
	<header class="card-header">Message
	<span class="pull-right">
		This will temporarily disable the entire site to display the message until you turn it off.
	</span>
	</header>

	<div class="card-body">
	<form onSubmit="Settings.submitMessage(this);return false">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="message_enabled">Global maintenance message</label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="message_enabled" name="message_enabled">
			<option value="true" {if $message_enabled}selected{/if}>Enabled</div>
			<option value="false" {if !$message_enabled}selected{/if}>Disabled</div>
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="message_headline">Headline</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="message_headline" name="message_headline" value="Maintenance" onKeyUp="Settings.liveUpdate(this, 'headline')">
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="message_headline_size">Headline size (default: 56)</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" id="message_headline_size" name="message_headline_size" value="56" onKeyUp="Settings.liveUpdate(this, 'headline_size')">
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="message_text">Message</label>
		<div class="col-sm-10">
		<textarea class="form-controlnui-focus border-muted-300 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full border bg-white font-sans transition-all duration-300 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 min-h-[2.5rem] text-sm leading-[1.6] rounded resize-none p-2 mb-3" id="message_text" name="message_text" rows="10" onKeyUp="Settings.liveUpdate(this, 'text')">The Website is currently down for maintenance, please come back later!</textarea>
		</div>
		</div>

		<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Save message</button>
	</form>
	</div>
</div>
{/if}

<div class="card">
	<div class="card-header">Preview</div>
	<div class="card-body">
		<span class="text-center">
		<h3 id="live_headline" style="font-size:56px;">Maintenance</h3>
		<p id="live_text">The Website is currently down for maintenance, please come back later!</p>
		</span>
	</div>
</div>