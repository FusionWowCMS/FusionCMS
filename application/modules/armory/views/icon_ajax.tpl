<span class="get_icon_{$id}">
	<i class="fas fa-spinner fa-sm fa-spin"></i>
</span>

<script type="text/javascript">
	$(document).ready(function()
	{
		$.get(Config.URL + "icon/get/" + {$realm} + "/" + {$id}, function(data)
	 	{
	 		$(".get_icon_" + {$id}).each(function()
	 		{
	 			$(this).html("<img src='https://icons.wowdb.com/retail/small/" + data + ".jpg' align='absmiddle'/>");
	 		});
	 	});
	});
</script>