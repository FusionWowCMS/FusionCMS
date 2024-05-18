<table>
    <thead>
        <tr>
            <th class="debug-bar-width6r">Time</th>
            <th>Query String</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$queries item=item}
        <tr class="{$item.class}" title="{$item.hover}" data-toggle="{$item.qid}-trace">
            <td class="narrow">{$item.duration}</td>
            <td>{$item.sql}</td>
            <td class="debug-bar-alignRight"><strong>{$item.trace_file}</strong></td>
        </tr>
        <tr class="muted debug-bar-ndisplay" id="{$item.qid}-trace">
            <td></td>
            <td colspan="2">
            {foreach from=$item.trace item=tra}
                {$tra.index}<strong>{$tra.file}</strong><br/>
                {$tra.function}<br/><br/>
            {/foreach}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>
