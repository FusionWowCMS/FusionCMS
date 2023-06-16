var Donate = {
    offset: 0,
	loadMoreCount: 10,
    logCount: 0,
    logid: 0,
	
	search: function(type)
	{
		var string = $("#search_" + type).val();
		
		$("#donate_list_" + type).html('<i class="fa-solid fa-spinner fa-xl fa-spin"></i>');
	
		$.post(Config.URL + "donate/admin/search/" + type, {string: string, csrf_token_name: Config.CSRF}, function(data)
		{
			$("#donate_list_" + type).fadeOut(150, function()
			{
				$(this).html(data).slideDown(500, function()
				{
					$('[data-toggle="tooltip"]').tooltip();
				});
			});
		});	
	},

	give: function(id, field)
	{
		$("tr#paypal_id_"+ id +" td.paypal_valide").html("Manually compl.");

		$(field).parent().remove();

		$.get(Config.URL + "donate/admin/give/" + id, function(data)
		{
			console.log(data);
		});
	},

    addValue: function()
	{
		Swal.fire({
			title: 'Add value',
			html: '<input type="text" id="price" class="swal2-input" placeholder="Price" value=""><br><input id="points" class="swal2-input" placeholder="Points" value="">',
		}).then(function(result) {
		if (result.isConfirmed)
        {
			var price = $("#price").val();
			var points = $("#points").val();

			$.post(Config.URL + "donate/admin/save", {price: price, points: points, csrf_token_name: Config.CSRF}, function(data)
			{
				if($.isNumeric(data))
				{
                    var id = data;

					Swal.fire({
						icon: "success",
						title: 'Value added',
					});

                    $("#value_list").last().append('<tr data-id='+id+'>' +
                                                   '<th>'+price+'</th>' +
                                                   '<td>'+points+'</td>' +
                                                   '<td class="text-center">' +
                                                   '<a href="javascript:void(0)" class="btn btn-primary btn-sm" onClick="Donate.updateValue('+id+', this); return false">Edit</a> ' +
                                                   '<a href="javascript:void(0)" class="btn btn-primary btn-sm" onClick="Donate.deleteValue('+id+', this); return false">Delete</a>' +
                                                   '</td>' +
                                                   '</tr>');
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

    updateValue: function(id, price, points)
	{
        console.log(price);

		Swal.fire({
			title: 'Update value',
			html: '<input type="text" id="price" class="swal2-input" placeholder="Price" value="' + price + '"><br><input id="points" class="swal2-input" placeholder="Points" value="' + points + '">',
		}).then(function(result) {
		if (result.isConfirmed)
        {
            var price = $("#price").val();
			var points = $("#points").val();

			$.post(Config.URL + "donate/admin/save/" + id, {price: price, points: points, csrf_token_name: Config.CSRF}, function(data)
			{
				if(data == '1')
				{
                    window.location = Config.URL + "donate/admin/settings";
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
    
    deleteValue: function(id, element)
	{
		Swal.fire({
			title: 'Do you really want to delete this value?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		if (result.isConfirmed)
        {
			$(element).parents("tr").slideUp(300, function()
			{
				$(this).remove();
			});

			$.get(Config.URL + "donate/admin/deleteValue/" + id, function(data)
			{
				console.log(data);
			});
		}
		})
	},
    
    loadMore: function()
	{
		this.logid++;

		this.offset += this.loadMoreCount;
        this.logCount = $('#js_load_more').val();

        // Hide the load more
        $("#show_more_count").remove();

        // Show ajax loading here

        // Do the post request.
		$.post(Config.URL + "donate/admin/loadMoreLogs", {offset: this.offset, count: this.loadMoreCount, show_more: this.logCount, csrf_token_name: Config.CSRF}, function(data)
		{
			data = "<div id='new_logs_" + Donate.logid + "'>" + data + "</div>";

			$("#donate_list_paypal").append(data);

			$("#new_logs_" + Donate.logid).fadeIn(300, function()
			{
				$('[data-toggle="tooltip"]').tooltip();
			});
		});
	}
};