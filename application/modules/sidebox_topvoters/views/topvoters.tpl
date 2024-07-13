<script type="text/javascript">document.querySelector('#topvoters-css') || document.head.appendChild(Object.assign(document.createElement('link'), { id: 'topvoters-css', rel: 'stylesheet', type: 'text/css', href: '{$css}' }));</script>

<section class="sidebox-topvoters is-widget">
    <div glow=""></div>
    <div class="topvoters-row">
        <div class="topvoters-head">
            <h3 class="head-title">Top Voters</h3>
            <h4 class="head-desc">Resets Every Week!</h4>
        </div>
    </div>
    <div class="topvoters-row full-h">
        <div class="topvoters-body">
            {if $accounts}
                <table>
                    <tbody>
                    {foreach from=$accounts key=key item=account}
                        <tr>
                            <td class="col-1 text-left"><span class="acc-rank">{$key + 1}</span></td>
                            <td class="col-2 text-left"><a href="{$url}profile/{$account.user_id}" class="acc-name" data-tip="View profile" data-hasevent="1">{$account.nickname}</a></td>
                            <td class="col-3 text-right"><span class="acc-votes"><i>{$account.vote}</i> Votes</span>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            {else}
                <br/>
                There are no voters to display
                <br/>
                <br/>
            {/if}
        </div>
    </div>
    <div class="topvoters-row">
        <div class="topvoters-foot">
            <div class="foot-info">Vote for our server and get your points!</div>
        </div>
    </div>
</section>