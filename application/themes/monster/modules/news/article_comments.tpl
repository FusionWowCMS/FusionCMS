<div class="divider"></div>

<div class="comments_area" {$comments_id}>
	{$comments}
</div>

{if hasPermission("canAddComment")}
<form {$form}>
	{if $online}
		<textarea spellcheck="false" {$field_id} placeholder="{lang("type_comment", "news")}" onkeyup="UI.limitCharacters(this, 'characters_remaining_{$id}')" maxlength="255"></textarea>
		<div class="characters_remaining"><span id="characters_remaining_{$id}">0 / 255</span> {lang("characters", "news")}</div>
		<input type="submit" value="{lang("submit", "news")}" id="comment_button_{$id}" />
	{else}
		<textarea disabled placeholder="{lang("log_in", "news")}"></textarea>
		<input type="submit" value="{lang("submit", "news")}"/>
	{/if}
</form>
{/if}

<div class="clear"></div>