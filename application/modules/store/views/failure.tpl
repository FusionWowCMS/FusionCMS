<div style="width:70%;margin-left:auto;margin-right:auto;margin-top:20px;margin-bottom:20px;font-size:14px;">

<script type="text/javascript">
	setTimeout(function()
	{
		window.location.reload(true);
	}, 10000);
</script>

{if $type == "offline"}
	{lang("error_offline", "store")}
{elseif $type == "character"}
	{lang("error_character", "store")}
{elseif $type == "character_exists"}
	{lang("error_character_exists", "store")}
{elseif $type == "character_not_mine"}
	{lang("error_character_not_mine", "store")}
{elseif $type == "character_not_offline"}
	{lang("error_character_not_offline", "store")}
{elseif $type == "no_console"}
	{lang("error_no_console", "store")}
{/if}

<a href="javascript:window.location.reload(true)">{lang("go_back", "store")}</a>

</div>