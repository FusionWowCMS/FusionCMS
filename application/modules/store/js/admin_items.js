var Items = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "item",

	/**
	 * The ID of the fusionEditor (like "#news_content"), if any, otherwise put false
	 */
	fusionEditor: false,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "store/admin_items/delete/",
		create: "store/admin_items/createItem/",
		createGroup: "store/admin_items/createGroup/",
		save: "store/admin_items/save/"
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
			title: 'Do you really want to delete this "' + identifier + '"?',
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

	removeGroup: function(id, element)
	{
		Swal.fire({
			title: 'Do you really want to delete this group and all of it\'s items?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		if (result.isConfirmed) {
			$.get(Config.URL + "store/admin_items/deleteGroup/" + id, function(data)
			{
				console.log(data);
				window.location.reload(true);
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

	addGroup: function()
	{
		var id = this.identifier;

		if($("#add_group").is(":visible"))
		{
			$("#add_group").fadeOut(150, function()
			{
				$("#main_" + id).fadeIn(150);
			});
		}
		else
		{
			$("#main_" + id).fadeOut(150, function()
			{
				$("#add_group").fadeIn(150);
			});
		}
	},

	/**
	 * Submit the form contents to the create link
	 * @param Object form
	 */
	create: function(form, isGroup)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select, textarea").each(function()
		{
			if($(this).attr("type") == "checkbox")
			{
				values[$(this).attr("name")] = this.checked;
			}
			else if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + ((isGroup)?this.Links.createGroup:this.Links.create), values, function(data)
		{
			if(data == "yes")
			{
				window.location = Config.URL + "store/admin_items";
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

		$(form).find("input, select, textarea").each(function()
		{
			if($(this).attr("type") == "checkbox")
			{
				values[$(this).attr("name")] = this.checked;
			}
			else if($(this).attr("type") != "submit")
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
				window.location = Config.URL + "store/admin_items";
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

	groupActions: function()
	{
		if(typeof formType != "undefined")
		{
			Items.formType = formType;
		}
		
		$(".item_group").each(function()
		{
			$(this).hover(
				function()
				{
					$(this).find(".group_title").hide(0, function()
					{
						$(this).siblings(".group_order").hide(0);
						$(this).siblings(".group_actions").show(0);
					});
				},
				function()
				{
					$(this).find(".group_actions").hide(0, function()
					{
						$(this).siblings(".group_order").show(0);
						$(this).siblings(".group_title").show(0);					
					});
				}
			);
		});
	},

	editGroup: function(id)
	{
		var data = {
			title:$("#title").val(),
			order:$("#order").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "store/admin_items/saveGroup/" + id, data, function(response)
		{
			if(response == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "Group has been changed!",
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

	formType: "item",
	
	fadeFormIn: function(name)
	{
		Items.formType = name;

		$("#" + name + "_form").fadeIn(300);
	},

	changeType: function(select)
	{
		switch(select.value)
		{
			case "item":
				if($("#query_form").is(":visible"))
				{
					$("#query_form").fadeOut(300, this.fadeFormIn("item"));
				}
				else if($("#command_form").is(":visible"))
				{
					$("#command_form").fadeOut(300, this.fadeFormIn("item"));
				}
			break;

			case "command":
				if($("#query_form").is(":visible"))
				{
					$("#query_form").fadeOut(300, this.fadeFormIn("command"));
				}
				else if($("#item_form").is(":visible"))
				{
					$("#item_form").fadeOut(300, this.fadeFormIn("command"));
				}
			break;

			case "query":
				if($("#item_form").is(":visible"))
				{
					$("#item_form").fadeOut(300, this.fadeFormIn("query"));
				}
				else if($("#command_form").is(":visible"))
				{
					$("#command_form").fadeOut(300, this.fadeFormIn("query"));
				}
			break;
		}
	}
}

$(document).ready(Items.groupActions);