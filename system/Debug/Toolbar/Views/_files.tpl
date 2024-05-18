<table>
    <tbody>
    {foreach from=$userFiles item=item}
        <tr>
            <td>{$item.name}</td>
            <td>{$item.path}</td>
        </tr>
    {/foreach}
    {foreach from=$coreFiles item=item}
        <tr class="muted">
            <td class="debug-bar-width20e">{$item.name}</td>
            <td>{$item.path}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
