(function($){
	'use strict';
	$(window).on('load', function () {
		if ($(".preloader").length > 0)
		{
			$(".preloader").fadeOut("slow");
		}
	});
})(jQuery);

(function($) {
	'use strict';

	var $document,
		idleTime;

	$document = $(document);

	$(function() {
		$.idleTimer( 900000 );

		$document.on( 'idle.idleTimer', function() {
			$.post(Config.URL + 'admin/destroySession', {csrf_token_name: Config.CSRF}, function(data)
			{});
			LockScreen.show();
		});
	});

}).apply(this, [jQuery]);

var Custom = {
	destroySession: function()
	{
		$.post(Config.URL + 'admin/destroySession', {csrf_token_name: Config.CSRF}, function(data)
		{});
	},
}

var Login = {
	send: function(form)
	{
		var values = {csrf_token_name: Config.CSRF, send:"1"};

		$(form).find("input[type='password']").each(function()
		{
			values[$(this).attr("id")] = $(this).val();
		});
		console.log(values);
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
					console.log(data);
					
					window.location.reload(true);
				break;

				default:
					console.log(data);
				break;
			}
		}).fail(function(e) {
			console.log(e);
		  });
	}
}