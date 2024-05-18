<table>
    <thead>
    <tr>
        <th>Action</th>
        <th>Datetime</th>
        <th>Status</th>
        <th>Method</th>
        <th>URL</th>
        <th>Content-Type</th>
        <th>Is AJAX?</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$files item=item}
        <tr data-active="{$item.active}">
            <td class="debug-bar-width70p">
                <button class="ci-history-load" data-time="{$item.time}">Load</button>
            </td>
            <td class="debug-bar-width190p">{$item.datetime}</td>
            <td>{$item.status}</td>
            <td>{$item.method}</td>
            <td>{$item.url}</td>
            <td>{$item.contentType}</td>
            <td>{$item.isAJAX}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
