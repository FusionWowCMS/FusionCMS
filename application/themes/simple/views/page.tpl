{strip}

{* Get module name *}
{$module = strtolower($CI->router->fetch_module())}

{* Layout *}
{$layout.type = "lg"}
{$layout.file = "{$theme_path}views{$DS}layouts{$DS}box.tpl"}

{* RENDER PAGE *}
{include file=$layout.file _type=$layout.type _module=$module _head=$headline _body=$content}

{/strip}