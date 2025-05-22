<div class="container">
    <div class="row align-items-center mb-3">
        <div class="col-auto">
            <label for="realmSelect" class="col-form-label">{lang("realm", "online")}</label>
        </div>
        <div class="col">
            <select id="realmSelect" class="form-select">
                {foreach from=$realms item=realm}
                    <option value="{$realm->getId()}">{$realm->getName()} ({$realm->getOnline()})</option>
                {/foreach}
            </select>
        </div>
    </div>

    <div id="playersTableContainer" style="display:none;" class="table-responsive">
        <table id="playersTable" class="nice_table">
            <thead>
            <tr>
                <th>{lang("character", "online")}</th>
                <th>{lang("level", "online")}</th>
                <th>{lang("race", "online")}</th>
                <th>{lang("class", "online")}</th>
                <th>{lang("location", "online")}</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
