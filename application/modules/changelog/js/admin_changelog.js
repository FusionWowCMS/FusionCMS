var Changelog = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "changelog",

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "changelog/admin/delete/",
		removeCategory: "changelog/admin/deleteCategory/",
		create: "changelog/admin/create/",
		save: "changelog/admin/save/",
		saveCategory: "changelog/admin/saveCategory/",
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

		Swal.fire({
				title: 'Do you really want to delete this ' + identifier + '?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			if (result.isConfirmed) {
				$("#" + identifier + "_count").html(parseInt($("#" + identifier + "_count").html()) - 1);

				$(element).parents("tr").slideUp(300, function()
				{
					$(this).remove();
				});

				$.get(Config.URL + removeLink + id, function(data)
				{
					console.log(data);
				});
			}
			})
	},

	/**
	 * Toggle between the "add" form and the list
	 */
	add: function(categoryId)
	{
		var id = this.identifier;

		if($("#add_" + id).is(":visible"))
		{
			$("#add_" + id).fadeOut(150, function()
			{
				$("#main_" + id).fadeIn(150);
			});
		}
		else
		{
			$("#main_" + id).fadeOut(150, function()
			{
				$("#add_" + id).fadeIn(150);
			});
		}
	},

	/**
	 * Submit the form contents to the create link
	 * @param Object form
	 */
	create: function(form)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		$.post(Config.URL + this.Links.create, values, function()
		{
			window.location.reload(true);
		});
	},

	/**
	 * Submit the form contents to the save link
	 * @param Object form
	 */
	save: function(form, id)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, textarea, select").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		$.post(Config.URL + this.Links.save + id, values, function(data)
		{
			window.location = Config.URL + "changelog/admin";
		});
	},

	/**
	 * ----------- Module specific code -----------
	 */
	addChange: function(id)
	{
		(async () => {
		const { value: text } = await Swal.fire({
		input: 'textarea',
		inputLabel: 'Message',
		inputPlaceholder: 'Changelog message...',
		inputAttributes: {
			'aria-label': 'Changelog message...'
		},
		showCancelButton: true
		})
		if (text) {
			$.post(Config.URL + "changelog/admin/addChange/" + id, {csrf_token_name:Config.CSRF, change_message:text}, function(data)
			{
				data = JSON.parse(data);
				console.log(data);
				$("#headline_" + id).after('<table class="table table-responsive-md">' +
							'<tr>' +
								'<td>' + data.changelog +'</td>' +
								'<td>' + data.author + '</td>' +
								'<td>' + data.date + '</td>' +
								'<td style="text-align:center;">' +
									'<a class="btn btn-primary btn-sm" href="' + Config.URL + 'changelog/admin/edit/' + data.id + '" data-tip="Edit"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;'+
									'<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Changelog.remove(' + data.id + ', this)" data-tip="Delete"><i class="fa-solid fa-trash-can"></i></a>'+
								'</td>' +
							'</tr>' +
						'</table>');
				$("#headline_" + id).next().slideDown(300);
			});
		}
		})()
	},

	/**
	 * Removes a category
	 * @param  Int id
	 * @param  Object element
	 */
	removeCategory: function(id, element)
	{
		var identifier = this.identifier,
			removeLink = this.Links.removeCategory;
		var entries = $(element).parents("tr").children("tr").length - 1;

			Swal.fire({
				title: 'Do you really want to delete this category and all it\'s entries?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			if (result.isConfirmed) {
				$("#" + identifier + "_count").html(parseInt($("#" + identifier + "_count").html()) - entries);

				$(element).parents("tr").slideUp(300, function()
				{
					$(this).remove();
				});

				$.get(Config.URL + removeLink + id, function(data)
				{
					console.log(data);
				});
			}
			})
	},

	renameCategory: function(id, field)
	{
		var nameField = $(field).parents("td").prev("td").children("b");
		var renameHTML = '<input type="text" id="rename" value="' + nameField.html() + '">';

		Swal.fire({
			title: 'Rename category',
			html: renameHTML,
			focusConfirm: false,
			}).then((result) => {
				var name = $("#rename").val();
				nameField.html(name);

				$.post(Config.URL + Changelog.Links.saveCategory + id, {csrf_token_name:Config.CSRF, typeName:name});
					Swal.fire({
					icon: 'success',
					title: 'Category saved!',
				})
			})
	}
}