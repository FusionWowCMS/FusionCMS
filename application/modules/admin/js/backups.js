var Backups = {
	generate: function(element)
	{
		Swal.fire({
			title: 'Do you really want to generate a backup?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
		if (result.isConfirmed) {

			$.get(Config.URL + "admin/backups/do_backup/", function(data)
			{
				console.log(data);
				if(data == "yes")
				{
					Swal.fire({
						icon: "success",
						title: "Backup generated!",
					});
					window.location = Config.URL + "admin/backups";
				}
				else
				{
					console.log(data);
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: data,
					})
				}
			});
		}
		})
	},
	
	saveSettings: function()
	{
		var data = {
			auto_backups:$("#auto_backups").val(),
			backups_interval:$("#backups_interval").val(),
			backups_time:$("#backups_time").val(),
			backups_max_keep:$("#backups_max_keep").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/backups/saveSettings", data, function(response)
		{
			if(response == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "Backup settings have been saved!",
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
	},
	
	remove: function(id, element)
	{
		Swal.fire({
			title: 'Do you really want to delete the backup?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
		if (result.isConfirmed) {
			$.get(Config.URL + "admin/backups/delete/" + id, function(data)
			{
				console.log(data);
				if(data == "yes")
				{
					Swal.fire({
						icon: "success",
						title: "Backup deleted!",
					});
					
					$(element).parents("tr").slideUp(300, function()
					{
						$(this).remove();
					});
				}
				else
				{
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: data,
					})
				}
			});
		}
		})
	},
	
	restore: function(id)
	{
		Swal.fire({
			title: 'Do you really want to restore the backup?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
		if (result.isConfirmed) {
			$.get(Config.URL + "admin/backups/restore/" + id, function(data)
			{
				console.log(data);
				if(data == "yes")
				{
					Swal.fire({
						icon: "success",
						title: "Backup imported!",
					});
				}
				else
				{
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: data,
					})
				}
			});
		}
		})
	},
}
