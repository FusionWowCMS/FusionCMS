var Theme = {
	
	count: false,

	initialize: function()
	{
		Theme.count = $("#theme_overflow a").length;
	},

	scroll: function(to)
	{
		// Arrays start on 0 - CSS selctors don't.
		to = to + 1;

		if(Theme.count == false)
		{
			Theme.initialize();
		}

		var margin = -(248 * (to - 2)) - 25;

		$("#theme_overflow").css({marginLeft:margin});
		$("#theme_overflow img:not(:nth-child(" + to + "))").transition({scale:0.85,opacity:0.7,perspective:'233px',rotateY: '0deg'}, 500);
		$("#theme_overflow img:nth-child(" + to + ")").transition({scale:1,opacity:1,perspective:'233px',rotateY: '10deg'}, 500);

		$(".active_theme").removeClass("active_theme");
		$("#theme_" + (to - 1)).addClass("active_theme");
	},

	select: function(name)
	{
			Swal.fire({
			  title: 'Do you want to change the theme to "'+ name +'"?',
			  showDenyButton: true,
			  showCancelButton: false,
			  confirmButtonText: 'Change',
			  denyButtonText: `Don't change`,
			  icon: 'question'
			}).then((result) => {
				if (result.isConfirmed) {
					$.get(Config.URL + "admin/theme/set/" + name, function(data) {
						if(data == "yes") {
							Swal.fire({
							  title: 'Theme was saved!',
							  showDenyButton: false,
							  showCancelButton: false,
							  confirmButtonText: 'OK',
							  icon: 'success'
							}).then((result) => {
								//Remove dsiabled from all button and set text to enabled
								$("#all_themes .theme_action button").removeAttr("disabled");
								$("#all_themes .theme_action button").text("Enable");
								
								//Add to button disabled state and current Text
								$("#btn-"+ name).attr("disabled", "true");
								$("#btn-"+ name).text("Current");
							});
						} else {
							Swal.fire(data, '', 'info');
						}
					});
				}
			})
	}
}