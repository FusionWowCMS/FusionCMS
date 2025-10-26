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
        <div id="gm" class="col-lg-8 py-lg-5 pb-5 pb-lg-0 table-responsive">
            {foreach from=$realms item=realm}
                <div class="section-header"><span>{$realm.name}</span></div>
                <div class="section-body">
                    <div id="top_tools">
                        {if $realm.hasConsole && hasPermission("kick")}
                            <a href="javascript:void(0)" onClick="Gm.kick({$realm.id})" class="nice_button">
                                <img src="{$url}application/images/icons/door_out.png" alt="{lang("kick", "gm")}">
                                {lang("kick", "gm")}
                            </a>
                        {/if}

                        {if hasPermission("ban")}
                            <a href="javascript:void(0)" onClick="Gm.ban()" class="nice_button">
                                <img src="{$url}application/images/icons/cross.png" alt="{lang("ban", "gm")}">
                                {lang("ban", "gm")}
                            </a>
                        {/if}
                    </div>
                    {if $realm.tickets}
                        {foreach from=$realm.tickets item=ticket}
                            <div class="gm_ticket">
                                <div class="gm_ticket_info">
                                    <table class="nice_table">
                                        <tr>
                                            <td width="25%">{lang("ticket", "gm")}</td>
                                            <td width="20%">{lang("time", "gm")}</td>
                                            <td width="40%">{lang("message", "gm")}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>#{$ticket.ticketId} {lang("by", "gm")} <a href="{$url}character/{$realm.id}/{$ticket.guid}" target="_blank">{$ticket.name}</a></td>
                                            <td>{$ticket.ago}</td>
                                            <td>{$ticket.message_short}</td>
                                            <td style="text-align:right;"><a class="nice_button" onClick="Gm.view(this)" href="javascript:void(0)">{lang("view", "gm")}</a></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="gm_ticket_info_full">
                                    <table class="nice_table">
                                        <tr>
                                            <td width="25%">{lang("ticket", "gm")}</td>
                                            <td width="20%">{lang("time", "gm")}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>#{$ticket.ticketId} {lang("by", "gm")} <a href="{$url}character/{$realm.id}/{$ticket.guid}" target="_blank">{$ticket.name}</a></td>
                                            <td>{$ticket.ago}</td>
                                            <td style="text-align:right;"><a class="nice_button" onClick="Gm.hide(this)" href="javascript:void(0)">{lang("hide", "gm")}</a></td>
                                        </tr>
                                    </table>
                                    <div class="gm_ticket_text">{$ticket.message}</div>
                                </div>

                                <div class="gm_tools">
                                    {if hasPermission("answer")}
                                        <a href="javascript:void(0)" onClick="Gm.close({$realm.id}, {$ticket.ticketId}, this)" class="nice_button"><img src="{$url}application/images/icons/accept.png"> {lang("close", "gm")}</a>
                                        <a href="javascript:void(0)" onClick="Gm.answer({$realm.id}, {$ticket.ticketId}, this)" class="nice_button"><img src="{$url}application/images/icons/email.png"> {lang("answer", "gm")}</a>
                                    {/if}

                                    {if hasPermission("unstuck")}
                                        <a href="javascript:void(0)" onClick="Gm.unstuck({$realm.id}, {$ticket.ticketId}, this)" class="nice_button"><img src="{$url}application/images/icons/wand.png"> {lang("unstuck", "gm")}</a>
                                    {/if}

                                    {if hasPermission("sendItem")}
                                        <a href="javascript:void(0)" onClick="Gm.sendItem({$realm.id}, {$ticket.ticketId}, this)" class="nice_button"><img src="{$url}application/images/icons/lorry.png"> {lang("send_item", "gm")}</a>
                                    {/if}
                                </div>
                            </div>
                        {/foreach}
                    {else}
                        <div style="padding:20px;">{lang("no_tickets", "gm")}</div>
                    {/if}
                </div>
            {/foreach}
        </div>
    </div>
</div>