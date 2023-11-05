{$head}
	<body class="{$body_class}">
		{$modals}

		{* Load formatters *}
		{include file="{$T_ROOT_PATH}views{$DS}formatters{$DS}menu.tpl" scope="parent"}
		{include file="{$T_ROOT_PATH}views{$DS}formatters{$DS}sidebox.tpl" scope="parent"}

		{* Load parts *}
		{include file="{$T_ROOT_PATH}views{$DS}parts{$DS}header.tpl"}
		{include file="{$T_ROOT_PATH}views{$DS}parts{$DS}wall.tpl"}
		{include file="{$T_ROOT_PATH}views{$DS}parts{$DS}page.tpl"}
		{include file="{$T_ROOT_PATH}views{$DS}parts{$DS}footer.tpl"}
	</body>
</html>