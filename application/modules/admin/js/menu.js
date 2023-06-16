var Menu = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "link",

	/**
	 * The ID of the fusionEditor (like "#news_content"), if any, otherwise put false
	 */
	fusionEditor: false,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "admin/menu/delete/",
		create: "admin/menu/create/",
		save: "admin/menu/save/",
		move: "admin/menu/move/"
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
			title: 'Do you really want to delete this link?',
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
	add: function()
	{
		var id = this.identifier;

		if ($("#add_link").css('display') == 'none')
		{
			var div = document.getElementById('add_link');
			div.style.display = 'block';
		}
		else
		{
			var div = document.getElementById('add_link');
			div.style.display = 'none';
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

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + this.Links.create, values, function(data)
		{
			console.log(data);
			if(data == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "New link has been saved!",
				});
				window.location = Config.URL + "admin/menu";
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
	},

	/**
	 * Submit the form contents to the save link
	 * @param Object form
	 */
	save: function(form, id)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select, label").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + this.Links.save + id, values, function(data)
		{
			if(data == "yes")
			{
				window.location = Config.URL + "admin/menu";
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
	selectCustom: function()
	{
		var rows = $('<div class="" id="custom_pages"></div>');
		console.log(rows);

		for(i in customPages)
		{
		rows.append("<input class='form-check-input' type='checkbox' id='page_" + i + "' value='" + i + "'> <label for='page_" + i + "' style='margin-top: 0.15em;'>" + customPages[i].name + "</label><br>");
		}

		Swal.fire({
			title: 'Select',
			html: rows,
			showCancelButton: true,
		}).then((result) => {
		if (result.isConfirmed) {
			$("#custom_pages").children("input[type='checkbox']").each(function()
			{
				if(this.checked)
				{
					$("#link").val("page/" + customPages[this.value].identifier);
				}
			});
		}
		})
	},

	toggleRank: function(field)
	{
		if(field.value == 0)
		{
			$("#rank_field").fadeIn(300);
		}
		else
		{
			$("#rank_field").fadeOut(300);
		}
	}
}