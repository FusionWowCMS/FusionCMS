<link rel="stylesheet" href="{$url}application/views/old/modules/teleport/css/teleport.css" type="text/css" />
<script type="text/javascript">
	$(document).ready(function()
	{
		function initializeTeleport()
		{
			if(typeof Teleport != "undefined")
			{
				Teleport.User.initialize({$vp}, {$dp});
			}
			else
			{
				setTimeout(initializeTeleport, 50);
			}
		}

		initializeTeleport();
	});
</script>
<form id="teleport">
	<section id="select_character">
		<div class="online_realm_button">{lang("select_char", "teleport")}</div>

		{if $total}
			{foreach from=$characters item=realm}
				<div class="teleport_realm_divider">{$realm.realmName}</div>
				{foreach from=$realm.characters item=character}
					<div class="select_character">
						<div class="character store_item">
							<section class="character_buttons">
								<a href="javascript:void(0);" class="nice_button" onClick="Teleport.selectCharacter(this, {$realm.realmId}, {$character.guid}, '{$character.name}', {$character.money / 10000}, '{$character.race}')">
									{lang("select", "teleport")}
								</a>
							</section>

							<img class="item_icon" width="36" height="36" src="{$url}application/images/avatars/{$character.avatar}.gif" align="absmiddle" data-tip="<img src='{$url}application/images/stats/{$character.class}.gif' align='absbottom'/> {$character.name} (Lv{$character.level})">

							<a class="character_name" data-tip="<img src='{$url}application/images/stats/{$character.class}.gif' align='absbottom'/> {$character.name} (Lv{$character.level})">{$character.name}</a>
							<br /><img src="{$url}application/images/icons/coins.png" align="absmiddle"> {floor($character.money / 10000)} {lang("gold", "teleport")}
							<div class="clear"></div>
						</div>
					</div>
				{/foreach}
			{/foreach}
		{else}
			<p class="text-center"><b>{lang("no_chars", "teleport")}</b></p>
		{/if}
	</section>
	<div class="vertical_divider"></div>
	<section class="location-select" id="select_location">
		<div class="online_realm_button">{lang("teleport_hub", "teleport")}</div>
		{if $locations}
			{foreach from=$locations item=location}
				<div class="location-select location" data-realm="{$location.realm}" data-faction="{$location.required_faction}">
					<section class="location_buttons">
						<a href="javascript:void(0)" onClick="Teleport.buy({$location.id}, this)" class="nice_button">
							{if $location.vpCost}
								<img src="{$url}application/images/icons/lightning.png" align="absmiddle">
								{$location.vpCost} {lang("vp", "teleport")}
							{elseif $location.dpCost}
								<img src="{$url}application/images/icons/coins.png" align="absmiddle">
								{$location.dpCost} {lang("dp", "teleport")}
							{elseif $location.goldCost}
								<img src="{$url}application/images/icons/coins.png" align="absmiddle">
								{$location.goldCost} {lang("gold", "teleport")}
							{else}
								{lang("free", "teleport")}
							{/if}
						</a>
					</section>

					<a class="location_name">{$location.name}</a>
					<br />{$location.description}
					<div class="clear"></div>
				</div>
			{/foreach}
		{else}
			<p class="text-center"><b>{lang("no_locations", "teleport")}</b></p>
		{/if}
	</section>

	<div class="clear"></div>
</form>