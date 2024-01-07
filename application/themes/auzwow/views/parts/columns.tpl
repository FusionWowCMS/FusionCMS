{strip}

<!-- Columns.Start -->
<div id="columns" class="columns self_clear">
	<div class="c_col countdown border_box">
		<div class="c_col-inner border_box">
			{if $theme_configs.config.countdown['enabled']}
				<div class="countdown_text vertical_center overflow_ellipsis" title="{preg_replace('/<[^>]*>/', '', langColumn($theme_configs.config.countdown.text))}">
					<em>{lang('countdown', 'theme_auzwow')}</em>
					<span>{langColumn($theme_configs.config.countdown.text)}</span>
				</div>

				<div id="countdown_timer" class="countdown_timer vertical_center">
					<span>00 <i>{lang('global_d', 'theme_auzwow')}</i></span>
					<span>00 <i>{lang('global_h', 'theme_auzwow')}</i></span>
					<span>00 <i>{lang('global_m', 'theme_auzwow')}</i></span>
				</div>
			{else}
				<div class="countdown_text wide vertical_center">
					<em>{lang('countdown_oops', 'theme_auzwow')}</em>
					<span>{lang('countdown_disabled', 'theme_auzwow')}</span>
				</div>
			{/if}
		</div>
	</div>

	<div class="c_col latestnews border_box">
		<div class="c_col-inner border_box">
			<i class="icon icon-dots"></i>

			<div class="loading_ajax border_box anti_blur">
				<div class="loading_bar_1 loading_anim vertical_center"></div>
				<div class="loading_bar_2 loading_anim vertical_center"></div>
				<div class="loading_bar_3 loading_anim vertical_center"></div>
			</div>

			<div class="rss_item border_box anti_blur"></div>
		</div>
	</div>

	<div class="c_col realmstatus border_box">
		<div class="c_col-inner border_box">
			{foreach from=$sideboxes key=key item=sidebox}
				{if $sidebox.type == 'status' || $sidebox.type == 'online_players_extended'}{$sidebox.data}{break}{/if}
				{if !isset($sideboxes[$key + 1])}<div class="realmstatus_not_found vertical_center">{lang('realmstatus_not_found', 'theme_auzwow')}</div>{/if}
			{/foreach}
		</div>
	</div>
</div>
<!-- Columns.End -->

{/strip}