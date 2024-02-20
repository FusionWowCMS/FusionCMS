<link rel="stylesheet" href="{$url}{$load_css}" type="text/css"/>

<script type="text/javascript">
    var Top = {
        realm: {$selected_realm},
        type: 0,
        pvpTab: 2,

        changeRealm: function (select) {
            var selected = $(select).find('option:selected');

            if (typeof selected != 'undefined' && selected.length > 0) {
                // Check if changed
                if (selected.val() != this.realm) {
                    setCookie('store_realm', selected.val(), 365, '/');
                    this.toggleRealm(selected.val());
                }
            }
        },

        toggleRealm: function (realmId) {
            // Check if it's already active
            if (this.realm == realmId)
                return;

            // Disable the current
            $('.realm_content[data-id="' + this.realm + '"]').hide();

            // Enable the new
            $('.realm_content[data-id="' + realmId + '"]').show();

            // Save the realm id
            this.realm = realmId;
        },

        toggleType: function (id) {
            // Check if it's already active
            if (this.type == id)
                return;

            // Disable the current
            $('.type_content[data-id="' + this.type + '"]').each(function (index, element) {
                $(element).hide();
            });
            $('#type_button_' + this.type).removeClass('active');

            // Enable the new
            $('.type_content[data-id="' + id + '"]').each(function (index, element) {
                $(element).show();
            });
            $('#type_button_' + id).addClass('active');

            // Save the type id
            this.type = id;
        },

        togglePVPTab: function (id) {
            // Check if it's already active
            if (this.pvpTab == id)
                return;

            // Disable the current
            $('.pvptab_content[data-id="' + this.pvpTab + '"]').each(function (index, element) {
                $(element).hide();
            });
            $('.pvptab_button[data-id="' + this.pvpTab + '"]').each(function (index, element) {
                $(element).removeClass('active');
                $(element).parent().find('#tab_dot').remove();
            });

            // Enable the new
            $('.pvptab_content[data-id="' + id + '"]').each(function (index, element) {
                $(element).show();
            });
            $('.pvptab_button[data-id="' + id + '"]').each(function (index, element) {
                $(element).addClass('active');
                $(element).parent().append('<div id="tab_dot"></div>');
            });

            // Save the tab id
            this.pvpTab = id;
        }
    };
</script>

