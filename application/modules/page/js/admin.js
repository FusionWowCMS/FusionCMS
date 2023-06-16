var Pages = {

	remove: function(id, element)
	{
		var row = $(element).parents("tr");
		Swal.fire({
		title: 'Are you sure?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		if (result.isConfirmed) {
		Swal.fire(
		'Deleted!',
		'',
		'success'
		)
			$("#page_count").html(parseInt($("#page_count").html()) - 1);

			row.hide(300, function() {
				row.remove();
			});

			$.get(Config.URL + "page/admin/delete/" + id);
		}
		})
	},

	send: function(id)
	{
		require([Config.URL + "application/js/tiny_mce/tinymce.min.js"], function () {

			tinyMCE.triggerSave();

			var data = {
				name: $("#headline").val(),
				identifier: $("#identifier").val(),
				rank_needed: $("#rank_needed").val(),
				content: $("textarea.tinymce").val(),
				visibility: $("#visibility").val(),
				csrf_token_name: Config.CSRF
			};
	
			$.post(Config.URL + "page/admin/create" + ((id) ? "/" + id : ""), data, function(response)
			{
				if(response == "yes")
				{
					window.location = Config.URL + "page/admin";
				}
				else
				{
					Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: (response),
					})
				}
			});
		});
	}
}