var Accounts = {
	offset: 0,
	loadMoreCount: 10,
    logCount: 0,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		save: "admin/accounts/save/",
		loadMore: "admin/accounts/loadMoreLogs/",
	},
	
	/**
	 * Submit the form contents to the save link
	 * @param Object form
	 */
	save: function(form, id)
	{
		var values = {csrf_token_name: Config.CSRF};

		$("input, select", $(form)).each(function()
		{
			if($(this).attr("type") != "submit")
			{
				if($(this).attr("type") == "checkbox")
				{
					values[$(this).attr("name")] = this.checked;
				}
				else
				{
					values[$(this).attr("name")] = $(this).val();
				}
			}
		});

		$.post(Config.URL + this.Links.save + id, values, function(data)
		{

			if(data == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "The account has been saved!",
				});
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

	moduleState: function(arrowObj, id)
	{
		var obj = $('#'+id);
		var arrow = $('#'+arrowObj);
		if (obj.attr("style") == "display: none;")
		{
			obj.slideToggle(100);
			arrow.css("-webkit-transform", "rotate(90deg)");
			arrow.css("-moz-transform", "rotate(90deg)");
			arrow.css("-o-transform", "rotate(90deg)");
			arrow.css("-ms-transform", "rotate(90deg)");
		}
		else
		{
			obj.slideToggle(300);
			arrow.css("-webkit-transform", "rotate(0deg)");
			arrow.css("-moz-transform", "rotate(0deg)");
			arrow.css("-o-transform", "rotate(0deg)");
			arrow.css("-ms-transform", "rotate(0deg)");
		}
	},
	
	loadMore: function(id)
	{

		this.offset += this.loadMoreCount;
        this.logCount = $('#js_load_more').val();

        $("#show_more_count").remove();

		$.post(Config.URL + this.Links.loadMore + id, {offset: this.offset, count: this.loadMoreCount, show_more: this.logCount, csrf_token_name: Config.CSRF}, function(data)
		{
			$("#overview").append(data);;
		});
		$("#show_more_count").append();
	},
	
	removePendingAcc: function(id, element)
	{
		Swal.fire({
			title: 'Do you really want to delete the pending account?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
		if (result.isConfirmed) {
			$.get(Config.URL + "admin/accounts/deletePendingAcc/" + id, function(data)
			{
				console.log(data);
				if(data == "yes")
				{
					Swal.fire({
						icon: "success",
						title: "Pending account deleted!",
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
	
	activatePendingAcc: function(id, element)
	{
		Swal.fire({
			title: 'Do you really want to activate the pending account?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
		if (result.isConfirmed) {
			$.get(Config.URL + "admin/accounts/activatePendingAcc/" + id, function(data)
			{
				console.log(data);
				if(data == "yes")
				{
					console.log(data);
					Swal.fire({
						icon: "success",
						title: "Pending account activated!",
					});
					
					$(element).parents("tr").slideUp(300, function()
					{
						$(this).remove();
					});
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
}
