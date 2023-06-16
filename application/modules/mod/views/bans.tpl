<div class="row">

<div class="mb-3">
	<a href="javascript:void(0)" onClick="Mod.banAcc()" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">
		<img src="{$url}application/images/icons/cross.png" align="absmiddle">
		{lang("ban", "mod")}
	</a>
	<a href="javascript:void(0)" onClick="Mod.banIP()" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md">
		<img src="{$url}application/images/icons/cross.png" align="absmiddle">
		Ban an IP
	</a>
</div>

<div class="col-lg-6 mb-3">
<div class="col">
	<section class="card">
		<header class="card-header">
			<div class="card-actions">
				<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
				<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
			</div>
			<h2 class="card-title">Banned accs</h2>
		</header>
        <div class="card-body">
			<table class="table table-bordered table-striped mb-0 dataTable no-footer" id="activeBanList">
			<thead>
				<tr role="row">
					<th>Acc</th>
					<th>Banned at</th>
					<th>Unbanned at</th>
					<th>Reason</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				{if $activeBannedAccs}
					{foreach from=$activeBannedAccs item=a_accs}
						<tr role="row">
							<td><a data-bs-toggle="tooltip" data-bs-placement="top" title="View profile" href="{$url}profile/{$a_accs.id}" target="_blank">{$CI->user->getUsername($a_accs.id)} ({$a_accs.id})</a></td>
							<td>{date("Y/m/d H:i:s", $a_accs.bandate)}</td>
							<td>{date("Y/m/d H:i:s", $a_accs.unbandate)}</td>
							<td>{$a_accs.banreason}</td>
							<td class="text-center"><a data-bs-toggle="tooltip" data-bs-placement="top" title="Unban" href="javascript:void(0)" onClick="Mod.unbanAcc({$a_accs.id}, this)" ><i class="fa-solid fa-lock-open"></i></a></td>
						</tr>
					{/foreach}
				{/if}
			<tbody>
			</table>
        </div>
    </section>
</div>
</div>

<div class="col-lg-6 mb-3">
<div class="col">
	<section class="card">
		<header class="card-header">
			<div class="card-actions">
				<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
				<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
			</div>
			<h2 class="card-title">Expired bans</h2>
		</header>
        <div class="card-body">
			<table class="table table-bordered table-striped mb-0 dataTable no-footer" id="ExpiredBanList">
			<thead>
				<tr role="row">
					<th>Acc</th>
					<th>Banned at</th>
					<th>Unbanned at</th>
					<th>Reason</th>
				</tr>
			</thead>
			<tbody>
				{if $expiredBannedAccs}
					{foreach from=$expiredBannedAccs item=e_accs}
						<tr role="row">
							<td><a data-bs-toggle="tooltip" data-bs-placement="top" title="View profile" href="{$url}profile/{$e_accs.id}" target="_blank">{$CI->user->getUsername($e_accs.id)} ({$e_accs.id})</a></td>
							<td>{date("Y/m/d H:i:s", $e_accs.bandate)}</td>
							<td>{date("Y/m/d H:i:s", $e_accs.unbandate)}</td>
							<td>{$e_accs.banreason}</td>
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

<script>
$(document).ready(function() {
    $('#activeBanList').DataTable();
    $('#ExpiredBanList').DataTable();
} );
</script>

