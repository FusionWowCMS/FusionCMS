var Languages = {

	set: function(lang)
	{
		$(lang).fadeOut(500);

		var values = {
			csrf_token_name: Config.CSRF,
			language: lang
		};

		$.post(Config.URL + "admin/languages/set/", values, function(data)
		{
			if(data == "success")
			{
				window.location.reload(true);
			}
			else
			{
				Swal.fire('', data, 'error')
			}
		});
	}
}