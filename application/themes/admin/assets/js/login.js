var Login = {
	
	send: function(form)
	{
		var values = {csrf_token_name: Config.CSRF, send:"1"};

		$(form).find("input[type='password']").each(function()
		{
			values[$(this).attr("id")] = $(this).val();
		});

		$.post(Config.URL + "admin", values, function(data)
		{
			console.log(data);
			switch(data)
			{
				case "key":
					$("#security_code").addClass("border border-danger");
				break;

				case "permission":
					$("#security_code").attr("disabled", "disabled").removeClass("border border-danger");

					alert("You do not have permission to access the admin panel (assign permission: [view, admin])");
				break;

				case "welcome":
					$("#security_code").attr("disabled", "disabled").removeClass("border border-danger");
					
					window.location.reload(true);
				break;

				default:
					// do nothing
				break;
			}
		}).fail(function(jqXHR, status, error)
		   {
				console.log(jqXHR.status);
			    if(jqXHR.status == 403)
				{
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'You are not authorized to perform that action',
					})
				}
				else if(jqXHR.status == 404)
				{
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Site not found! Please log in again',
					})
				}
				else
				{
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Something went wrong! Please reload the site',
					})
				}
		   });
	}
};

$.ajaxSetup({ beforeSend: function(jqXHR, settings) {
		if(typeof settings.data === 'object')
			settings.data.append('csrf_token_name', getCookie('csrf_cookie_name'));

		if(typeof settings.data === 'string')
			settings.data += (settings.data ? '&' : '') + 'csrf_token_name' + '=' + getCookie('csrf_cookie_name');
	} }); // adds CSRF token to posts actions, automatically

$.ajaxPrefilter(function(options) {
	if(typeof options.forceCrossDomain === 'undefined' || (typeof options.forceCrossDomain !== 'undefined' && !options.forceCrossDomain))
		options.crossDomain = false;
}); // increases the compatibility

$(document).ajaxComplete(function(event, jqXHR, settings) {
	if((settings.data && typeof settings.data === 'string' && settings.data.indexOf('csrf_token_name') >= 0 && $('input[name="' + 'csrf_token_name' + '"]').length)
		|| (settings.data && typeof settings.data === 'object' && 'csrf_token_name' in settings.data && $('input[name="' + 'csrf_token_name' + '"]').length))
		$('input[name="' + 'csrf_token_name' + '"]').val(getCookie('csrf_cookie_name'));
}); // renew CSRF field value, automatically