<!-- Footer.Start -->
<footer class="footer" footer>
	<div footer-glow><div footer-glow-1></div><div footer-glow-2></div></div>

	<div class="container">
		{if $menus.bottom}
			<div class="row">
				<div class="col-sm-12">
					<!-- Navbar.Start -->
					<nav class="navbar navbar-expand">
						<!-- Nav.Start -->
						<ul class="navbar-nav mx-auto">{$menus.bottom}</ul>
						<!-- Nav.End -->
					</nav>
					<!-- Navbar.End -->
				</div>

				<div class="col-sm-12">
					<div class="divider"></div>
				</div>
			</div>
		{/if}

		<div class="row align-items-center">
			<div class="col-sm-12 col-lg-6">
				<!-- Copyright.Start -->
				<div class="footer-copyright">
					{sprintf(lang('copyright', 'theme'), '<strong>'|cat:$serverName|cat:'</strong>', '<span>'|cat:date('Y')|cat:'</span>')}
				</div>
				<!-- Copyright.End -->
			</div>

			<div class="col-sm-12 col-lg-6">
				<!-- Logos.Start -->
				<div class="footer-logos">
					<div class="logo-icon type-fcms" data-bs-html="true" data-bs-toggle="tooltip" data-bs-title="Powered by <b>FusionCMS</b>"></div>
					<div class="logo-sep"></div>
					<div class="logo-icon type-evil" data-bs-html="true" data-bs-toggle="tooltip" data-bs-title="Designed by <b>EvilSystem</b>"></div>
					<div class="logo-sep"></div>
					<div class="logo-icon type-dark" data-bs-html="true" data-bs-toggle="tooltip" data-bs-title="Coded by <b>Darksider</b>"></div>
				</div>
				<!-- Logos.End -->
			</div>
		</div>
	</div>
</footer>
<!-- Footer.End -->