var Template = {
	save: function(id)
	{
		var data = {
			code:$("#code").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/email_template/save/" + id, data, function(response)
		{
			if(response == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "Template has been saved!",
				});
			}
			else
			{
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
				})
			}
		});
	}
}
