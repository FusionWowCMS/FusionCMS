{if !$logs }
<p>Nothing was logged. If you were expecting logged items, ensure that LoggerConfig file has the correct threshold set.</p>
{else}
<table>
    <thead>
        <tr>
            <th>Severity</th>
            <th>Message</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$logs item=item}
        <tr>
            <td>{$item.level}</td>
            <td>{$item.msg}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
{/if}
