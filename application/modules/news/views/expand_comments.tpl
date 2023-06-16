{if $article.comments != -1}
	<script type="text/javascript">
		$(document).ready(function()
		{
			function checkIfLoaded()
			{
				if(typeof Ajax != "undefined")
				{
					Ajax.showComments({$article.id});
				}
				else
				{
					setTimeout(checkIfLoaded, 50);
				}
			}

			checkIfLoaded();
		});
	</script>
{/if}