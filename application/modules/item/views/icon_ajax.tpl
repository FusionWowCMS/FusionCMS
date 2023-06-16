<span class="get_icon_{$id}">
	<div class='item'>
		<a></a>
		<div class="text-center fa-2x" style="height:56px; width:56px;">
			<i class="fas fa-spinner fa-spin align-middle"></i>
		</div>
	</div>
</span>

<script type="text/javascript">
	$(document).ready(function()
	{
		$.get(Config.URL + "icon/get/" + {$realm} + "/" + {$id}, function(data)
	 	{
	 		$(".get_icon_" + {$id}).each(function()
	 		{
	 			$(this).html("<div class='item'><a></a><img src='https://icons.wowdb.com/retail/large/" + data + ".jpg' /></div>");
	 		});
	 	});
	});
</script>