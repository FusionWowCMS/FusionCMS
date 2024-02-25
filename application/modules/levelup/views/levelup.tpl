<script type="text/javascript">
	$(document).ready(function()
	{
		function initializeLevelUp()
		{
			if(typeof LevelUp != "undefined")
			{
				LevelUp.User.initialize({
					dp: {$dp}, 
					realm: {$firstRealm}
				});
			}
			else
			{
				setTimeout(initializeLevelUp, 50);
			}
		}

		initializeLevelUp();
	});
</script>
<div id="info_text"> {$description} </div>



<section id="character_tools">


    <form onSubmit="LevelUp.Submit(this); return false;">

        <label> Realm

            <select name="realm" id="realm" onChange="LevelUp.RealmChanged(this);">
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

            <select name="character_{$realm.realmId}" id="character" class="selectboxit" onChange="LevelUp.CharacterChanged(this, {$realm.realmId});">
                
                {if $realm.characters}

                <option value="0"> Select Character </option>

                {foreach from=$realm.characters item=character}

                {if $character.level != $maxlevel}

                <option value="{$character.guid}">{$character.name} - Lvl {$character.level}</option>

                {/if}




                {/foreach}

                {else}
                
                <option value="0">no character</option>
                
                {/if}
            </select>


        </label>
        {/foreach}

        <label> Price

            <select name="id" id="id" onChange="LevelUp.CharacterPrice(this);">

                {foreach from=$prices item=price key=key}
                
                   <option value="{$price}">Level {$key} DP {$price} </option>
                
                {/foreach}

            </select>

        </label>




        <div id="submit"> <input type="submit" class="nice_button mt-2" value="Level Up" />  </div>

    </form>
</section>
<section id="character_tools_message" class="form_message" style="display: none;"></section>