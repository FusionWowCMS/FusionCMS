{$head}
	<body class="{$body_class}">
		{$modals}

		{* Load formatters *}
		{include file="{$theme_path}views{$DS}formatters{$DS}menu.tpl" scope="parent"}
		{include file="{$theme_path}views{$DS}formatters{$DS}sidebox.tpl" scope="parent"}

		{* Load parts *}
		{include file="{$theme_path}views{$DS}parts{$DS}header.tpl"}
		{include file="{$theme_path}views{$DS}parts{$DS}slider.tpl"}
		{include file="{$theme_path}views{$DS}parts{$DS}content.tpl"}
		{include file="{$theme_path}views{$DS}parts{$DS}footer.tpl"}
	</body>
</html>