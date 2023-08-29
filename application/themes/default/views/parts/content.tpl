<!-- Content.Start -->
<section class="section section-content" content>
	<div class="container">
		<div class="row">
			<div id="left" class="col-sm-12 {if $showSideboxes && !isset($is404)}col-lg-8{/if}" mainbar>
				{if $isHomePage}{include file="{$theme_path}views{$DS}parts{$DS}banners.tpl"}{/if}
				{if $isHomePage && $MY_sideboxes.top}{include file="{$theme_path}views{$DS}parts{$DS}widgets_top.tpl"}{/if}
				{include file="{$theme_path}views{$DS}parts{$DS}mainbar.tpl"}
			</div>

			{if $showSideboxes && !isset($is404)}
				<div id="right" class="col-sm-12 col-lg-4" sidebar>
					{include file="{$theme_path}views{$DS}parts{$DS}sidebar.tpl"}
				</div>
			{/if}
		</div>

		{if $isHomePage && $MY_sideboxes.bottom}{include file="{$theme_path}views{$DS}parts{$DS}widgets_bottom.tpl"}{/if}
	</div>
</section>
<!-- Content.End -->