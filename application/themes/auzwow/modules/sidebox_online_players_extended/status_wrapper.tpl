<div id="update_status"><div class="loading_ajax"><img width="160" height="24" alt="{lang('global_loading', 'theme_auzwow')}" src="{$image_path}ajax.gif" /></div></div>

<script type="text/javascript">
	var Status = {
		statusField: $('#update_status'),

		/**
		 * Refresh the realm status
		 */
		update: function()
		{
			$.get(Config.URL + 'sidebox_online_players_extended/status', function(data)
			{
				Status.statusField.fadeOut(300, function()
				{
					Status.statusField.html(data);
					Status.statusField.fadeIn(300);
				})
			});
		}
	}

	Status.update();

	{if $auto_refresh}setInterval(Status.update, {$auto_refresh_interval} * 1000);{/if}
</script>