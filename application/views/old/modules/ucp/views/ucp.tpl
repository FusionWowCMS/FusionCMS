<link rel="stylesheet" href="{$url}application/views/old/modules/ucp/css/ucp.css" type="text/css" />
<section id="ucp_top">
	<a href="{$url}ucp/avatar" id="ucp_avatar">
		<div>{lang("change_avatar", "ucp")}</div>
		<img src="{$avatar}"/>
	</a>

	<section id="ucp_info">
		<aside>
			<table width="100%">
				<tr data-tip="{lang("data_tip_vote", "ucp")}">
					<td width="10%"><img src="{$url}application/images/icons/lightning.png" /></td>
					<td width="40%">{lang("voting_points", "ucp")}</td>
					<td width="50%">{$vp}</td>
				</tr>
				<tr data-tip="{lang("data_tip_donate", "ucp")}">
					<td width="10%"><img src="{$url}application/images/icons/coins.png" /></td>
					<td width="40%">{lang("donation_points", "ucp")}</td>
					<td width="50%">{$dp}</td>
				</tr>
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/shield_add.png" /></td>
					<td width="40%">{lang("account_status", "ucp")}</td>
					<td width="50%">{$status}</td>
				</tr>
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/date_go.png" /></td>
					<td width="40%">{lang("member_since", "ucp")}</td>
					<td width="50%">{$register_date}</td>
				</tr>
			</table>
		</aside>

		<aside>
			<table width="100%">
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/user.png" /></td>
					<td width="40%">{lang("nickname", "ucp")}</td>
					<td width="50%">
						<a href="{$url}ucp/settings" data-tip="{lang("change_nickname", "ucp")}" style="float:left;margin-left:10px;"><img src="{$url}application/images/icons/pencil.png" align="absbottom" /></a>
						<a href="profile/{$id}" data-tip="View profile">{$username}</a>
					</td>
				</tr>
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/email.png" /></td>
					<td width="40%">{lang("email", "ucp")}</td>
					<td width="50%">
						<a href="{$url}ucp/settings" data-tip="{lang("edit", "ucp")}" style="float:left;margin-left:10px;"><img src="{$url}application/images/icons/pencil.png" align="absbottom" /></a>
						{$email}
					</td>
				</tr>
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/lock.png" /></td>
					<td width="40%">{lang("password", "ucp")}</td>
					<td width="50%">
						<a href="{$url}ucp/settings" data-tip="{lang("edit", "ucp")}" style="float:left;margin-left:10px;"><img src="{$url}application/images/icons/pencil.png" align="absbottom" /></a>
						********
					</td>
				</tr>
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/star.png" /></td>
					<td width="40%">{lang("account_rank", "ucp")}</td>
					<td width="50%">{foreach from=$groups item=group} <span {if $group.color}style="color:{$group.color}"{/if}>{$group.name}</span> {/foreach}</td>
				</tr>
			</table>
		</aside>
	</section>

	<div class="clear"></div>	
</section>

<div class="ucp_divider"></div>

<section id="ucp_buttons">
	{if hasPermission('view', "vote") && $config['vote']}
		<a href="{$url}{$config.vote}" style="background-image:url({$url}application/modules/ucp/images/vote_panel.jpg)"></a>
	{/if}

	{if hasPermission('view', "donate") && $config['donate']}
	<a href="{$url}{$config.donate}" style="background-image:url({$url}application/modules/ucp/images/donate_panel.jpg)"></a>
	{/if}

	{if hasPermission('view', "store") && $config['store']}
		<a href="{$url}{$config.store}" style="background-image:url({$url}application/modules/ucp/images/item_store.jpg)"></a>
	{/if}

	{if hasPermission('canUpdateAccountSettings', 'ucp') && $config['settings']}
		<a href="{$url}{$config.settings}" style="background-image:url({$url}application/modules/ucp/images/account_settings.jpg)"></a>
	{/if}

	{if hasPermission('canChangeExpansion', "ucp") && $config['expansion']}
        <a href="{$url}{$config.expansion}" style="background-image:url({$url}application/modules/ucp/images/change_expansion.jpg)"></a>
	{/if}

	{if hasPermission('view', "teleport") && $config['teleport']}
		<a href="{$url}{$config.teleport}" style="background-image:url({$url}application/modules/ucp/images/teleport_hub.jpg)"></a>
	{/if}

	{if hasPermission('view', "gm") && $config['gm']}
		<a href="{$url}{$config.gm}" style="background-image:url({$url}application/modules/ucp/images/gm_panel.jpg)"></a>
	{/if}

	{if hasPermission('view', "admin") && $config['admin']}
		<a href="{$url}{$config.admin}" style="background-image:url({$url}application/modules/ucp/images/admin_panel.jpg)"></a>
	{/if}
	
	<div class="clear"></div>
</section>

{if $characters > 0}
	<div class="section-body">
		{foreach from=$realms item=realm}
			{if $realm->getCharacterCount() > 0}
            <div class="table-responsive text-nowrap">
				<table class="nice_table mb-3">
						<thead>
							<tr>
								<th scope="col" colspan="6" class="h4 text-center">{$realm->getName()}</th>
							</tr>
						</thead>
						{foreach from=$realm->getCharacters()->getCharactersByAccount() item=character}
							<tr>
								<td class="col-0">
									<img src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif">
								</td>
								<td class="col-2">
									<img src="{$url}application/images/stats/{$character.class}.gif" width="20px">
								</td>

								{$money = $realmObj->formatMoney($character.money)}
								<td class="col-3">{$character.name}</td>

								<td class="col-4 user-points">
									{if $money}
										<span class="gold-points"><i class="fa-solid fa-coins"></i> {$money["gold"]}</span>
										<span class="silver-points"><i class="fa-solid fa-coins"></i> {$money["silver"]}</span>
										<span class="copper-points"><i class="fa-solid fa-coins"></i> {$money["copper"]}</span>
									{else}
										<span class="copper-points"><i class="fa-solid fa-coins"></i> 0</span>
									{/if}
								</td>

								<td class="col-5">Lv{$character.level}</td>
								<td class="col-6"><a href="{$url}character/{$realm->getId()}/{$character.name}">View</a></td>
							</tr>
						{/foreach}
				</table>
            </div>
			{/if}
		{/foreach}
	</div>
{/if}