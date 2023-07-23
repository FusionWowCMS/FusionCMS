{*

<!-- later...
{if hasPermission("addPermissions")}
	<span>
		<a class="nice_button" href="javascript:void(0)" onClick="Roles.add()">Create role</a>
	</span>
{/if}
-->

*}

{strip}

<style type="text/css">
	#main_roles #roles_list .role-item-content.expanded {
		display: table-row !important;
	}
</style>

<script type="text/javascript">
	$(document.body).on('mouseenter', '.role-item', function() {
		$(this).next().addClass('expanded');
	}).on('mouseleave', '.role-item', function() {
		$(this).next().removeClass('expanded');
	});

	$(document.body).on('mouseenter', '.role-item-content', function() {
		$(this).addClass('expanded');
	}).on('mouseleave', '.role-item-content', function() {
		$(this).removeClass('expanded');
	})
</script>

{/strip}

<section id="main_roles" class="section section-main_roles" main_roles>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table id="roles_list" class="table table-hover table-striped-columns">
						<tbody>
							{foreach from=$modules key=name item=module}
								{if $module.db || $module.manifest}
									{if $module.db}
										{foreach from=$module.db item=role}
											<tr class="role-item">
												<td width="30%">{$role.name}</td>
												<td width="30%">{ucfirst($module.name)}</td>
												<td width="30%">Custom role</td>
												<td width="9%" class="text-end">
													{if hasPermission('editPermissions')}<a href="{$url}admin/aclmanager/editRole/{$role.id}" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fa-solid fa-pen"></i></a>&nbsp;{/if}
													{if hasPermission('deletePermissions')}<a href="javascript:void(0)" onClick="Roles.remove({$role.id}, this)" data-bs-toggle="tooltip" data-bs-title="Delete"><i class="fa-solid fa-minus"></i></a>{/if}
												</td>
												<td width="1%" class="text-end"><i class="fa-solid fa-arrow-down-long"></i></td>
											</tr>

											<tr class="role-item-content table-active" style="display: none;">
												<td colspan="5">
													<div class="role-desc">{$role.description}</div>
													{foreach from=$role.permissions key=name item=value}
														<div class="role-perm"><img src="{$url}application/images/icons/{($value) ? 'accept' : 'exclamation'}.png" /> {$name}</div>
													{/foreach}
												</td>
											</tr>
										{/foreach}
									{/if}

									{if $module.manifest}
										{foreach from=$module.manifest key=roleName item=role}
											<tr class="role-item">
												<td width="30%">{$roleName}</td>
												<td width="30%">{ucfirst($module.name)}</td>
												<td width="30%">Module-provided role <i class="fa fa-info-circle" data-bs-toggle="tooltip" data-bs-title="Module-provided roles can not be changed"></i></td>
												<td width="9%" class="text-end">&nbsp;</td>
												<td width="1%" class="text-end"><i class="fa-solid fa-arrow-down-long"></i></td>
											</tr>

											<tr class="role-item-content table-active" style="display: none;">
												<td colspan="5">
													<div class="role-desc">{$role.description}</div>
													{foreach from=$role.permissions key=name item=value}
														<div class="role-perm"><img src="{$url}application/images/icons/{($value) ? 'accept' : 'exclamation'}.png" /> {$name}</div>
													{/foreach}
												</td>
											</tr>
										{/foreach}
									{/if}
								{/if}
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

{*

<!-- later...
<section class="box big" id="add_roles" style="display:none;">
	<h2><a href='javascript:void(0)' onClick="Roles.add()" data-tip="Return to roles">Roles</a> &rarr; New role</h2>

	<form onSubmit="Roles.create(this); return false" id="submit_form">

		<label for="name">Role name</label>
		<input type="text" name="name" id="name"/>

		<label for="description">Description (optional)</label>
		<input type="text" name="description" id="description"/>

		<input type="submit" value="Submit role" />
	</form>
</section>
-->

*}
