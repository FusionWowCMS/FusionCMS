<section class="card" id="main_groups">
	<div class="card-header">
		Groups (<div style="display:inline;" id="groups_count">{if !$groups}0{else}{count($groups)}{/if}</div>){if hasPermission("addPermissions")}<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Groups.add()">Create group</a>{/if}
	</div>

	<div class="card-body">
		{if $groups}
		<table class="table table-responsive-md table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>ID</th>
				<th>Members</th>
				<th style="text-align: center;">Action</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$groups item=group}
				<tr>
					<td data-toggle="tooltip" data-placement="bottom" title="{$group.description}"><b style="color:{$group.color} !important;">{$group.name}</b></td>
					<td> {$group.id}</td>
					<td>{if $group.memberCount}{$group.memberCount} {($group.memberCount == 1) ? "member" : "members"}{/if}</td>
					<td style="text-align:center;">
						{if hasPermission("editPermissions")}
							<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}admin/aclmanager/editGroup/{$group.id}">Edit</a>&nbsp;
						{/if}

						{if hasPermission("deletePermissions")}
							{if !in_array($group.id, array($guestId, $playerId))}
							<a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Groups.remove({$group.id}, this)">Delete</a>
							{/if}
						{/if}
					</td>
				</tr>
			{/foreach}
		</tbody>
		</table>
		{/if}
	</div>
</section>

