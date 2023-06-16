<div class="row">
<div class="col-lg-3">
<div class="row">
{if $tickets}
	{foreach from=$tickets item=realm key=key}
		<div class="col-12 mb-3">
			<div class="card-body bg-quaternary">
				<div class="widget-summary">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon">
							<img src="{$url}application/images/emulator/{$realm.emulator}.png" style="width: 90px;"></img>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">{$realm.realmName}</h4>
							<div class="info">
								<strong class="amount"><span class="counter" data-from="0" data-to="{count((array)$realm.tickets)}"></span> tickets</strong>
							</div>
						</div>
						<div class="summary-footer">
							<a href="{$url}mod/tickets" class="text-uppercase">(view all)</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	{/foreach}
{/if}
</div>
</div>

<div class="col-lg-9 mb-3">
<div class="col">
	<section class="card">
		<header class="card-header">
			<div class="card-actions">
				<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
				<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
			</div>
			<h2 class="card-title">Latest Moderator Actions</h2>
		</header>
        <div class="card-body table-responsive">
			<table class="table table-bordered table-striped mb-0 dataTable no-footer" id="modlogs">
			<thead>
				<tr role="row">
					<th>Action</th>
					<th>Acc/Char</th>
					<th>Mod</th>
					<th>IP</th>
					<th>Time</th>
				</tr>
			</thead>
			<tbody>
				{if $modlogs}
					{foreach from=$modlogs item=log}
						<tr role="row">
							<td>{$log.action}</td>
							<td>
							{if $log.isAcc}
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="View profile" href="{$url}profile/{$log.affected}" target="_blank">{$CI->user->getUsername($log.affected)}</a>
							{else}
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="View character" href="{$url}character/{$log.realm}/{$log.affected}" target="_blank">{$log.charName}</a>
							{/if}
							</td>
							<td><a data-bs-toggle="tooltip" data-bs-placement="top" title="View profile" href="{$url}profile/{$log.mod}" target="_blank">{$CI->user->getUsername($log.mod)}</a></td>
							<td>{$log.ip}</td>
							<td>{date("Y-m-d H:i:s", $log.time)}</td>
						</tr>
					{/foreach}
				{/if}
			<tbody>
			</table>
        </div>
    </section>
</div>
</div>

</div>
</div>

<script>
$(document).ready(function() {
    $('#modlogs').DataTable({
		"order": [[4, "desc"]]
	});
} );
</script>
<script type="text/javascript">
  $('.counter').countTo({
	refreshInterval: 50,
  });
</script>