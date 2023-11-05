<!-- Popup background -->
<div id="popup_bg"></div>

<!-- Confirm box -->
<div id="confirm" class="popup-box type-confirm v-center" style="display:none">
	<div id="confirm_question" class="popup-content"></div>

	<div class="popup-buttons">
		<a href="javascript:void(0)" id="confirm_button" class="nice_button popup-button type-action"></a>
		<a href="javascript:void(0)" id="confirm_hide" class="nice_button popup-button type-cancel" onClick="UI.hidePopup()">{lang('general_cancel', 'theme')}</a>
	</div>
</div>

<!-- Alert box -->
<div id="alert" class="popup-box type-alert v-center" style="display:none">
	<div id="alert_message" class="popup-content"></div>

	<div class="popup-buttons">
		<a href="javascript:void(0)" id="alert_button" class="nice_button popup-button type-okay">{lang('general_okay', 'theme')}</a>
	</div>
</div>

{if $vote_reminder}
	<!-- Vote reminder popup -->
	<div id="vote_reminder">
		<a href="{$url}vote"><img width="" height="" alt="" src="{$vote_reminder_image}" /></a>
	</div>
{/if}