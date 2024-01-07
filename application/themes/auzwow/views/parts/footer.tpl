{strip}

<!-- Footer.Start -->
<footer id="footer" class="footer">
	<div class="aw_row row-1">
		<div class="aw_container">
			<div class="aw_col col-1">
				<div class="box">
					<div class="box_title">{sprintf(lang('footer_msg_title', 'theme_auzwow'), $serverName)}</div>
					<div class="box_content">{langColumn($theme_configs.config.footer.text)}</div>
				</div>
			</div>

			<div class="aw_col col-2">
				<div class="box">
					<div class="box_title">{sprintf(lang('footer_nav_title', 'theme_auzwow'), $serverName)}</div>
					<div class="box_content">
						<ul class="footer_nav">
							{foreach from=$menu_bottom key=key item=foot_nav}
								<li><a {$foot_nav.link} class='nav_item {if $foot_nav.active}nav_active{/if} {if !isset($menu_bottom[$key + 1])}nav_last{/if}'>{$foot_nav.name}</a></li>
							{/foreach}
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="aw_row row-2">
		<a href="#top" class="nice_button nice_active_2 back-to-top"></a>

		<div class="aw_container">
			<div class="aw_col col-1">
				<span class="zafire">{lang('footer_zafire', 'theme_auzwow')}</span>
				<span class="darksider">{lang('footer_darksider', 'theme_auzwow')}</span>
			</div>

			<div class="aw_col col-2">
				<span class="copyright">{sprintf(lang('footer_copyright', 'theme_auzwow'), $serverName)} <i>{$theme_configs.config.footer.since} - {date('Y')}</i></span>
			</div>
		</div>
	</div>
</footer>
<!-- Footer.End -->

{/strip}