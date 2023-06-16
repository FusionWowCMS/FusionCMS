<div id="wrap_{$id}" class="fusioneditor">
	<div class="fusioneditor_tools">
		<div style="float:right;display:none" id="fusioneditor_{$id}_close">
			<a class="fusioneditor_close" href="javascript:void(0)" onClick="FusionEditor.close('{$id}')" data-tip="{lang("close_tool")}">
				<img src="{$url}application/images/icons/bullet_arrow_up.png" />
			</a>
		</div>

		{foreach from=$tools item=tool key=name}
			{if $tool.enabled}
				<a href="javascript:void(0)" onClick="FusionEditor.Tools.{$name}('{$id}')" data-tip="{$tool.text}">
					<img src="{$url}application/images/icons/{$tool.icon}.png" />
				</a>
			{/if}
		{/foreach}
		<div class="clear"></div>
		<div class="fusioneditor_toolbox" id="fusioneditor_{$id}_toolbox" style="display:none;"></div>
	</div>
	<div id="{$id}" class="fusioneditor_field" style="min-height:{$height}px">{$content}</div>
</div>

<script type="text/javascript">
	$(document).ready(function()
	{
		function enableFusionEditor()
		{
			if(typeof FusionEditor != "undefined")
			{
				FusionEditor.create("{$id}");
			}
			else
			{
				setTimeout(enableFusionEditor, 50);
			}
		}

		enableFusionEditor();
	});
</script>