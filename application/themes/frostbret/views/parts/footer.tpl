<!-- Footer Section.Start -->
<footer class="footer" footer="">
  <div class="container-fluid">
    <div class="row row-1">
      <div class="col-sm-12">
        <!-- Navbar.Start -->
        <nav class="navbar navbar-bottom">
          <ul class="navbar-nav">
			{foreach from=$menu_bottom item=menu}
				<li class="nav-item">
					<a {$menu.link} class="nav-link {if $menu.active}nav-active{/if}" title="{$menu.name}">{$menu.name}</a>
				</li>
			{/foreach}
          </ul>
        </nav>
        <!-- Navbar.End -->
        <div line="">
          <div line-glow=""></div>
        </div>
      </div>
    </div>
    <div class="row row-2">
      <div class="col-sm-12">
        <p class="footer-text">World of Warcraft© and Blizzard Entertainment© are all trademarks or registered trademarks of Blizzard Entertainment in the United States and/or other countries. These terms and all related materials, logos, and images are copyright© Blizzard Entertainment. This site is in no way associated with or endorsed by Blizzard Entertainment©</p>
      </div>
    </div>
    <div class="row row-3">
      <div class="col-sm-12">
        <div class="footer-copyright">{lang("Copyright", "default")} © <strong>{$serverName}</strong>
        <div>Coded by <a href="skype:darkstriders?chat">E. Darksider</a>.</div>
        </div>
        <br>
      </div>
    </div>
  </div>
</footer>
