<div id="pm_controls" class="d-flex justify-content-between mb-3">
    <div id="pm_controls_right" class="d-flex">
        {if hasPermission("compose")}
            <a href="{$url}messages/create" class="nice_button me-2">{lang("compose_message", "messages")}</a>
        {/if}
        <a href="javascript:void(0)" onClick="Messages.clearInbox()" class="nice_button" id="pm_empty">{lang("empty_inbox", "messages")}</a>
    </div>

    <div>
        <a href="javascript:void(0)" onClick="Messages.showTab('inbox', this)" class="nice_button {if !$is_sent}nice_active{/if}">{lang("inbox", "messages")} ({$inbox_count})</a>
        <a href="javascript:void(0)" onClick="Messages.showTab('sent', this)" class="nice_button {if $is_sent}nice_active{/if}">{lang("sent_messages", "messages")} ({$sent_count})</a>
    </div>
</div>
<hr class="ucp_divider">

<div id="pm_inbox" class="pm_spot" {if $is_sent}style="display:none;"{/if}>
    {if $messages}
        <table class="table table-striped nice_table">
            <thead>
            <tr>
                <th width="18%">{lang("sender", "messages")}</th>
                <th>{lang("message_title", "messages")}</th>
                <th width="18%" class="text-center">{lang("date", "messages")}</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$messages item=message}
                <tr>
                    <td><a href="{$url}profile/{$message.sender_id}" data-tip="View profile">{$message.sender_name}</a></td>
                    <td><a href="{$url}messages/read/{$message.id}" data-tip="Read message" {if $message.read == 0}class="text-primary"{/if}>{$message.title}</a></td>
                    <td class="text-center">{date("Y-m-d", $message.time)}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        <div class="my-3"></div>
        {$pagination}
    {else}
        <div class="text-center py-3">{lang("no_messages", "messages")}.</div>
    {/if}
</div>

<div id="pm_sent" class="pm_spot" {if !$is_sent}style="display:none;"{/if}>
    {if $sent}
        <table class="table table-striped nice_table">
            <thead>
            <tr>
                <th width="18%">{lang("receiver", "messages")}</th>
                <th>{lang("message_title", "messages")}</th>
                <th width="18%" class="text-center">Date</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$sent item=message}
                <tr>
                    <td><a href="{$url}profile/{$message.user_id}" data-tip="View profile">{$message.receiver_name}</a></td>
                    <td><a href="{$url}messages/read/{$message.id}" data-tip="Read message">{$message.title}</a></td>
                    <td class="text-center">{date("Y-m-d", $message.time)}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        <div class="my-3"></div>
        {$sent_pagination}
    {else}
        <div class="text-center py-3">{lang("no_messages", "messages")}.</div>
    {/if}
</div>
