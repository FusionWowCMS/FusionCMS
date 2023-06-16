var Sidebox = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "sidebox",

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "admin/sidebox/delete/",
		create: "admin/sidebox/create_submit/",
		save: "admin/sidebox/save/",
		move: "admin/sidebox/move/"
	},

	/**
	 * Removes an entry from the list
	 * @param  Int id
	 * @param  Object element
	 */
	remove: function(id, element)
	{
		var identifier = this.identifier,
			removeLink = this.Links.remove;
			row = $(element).parents("tr");

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
		$("#" + identifier + "_count").html(parseInt($("#" + identifier + "_count").html()) - 1);

			row.hide(300, function() {
				row.remove();
			});

			$.get(Config.URL + removeLink + id);
		}
		})
	},

	/**
	 * Submit the form contents to the create link
	 * @param Object form
	 */
	create: function()
	{
		require([Config.URL + "application/js/tiny_mce/tinymce.min.js"], function () {
		
			tinyMCE.triggerSave();
			
			var data = {
				displayName: $("#displayName").val(),
				type: $("#type").val(),
				content: $("textarea.tinymce").val(),
				visibility: $("#visibility").val(),
				location: $("#location").val(),
				csrf_token_name: Config.CSRF
			};

			$.post(Config.URL + "admin/sidebox/create_submit", data, function(response)
			{
				if(response == "yes")
				{
					console.log(response);
					window.location = Config.URL + "admin/sidebox";
				}
				else
				{
					console.log(response);
					Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: (response),
					})
				}
			});
		
		});
	},

	/**
	 * Submit the form contents to the save link
	 * @param Object form
	 */
	save: function(form, id)
	{
		require([Config.URL + "application/js/tiny_mce/tinymce.min.js"], function () {
		
			tinyMCE.triggerSave();
			
			var data = {
				displayName: $("#displayName").val(),
				type: $("#type").val(),
				content: $("textarea.tinymce").val(),
				visibility: $("#visibility").val(),
				csrf_token_name: Config.CSRF
			};

			$.post(Config.URL + "admin/sidebox/save/" + id, data, function(response)
			{
				if(response == "yes")
				{
					window.location = Config.URL + "admin/sidebox";
				}
				else
				{
					Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
					})
				}
				console.log(response);
			});
		
		});
	},

	/**
	 * Move up/down
	 * @param String direction
	 * @param Int id
	 * @param Object element
	 */
	move: function(direction, id, element)
	{
		var row = $(element).parents("tr");
		var targetRow = (direction == "up") ? row.prev("tr") : row.next("tr");

		if(targetRow.length)
		{
			$.get(Config.URL + this.Links.move + id + "/" + direction, function(data)
			{
				console.log(data);
			});

			row.hide(300, function()
			{
				if(direction == "down")
				{
					targetRow.after(row);
				}
				else
				{
					targetRow.before(row);
				}

				row.slideDown(300);
			});
		}
	},

	/**
	 * ----------- Module specific code -----------
	 */
	toggleCustom: function(select)
	{
		if(select.value == "sidebox_custom")
		{
			$("#custom_field").fadeIn(150);
		}
		else
		{
			$("#custom_field").fadeOut(150);
		}
	}
}