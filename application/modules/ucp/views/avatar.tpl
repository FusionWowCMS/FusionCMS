<div class="page-subbody p-0">
    <div class="avatars">
        <div class="row g-2">
            <div class="col-sm-12 mb-4">
                <div class="avatars_name">Player avatars</div>
            </div>

            {foreach from=$avatars key=key item=data}
                {if $data.staff == 0}
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 col-xl-2">
                        <a href="javascript:void(0);" data-avatar-id="{$data.id}" class="my_avatar {if $avatarId == $data.id}avatar_current{/if}" onclick="Avatar.change(this)" style="background-image: url('{$url}application/images/avatar/{$data.avatar}');"></a>
                    </div>
                {/if}
            {/foreach}
        
            {if $isStaff}
                <div class="divider"></div>
                <div class="col-sm-12 mb-4">
                    <div class="avatars_name">Staff avatars</div>
                </div>

                {foreach from=$avatars key=key item=data}
                    {if $data.staff == 1}
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 col-xl-2">
                            <a href="javascript:void(0);" data-avatar-id="{$data.id}" class="my_avatar {if $avatarId == $data.id}avatar_current{/if}" onclick="Avatar.change(this)" style="background-image: url('{$url}application/images/avatar/{$data.avatar}');"></a>
                        </div>
                    {/if}
                {/foreach}
            {/if}
        </div>
    </div>
</div>