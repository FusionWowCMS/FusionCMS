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
            <div class="section-header"><span>{lang("banned_account_list_active", "gm")}</span></div>
            <div id="top_tools">
                {if hasPermission("ban")}
                    <a href="javascript:void(0)" onClick="Gm.ban()" class="nice_button">
                        <img src="{$url}application/images/icons/cross.png" alt="{lang("ban", "gm")}">
                        {lang("ban", "gm")}
                    </a>
                {/if}
            </div>
            {if $accountsBanActive}
                <table class="table table-bordered table-striped mb-0 dataTable no-footer nice_table">
                    <thead>
                        <tr>
                            <th>{lang("account", "gm")}</th>
                            <th>{lang("banned_at", "gm")}</th>
                            <th>{lang("unbanned_at", "gm")}</th>
                            <th>{lang("ban_reason", "gm")}</th>
                            <th>{lang("banned_by", "gm")}</th>
                            <th>{lang("action", "gm")}</th>
                        </tr>
                    </thead>

                    <tbody>
                        {if $accountsBanActive}
                            {foreach from=$accountsBanActive item=account}
                                <tr role="row">
                                    <td><a data-bs-toggle="tooltip" data-bs-placement="top" title="View profile" href="{$url}profile/{$account.id}" target="_blank">{$CI->user->getUsername($account.id)} ({$account.id})</a></td>
                                    <td>{date("Y/m/d H:i:s", $account.bandate)}</td>
                                    <td>{date("Y/m/d H:i:s", $account.unbandate)}</td>
                                    <td>{$account.banreason}</td>
                                    <td>{$account.bannedby}</td>
                                    <td class="text-center"><a data-bs-toggle="tooltip" data-bs-placement="top" title="Unban" href="javascript:void(0)" onClick="Gm.unbanAcc({$account.id}, this)" ><i class="fa-solid fa-lock-open"></i></a></td>
                                </tr>
                            {/foreach}
                        {/if}
                    <tbody>
                </table>
            {else}
                <div style="padding:20px;">{lang("no_data", "gm")}</div>
            {/if}
            <div class="section-header mt-5"><span>{lang("banned_account_list_expired", "gm")}</span></div>
            {if $accountsBanActive}
                <table class="table table-bordered table-striped mb-0 dataTable no-footer nice_table">
                    <thead>
                    <tr>
                        <th>{lang("account", "gm")}</th>
                        <th>{lang("banned_at", "gm")}</th>
                        <th>{lang("unbanned_at", "gm")}</th>
                        <th>{lang("banned_by", "gm")}</th>
                        <th>{lang("ban_reason", "gm")}</th>
                    </tr>
                    </thead>

                    <tbody>
                    {if $accountsBanExpired}
                        {foreach from=$accountsBanExpired item=account}
                            <tr role="row">
                                <td><a data-bs-toggle="tooltip" data-bs-placement="top" title="View profile" href="{$url}profile/{$account.id}" target="_blank">{$CI->user->getUsername($account.id)} ({$account.id})</a></td>
                                <td>{date("Y/m/d H:i:s", $account.bandate)}</td>
                                <td>{date("Y/m/d H:i:s", $account.unbandate)}</td>
                                <td>{$account.bannedby}</td>
                                <td>{$account.banreason}</td>
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