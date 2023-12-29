var Vote = {
	
	/**
	 * Opens the link and changes the vote now button
	 */
	open: function(id, time)
	{
		$.post(Config.URL + "vote/site/", { id: id, csrf_token_name: Config.CSRF, isFirefox: navigator.userAgent.toLowerCase().indexOf('firefox') > -1 || isIE }, function(response)
		{
			window.open(response);
		});
		
		// Change the "vote now" button
		$("#vote_field_" + id).parents(".card").addClass("card-disabled");
		$("#vote_field_" + id).html('<div class="h4">'+ time +''+ lang("hours_remaining", "vote") +'</div>');
		
		return false;
	}
}

$(document).ready(function()
{
	if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1 || isIE)
	{
		setTimeout(function()
		{
			$(".firefox").fadeIn(1000);
		}, 1000);
	}
});
