<style type="text/css">
	#language_picker a {
		display:block;
		padding:8px;
		font-size:14px;
		transition:0.3s all;
		-webkit-transition:0.3s all;
		-moz-transition:0.3s all;
		-o-transition:0.3s all;
		-ms-transition:0.3s all;
		border-bottom:1px solid rgba(0,0,0,0.1);
		border-top:1px solid rgba(255,255,255,0.05);
		opacity:0.4;
	}

	#language_picker a:last-child { border-bottom:none; }
	
	#language_picker a:first-child { border-top:none; }

	#language_picker a img {
		margin-right:10px;
	}

	#language_picker a:hover {
		padding-left:20px;
		opacity:1;
	}

	#language_picker .current_language {
		opacity:1;
	}
</style>

<script type="text/javascript">
	function setLanguage(language, field)
	{
		$("#language_picker").fadeOut(250, function()
		{
			$(this).html('<div class="fa-2x text-center"><i class="fas fa-spinner fa-spin"></i></div>').fadeIn(250, function()
			{
				$.get(Config.URL + "sidebox_language_picker/language_picker/set/" + language, function()
				{
					window.location.reload(true);
				});
			});
		})
	}
</script>

<section id="language_picker">
	{foreach from=$languages item=language key=flag}
		<a href="javascript:void(0)" onClick="setLanguage('{$language}', this)" {if $current == $language}class="current_language"{/if}>
			<img src="{$url}application/images/flags/{$flag}.png" alt="{$flag}"> {ucfirst($language)}
		</a>
	{/foreach}
</section>