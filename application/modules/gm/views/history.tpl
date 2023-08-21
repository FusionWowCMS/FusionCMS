<div class="container">
    <div class="row">
        <div class="col-lg-4 py-5 pe-lg-5">
            <div class="section-header"><span>{lang("gm_panel", "gm")}</span></div>
            <div class="section-body">
                <div class="list-group mt-3">
                    <a href="{$url}gm" class="list-group-item list-group-item-action  {if $link_active == 'gm'}active{/if}">{lang("ticket_list", "gm")}</a>
                    {if hasPermission("ban")}<a href="{$url}gm/account_banned" class="list-group-item list-group-item-action  {if $link_active == 'account_banned'}active{/if}">{lang("banned_account_list", "gm")}</a>{/if}
                    {if hasPermission("ban")}<a href="{$url}gm/ip_banned" class="list-group-item list-group-item-action  {if $link_active == 'ip_banned'}active{/if}">{lang("banned_ip_list", "gm")}</a>{/if}
                    {if hasPermission("ban")}<a href="{$url}gm/history" class="list-group-item list-group-item-action  {if $link_active == 'history'}active{/if}">{lang("history_list", "gm")}</a>{/if}
                </div>
            </div>
        </div>
        <div class="col-lg-8 py-lg-5 pb-5 pb-lg-0 table-responsive">
            <div class="section-header"><span>{lang("history_list", "gm")}</span></div>
            {if $gmLogs}
                <table class="table table-bordered table-striped mb-0 dataTable no-footer nice_table">
                    <thead>
                        <tr>
                            <th>{lang("action", "gm")}</th>
                            <th>{lang("type", "gm")}</th>
                            <th>{lang("affected", "gm")}</th>
                            <th>{lang("gm", "gm")}</th>
                            <th>{lang("ip", "gm")}</th>
                            <th>{lang("time", "gm")}</th>
                        </tr>
                    </thead>

                    <tbody>
                        {foreach from=$gmLogs item=log}
                            <tr role="row">
                                <td>{$log.action}</td>
                                <td>
                                    {$log.type}
                                </td>
                                <td>
                                    {if $log.type == 'account'}
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="View profile" href="{$url}profile/{$log.affected}" target="_blank">{$CI->user->getUsername($log.affected)}</a>
                                    {elseif $log.type == 'characters'}
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="View character" href="{$url}character/{$log.realm}/{$log.affected}" target="_blank">{$log.charName}</a>
                                    {else}
                                        {$log.affected}
                                    {/if}
                                </td>
                                <td><a data-bs-toggle="tooltip" data-bs-placement="top" title="View profile" href="{$url}profile/{$log.gm_id}" target="_blank">{$CI->user->getUsername($log.gm_id)}</a></td>
                                <td>{$log.ip}</td>
                                <td>{date("Y-m-d H:i:s", $log.time)}</td>
                            </tr>
                        {/foreach}
                    <tbody>
                </table>
            {else}
                <div style="padding:20px;">{lang("no_data", "gm")}</div>
            {/if}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.nice_table').DataTable();
    } );
</script>