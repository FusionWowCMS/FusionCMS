{if !isset($link_active)}{$link_active = ""}{/if}

<div class="col-lg-4 py-5 pe-lg-5">
    <div class="w-100 text-center mb-5">

        <a href="{$url}ucp/avatar" class="user-avatar">
            <img src="{$CI->user->getAvatar()}" alt="avatar" class="rounded-circle">
            <div class="avatar-change-text">
                {lang("change_avatar", "main")}
            </div>
        </a>

    </div>
    <div class="section-header">User Control Panel</div>
    <div class="section-body">
        {foreach $ucp_menus as $group => $menusGroup}
            <div class="list-group mt-3">
                {foreach $menusGroup as $menu}
                    <a href="{$menu.link}" class="list-group-item list-group-item-action {if $url|cat:$link_active == $menu.link}active{/if}">
                        {$menu.name}
                    </a>
                {/foreach}
            </div>
        {/foreach}
    </div>
</div>
