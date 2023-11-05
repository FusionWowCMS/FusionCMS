{if $showSideboxes && !isset($is404)}
	<!-- Sideboxes.Start -->
	<div class="col-lg-12 col-xl-4 col-xxl-3" side>
		{foreach from=$MY_sideboxes.side item=item}
			{$item}
		{/foreach}
	</div>
	<!-- Sideboxes.End -->
{/if}