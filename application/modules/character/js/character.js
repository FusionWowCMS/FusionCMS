var Character = {
	
	loadedIcons: [],
	/**
	 * Performs an ajax call to get the display name
	 * This should only be called if the icon cache was empty
	 * @param Int id
	 */
	 getIcon: function(id, realm)
	 {
	 	if($.inArray(id, this.loadedIcons) == -1)
	 	{
	 		this.loadedIcons.push(id);

	 		$.get(Config.URL + "icon/get/" + realm + "/" + id, function(data)
		 	{
		 		$(".get_icon_" + id).each(function()
		 		{
		 			$(this).html("<div class='item'><a href='" + Config.URL + "item/" + realm + "/" + id + "' rel='item=" + id + "' data-realm='" + realm + "'></a><img src='https://icons.wowdb.com/retail/large/" + data + ".jpg' /></div>");
		 			Tooltip.refresh();
		 		});
		 	});
	 	}
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