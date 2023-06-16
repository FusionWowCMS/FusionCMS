<div class="accordion accordion-flush" id="online_page">
   {foreach from=$realms item=realm}
   <div class="accordion-item mb-3">
      <h2 class="accordion-header" id="{$realm->getId()}">
         {if $realm->isOnline()}
         <button class="accordion-button text-center" type="button" data-bs-toggle="collapse" data-bs-target="#realm-{$realm->getId()}" aria-expanded="true" aria-controls="realm-{$realm->getId()}">
         {$realm->getName()} ({$realm->getOnline()})
         </button>
      </h2>
      <div id="realm-{$realm->getId()}" class="accordion-collapse collapse {if count($realms) == 1}show{/if}" aria-labelledby="{$realm->getId()}" data-bs-parent="#online_page">
         <div class="accordion-body p-0" id="online_realm_{$realm->getId()}">
            {if $realm->getOnline() > 0}
			<div class="table-responsive text-nowrap">
            <table class="nice_table">
               <thead>
                  <tr>
                     <th><a href="javascript:void(0)" onClick="Sort.name({$realm->getId()})">{lang("character", "online")}</a></th>
                     <th><a href="javascript:void(0)" onClick="Sort.level({$realm->getId()})">{lang("level", "online")}</a></th>
                     <th>{lang("race", "online")}</th>
                     <th>{lang("class", "online")}</th>
                     <th><a href="javascript:void(0)" onClick="Sort.location({$realm->getId()})">{lang("location", "online")}</a></th>
                  </tr>
               </thead>
               <tbody>
                  {foreach from=$realm->getCharacters()->getOnlinePlayers() item=character}
                  <tr>
                     <td><a data-tip="{lang("view_profile", "online")}" href="{$url}character/{$realm->getId()}/{$character.guid}">{$character.name}</a></td>
                     <td>{$character.level}</td>
                     <td><img src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif"></td>
                     <td><img src="{$url}application/images/stats/{$character.class}.gif" /></td>
                     <td>{$realmsObj->getZone($character.zone)}</td>
                  </tr>
                  {/foreach}
               </tbody>
               {else}
               <center style="margin-bottom:10px;">{lang("no_players", "online")}</center>
               {/if}
            </table>
			</div>
         </div>
      </div>
      {else}
      <button class="accordion-button text-center" type="button" data-bs-toggle="collapse" data-bs-target="#realm-{$realm->getId()}" aria-expanded="true" aria-controls="realm-{$realm->getId()}">
      {$realm->getName()} ({lang("offline", "online")})
      </button>
      {/if}
   </div>
   {/foreach}
</div>