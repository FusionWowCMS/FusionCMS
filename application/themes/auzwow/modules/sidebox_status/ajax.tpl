<div id="update_status"><div class="loading_ajax"><img width="160" height="24" alt="{lang('global_loading', 'theme_auzwow')}" src="{$image_path}ajax.gif" /></div></div>

<script type="text/javascript">
	var Status = {
		statusField: $('#update_status'),

		/**
		 * Refresh the realm status
		 */
		update: function()
		{
			$.get(Config.URL + 'sidebox_status/status_refresh', function(data)
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
</script>