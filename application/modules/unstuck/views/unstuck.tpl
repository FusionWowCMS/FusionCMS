<script type="text/javascript">
    $(document).ready(function () {
        function initializeUnstuck() {
            if (typeof Unstuck != "undefined") {
                Unstuck.User.initialize({
                    dp: {$dp},
                    price: {$service_cost},
                });
            } else {
                setTimeout(initializeUnstuck, 50);
            }
        }

        initializeUnstuck();
    });
</script>
<div id="info_text"> {$description} </div>

<section id="character_tools">
    <form onSubmit="Unstuck.Submit(this); return false;">
        <label for="realm">Realm</label>
        <select name="realm" id="realm" onChange="Unstuck.RealmChanged();">
            {if $characters}
                {foreach from=$characters item=realm}
                    <option value="{$realm.realmId}">{$realm.realmName}</option>
                {/foreach}
            {else}
                <option value="0">No realms</option>
            {/if}
        </select>

        <label for="character" class="character_select">Character</label>
        {foreach from=$characters item=realm}
            <select {if !$realm@first}style="display:none"{/if} name="character_selector" data-character id="character_select_{$realm.realmId}" onChange="Unstuck.CharacterChanged(this, {$realm.realmId});">
                {if $realm.characters}
                    <option value="0"> Select Character</option>
                    {foreach from=$realm.characters item=character}
                        <option value="{$character.guid}">{$character.name} - Lvl {$character.level}</option>
                    {/foreach}
                {else}
                    <option value="0">No character</option>
                {/if}
            </select>
        {/foreach}

        <div class="service_cost">
            {if $service_cost}
                <div id="cost">Server Fee<img src="{$url}application/images/icons/coins_add.png"/>DP {$service_cost}</div>
            {else}
                <div id="cost"> Server Fee Free</div>
            {/if}
        </div>

        <div id="submit"><input type="submit" class="nice_button mt-2" value="Unstuck"/></div>

    </form>
</section>
<section id="character_tools_message" class="form_message" style="display: none;"></section>