<span class="get_icon_{$id}">
	<div class="item">
		<a></a>
		<div class="text-center fa-2x" style="height:56px; width:56px;">
			<i class="fas fa-spinner fa-spin align-middle"></i>
		</div>
	</div>
</span>

<script type="text/javascript">
	function Interval{$id}()
	{
		if(typeof Character != "undefined")
		{
			Character.getIcon({$id}, {$realm});
		}
		else
		{
			setTimeout(Interval{$id}, 100);
		}
	}

	$(document).ready(function()
	{
		Interval{$id}();
	});
</script>