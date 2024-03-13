<section id="update_status">
    <div style="text-align:center;margin-bottom:10px;">
        <i class="fa-duotone fa-spinner fa-pulse"></i>
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
            $.get(Config.URL + "sidebox_online_players_extended/status", function(data) {
                Status.statusField.html(data);
            });
        }
    }

    Status.update();

	{if $auto_refresh}
		setInterval(Status.update, {$auto_refresh_interval} * 1000);
	{/if}
</script>
