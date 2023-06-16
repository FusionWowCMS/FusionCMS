var Teleport = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "teleport",

	/**
	 * The ID of the fusionEditor (like "#news_content"), if any, otherwise put false
	 */
	fusionEditor: false,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "teleport/admin/delete/",
		create: "teleport/admin/create/",
		save: "teleport/admin/save/",
		move: "teleport/admin/move/"
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
			title: 'Do you really want to delete this location?',
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
	 * Submit the form contents to the create link
	 * @param Object form
	 */
	create: function(form)
	{
		var values = {
			name:$("#name").val(),
			description:$("#description").val(),
			x:$("#x").val(),
			y:$("#y").val(),
			z:$("#z").val(),
			orientation:$("#orientation").val(),
			mapId:$("#mapId").val(),
			vpCost:$("#vpCost").val(),
			dpCost:$("#dpCost").val(),
			goldCost:$("#goldCost").val(),
			realm:$("#realm").val(),
			required_faction:$("#required_faction").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + this.Links.create, values, function(response)
		{
			if(response == "yes")
			{
				window.location = Config.URL + "teleport/admin";
			}
			else
			{
				console.log(values);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
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
		var values = {
			name:$("#name").val(),
			description:$("#description").val(),
			x:$("#x").val(),
			y:$("#y").val(),
			z:$("#z").val(),
			orientation:$("#orientation").val(),
			mapId:$("#mapId").val(),
			vpCost:$("#vpCost").val(),
			dpCost:$("#dpCost").val(),
			goldCost:$("#goldCost").val(),
			realm:$("#realm").val(),
			required_faction:$("#required_faction").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + this.Links.save + id, values, function(response)
		{
			if(response == "yes")
			{
				window.location = Config.URL + "teleport/admin";
			}
			else
			{
				console.log(values);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
				})
			}
		});
	},

	/**
	 * ----------- Module specific code -----------
	 */
	changePrice: function(select)
	{
		$("#vpCost").val("0");
		$("#dpCost").val("0");
		$("#goldCost").val("0");
				
		switch(select.value)
		{
			case "free":
				$("#vp_price").fadeOut(300);
				$("#dp_price").fadeOut(300);
				$("#gold_price").fadeOut(300);
			break;


			case "vp":
				if($("#gold_price").is(":visible"))
				{
					$("#gold_price").fadeOut(300, function()
					{
						$("#vp_price").fadeIn(300);
					});
				}
				else
				{
					$("#dp_price").fadeOut(300, function()
					{
						$("#vp_price").fadeIn(300);
					});
				}
			break;

			case "dp":
				if($("#gold_price").is(":visible"))
				{
					$("#gold_price").fadeOut(300, function()
					{
						$("#dp_price").fadeIn(300);
					});
				}
				else
				{
					$("#vp_price").fadeOut(300, function()
					{
						$("#dp_price").fadeIn(300);
					});
				}
			break;

			case "gold":
				if($("#vp_price").is(":visible"))
				{
					$("#vp_price").fadeOut(300, function()
					{
						$("#gold_price").fadeIn(300);
					});
				}
				else
				{
					$("#dp_price").fadeOut(300, function()
					{
						$("#gold_price").fadeIn(300);
					});
				}
			break;
		}
	}
}