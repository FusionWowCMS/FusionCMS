{if hasPermission("editSlider")}
<div class="card">
	<div class="card-header">Slider settings</div>
	<div class="card-body">

	<form onSubmit="Slider.saveSettings(this); return false">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="show_slider">Visibility</label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="show_slider" id="show_slider">
			<option value="home" {if $slider && $slider_home}selected{/if}>Only on homepage</option>
			<option value="always" {if $slider && !$slider_home}selected{/if}>Always</option>
			<option value="never" {if !$slider}selected{/if}>Never</option>
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="slider_interval">Slider interval (in seconds)</label>
		<div class="col-sm-10">
			<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="slider_interval" id="slider_interval" value="{$slider_interval/1000}">
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="slider_style">Slider transition style</label>
		<div class="col-sm-10">
		<select class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 focus:border-muted-300 focus:shadow-muted-300/50 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-600 dark:focus:border-muted-700 dark:focus:shadow-muted-800/50 peer w-full cursor-pointer appearance-none border bg-white font-sans focus:shadow-lg px-2 pe-9 h-10 py-2 text-sm leading-5 px-3 pe-6 rounded px-3" name="slider_style" id="slider_style">
			<option value="" {if !$slider_style}selected{/if}>Random (all)</option>
			
			<option value="1" {if $slider_style == 1}selected{/if}>Back Down</option>
			<option value="2" {if $slider_style == 2}selected{/if}>Back Up</option>
			<option value="3" {if $slider_style == 3}selected{/if}>Back Left / Right</option>
			<option value="4" {if $slider_style == 4}selected{/if}>Back Right / Left</option>
			
			<option value="5" {if $slider_style == 5}selected{/if}>Bounce Down</option>
			<option value="6" {if $slider_style == 6}selected{/if}>Bounce Up</option>
			<option value="7" {if $slider_style == 7}selected{/if}>Bounce Left / Right</option>
			<option value="8" {if $slider_style == 8}selected{/if}>Bounce Right / Left</option>
			
			<option value="9" {if $slider_style == 9}selected{/if}>Fade Down</option>
			<option value="10" {if $slider_style == 10}selected{/if}>Fade Up</option>
			<option value="11" {if $slider_style == 11}selected{/if}>Fade Left / Right</option>
			<option value="12" {if $slider_style == 12}selected{/if}>Fade Right / Left</option>
			
			<option value="13" {if $slider_style == 13}selected{/if}>Fade Top Left / Bottom Right</option>
			<option value="14" {if $slider_style == 14}selected{/if}>Fade Top Right / Bottom Left</option>
			<option value="15" {if $slider_style == 15}selected{/if}>Fade Bottom Left / Top Right</option>
			<option value="16" {if $slider_style == 16}selected{/if}>Fade Bottom Right / Top Left</option>
			
			<option value="17" {if $slider_style == 17}selected{/if}>Fade Down (Big)</option>
			<option value="18" {if $slider_style == 18}selected{/if}>Fade Up (Big)</option>
			<option value="19" {if $slider_style == 19}selected{/if}>Fade Left / Right (Big)</option>
			<option value="20" {if $slider_style == 20}selected{/if}>Fade Right / Left (Big)</option>
			
			<option value="21" {if $slider_style == 21}selected{/if}>Rotate Down Left</option>
			<option value="22" {if $slider_style == 22}selected{/if}>Rotate Down Right</option>
			<option value="23" {if $slider_style == 23}selected{/if}>Rotate Up Left</option>
			<option value="24" {if $slider_style == 24}selected{/if}>Rotate Up Right</option>
			
			<option value="25" {if $slider_style == 25}selected{/if}>Roll</option>
			
			<option value="26" {if $slider_style == 26}selected{/if}>Slide Down</option>
			<option value="27" {if $slider_style == 27}selected{/if}>Slide Up</option>
			<option value="28" {if $slider_style == 28}selected{/if}>Slide Left / Right</option>
			<option value="29" {if $slider_style == 29}selected{/if}>Slide Right / Left</option>
		</select>
		</div>
		</div>

		<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Save settings</button>
	</form>
	</div>
</div>
{/if}

<div class="card">
	<div class="card-header">Slides (<div style="display:inline;" id="slider_count">{if !$slides}0{else}{count($slides)}{/if}</div>)
	{if hasPermission("addSlider")}<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}admin/slider/new">Create slide</a>{/if}
	</div>
	<div class="card-body">
		<table class="table table-responsive-md table-hover">
		<thead>
			<tr>
				<th>Sort</th>
				<th>Image</th>
				<th>Header</th>
				<th style="text-align: center;">Action</th>
			</tr>
		</thead>
		<tbody>
		{if $slides}
		{foreach from=$slides item=slide}
			<tr>
				<td>
					{if hasPermission("editSlider")}
						<a href="javascript:void(0)" onClick="Slider.move('up', {$slide.id}, this)" data-toggle="tooltip" data-placement="bottom" title="Move up"><i class="fas fa-chevron-circle-up"></i></a>
						<a href="javascript:void(0)" onClick="Slider.move('down', {$slide.id}, this)" data-toggle="tooltip" data-placement="bottom" title="Move down"><i class="fas fa-chevron-circle-down"></i></a>
					{/if}
				</td>
				<td><b>{$slide.image}</b></td>
				<td>{$slide.header}</td>
				<td style="text-align:center;">
					{if hasPermission("editSlider")}
					<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}admin/slider/edit/{$slide.id}">Edit</a>
					{/if}
					&nbsp;
					{if hasPermission("deleteSlider")}
					<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Slider.remove({$slide.id}, this)">Delete</a>
					{/if}
				</td>
			</tr>
		{/foreach}
		</tbody>
		</table>
		{/if}
	</div>
</div>