<!-- Sidebox.Start -->
{if $sideboxes}
	{foreach from=$sideboxes item=sidebox}
		<section class="sidebox sidebox-{$sidebox.type} {if $sidebox@last}last-row{/if}">

			<h3 class="sidebox-head text-ellipsis">
				{if $sidebox.name == trim($sidebox.name) && str_contains($sidebox.name, ' ') !== false}
					{$names = explode(" ", $sidebox.name)}
					{for $i = 0; $i<count($names); $i++}
						{if $i % 2 == 1}<span>{$names[$i]}</span>{else}{$names[$i]}{/if}
					{/for}
				{else}
					{$sidebox.name}
				{/if}
			</h3>

			<div class="sidebox-body">
				{$sidebox.data}
			</div>
		</section>
	{/foreach}
{/if}
<!-- Sidebox.End -->