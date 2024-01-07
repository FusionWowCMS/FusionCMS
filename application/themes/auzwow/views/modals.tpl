{strip}

<div id="popup_bg"></div>

<!-- confirm box -->
<div id="confirm" class="confirm_box vertical_center">
	<div id="confirm_question" class="confirm_question popup_question"></div>

	<div class="popup_links">
		<a href="javascript:void(0)" id="confirm_button" class="nice_button confirm_button"></a>
		<a href="javascript:void(0)" id="confirm_hide" class="nice_button confirm_hide" onClick="UI.hidePopup()">{lang('global_cancel', 'theme_auzwow')}</a>
	</div>
</div>

<!-- alert box -->
<div id="alert" class="alert_box vertical_center">
	<div id="alert_message" class="alert_message"></div>

	<div class="popup_links">
		<a href="javascript:void(0)" id="alert_button" class="nice_button alert_button">{lang('global_okay', 'theme_auzwow')}</a>
	</div>
</div>

{if $vote_reminder}
	<!-- Vote reminder popup -->
	<div id="vote_reminder"><a href="{$url}vote"><img src="{$vote_reminder_image}" /></a></div>
{/if}

{/strip}