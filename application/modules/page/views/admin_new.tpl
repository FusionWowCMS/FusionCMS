{TinyMCE()}
<div class="card">
  <header class="card-header">
    New Page<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="{$url}page/admin">Back</a>
  </header>

	<div class="card-body">
	<form role="form" onSubmit="Pages.send(); return false">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="headline" id="languages">Headline</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="headline" />
		</div>
		</div>
			
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="identifier">Unique link identifier (as in mywebsite.com/page/<b>mypage</b>)</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="identifier" placeholder="mypage" />
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="visibility">Visibility mode</label>
		<div class="col-sm-10">
		<select class="form-control" name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
			<option value="everyone" selected>Visible to everyone</option>
			<option value="group">Controlled per group</option>
		</select>

		<div id="groups" style="display:none;">
			Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a> once you have created the page
		</div>
		</div>
		</div>
	</form>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="pages_content">Content</label>
		<div class="col-sm-10">
			<textarea name="pages_content" class="form-control tinymce" id="pages_content" cols="30" rows="10"></textarea>
		</div>
		</div>

		<form role="form" onSubmit="Pages.send(); return false">
			<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Submit page</button>
		</form>
	</div>
</div>

<script>
	require([Config.URL + "application/themes/admin/assets/js/mli.js"], function()
	{
		new MultiLanguageInput($("#headline"));
	});
</script>