{foreach from=$realmstatus item=realm}
	<li style="margin-top:4px;">{$realm->getName()}</li> {if $realm->isOnline()}<li class="blob green" style="margin-top:4px;"></li>{else}<li class="blob red" style="margin-top:4px;"></li>{/if}
{/foreach}