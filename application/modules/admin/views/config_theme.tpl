{foreach from=$configs item=config key=title}

<div class="card">
	<header class="card-header">{$title}.php</header>
<div class="card-body">
	{if array_key_exists('force_code_editor', $config) && $config['force_code_editor']}
		<form role="form" onSubmit="Settings.submitThemeConfigSource('{$themeName}', '{$title}');return false" id="advanced_{$title}">
			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="source_{$title}">Source code</label>
			<div class="col-sm-10">
				<textarea class="form-control nui-focus border-muted-300 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full border bg-white font-sans transition-all duration-300 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 min-h-[2.5rem] text-sm leading-[1.6] rounded resize-none p-2" id="source_{$title}" name="source_{$title}" rows="15" spellcheck="false">{$config.source}</textarea>
			</div>
			</div>
			<button type="submit" class="btn btn-primary">Save config</button>
		</form>
	{else}
		<button class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md mb-3" href="javascript:void(0)" onClick="Settings.toggleSource('{$title}', this)">Edit source code (advanced)</button>

		<form role="form" onSubmit="Settings.submitThemeConfigSource('{$themeName}', '{$title}');return false" id="advanced_{$title}" style="display:none;">
			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="source_{$title}">Source code</label>
			<div class="col-sm-10">
				<textarea class="form-control nui-focus border-muted-300 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full border bg-white font-sans transition-all duration-300 focus:shadow-lg disabled:cursor-not-allowed disabled:opacity-75 min-h-[2.5rem] text-sm leading-[1.6] rounded resize-none p-2" id="source_{$title}" name="source_{$title}" rows="15" spellcheck="false">{$config.source}</textarea>
			</div>
			</div>
			<button type="submit" class="btn btn-primary">Save config</button>
		</form>

		<form role="form" onSubmit="Settings.submitThemeConfig(this, '{$themeName}', '{$title}');return false" id="gui_{$title}">
			{foreach from=$config item=option key=label}
			<div class="form-group row">
				{if $label != "source"}
					{if is_array($option) && ctype_digit(implode('', array_keys($option)))}
						<label class="col-sm-2 col-form-label" for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
						<div class="col-sm-10">
							<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" value="{foreach from=$option item=value}{$value},{/foreach}" id="{$label}" name="{$label}" />
						</div>
					{elseif is_array($option)}	
						<label class="col-sm-2 col-form-label" for="{$label}"><b>{ucfirst(preg_replace("/_/", " ", $label))}</b></label>
						{foreach from=$option item=sub_option key=sub_label}		
							{if is_array($sub_option) && ctype_digit(implode('', array_keys($sub_option)))}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
								<div class="col-sm-10">
									<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" value="{foreach from=$sub_option item=value}{$value},{/foreach}" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}" />
								</div>
							{elseif is_array($sub_option)}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}"><b>{ucfirst(preg_replace("/_/", " ", $sub_label))}</b></label>
							{elseif $sub_option === true}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
								<div class="col-sm-10">
								<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}">
									<option selected value="true">Yes</option>
									<option value="false">No</option>
								</select>
								</div>
							{elseif $sub_option === false}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
								<div class="col">
								<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}">
									<option value="true">Yes</option>
									<option selected value="false">No</option>
								</select>
								</div>
							{else}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
								<div class="col">
									<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" value="{$sub_option}" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}" />
								</div>
							{/if}
						{/foreach}
					{elseif $option === true}
						<label class="col-sm-2 col-form-label" for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
						<div class="col-sm-10">
						<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="{$label}" name="{$label}">
							<option selected value="true">Yes</option>
							<option value="false">No</option>
						</select>
						</div>
					{elseif $option === false}
						<label class="col-sm-2 col-form-label" for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
						<div class="col-sm-10">
						<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" id="{$label}" name="{$label}">
							<option value="true">Yes</option>
							<option selected value="false">No</option>
						</select>
						</div>
					{else}
						<label class="col-sm-2 col-form-label" for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
						<div class="col-sm-10">
							<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" value="{$option}" id="{$label}" name="{$label}" />
						</div>
					{/if}
				{/if}
				</div>
			{/foreach}
			
			<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Save config</button>
		</form>
	{/if}
</div>
</div>
{/foreach}