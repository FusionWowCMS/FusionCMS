<style>
.list-group-item {
	background-color: #171717;
	color: #abb4be;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <div class="list-group">
				{if $logs}
					{foreach from=$files item=file}
                        <a href="?f={base64_encode($file)}" class="list-group-item {if $currentFile == $file}active{/if}">
                           {$file}
                        </a>
                    {/foreach}
				{else}
					<a class="list-group-item active">No Log Files Found</a>
                {/if}
            </div>
        </div>
        <div class="col-sm-9 col-md-10 table-container">
            <table id="table-log" class="table table-striped">
                <thead>
                <tr>
                    <th>Level</th>
                    <th>Date</th>
                    <th>Content</th>
                </tr>
                </thead>
                <tbody>
				{foreach from=$logs key=key item=log}
                    <tr data-display="stack{$key}">
                        <td class="text-{$log.class}">
                            <i class="{$log.icon}" aria-hidden="true"></i>
                            &nbsp;{$log.level}
                        </td>
                        <td class="date">{$log.date}</td>
                        <td class="text">
                            {if array_key_exists('extra', $log)}
                                <a class="pull-right expand btn btn-default btn-xs" data-display="stack{$key}">
                                    <i class="fa-duotone fa-magnifying-glass"></i>
                                </a>
                            {/if}
								{$log.content}
                            {if array_key_exists('extra', $log)}
                                <div class="stack" id="stack{$key}" style="display: none; white-space: pre-wrap;">
                                    {$log.extra}
                                </div>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('.table-container tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });

        $('#table-log').DataTable({
            "order": [],
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("datatable"));
                if (data) data.start = 0;
                return data;
            }
        });
        $('#delete-log, #delete-all-log').click(function () {
            return confirm('Are you sure?');
        });

        $('input[type="search"]').addClass('form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 h-10 text-sm leading-5 rounded-xl !bg-muted-100 dark:!bg-muted-700 focus:!bg-white dark:focus:!bg-muted-900 mb-3');
    });
</script>