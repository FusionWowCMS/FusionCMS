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
            <div class="section-header"><span>{lang("banned_ip_list", "gm")}</span></div>
            <div id="top_tools">
                {if hasPermission("ban")}
                    <a href="javascript:void(0)" onClick="Gm.banIP()" class="nice_button">
                        <img src="{$url}application/images/icons/cross.png">
                        {lang("ban_ip", "gm")}
                    </a>
                {/if}
            </div>
            {if $ipsBanned}
                <table class="table table-bordered table-striped mb-0 dataTable no-footer nice_table">
                    <thead>
                        <tr>
                            <th>{lang("ip", "gm")}</th>
                            <th>{lang("banned_at", "gm")}</th>
                            <th>{lang("unbanned_at", "gm")}</th>
                            <th>{lang("ban_reason", "gm")}</th>
                            <th>{lang("banned_by", "gm")}</th>
                            <th>{lang("action", "gm")}</th>
                        </tr>
                    </thead>

                    <tbody>
                        {if $ipsBanned}
                            {foreach from=$ipsBanned item=ip}
                                <tr role="row">
                                    <td>{$ip.ip}</td>
                                    <td>{date("Y/m/d H:i:s", $ip.bandate)}</td>
                                    <td>{date("Y/m/d H:i:s", $ip.unbandate)}</td>
                                    <td>{$ip.banreason}</td>
                                    <td>{$ip.bannedby}</td>
                                    <td class="text-center"><a data-bs-toggle="tooltip" data-bs-placement="top" title="Unban" href="javascript:void(0)" onClick="Gm.unbanIp('{$ip.ip}')" ><i class="fa-solid fa-lock-open"></i></a></td>
                                </tr>
                            {/foreach}
                        {/if}
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