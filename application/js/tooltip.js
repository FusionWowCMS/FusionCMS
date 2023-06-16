/**
 * Tooltip related functions
 */
function Tooltip()
{
	this.tooltip_element = "fusion_tooltip";
	/**
	 * Add event-listeners
	 */
	this.initialize = function()
	{
		// Add the tooltip element
		$("body").prepend('<div id="'+ Tooltip.tooltip_element +'" style="display:none;"></div>');

		// Add mouse-over event listeners
		this.addEvents();
	}

	/**
	 * Used to support Ajax content
	 * Reloads the tooltip elements
	 */
	this.refresh = function()
	{
		// Remove all
		$("[data-tip]").unbind('hover');

		// Re-add
		this.addEvents();
	}
	
	/**
	 * Adds mouseover events to all elements
	 * that should show a tooltip.
	 */
	this.addEvents = function()
	{
		Tooltip.addEvents.handleMouseMove = function(e)
		{
			Tooltip.move(e.pageX, e.pageY);
		}
		
		// Add mouse-over event listeners
		$("[data-tip]").hover(
			function()
			{
				$(document).bind('mousemove', Tooltip.addEvents.handleMouseMove);
				Tooltip.show($(this).attr("data-tip"));
			},
			function()
			{
				$("#"+ Tooltip.tooltip_element).hide();
				$(document).unbind('mousemove', Tooltip.addEvents.handleMouseMove);
			}
		);

		if(Config.UseFusionTooltip)
		{
			$("[rel]").hover(
				function()
				{
					$(document).bind('mousemove', Tooltip.addEvents.handleMouseMove);
					if(/^item=[0-9]*$/.test($(this).attr("rel")))
					{
						Tooltip.Item.get(this, function(data)
						{
							Tooltip.show(data);
						});
					}
				},
				function()
				{
					$(document).unbind('mousemove', Tooltip.addEvents.handleMouseMove);
					$("#"+ Tooltip.tooltip_element).hide();
				}
			);
		}
	}

	/**
	 * Moves tooltip
	 * @param Int x
	 * @param Int y
	 */
	this.move = function(x, y)
	{
		// Get half of the width
		var width = ($("#"+ Tooltip.tooltip_element).css("width").replace("px", "") / 2);

		// Position it at the mouse, and center
		$("#"+ Tooltip.tooltip_element).css("left", x - width).css("top", y + 25);
	}

	/**
	 * Displays the tooltip
	 * @param Object element
	 */
	this.show = function(data)
	{
		$("#"+ Tooltip.tooltip_element).html(data).show();
	}

	/**
	 * Item tooltip object
	 */
	 this.Item = new function()
	 {
	 	/**
	 	 * Loading HTML
	 	 */
	 	this.loading = "Loading...";

	 	/**
	 	 * Runtime cache
	 	 */
	 	this.cache = new Array();

	 	/**
	 	 * The currently displayed item ID
	 	 */
	 	this.currentId = false;

	 	/**
	 	 * Load an item and display it in the tooltip
	 	 * @param Object element
	 	 * @param Function callback
	 	 */
	 	this.get = function(element, callback)
	 	{
	 		var obj = $(element);
	 		var realm = obj.attr("data-realm");
	 		var id = obj.attr("rel").replace("item=", "");
	 		Tooltip.Item.currentId = id;

	 		if(id in this.cache)
	 		{
	 			callback(this.cache[id])
	 		}
	 		else
	 		{
	 			var cache = Tooltip.Item.CacheObj.get("item_" + realm + "_" + id + "_" + Config.language);

		 		if(cache !== false)
		 		{
		 			callback(cache);
		 		}
		 		else
		 		{
		 			callback(this.loading);

			 		$.get(Config.URL + "tooltip/" + realm + "/" + id, function(data)
			 		{
			 			// Cache it this visit
			 			Tooltip.Item.cache[id] = data;
			 			Tooltip.Item.CacheObj.save("item_" + realm + "_" + id  + "_" + Config.language, data);

			 			// Make sure it's still visible
			 			if($("#"+ Tooltip.tooltip_element).is(":visible") && Tooltip.Item.currentId == id)
			 			{
			 				callback(data);
			 			}
			 		});
			 	}
		 	}
	 	}

	 	this.CacheObj = new function()
	 	{
	 		/**
	 		 * Get cache from localStorage
	 		 * @param String name
	 		 * @return Mixed
	 		 */
	 		this.get = function(name)
	 		{
	 			if(typeof localStorage != "undefined")
	 			{
	 				var cache = localStorage.getItem(name);
	 				
		 			if(cache)
		 			{
		 				cache = JSON.parse(cache);

		 				// If it hasn't expired
		 				if(cache.expiration > Math.round((new Date()).getTime() / 1000))
		 				{
		 					return cache.data;
		 				}
		 				else
		 				{
		 					return false;
		 				}
		 			}
		 			else
		 			{
		 				return false;
		 			}
		 		}
		 		else
		 		{
		 			return false;
		 		}
	 		}

	 		/**
	 		 * Save data to localStorage
	 		 * @param String name
	 		 * @param String data
	 		 * @param Int expiration
	 		 */
	 		this.save = function(name, data)
	 		{
	 			if(typeof localStorage != "undefined")
	 			{
	 				var time = Math.round((new Date()).getTime() / 1000);
	 				var expiration = time + 60*60*24;

		 			localStorage.setItem(name, JSON.stringify({"data": data, "expiration": expiration}));
	 			}
	 		}
	 	}
	 }
}

var Tooltip = new Tooltip();
