<div class="card">
<div class="card-header">
    Sideboxes(<div style="display:inline;" id="sidebox_count">{if !$sideboxes}0{else}{count($sideboxes)}{/if}</div>)
	{if hasPermission("addSideboxes")}<a class="btn btn-primary btn-sm pull-right" href="{$url}admin/sidebox/new">Create Sidebox</a>{/if}
</div>
<div class="card-body">
<table class="table table-responsive-md table-hover mb-0">
	<thead>
		<tr>
			<th>Order</th>
			<th>Name</th>
			<th>Sidebox</th>
			<th>Visibility</th>
			<th>Location</th>
			<th scope="col" style="text-align:center;">Actions</th>
		</tr>
	</thead>
	<tbody>
		{if $sideboxes}
		{foreach from=$sideboxes item=sidebox}
			<tr>
				<td>
					<a href="javascript:void(0)" onClick="Sidebox.move('up', {$sidebox.id}, this)" data-bs-toggle="tooltip" data-placement="bottom" title="Move up"><i class="fas fa-chevron-circle-up"></i></a>
					<a href="javascript:void(0)" onClick="Sidebox.move('down', {$sidebox.id}, this)" data-bs-toggle="tooltip" data-placement="bottom" title="Move down"><i class="fas fa-chevron-circle-down"></i></a></td>
				<td><b>{langColumn($sidebox.displayName)}</b></td>
				<td>{$sidebox.name}</td>
				<td>{if $sidebox.permission}Controlled per group{else}Visible to everyone{/if}</td>
				<td>{$sidebox.location}</td>
				<td style="text-align:center;">
					<a href="{$url}admin/sidebox/edit/{$sidebox.id}"><button type="button" class="btn btn-primary btn-sm">Edit</button></a>&nbsp;
					<a href="javascript:void(0)" onClick="Sidebox.remove({$sidebox.id}, this)"><button type="button" class="btn btn-primary btn-sm">Remove</button></a>
				</td>
			</tr>
		{/foreach}
		{/if}
	</tbody>
</table>
</div>
</div>