<section class="card" id="add_groups" style="display:none;">
	<div class="card-header">
	<a href='javascript:void(0)' onClick="Groups.add()" data-toggle="tooltip" data-placement="bottom" title="Return to groups">Groups</a> &rarr; New group
	</div>
	<div class="card-body">
	<form onSubmit="Groups.create(this); return false" id="submit_form">
	
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name">Group name</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="name" id="name"/>
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="description">Description (optional)</label>
		<div class="col-sm-10">
		<input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="description" id="description"/>
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="color">Group color (optional)</label>
		<div class="col-sm-10">
		<input type="color" name="color" id="color" value="#ffffff"/>
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="members">Members</label>
		<div class="col-sm-10">
		<span>
			<div class="memberList">
				Members can be added once the group has been created
			</div>
		</span>
		</div>
        </div>

		<label class="col-sm-3 col-form-label" for="roles">
			<a href="javascript:void(0)" onClick="$('#visibility input[type=checkbox]').each(function(){ this.checked = true; });" style="float:right;display:block;">[Select all]</a>
			Visibility permissions
		</label>

		<div id="visibility">
			{if $links}
				<div class="role_module">
					<h3>Menu links</h3>
					{foreach from=$links item=link}
						<table class="table table-responsive-md table-hover">
							{if $link.permission}
								<tr>
									<td width="5%" style="text-align:center;"><input type="checkbox" name="MENU_{$link.id}" id="MENU_{$link.id}"></td>
									<td width="25%">
										<span style="font-size:10px;padding:0px;display:inline;">{$link.side}&nbsp;&nbsp;</span>

										<label for="MENU_{$link.id}" style="	display:inline;border:none;font-weight:bold;">{langColumn($link.name)}</label></td>
									<td style="font-size:10px;">{$link.link}</td>
								</tr>
							{else}
								<tr style="opacity:0.6" data-toggle="tooltip" data-placement="bottom" title="This menu link is set to 'Visible to everyone'-mode.<br />If you want to control the visibility per group, please<br /> go to 'Menu links' and change the visibility mode.">
									<td width="5%" style="text-align:center;"><input type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<span style="font-size:10px;padding:0px;display:inline;">{$link.side}&nbsp;&nbsp;</span>

										<label style="	display:inline;border:none;font-weight:bold;">{langColumn($link.name)}</label></td>
									<td style="font-size:10px;">{$link.link}</td>
								</tr>
							{/if}		
						</table>
					{/foreach}
				</div>
			{/if}

			{if $pages}
				<div class="role_module">
					<h3>Custom pages</h3>
					{foreach from=$pages item=page}
						<table class="table table-responsive-md table-hover">
							{if $page.permission}
								<tr>
									<td width="5%" style="text-align:center;"><input type="checkbox" name="PAGE_{$page.id}" id="PAGE_{$page.id}"></td>
									<td width="25%">
										<label for="PAGE_{$page.id}" style="display:inline;border:none;font-weight:bold;">{langColumn($page.name)}</label></td>
									<td style="font-size:10px;">pages/{$page.identifier}</td>
								</tr>
							{else}
								<tr style="opacity:0.6" data-toggle="tooltip" data-placement="bottom" title="This page is set to 'Visible to everyone'-mode.<br />If you want to control the visibility per group, please<br /> go to 'Custom pages' and change the visibility mode.">
									<td width="5%" style="text-align:center;"><input type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="PAGE_{$page.id}" style="display:inline;border:none;font-weight:bold;">{langColumn($page.name)}</label></td>
									<td style="font-size:10px;">pages/{$page.identifier}</td>
								</tr>
							{/if}		
						</table>
					{/foreach}
				</div>
			{/if}

			{if $sideboxes}
				<div class="role_module">
					<h3>Sideboxes</h3>
					{foreach from=$sideboxes item=sidebox}
						<table class="table table-responsive-md table-hover">
							{if $sidebox.permission}
								<tr>
									<td width="5%" style="text-align:center;"><input type="checkbox" name="SIDEBOX_{$sidebox.id}" id="SIDEBOX_{$sidebox.id}"></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}" style="display:inline;border:none;font-weight:bold;">{langColumn($sidebox.displayName)}</label></td>
									<td style="font-size:10px;">{$sidebox.type}</td>
								</tr>
							{else}
								<tr style="opacity:0.6" data-toggle="tooltip" data-placement="bottom" title="This sidebox is set to 'Visible to everyone'-mode.<br />If you want to control the visibility per group, please<br /> go to 'Sideboxes' and change the visibility mode.">
									<td width="5%" style="text-align:center;"><input type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}" style="display:inline;border:none;font-weight:bold;">{langColumn($sidebox.displayName)}</label></td>
									<td style="font-size:10px;">{$sidebox.type}</td>
								</tr>
							{/if}		
						</table>
					{/foreach}
				</div>
			{/if}
		</div>

		<label for="roles" data-toggle="tooltip" data-placement="bottom" title="A role is a pre-defined set of permissions. The color indicates the role's danger-level. Please note that certain permissions may have a default value of 'allowed', such as actions that are meant to be performed by everyone by default.">
			<a href="javascript:void(0)" onClick="$('#roles input[type=checkbox]').each(function(){ this.checked = true; });" style="float:right;display:block;">[Select all]</a>
			Roles <a>(?)</a>
		</label>
		
		<div id="roles">
			{foreach from=$modules key=name item=module}
				{if $module.db || $module.manifest}
					<div class="role_module">
						<h3>{ucfirst($module.name)}</h3>
						<table class="table table-responsive-md table-hover">
							{if $module.db}
								{foreach from=$module.db item=role}
									<tr>
										<td width="5%" style="text-align:center;"><input type="checkbox" name="{$name}-{$role.name}" id="{$name}-{$role.name}"></td>
										<td width="25%">Custom role: <label for="{$name}-{$role.name}" style="display:inline;border:none;font-weight:bold;">{$role.name}</label></td>
										<td style="font-size:10px;">{$role.description}</td>
									</tr>
								{/foreach}
							{/if}
							
							{if $module.manifest}
								{foreach from=$module.manifest key=roleName item=role}
									<tr>
										<td width="5%" style="text-align:center;"><input type="checkbox" name="{$name}-{$roleName}" id="{$name}-{$roleName}"></td>
										<td width="25%"><label for="{$name}-{$roleName}" style="display:inline;border:none;font-weight:bold;{if isset($role.color)}color:{$role.color};{/if}">{$roleName}</label></td>
										<td style="font-size:10px;">{$role.description}</td>
									</tr>
								{/foreach}
							{/if}
						</table>
					</div>
				{/if}
			{/foreach}
		</div>

		<button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">Submit group</button>
	</form>
	</div>
</div>