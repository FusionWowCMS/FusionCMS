<section id="update_status">
	<div style="text-align:center;margin-top:10px;margin-bottom:10px;">
		<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
	</div>
</section>

<script type="text/javascript">
	var Status = {
		statusField: $("#update_status"),
		
		/**
		 * Refresh the realm status
		 */
		update: function()
		{
			$.get(Config.URL + "sidebox_status/status_refresh", function(data)
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