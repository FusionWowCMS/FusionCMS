{strip}

<div class="main_b_holder">
	<div class="aw_container">
		{if $isHomePage && $theme_configs.config.announcement.enabled}{include file="{$theme_path}views/parts/announcement.tpl"}{/if}
		{include file="{$theme_path}views/parts/columns.tpl"}
	</div>

	<div class="line_separator"></div>

	<div class="aw_container">
		<div class="body_content self_clear">
			<!-- Body Content start here -->

			{include file="{$theme_path}views/parts/mainside.tpl"}

			{if $showSideboxes && !isset($is404)}{include file="{$theme_path}views/parts/sidebar.tpl"}{/if}

			<!-- Body Content ends here -->
		</div>
	</div>
</div>

{/strip}