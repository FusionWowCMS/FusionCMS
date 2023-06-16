var Orders = {

	search: function(type)
	{
		var string = $("#search_" + type).val();
		
		$("#order_list_" + type).html('<i class="fa-solid fa-spinner fa-xl"></i>');
	
		$.post(Config.URL + "store/admin_orders/search/" + type, {string: string, csrf_token_name: Config.CSRF}, function(data)
		{
			$("#order_list_" + type).fadeOut(150, function()
			{
				$(this).html(data).slideDown(500, function()
				{
					$('[data-toggle="tooltip"]').tooltip();
				});
			});
		});	
	},

	refund: function(id, element)
	{
		Swal.fire({
				title: 'Do you really want to refund?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, refund!'
			}).then((result) => {
			if (result.isConfirmed) {
				$(element).parents("tr").slideUp(300, function()
				{
					$(this).remove();
				});

				$.get(Config.URL + "store/admin_orders/refund/" + id), function(data)
				{
					console.log(data);
				};
			}
			})
	}
}