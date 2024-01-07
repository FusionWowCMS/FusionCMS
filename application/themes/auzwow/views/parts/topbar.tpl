{strip}

<!-- Topbar.Start -->
<div id="topbar" class="topbar">
	<div class="aw_container">
		{if $isOnline}
			<!-- Logged in -->
			<div class="topbar-inner logged_in border_box self_clear">
				<div class="topbar-left">
					<div class="topbar-avatar border_box"><a href="{$url}ucp/avatar" class="border_box"><img src="{$CI->user->getAvatar()}" width="25" height="25" alt="{sprintf(lang('global_user_avatar', 'theme_auzwow'), $CI->user->getNickname())}" /></a></div>

					<div class="topbar-info">
						<span class="i_welcome">{lang('uinfo_welcome', 'theme_auzwow')} <a href="{$url}profile/{$CI->user->getId()}">{$CI->user->getNickname()}</a>!</span>&nbsp;
					</div>
				</div>

				<div class="topbar-right">
					<div class="topbar-coins">
						<span class="c_silver">{lang('voting_points', 'main')}: <i>{$CI->user->getVp()}</i></span>
						<span class="c_gold">{lang('donation_points', 'main')}: <i>{$CI->user->getDp()}</i></span>
					</div>

					<span class="topbar-sep"></span>

					<div class="topbar-menu">
						<a href="{$url}ucp">{lang('accmenu_panel', 'theme_auzwow')}</a>

						<span class="topbar-sep"></span>

						<a href="{$url}logout">{lang('accmenu_logout', 'theme_auzwow')}</a>
					</div>
				</div>
			</div>
		{else}
			<!-- not Logged -->
			<div class="topbar-inner not_logged border_box self_clear">
				<div class="topbar-left">
					<div class="topbar-avatar border_box"><span class="border_box"><img src="{$image_path}misc/inv_misc_questionmark.jpg" width="25" height="25" alt="{lang('global_avatar', 'theme_auzwow')}" /></span></div>

					<div class="topbar-info">
						<span class="i_welcome">{lang('nluinfo_welcome', 'theme_auzwow')}</span>&nbsp;

						<span>{lang('nluinfo_msg', 'theme_auzwow')}</span>
					</div>
				</div>

				<div class="topbar-right">
					<div class="topbar-menu">
						<a href="{$url}register">{lang('nlaccmenu_register', 'theme_auzwow')}</a>

						<span class="topbar-sep"></span>

						<a href="{$url}login">{lang('nlaccmenu_login', 'theme_auzwow')}</a>
					</div>
				</div>
			</div>
		{/if}
	</div>
</div>
<!-- Topbar.End -->

{/strip}