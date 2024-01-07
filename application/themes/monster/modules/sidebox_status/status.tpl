{foreach from=$realms item=realm}
<div class="realms-status">
    <div class="a-realm">
    <div id="head" class="clearfix text-shadow">
        <p id="name">{$realm->getName()}</p>
		{if $realm->isOnline()}
				<p id="info">Online</p>
			{else}
				<p id="info">Offline</p>
			{/if}
    </div>
    <div id="body" class="clearfix text-shadow">
	{if $realm->isOnline()}
		<p id="online"><font color="#d28010">{$realm->getOnline()}</font> Players Online</p>
		{else}
		<p id="online"><font color="#d28010">0</font> Players Online</p>
		<p id="uptime"><font color="#5b5851">0d&nbsp;0h&nbsp;0m&nbsp;</font> Uptime</p>
	{/if}
     </div>
</div>
</div>
{/foreach}