<section class="card">
	<header class="card-header">
		<h2 class="card-title font-heading font-light text-muted-800 dark:text-white md:block">Accounts</h2>
	</header>
	<div class="card-body">
		<table class="table table-bordered table-striped" id="acclist">
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>EMail</th>
					<th>Join date</th>
					<th>Expansion</th>
                    <th>Action</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</section>

<script>
$(document).ready(function() {
    var table = $('#acclist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{$url}admin/accounts/get_accs_ajax",
            "type": "POST",
            "data": function(d) {
                d.csrf_token_name = Config.CSRF,
                d.search = $('input[type="search"]').val();
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "username" },
            { "data": "email" },
            { "data": "joindate" },
            { "data": "expansion" },
            { "data": null, "render": function(data, type, row, meta) {
                return '<a href="{$url}admin/accounts/get/' + row.id + '">View</a>';
            }}
        ]
    });

    $('input[type="search"]').on('keyup', function() {
        table.search(this.value).draw();
    });

	$('input[type="search"]').addClass('form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 h-10 text-sm leading-5 rounded-xl !bg-muted-100 dark:!bg-muted-700 focus:!bg-white dark:focus:!bg-muted-900 mb-3');
});
</script>
