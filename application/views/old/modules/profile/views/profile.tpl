<link rel="stylesheet" href="{$url}application/views/old/modules/ucp/css/ucp.css" type="text/css" />
<section id="ucp_top">
	<a id="ucp_avatar" style="width:44px;height:44px;margin-top:7px;">
		<img src="{$avatar}" height="44" width="44"/>
	</a>

	<section id="ucp_info" style="height:auto;">
		<aside style="height:auto;width:190px;margin-right:10px;">
			<table width="100%">
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/user.png" /></td>
					<td width="40%">{lang("nickname", "profile")}</td>
					<td width="50%" style="overflow:hidden;">{$username}</td>
				</tr>
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/world.png" /></td>
					<td width="40%">{lang("location", "profile")}</td>
					<td width="50%">{$location}</td>
				</tr>
			</table>
		</aside>

		<aside style="height:auto;width:190px;">
			<table width="100%">
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/shield.png" /></td>
					<td width="40%">{lang("account_status", "profile")}</td>
					<td width="50%">{$status}</td>
				</tr>
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/date.png" /></td>
					<td width="40%">{lang("member_since", "profile")}</td>
					<td width="50%">{$register_date}</td>
				</tr>
			</table>
		</aside>
		<aside style="height:auto;width:200px;padding-left:10px;">
			<table width="100%">
				<tr>
					<td width="10%"><img src="{$url}application/images/icons/award_star_bronze_1.png" /></td>
					<td width="20%">{lang("account_rank", "profile")}</td>
					<td width="70%">{foreach from=$groups item=group} <span {if $group.color}style="color:{$group.color}"{/if}>{$group.name}</span> {/foreach}</td>
				</tr>
				{if $online && $not_me}
					<tr>
						<td><img src="{$url}application/images/icons/email.png" /></td>
						<td>{lang("contact", "profile")}</td>
						<td><a href="{$url}messages/create/{$id}">{lang("pm", "profile")}</a></td>
					</tr>
				{else}
					<tr>
						<td>&nbsp;</td>
						<td></td>
					</tr>
				{/if}
			</table>
		</aside>
	</section>

	<div style="clear:both;"></div>	
</section>
{$characters}