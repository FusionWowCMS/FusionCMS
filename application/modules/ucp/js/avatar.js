var Avatar = {
	Links: {
		"change": "ucp/avatar/change"
	},
	
	change: function(element) {
		element = $(element);
		
		var value = {csrf_token_name: Config.CSRF, avatar_id: element.data('avatar-id')};
		
		$.post(Config.URL + Avatar.Links.change, value, function(data)
        {
			try {
				data = JSON.parse(data);
				
				if(data['error'])
                {
					Swal.fire({
                        text: data['error'],
                        icon: 'error'
                    });
				}
				
				if(data['success'])
                {
					$('.my_avatar').removeClass('avatar_current');
					element.addClass('avatar_current');
				}
			} catch(e) {
				console.error(e);
				return;
			}
		});
	}
	
}