<div class="page-subbody mt-0">
    <form onSubmit="Search.show_data();return false;">
        <div class="input-group">
            <input class="col-xs-12 col-sm-12 col-md-12 col-lg-3 form-control mx-1" type="text" id="search_field" name="search_field" placeholder="{lang("search_placeholder", "armory")}">
        
            <select class="col-xs-12 col-sm-12 col-md-12 col-lg-3 mx-1" id="realm" name="realm" onchange="Search.toggle();return false;">
                <option value="0" disabled>{lang("realm", "armory")}</option>
                {for $i = 0; $i<count((array)$realms); $i++}
                    <option {if $i == 0}selected{/if} value="{$realms[$i]->getId()}">{$realms[$i]->getName()}</option>				
                {/for}
            </select>
        
            <select class="col-xs-12 col-sm-12 col-md-12 col-lg-3 mx-1" id="table" name="table" onchange="Search.toggle();return false;">
                <option value="items">{lang("items", "armory")}</option>
                <option value="guilds">{lang("guilds", "armory")}</option>
                <option value="characters">{lang("characters", "armory")}</option>
            </select>
        
            <button class="nice_button mx-1" type="submit">{lang("search_button", "armory")}</button>
        </div>
    </form>
</div>

<div class="page-subbody mt-4 p-4 mt-0 table-responsive" id="search_box">
	<table class="nice_table" id="search_results_items">
        <thead>
            <tr>
				<th>{lang("name", "armory")}</th>
				<th class="text-center">{lang("level", "armory")}</th>
				<th class="text-center">{lang("required", "armory")}</th>
				<th>{lang("type", "armory")}</th>
			</tr>
        </thead>
        <tbody></tbody>
    </table>
    <table class="nice_table" id="search_results_characters">
        <thead>
            <tr>
				<th style="width:10px"></th>
				<th>{lang("name", "armory")}</th>
				<th>{lang("faction", "armory")}</th>
				<th>{lang("level", "armory")}</th>
				<th></th>
			</tr>
        </thead>
        <tbody></tbody>
    </table>
    <table class="nice_table" id="search_results_guilds">
        <thead>
            <tr>
				<th>{lang("name", "armory")}</th>
				<th class="text-center">{lang("members", "armory")}</th>
				<th class="text-center">{lang("owner", "armory")}</th>
			</tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
