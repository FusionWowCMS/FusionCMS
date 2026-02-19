<section class="box big">

	<h2>
		<img src="{$url}application/themes/admin/images/icons/black16x16/ic_settings.png"/>
		{lang('what_manage', 'admin')}
	</h2>

	<span style="padding-top:22px;padding-bottom:22px;">
		<a href="{$url}aclmanager/groups" class="big_icon_button" data-tip="{lang('groups_description', 'admin')}">
			<img src="{$url}application/modules/admin/images/id.png" style="margin-top:-12px;">
			{lang('groups', 'admin')}
		</a>

		<a href="{$url}aclmanager/roles" class="big_icon_button" data-tip="{lang('roles_description', 'admin')}">
			<img src="{$url}application/modules/admin/images/eye.png" style="margin-top:-4px;">
			{lang('roles', 'admin')}
		</a>

		<a href="{$url}aclmanager/users" class="big_icon_button" data-tip="{lang('user_permissions_description', 'admin')}">
			<img src="{$url}application/modules/admin/images/man-user.png" style="margin-top:-14px;">
			{lang('user_permissions', 'admin')}
		</a>

		<div class="clear"></div>
	</span>

</section>
