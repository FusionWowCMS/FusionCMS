<script type="text/javascript">
    $(document).ready(function () {
        function initializeLevelUp() {
            if (typeof LevelUp != "undefined") {
                LevelUp.User.initialize({
                    dp: {$dp}
                });
            } else {
                setTimeout(initializeLevelUp, 50);
            }
        }

        initializeLevelUp();
    });
</script>
<div id="info_text"> {$description} </div>

<section id="character_tools">
    <form onSubmit="LevelUp.Submit(this); return false;">
        <label for="realm">Realm</label>
        <select name="realm" id="realm" onChange="LevelUp.RealmChanged();">
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
            <select {if !$realm@first}style="display:none"{/if} name="character_selector" data-character id="character_select_{$realm.realmId}" onChange="LevelUp.CharacterChanged(this, {$realm.realmId});">
                {if $realm.characters}
                    <option value="0"> Select Character</option>
                    {foreach from=$realm.characters item=character}
                        {if $character.level != $maxlevel}
                            <option value="{$character.guid}">{$character.name} - Lvl {$character.level}</option>
                        {/if}
                    {/foreach}
                {else}
                    <option value="0">No character</option>
                {/if}
            </select>
        {/foreach}

        <label for="id">Price</label>
        <select name="id" id="id" onChange="LevelUp.CharacterPrice(this);">
            {foreach from=$prices item=price key=key}
                <option value="{$price}">Level {$key} DP {$price} </option>
            {/foreach}
        </select>

        <div id="submit"><input type="submit" class="nice_button mt-2" value="Level Up"/></div>

    </form>
</section>
<section id="character_tools_message" class="form_message" style="display: none;"></section>