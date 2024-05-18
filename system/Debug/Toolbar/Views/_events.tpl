<table>
    <thead>
        <tr>
            <th class="debug-bar-width6r">Time</th>
            <th>Event Name</th>
            <th>Times Called</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$events item=item}
        <tr>
            <td class="narrow">{$item.duration} ms</td>
            <td>{$item.event}</td>
            <td>{$item.count}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
