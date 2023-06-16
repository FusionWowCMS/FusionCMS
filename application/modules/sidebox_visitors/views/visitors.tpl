<script type="text/javascript">
	var Visitors = {

		show: function(link)
		{
			$(link).parent().fadeOut(100);
			$("#all_visitors").html('<i class="fas fa-spinner fa-pulse"></i>').show();

			$.get(Config.URL + "sidebox_visitors/visitors/getAll", function(data)
			{
				$("#all_visitors").fadeOut(100, function()
				{
					$(this).html(data).fadeIn(100);
				});
			});
		}
	}
</script>

{$there_are} <b>{$count}</b> {$word} {lang("online", "sidebox_visitors")} <span>(<a href="javascript:void(0)" onClick="Visitors.show(this)">{lang("who", "sidebox_visitors")}</a>)</span>
<div id="all_visitors" style="margin-top:10px;display:none;"></div>