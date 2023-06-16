var Groups = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "groups",

	/**
	 * The ID of the fusionEditor (like "#news_content"), if any, otherwise put false
	 */
	fusionEditor: false,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "admin/aclmanager/groupDelete/",
		create: "admin/aclmanager/groupCreate/",
		save: "admin/aclmanager/groupSave/",
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
			title: 'Do you really want to delete this group?',
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
			if($(this).attr("type") != "submit" && $(this).attr("type") != "checkbox")
			{
				values[$(this).attr("name")] = $(this).val();
			}
			else if($(this).attr("type") == "checkbox")
			{
				values[$(this).attr("name")] = this.checked;
			}
		});

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + this.Links.create, values, function(data)
		{
			console.log(data);
			if(data == '1')
			{
				window.location.reload(true);
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
	 * Submit the form contents to the save link
	 * @param Object form
	 */
	save: function(form, id)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select").each(function()
		{
			if($(this).attr("type") != "submit" && $(this).attr("type") != "checkbox")
			{
				values[$(this).attr("name")] = $(this).val();
			}
			else if($(this).attr("type") == "checkbox")
			{
				values[$(this).attr("name")] = this.checked;
			}
		});

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + this.Links.save + id, values, function(data)
		{
			console.log(data);
			if(data == '1')
			{
				Swal.fire({
					icon: "success",
					title: "The group has been saved!",
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
	},

	removeAccount: function(name, field, groupId, isYourself)
	{
		var proceed = function()
		{
			$(field).transition({rotateX: '90deg', opacity:0 }, 500, function()
			{
				$(this).hide();
			});

			if(name)
			{
				var data = {
					name: name,
					groupId: groupId,
					csrf_token_name: Config.CSRF
				};

				$.post(Config.URL + "admin/aclmanager/removeMember", data);
			}
		};

		if(isYourself)
		{
			Swal.fire({
			title: 'Are you sure you want to remove yourself from this group?',
			text: "You may revoke your admin panel access by doing so.",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, remove me!'
		}).then((result) => {
		if (result.isConfirmed) {
			proceed();
		}
		})
		}
		else
		{
			proceed();
		}
		
	},

	addAccount: function(field, groupId)
	{
		field = $(field);
		
		Swal.fire({
			title: 'Add member',
			html: '<input class="swal2-input" type="text" id="add_member_name" placeholder="Enter username..." autofocus>',
		}).then(function(result) {
		if (result.isConfirmed) {
			var name = $("#add_member_name").val();

			var newItem = $('<a class="btn btn-danger btn-sm" href="javascript:void(0)" onClick="Groups.removeAccount(\'' + name + '\', this, ' + groupId + ')">\
								' + name + '\
							</a>');

			newItem.transition({rotateX: '90deg', opacity:0 }, 0);
			newItem.insertBefore(field);
			newItem.transition({rotateX: '0deg', opacity:1 }, 500);

			var data = {
				name: name,
				groupId: groupId,
				csrf_token_name: Config.CSRF
			};

			$.post(Config.URL + "admin/aclmanager/addMember/" + groupId, data, function(response)
			{
				if(response == "invalid")
				{
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: "The account doesn't exist",
					})
					Groups.removeAccount(false, newItem);
				}
			});
		}
		})
	}
}