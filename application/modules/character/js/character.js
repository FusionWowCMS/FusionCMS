var Character = {
	
	loadedIcons: [],
	/**
	 * Performs an ajax call to get the display name
	 * This should only be called if the icon cache was empty
	 * @param Int id
	 */
	 getIcon: function(id, realm, api_item_icons)
	 {
	 	if($.inArray(id, this.loadedIcons) == -1)
	 	{
	 		this.loadedIcons.push(id);

	 		$.get(Config.URL + "icon/get/" + realm + "/" + id, function(data)
		 	{
		 		$(".get_icon_" + id).each(function()
		 		{
		 			$(this).html("<div class='item'><a href='" + Config.URL + "item/" + realm + "/" + id + "' rel='item=" + id + "' data-realm='" + realm + "'></a><img src='" + api_item_icons + "/large/" + data + ".jpg' /></div>");
		 			Tooltip.refresh();
		 		});
		 	});
	 	}
	 },

	getItem: function(item, trans, realm, api_item_icons)
	{
		let transmog = false;

		if(parseInt(trans))
		{
			transmog = true;

			// Send AJAX call to grab transmog item info
			$.get(Config.URL + 'item/ajax/' + realm + '/' + trans, (data) => {
				transmog = data;
			}, 'json');
		}

		function __SLEEP__()
		{
			if(transmog && typeof(transmog) === 'boolean')
			{
				setTimeout(__SLEEP__, 50);
				return false;
			}

			$.get(Config.URL + 'item/ajax/' + realm + '/' + item, (data) => {
				$(".get_icon_" + item).each(function()
				{
					// Prepare html
					html = '<div class="item" equiplist="[{SLOT}, {DISPLAY}]"><!-- [TRANS] --><a href="{BASEURL}item/{REALM}/{ITEM}" rel="item={ITEM}&transmog={TRANSMOG}" data-realm="{REALM}"></a><img src="{ICONURL}/large/{ICON}.jpg" /></div>';

					// Append trans icon
					if(transmog)
						html = html.replace('<!-- [TRANS] -->', '<a href="{BASEURL}item/{REALM}/{TRANS}" class="item-trans" rel="item={TRANS}" data-realm="{REALM}"></a>');

					// format html
					html = html.replaceAll('{BASEURL}', Config.URL)
							   .replaceAll('{ITEM}', item)
							   .replaceAll('{TRANS}', trans)
							   .replaceAll('{REALM}', realm)
							   .replace('{ICONURL}', api_item_icons)
							   .replace('{ICON}', data.icon)
							   .replace('{SLOT}', data.InventoryType);

					html = (data.displayid) ? html.replace('{DISPLAY}', (transmog) ? transmog.displayid : data.displayid) : html.replace('equiplist="[{SLOT}, {DISPLAY}]"', '');

					// Transmog available?
					html = (transmog) ? html.replace('{TRANSMOG}', transmog.name) : html.replace('&transmog={TRANSMOG}', '');

					$(this).html(html);

					Tooltip.refresh();
				});
			}, 'json');
		}

		__SLEEP__();
	},

	 /**
	  * Whether the tabs are changing or not
	  * @type Boolean
	  */
	 tabsAreChanging: false,

	 /**
	  * Change tab
	  * @param String selector
	  * @param Object link
	  */
	 tab: function(selector, link)
	 {
	 	if(!this.tabsAreChanging)
	 	{
	 		this.tabsAreChanging = true;

		 	// Find out the current tab
		 	var currentTabLink = $(".armory_current_tab");
		 	var currentTabId = "#tab_" + currentTabLink.attr("onClick").replace("Character.tab('", "").replace("', this)", "");

		 	// Change link states
		 	currentTabLink.removeClass("armory_current_tab");
		 	$(link).addClass("armory_current_tab");

		 	// Fade the current and show the new
		 	$(currentTabId).fadeOut(300, function()
		 	{
		 		$("#tab_" + selector).fadeIn(300, function()
	 			{
	 				Character.tabsAreChanging = false;
	 			});
		 	});
	 	}
	 },

	 /**
	  * Slide to an attributes tab
	  * @param Int id
	  */
	 attributes: function(id)
	 {
	 	if(id == 2)
	 	{
	 		$("#attributes_wrapper").animate({marginLeft:"-367px"}, 500);
	 		$("#tab_armory_1").fadeTo(500, 0.1);
	 		$("#tab_armory_3").fadeTo(500, 0.1);
	 		$("#tab_armory_2").fadeTo(500, 1);
	 	}
	 	else if(id == 1)
	 	{
	 		$("#attributes_wrapper").animate({marginLeft:"0px"}, 500);
	 		$("#tab_armory_2").fadeTo(500, 0.1);
	 		$("#tab_armory_3").fadeTo(500, 0.1);
	 		$("#tab_armory_1").fadeTo(500, 1);
	 	}
	 	else
	 	{
	 		$("#attributes_wrapper").animate({marginLeft:"-734px"}, 500);
	 		$("#tab_armory_1").fadeTo(500, 0.1);
	 		$("#tab_armory_2").fadeTo(500, 0.1);
	 		$("#tab_armory_3").fadeTo(500, 1);
	 	}
	 }
}