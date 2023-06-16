var UI = {

	/**
	 * Initialize the admin panel
	 */
	initialize: function()
	{
		this.Tooltip.initialize();
	},

	Tooltip: {

		/**
		 * Add event-listeners
		 */
		initialize: function()
		{
			// Add the tooltip element
			$("body").prepend('<div id="tooltip"></div>');

			// Add mouse-over event listeners
			this.addEvents();

			// Add mouse listener
			$(document).mousemove(function(e)
			{
				UI.Tooltip.move(e.pageX, e.pageY);
			});
		},

		/**
		 * Used to support Ajax content
		 * Reloads the tooltip elements
		 */
		refresh: function()
		{
			// Remove all
			$("[data-tip]").unbind('hover');

			// Re-add
			this.addEvents();
		},

		addEvents: function()
		{
			// Add mouse-over event listeners
			$("[data-tip]").hover(
				function()
				{
					UI.Tooltip.show($(this).attr("data-tip"));
				},
				function()
				{
					$("#tooltip").hide();
				}
			);
		},

		/**
		 * Moves tooltip
		 * @param Int x
		 * @param Int y
		 */
		move: function(x, y)
		{
			// Get half of the width
			var width = ($("#tooltip").css("width").replace("px", "") / 2);

			// Position it at the mouse, and center
			$("#tooltip").css("left", x - width).css("top", y + 25);
		},

		/**
		 * Displays the tooltip
		 * @param Object element
		 */
		show: function(data)
		{
			$("#tooltip").html(data).show();
		}
	}
}