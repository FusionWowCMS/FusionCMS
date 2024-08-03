<section class="section section-widgets" widgets="" home_page_only=""><div separator="" separator-arrow-down=""><span separator-arrow=""></span></div>
	<div class="container">
		<div class="row g-4 justify-content-center">
		{if $sideboxes_bottom}
		{foreach from=$sideboxes_bottom item=sidebox}
			<div class="col-md-12 col-lg-4" widget="{$sidebox.type}">
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
			</div>
		{/foreach}
		{/if}
		</div>
	</div>
</section>