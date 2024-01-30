{if !isset($link_active)}{$link_active = ""}{/if}

<style>
.user-avatar {
	position:relative;
	display:inline-block;
	width:150px;
	height:150px;
}

.user-avatar img {
	width:100%;
	height:150px;
	object-fit:cover;
   object-position:50% 50%;
}

.user-avatar .avatar-change-text {
	position:absolute;
	display:none;
	top:-1px;
	left:-1px;
	justify-content:center;
	align-items:center;
	width:calc(100% + 2px);
	height:calc(100% + 2px);
	background-color:rgba(19,21,30, 0.8);
	color:#fff;
	border-radius:50%;
}

.user-avatar:hover .avatar-change-text {
	display:flex;
}
</style>

<div class="col-lg-4 py-5 pe-lg-5">
	<div class="w-100 text-center mb-5">
	
		<a href="{$url}ucp/avatar" class="user-avatar">
			<img src="{$CI->user->getAvatar()}" alt="avatar" class="rounded-circle">
			<div class="avatar-change-text">
				{lang("change_avatar", "main")}
			</div>
		</a>
		
	</div>
	<div class="section-header">User <span>Control</span> Panel</div>
	<div class="section-body">
		<div class="list-group">
			<a href="{$url}ucp" class="list-group-item list-group-item-action {if $link_active == 'ucp'}active{/if}">Account Overview</a>
			{if hasPermission('canUpdateAccountSettings', 'ucp')}<a href="{$url}ucp/settings" class="list-group-item list-group-item-action {if $link_active == 'settings'}active{/if}">{lang("account_settings", "main")}</a>{/if}
			{if $CI->config->item('totp_secret')}<a href="{$url}ucp/security" class="list-group-item list-group-item-action {if $link_active == 'security'}active{/if}">{lang("account_security", "main")}</a>{/if}
		</div>
		
		{* <div class="list-group mt-3">
			{if hasPermission('canChangeExpansion', "ucp")}<a href="{$url}ucp/expansion" class="list-group-item list-group-item-action  {if $link_active == 'expansion'}active{/if}">{lang("change_expansion", "main")}</a>{/if}
			{if hasPermission('view', "teleport")}<a href="{$url}teleport" class="list-group-item list-group-item-action  {if $link_active == 'teleport'}active{/if}">{lang("teleport_hub", "main")}</a>{/if}
		</div> *}
		
		<div class="list-group mt-3">
			{if hasPermission('view', "teleport")}<a href="{$url}teleport" class="list-group-item list-group-item-action  {if $link_active == 'teleport'}active{/if}">{lang("teleport_hub", "main")}</a>{/if}
			{if hasPermission('view', "vote")}<a href="{$url}vote" class="list-group-item list-group-item-action  {if $link_active == 'vote'}active{/if}">{lang("vote", "main")}</a>{/if}
			{if hasPermission('view', "donate")}<a href="{$url}donate" class="list-group-item list-group-item-action  {if $link_active == 'donate'}active{/if}">{lang("donate", "main")}</a>{/if}
			{if hasPermission('view', "store")}<a href="{$url}store" class="list-group-item list-group-item-action  {if $link_active == 'store'}active{/if}">{lang("store", "main")}</a>{/if}
		</div>
		
		<div class="list-group mt-3">
			{if hasPermission('view', "gm")}<a href="{$url}gm" class="list-group-item list-group-item-action">{lang("gm_panel", "main")}</a>{/if}
			{if hasPermission('view', "admin")}<a href="{$url}admin" class="list-group-item list-group-item-action">{lang("admin_panel", "main")}</a>{/if}
		</div>
	</div>
</div>
