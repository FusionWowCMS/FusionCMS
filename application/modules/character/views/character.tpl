<!-- Character Top.Start -->
<div class="row top-bar">
	<div class="col-avatar">
		<div class="avatar">
			<img src="{$url}application/images/avatars/{$avatar}.gif"/>
		</div>
	</div>
	<div class="col-9 col-md-10 ps-4">
		<div class="d-flex h-100 align-items-center">
			<span class="h1 color-c{$class}">{$name}</span>
			<div class="border-start border-2 ms-3 ps-3">
				<div class=""> {$raceName} {$className}</div>
				<div class="">{if $guildName}<a href="{$url}guild/{$realmId}/{$guild}">❮{$guildName}❯</a>{/if} {$realmName}</div>
			</div>
		</div>
	</div>
</div>
<!-- Character Top.End -->
<hr class="my-5" />
<!-- Character Main.Start -->
<div class="row {if $faction == 1}bg-faction alliance{else if $faction == 2}bg-faction horde{/if}">
	<div class="col-items">
		<div class="item"><a></a>{$items.head}</div>
		<div class="item"><a></a>{$items.neck}</div>
		<div class="item"><a></a>{$items.shoulders}</div>
		<div class="item"><a></a>{$items.back}</div>
		<div class="item"><a></a>{$items.chest}</div>
		<div class="item"><a></a>{$items.body}</div>
		<div class="item"><a></a>{$items.tabard}</div>
		<div class="item"><a></a>{$items.wrists}</div>
	</div>
	
	<div class="col-main text-center pt-5">
		<div class="char-avatar d-inline-block">
			<i class="avatar shadow" style="background-image:url('{$url}/application/images/renderer/face/{$race}_{$gender}.png');"></i>
			<div class="char-level bg-dark fw-bold shadow">{$level}</div>
		</div>
		<div class="avatar-text h1 my-3">{$name}</div>
		
	</div>
	
	<div class="col-items">
		<div class="item"><a></a>{$items.hands}</div>
		<div class="item"><a></a>{$items.waist}</div>
		<div class="item"><a></a>{$items.legs}</div>
		<div class="item"><a></a>{$items.feet}</div>
		<div class="item"><a></a>{$items.finger1}</div>
		<div class="item"><a></a>{$items.finger2}</div>
		<div class="item"><a></a>{$items.trinket1}</div>
		<div class="item"><a></a>{$items.trinket2}</div>
	</div>
</div>

<div class="col-bottom d-flex justify-content-center">
	<div class="item"><a></a>{$items.mainhand}</div>
	<div class="item"><a></a>{$items.offhand}</div>
	<div class="item"><a></a>{$items.ranged}</div>
</div>
<!-- Character Main.End -->
<hr class="my-5" />
<!-- Character Bars.Start -->
<div class="row my-5">
	<div class="col-6">
		{if isset($stats.maxhealth)}
			{if $stats.maxhealth && $stats.maxhealth != "Unknown"}
				<div id="health" class="">
					<div class="d-flex justify-content-between">
					<span class="text-upper h4">Health</span>
					<span class="text-upper h4">{$stats.maxhealth}</span>
					</div>
					<div class="progress" style="height: 5px;">
						<div class="progress-bar  bg-health" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			{/if}
		{/if}		
	</div>
	<div class="col-6">
		{if isset($secondBarValue)}
			{if $secondBarValue && $secondBarValue != "Unknown"}
				<div id="{$secondBar}" class="">
					<div class="d-flex justify-content-between">
					<span class="text-upper h4">{$secondBar}</span>
					<span class="text-upper h4">{$secondBarValue}</span>
					</div>
					<div class="progress" style="height: 5px;">
						<div class="progress-bar  bg-{$secondBar}" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			{/if}
		{/if}
	</div>
</div>
<!-- Character Bars.End -->

