<script type="text/javascript">
	$(document).ready(function()
	{
		function initializeUnstuck()
		{
			if(typeof Unstuck != "undefined")
			{
				Unstuck.User.initialize({
					dp: {$dp}, 
					price: {$service_cost}, 
					realm: {$firstRealm}
				});
			}
			else
			{
				setTimeout(initializeUnstuck, 50);
			}
		}

		initializeUnstuck();
	});
</script>
<div id="info_text"> {$description} </div>

<section id="character_tools">

    <form onSubmit="Unstuck.Submit(this); return false;">

        <label> Realm
            <select name="realm" id="realm" onChange="Unstuck.RealmChanged(this);">
                {if $characters}
                {foreach from=$characters item=realm}
                <option value="{$realm.realmId}" {if $realm.realmId==$firstRealm}selected="selected" {/if}>{$realm.realmName}</option>
                {/foreach}
                {else}
                <option value="0">No realms</option>
                {/if}
            </select>
        </label>


        {foreach from=$characters item=realm}
        <label style="display: {if $realm.realmId == $firstRealm}block{else}none{/if};" class="character_select" id="character_select_{$realm.realmId}">
            Character

            <select name="character_{$realm.realmId}" id="character" class="selectboxit" onChange="Unstuck.CharacterChanged(this, {$realm.realmId});">
                {if $realm.characters}
                <option value="0"> Select Character </option>
                {foreach from=$realm.characters item=character}
                  <option value="{$character.guid}">{$character.name} - lvl {$character.level} </option>
                {/foreach}
                {else}
                <option value="0">no character</option>
                {/if}
            </select>
        </label>
        {/foreach}


        <div class="service_cost">

            {if $service_cost}
            <div id="cost">
                Server Fee
                <img src="{$url}application/images/icons/coins_add.png" />
                DP {$service_cost}
            </div>
            {else}
            <div id="cost"> Server Fee Free</div>
            {/if}
        </div>

        <div id="submit"> <input type="submit" class="nice_button mt-2" value="Unstuck" /></div>

    </form>
</section>
<section id="character_tools_message" class="form_message" style="display: none;"> </section>