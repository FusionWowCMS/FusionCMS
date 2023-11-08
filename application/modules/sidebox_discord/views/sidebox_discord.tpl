<script type="text/javascript">
    const discord_css_link = document.createElement('link');

    discord_css_link.rel  = 'stylesheet';
    discord_css_link.type = 'text/css';
    discord_css_link.href = '{$url}application/modules/{$module}/css/discord.css';

    document.getElementsByTagName('head')[0].appendChild(discord_css_link);
</script>
<div class="widget-discord">
    {if $style == 1}
        <a href="{$invite_link}"><img src="https://discord.com/api/guilds/{$server_id}/widget.png?style=banner1" alt="Discord"/></a>
    {elseif $style == 2}
        <a href="{$invite_link}"><img src="https://discord.com/api/guilds/{$server_id}/widget.png?style=banner2" alt="Discord"/></a>
    {elseif $style == 3}
        <a href="{$invite_link}"><img src="https://discord.com/api/guilds/{$server_id}/widget.png?style=banner3" alt="Discord"/></a>
    {elseif $style == 4}
        <a href="{$invite_link}"><img src="https://discord.com/api/guilds/{$server_id}/widget.png?style=banner4" alt="Discord"/></a>
    {else}
        <iframe src="https://discord.com/widget?id={$server_id}&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
    {/if}
</div>