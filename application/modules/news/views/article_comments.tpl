<div class="comments_area" {$comments_id}>
	{$comments}
</div>

{if hasPermission("canAddComment") && $CI->user->isOnline()}
<div class="post-block post-leave-comment">
<form {$form}>
<div class="p-2">
<div class="row">
	<div class="form-group col">
	{if $online}
		<textarea data-msg-required="Please enter your message." spellcheck="false" {$field_id} placeholder="{lang("type_comment", "news")}" onkeyup="UI.limitCharacters(this, 'characters_remaining_{$id}')" maxlength="255" required></textarea>
		<div class="text-end"><span id="characters_remaining_{$id}">0 / 255</span> {lang("characters", "news")}</div>
		<input class="nice_button" type="submit" value="{lang("submit", "news")}" id="comment_button_{$id}" />
	{else}
		<textarea disabled placeholder="{lang("log_in", "news")}"></textarea>
		<input class="nice_button" type="submit" value="{lang("submit", "news")}"/>
	{/if}
	</div>
</div>
</form>
</div>
{/if}