<section id="top_ranked_wrapper">
    <article id="top_ranked_content">

        {foreach from=$realms item=realm}

            <!-- START OF REALM TAB -->
            <div data-id="{$realm.id}" class="realm_content"
                 {if $realm.id !=$selected_realm}style="display: none;" {/if}>

                <!-- END OF PVP TABS -->
                <div data-id="0" class="type_content type_content_pvp">
                    <div class="header">
                        <div id="column">
                            <a href="javascript:void(0);" class="pvptab_button active" data-id="2"
                               onClick="Top.togglePVPTab(2);">{lang('top_today_kills', 'sidebox_top')}
                            </a>
                            <div id="tab_dot">
                            </div>
                        </div>
                        <div id="column">
                            <a href="javascript:void(0);" class="pvptab_button" data-id="1"
                               onClick="Top.togglePVPTab(1);">{lang('top_yesterday_kills', 'sidebox_top')}
                            </a>
                        </div>
                        <div id="column">
                            <a href="javascript:void(0);" class="pvptab_button" data-id="0"
                               onClick="Top.togglePVPTab(0);">
                                {lang('top_total_kills', 'sidebox_top')}
                            </a>
                        </div>
                    </div>
                    <div class="body">
                        <!-- TOP TOTAL KILL PLAYERS -->
                        <div data-id="0" class="pvptab_content" style="display: none;">
                            {if $realm.totalKills}
                                <div class="table-responsive text-nowrap">
                                    <table class="nice_table mb-1">
                                        <thead></thead>
                                        {foreach from=$realm.totalKills item=character}
                                            <tr>
                                                <td class="col-1">
                                                    {if $character.rank == 1 || $character.rank == 2 || $character.rank == 3}
                                                        <img width="16px" height="16px"
                                                             src="{$url}application/modules/sidebox_top/images/{$character.rank}.ico"/>
                                                    {/if}
                                                </td>
                                                <td class="col-1 stats_name">
                                                    <img src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif"
                                                         width="20px">
                                                    <img src="{$url}application/images/stats/{$character.class}.gif"
                                                         width="20px">
                                                </td>

                                                <td class="col-3">
                                                    <a href="{$url}character/{$realm.id}/{$character.guid}/"
                                                       data-character-tip="{$character.guid}" data-realm="{$realm.id}">
                                                        {$character.name}
                                                    </a>
                                                </td>

                                                <td class="col-4 user-points">
                                                    {$character.guild}
                                                </td>

                                                <td class="col-5">Kills : {$character.totalKills}</td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </div>
                            {else}
                                <div class="center">{lang('no_players', 'sidebox_top')}</div>
                            {/if}
                        </div>
                        <!-- TOP YESTERDAY KILL PLAYERS -->
                        <div data-id="1" class="pvptab_content" style="display: none;">
                            {if $realm.yesterdayKills}
                                <div class="table-responsive text-nowrap">
                                    <table class="nice_table mb-1">
                                        <thead></thead>
                                        {foreach from=$realm.yesterdayKills item=character}
                                            <tr>
                                                <td class="col-1">
                                                    {if $character.rank == 1 || $character.rank == 2 || $character.rank == 3}
                                                        <img width="16px" height="16px"
                                                             src="{$url}application/modules/sidebox_top/images/{$character.rank}.ico"/>
                                                    {/if}
                                                </td>
                                                <td class="col-1 stats_name">
                                                    <img src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif"
                                                         width="20px">
                                                    <img src="{$url}application/images/stats/{$character.class}.gif"
                                                         width="20px">
                                                </td>

                                                <td class="col-3">
                                                    <a href="{$url}character/{$realm.id}/{$character.guid}/"
                                                       data-character-tip="{$character.guid}" data-realm="{$realm.id}">
                                                        {$character.name}
                                                    </a>
                                                </td>

                                                <td class="col-4 user-points">
                                                    {$character.guild}
                                                </td>

                                                <td class="col-5">Kills : {$character.yesterdayKills}</td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </div>
                            {else}
                                <div class="center">{lang('no_players', 'sidebox_top')}</div>
                            {/if}
                        </div>

                        <!-- TOP TODAY KILL PLAYERS -->
                        <div data-id="2" class="pvptab_content">
                            {if $realm.todayKills}
                                <div class="table-responsive text-nowrap">
                                    <table class="nice_table mb-1">
                                        <thead></thead>
                                        {foreach from=$realm.todayKills item=character}
                                            <tr>
                                                <td class="col-1">
                                                    {if $character.rank == 1 || $character.rank == 2 || $character.rank == 3}
                                                        <img width="16px" height="16px"
                                                             src="{$url}application/modules/sidebox_top/images/{$character.rank}.ico"/>
                                                    {/if}
                                                </td>
                                                <td class="col-1 stats_name">
                                                    <img src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif"
                                                         width="20px">
                                                    <img src="{$url}application/images/stats/{$character.class}.gif"
                                                         width="20px">
                                                </td>

                                                <td class="col-3">
                                                    <a href="{$url}character/{$realm.id}/{$character.guid}/"
                                                       data-character-tip="{$character.guid}" data-realm="{$realm.id}">
                                                        {$character.name}
                                                    </a>
                                                </td>

                                                <td class="col-4">
                                                    {$character.guild}
                                                </td>

                                                <td class="col-5 user-points">Kills : {$character.todayKills}</td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </div>
                            {else}
                                <div class="center">{lang('no_players', 'sidebox_top')}</div>
                            {/if}
                        </div>

                    </div>
                </div>
                <!-- END OF PVP TABS -->

                <!-- START OF ACHIEVEMENTS TAB -->
                <div data-id="1" class="type_content type_content_achievement" style="display: none;">
                    <div class="header">
                        <div id="column"><a href="javascript:void(0);"
                                            class="achievementtab_button active">Achievement</a>
                            <div id="tab_dot"></div>
                        </div>
                    </div>
                    <div class="body">

                        <div class="achievementtab_content">
                            {if $realm.achivements}
                                <div class="table-responsive text-nowrap">
                                    <table class="nice_table mb-1">
                                        <thead></thead>
                                        {foreach from=$realm.achivements item=character}
                                            <tr>
                                                <td class="col-1">
                                                    {if $character.rank == 1 || $character.rank == 2 || $character.rank == 3}
                                                        <img width="16px" height="16px"
                                                             src="{$url}application/modules/sidebox_top/images/{$character.rank}.ico"/>
                                                    {/if}
                                                </td>
                                                <td class="col-1 stats_name">
                                                    <img src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif"
                                                         width="20px">
                                                    <img src="{$url}application/images/stats/{$character.class}.gif"
                                                         width="20px">
                                                </td>

                                                <td class="col-3">
                                                    <a href="{$url}character/{$realm.id}/{$character.guid}/"
                                                       data-character-tip="{$character.guid}" data-realm="{$realm.id}">
                                                        {$character.name}
                                                    </a>
                                                </td>

                                                <td class="col-4">
                                                    {$character.guild}
                                                </td>

                                                <td class="col-5 user-points">Points
                                                    : {$character.achievement_points}</td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </div>
                            {else}
                                <div class="center">{lang('no_players', 'sidebox_top')}</div>
                            {/if}
                        </div>

                    </div>
                </div>
                <!-- END OF ACHIEVEMENTS TAB -->
                <!-- START OF GUILD TABS -->
                <div data-id="2" class="type_content type_content_guild" style="display: none;">
                    <div class="header">
                        <div id="column"><a href="javascript:void(0);" class="guildtab_button active">Guilds</a>
                            <div id="tab_dot"></div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="guildtab_content">
                            {if $realm.guilds}
                                <div class="table-responsive text-nowrap">
                                    <table class="nice_table mb-1">
                                        <thead></thead>
                                        {foreach from=$realm.guilds item=guild}
                                            <tr>
                                                <td class="col-1">
                                                    {if $guild.rank == 1 || $guild.rank == 2 || $guild.rank == 3}
                                                        <img width="16px" height="16px"
                                                             src="{$url}application/modules/sidebox_top/images/{$guild.rank}.ico"/>
                                                    {/if}
                                                </td>
                                                <td class="col-1 stats_name">
                                                    <img src="{$url}application/modules/sidebox_top/images/faction-{$guild.faction}.jpg"
                                                         width="20px"/>
                                                </td>

                                                <td class="col-3">
                                                    {$guild.name}
                                                </td>

                                                <td class="col-4">
                                                    <a href="{$url}character/{$realm.id}/{$guild.leaderguid}"
                                                       data-character-tip="{$guild.leaderguid}"
                                                       data-realm="{$realm.id}">
                                                        Leader ({$guild.leaderName})
                                                    </a>
                                                </td>

                                                <td class="col-5 user-points">Points : {$guild.achievement_points}</td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </div>
                            {else}
                                <div class="center">{lang('no_players', 'sidebox_top')}</div>
                            {/if}
                        </div>

                    </div>
                </div>
                <!-- END OF GUILD TABS -->
            </div>
            <!-- END OF REALM TAB -->

        {/foreach}
    </article>

    <div class="top_ranked_row">
        <div id="top10_types_menu">
            <a href="javascript:void(0);" id="type_button_0" onClick="Top.toggleType(0);"
               class="col-xs-12 col-sm-12 col-md-12 col-lg-3 nice_button active">PVP</a>
            <a href="javascript:void(0);" id="type_button_1" onClick="Top.toggleType(1);"
               class="col-xs-12 col-sm-12 col-md-12 col-lg-3 nice_button">ACHIEVEMENT</a>
            <a href="javascript:void(0);" id="type_button_2" onClick="Top.toggleType(2);"
               class="col-xs-12 col-sm-12 col-md-12 col-lg-3 nice_button">GUILD</a>
        </div>

        <div id="top10_realms_menu">
            <select name="realm" id="realm" class="selectboxit col-xs-12 col-sm-12 col-md-12 col-lg-3"
                    onChange="Top.changeRealm(this); return true;">
                {foreach from=$realms item=realm}
                    <option value="{$realm.id}" {if $realm.id==$selected_realm}selected{/if}>{$realm.name}</option>
                {/foreach}
            </select>
        </div>
    </div>
</section>
