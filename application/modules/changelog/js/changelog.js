var Changelog = {

	addChange: function()
	{
		var changeTypeId = $("#changelog_types").val();
		var changeText = $("#change_text").val();

		if(changeText.length > 0)
		{
			$.post(Config.URL + "changelog/addChange", {change:changeText, category: changeTypeId, csrf_token_name: Config.CSRF}, function(id)
			{
				window.location.reload();
			});
		}
	}
}