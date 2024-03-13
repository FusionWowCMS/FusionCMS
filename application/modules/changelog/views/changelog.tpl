<div class="row">
{if hasPermission("canAddChange")}
<div class="col-lg-3 mb-3">
	{if hasPermission("canAddChange")}
		<a href="javascript:void(0)" onClick="$('#category_form').hide();$('#change_form').fadeToggle(150)" class="btn-sm nice_button">{lang("new_change", "changelog")}</a>
	{/if}
	
	{if hasPermission("canAddCategory")}
		<a href="javascript:void(0)" onClick="$('#change_form').hide();$('#category_form').fadeToggle(150)" class="btn-sm nice_button">{lang("new_category", "changelog")}</a>
	{/if}
</div>
<div class="col-lg-9">
	<div id="changelog_add">
		{if hasPermission("canAddChange")}
		<form id="change_form" onSubmit="Changelog.addChange(); return false" style="display:none;">
		<div class="row">
			{if !count(array($categories))}
				Please add a category first
			{else}
			<div class="col-md-3">
			<select name="category" id="changelog_types">
				{if $categories}
					{foreach from=$categories item=category}
						<option value="{$category.id}">{$category.typeName}</option>
					{/foreach}
				{/if}
			</select>
			</div>
			
			<div class="col-md-7">
				<input class="form-control" type="text" placeholder="{lang("change_info", "changelog")}" id="change_text" name="change">
			</div>
			
			<div class="col-md-2">
				<input class="btn-sm nice_button" type="submit" value="{lang("add", "changelog")}"/>
			</div>
		{/if}
		</div>
		</form>
		{/if}

		{if hasPermission("canAddCategory")}		
			{form_open('changelog/addCategory', $attributes)}
			<div class="row">
				<div class="col-md-10">
					<input class="form-control" type="text" placeholder="{lang("category_name", "changelog")}" name="category">
				</div>
				<div class="col-md-2">
					<input class="btn-sm nice_button" type="submit" value="{lang("add", "changelog")}"/>
				</div>
			</div>
			</form>
		{/if}
	</div>
</div>
{/if}

{if $changes}
<div id="changelog">
<section class="section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-9">
                   <div class="p-4 shadow rounded">
					{foreach from=$changes key=k item=change_time}
					<h5>{lang("changes_made_on", "changelog")} {$k}</h5>
						<ul class="list-unstyled">
						{foreach from=$change_time key=k_type item=change_type}
							{foreach from=$change_type item=change}
								<li class="text-muted my-2 ms-3">{if hasPermission("canRemoveChange")}<a href="{$url}changelog/remove/{$change.change_id}"><i class="fa-duotone fa-trash"></i></a>{/if}
								<i class="fa-duotone fa-circle-arrow-right"></i> <span class="fw-bold">{htmlspecialchars($k_type)}</span>: {htmlspecialchars($change.changelog)}</li>
							{/foreach}
						{/foreach}
						</ul>
					{/foreach}
					</div>
				</div>
			</div>
		</div>
		{else}
			<div id="changelog">
				<center style="padding:10px;">{lang("no_changes", "changelog")}</center>
			</div>
		{/if}
</section>
</div>