<!--Characters Attributes.Start -->
<div class="row">
	<div class="col-md-6">
		<div class="section-header">{lang("attributes", "character")}</div>
		<div class="section-body">
			<table class="table table-striped table-hover">
				<tr>
					<td>{lang("str", "character")}</td>
					<td class="text-end">{if isset($stats.strength)}{$stats.strength}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				<tr>
					<td>{lang("sta", "character")}</td>
					<td class="text-end">{if isset($stats.stamina)}{$stats.stamina}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				<tr>
					<td>{lang("int", "character")}</td>
					<td class="text-end">{if isset($stats.intellect)}{$stats.intellect}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				
				{if $stats && array_key_exists("spellPower", $stats)}
				<tr>
					<td>{lang("sp", "character")}</td>
					<td class="text-end">{if isset($stats.spellPower)}{$stats.spellPower}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				{/if}
				
				{if $stats && array_key_exists("attackPower", $stats)}
				<tr>
					<td>{lang("ap", "character")}</td>
					<td class="text-end">{if isset($stats.attackPower)}{$stats.attackPower}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				{/if}
			</table>
			
			<table class="table table-striped table-hover">
				{if $stats && array_key_exists("resilience", $stats)}
				<tr>
					<td>{lang("res", "character")}</td>
					<td class="text-end">{if isset($stats.resilience)}{$stats.resilience}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				{/if}
				
				<tr>
					<td>{lang("armor", "character")}</td>
					<td class="text-end">{if isset($stats.armor)}{$stats.armor}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				<tr>
					<td>{lang("block", "character")}</td>
					<td class="text-end">{if isset($stats.blockPct)}{$stats.blockPct}%{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				<tr>
					<td>{lang("dodge", "character")}</td>
					<td class="text-end">{if isset($stats.dodgePct)}{$stats.dodgePct}%{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				<tr>
					<td>{lang("parry", "character")}</td>
					<td class="text-end">{if isset($stats.parryPct)}{$stats.parryPct}%{else}{lang("unknown", "character")}{/if}</td>
				</tr>				
			</table>
			
			<table class="table table-striped table-hover">
				<tr>
					<td>{lang("crit", "character")}</td>
					<td class="text-end">{if isset($stats.critPct)}{$stats.critPct}%{else}{lang("unknown", "character")}{/if}</td>
				</tr>		
				<tr>
					<td>{lang("ranged_crit", "character")}</td>
					<td class="text-end">{if isset($stats.rangedCritPct)}{$stats.rangedCritPct}%{else}{lang("unknown", "character")}{/if}</td>
				</tr>			
				<tr>
					<td>{lang("spell_crit", "character")}</td>
					<td class="text-end">{if isset($stats.spellCritPct)}{$stats.spellCritPct}%{else}{lang("unknown", "character")}{/if}</td>
				</tr>		
				
				{if $stats && array_key_exists("spirit", $stats)}
				<tr>
					<td>{lang("spirit", "character")}</td>
					<td class="text-end">{if isset($stats.spirit)}{$stats.spirit}{else}{lang("unknown", "character")}{/if}</td>
				</tr>			
				{/if}
			</table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="section-header">{lang("pvp", "character")}</div>
		<div class="section-body">
			<table class="table table-hover table-striped">
				{if $pvp.kills !== false}
				<tr>
					<td>{lang("kills", "character")}</td>
					<td class="text-end">{if isset($pvp.kills)}{$pvp.kills}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				{/if}
				
				{if $pvp.honor !== false}
				<tr>
					<td>{lang("honor", "character")}</td>
					<td class="text-end">{if isset($pvp.honor)}{$pvp.honor}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				{/if}
				
				{if $pvp.arena !== false}
				<tr>
					<td>{lang("arena", "character")}</td>
					<td class="text-end">{if isset($pvp.arena)}{$pvp.arena}{else}{lang("unknown", "character")}{/if}</td>
				</tr>
				{/if}
			</table>
		</div>
	</div>
</div>
<!-- Characters Attributes.End -->

<!-- Load wowhead tooltip -->
{if !$fcms_tooltip}
<script type="text/javascript" src="https://static.wowhead.com/widgets/power.js"></script>
<script>var wowhead_tooltips = { "colorlinks": false, "iconizelinks": false, "renamelinks": false }</script>
{/if}