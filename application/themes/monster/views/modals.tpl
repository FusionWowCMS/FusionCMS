<div id="popup_bg"></div>

<!-- confirm box -->
<div id="confirm" class="popup">
	<h1 class="popup_question" id="confirm_question"></h1>

	<div class="popup_links">
		<a href="javascript:void(0)" class="popup_button" id="confirm_button"></a>
		<a href="javascript:void(0)" class="popup_hide" id="confirm_hide" onClick="UI.hidePopup()">
			Cancel
		</a>
		<div style="clear:both;"></div>
	</div>
</div>

<!-- alert box -->
<div id="alert" class="popup">
	<h1 class="popup_message" id="alert_message"></h1>

	<div class="popup_links">
		<a href="javascript:void(0)" class="popup_button" id="alert_button">Okay</a>
		<div style="clear:both;"></div>
	</div>
</div>

{if $vote_reminder}
	<!-- Vote reminder popup -->
	<div id="vote_reminder">
		<a href="{$url}vote">
			<img src="{$vote_reminder_image}" />
		</a>
	</div>
{/if}