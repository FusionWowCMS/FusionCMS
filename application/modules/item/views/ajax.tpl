<script type="text/javascript">
	$(document).ready(function()
	{
		$('.item_bg').html('{lang('loading', 'item')}');
		
		$.get(Config.URL + "tooltip/" + {$realm} + "/" + {$id}, function(data)
	 	{
	 		$(".item_bg").html(data);
	 	});
	});
</script>