{$head}
	<body class="{$body_class}">
		{include file="{$theme_path}views/parts/mobile/menu.tpl"}

		<div id="my-page">
			{$modals}

			{include file="{$theme_path}views/parts/topbar.tpl"}

			{include file="{$theme_path}views/parts/header.tpl"}

			{include file="{$theme_path}views/parts/slider.tpl"}

			{include file="{$theme_path}views/parts/content.tpl"}

			{include file="{$theme_path}views/parts/footer.tpl"}
		</div>
	</body>
</html>