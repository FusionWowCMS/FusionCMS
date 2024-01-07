{strip}

<!-- Sidebar -->
<aside id="left" class="sidebar">
	{if $theme_configs.config.social.facebook.enabled || $theme_configs.config.social.twitter.enabled || $theme_configs.config.social.youtube.enabled}{include file="{$theme_path}views/parts/socials.tpl"}{/if}

	{foreach from=$sideboxes key=key item=sidebox}
		{if $sidebox.type == 'status' || $sidebox.type == 'online_players_extended'}{continue}{/if}

		<section {if $sidebox.type != 'custom'}id="sidebox_{$sidebox.type}"{/if} class="sidebox {if $sidebox.type == 'custom'}custom{/if} {if !isset($sideboxes[$key + 1])}lastrow{/if}">
			<h4 class="sidebox_title dotted_separator border_box">{if (strpos($sidebox.name, ' ') !== false)}{substr_replace($sidebox.name, '<i>', strpos($sidebox.name, ' ') + 1, 0)|cat:'</i>'}{else}{$sidebox.name}{/if}</h4>
			<div class="sidebox_body">{$sidebox.data}</div>
		</section>
	{/foreach}
</aside>
<!-- Sidebar.End -->

{/strip}