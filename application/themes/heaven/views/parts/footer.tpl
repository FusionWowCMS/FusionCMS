<!-- Footer.Start -->
<footer class="footer" footer>
	<div class="container">
		<div class="row g-5 align-items-center justify-content-between">
			<div class="col-lg-12 col-xl-6">
				<!-- Copyright.Start -->
				<div class="footer-copyright">
					<span>{sprintf(lang('footer_copyright', 'theme'), '<i>', '</i>', '<strong>'|cat:$serverName|cat:'</strong>')}</span>
					{langColumn($theme_configs.config.footer.text)}
				</div>
				<!-- Copyright.End -->

				<!-- Credits.Start -->
				<div class="footer-credits">
					Coded by <span>Darksider</span> <i>//</i> Design by <span>Veins</span>
				</div>
				<!-- Credits.End -->
			</div>

			{if $menus.bottom}
				<div class="col-lg-12 col-xl-4">
					<!-- Navbar.Start -->
					<nav class="footer-navbar">
						{foreach from=array_chunk(explode('[|]', rtrim($menus.bottom, '[|]')), 6) item=items}
							<ul class="navbar-nav">
								{foreach from=$items item=item}{$item}{/foreach}
							</ul>
						{/foreach}
					</nav>
					<!-- Navbar.End -->
				</div>
			{/if}

			<div class="col-lg-12 col-xl-2">
				<!-- Brand.Start -->
				<a href="{$url}" class="footer-brand" title="{$serverName} - {$CI->config->item('title')}">
					<img width="55" height="48" alt="{$serverName}" src="{$MY_image_path}graphics/logo.png" />
					<span class="text-ellipsis">
						<b>{$serverName}</b>
						<i>{$CI->config->item('title')}</i>
					</span>
				</a>
				<!-- Brand.End -->
			</div>
		</div>
	</div>
</footer>
<!-- Footer.End -->