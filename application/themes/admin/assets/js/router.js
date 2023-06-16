var Router = {

	loadedJS: [],
	loadedCSS: [],
	first: true,
	page: false,

	/**
	 * Assign click events
	 */
	initialize: function()
	{
		// Check for pushState support
		if(history.pushState)
		{
			// Assign AJAX loading behavior to all our internal links
			$("a[href*='" + Config.URL + "']").each(function()
			{
				// Make sure it has not been assigned already
				if(!$(this).attr('data-hasEvent') && $(this).attr("target") != "_blank")
				{
					$(this).attr('data-hasEvent', '1');
					
					// Add the event listener
					$(this).click(function(event)
					{
						// Indicate the loading
						$("body").css("cursor", "wait");

						// Get the link
						var href = $(this).attr("href");

						$(".active").removeClass("active");
						$(this).addClass("active");

						// Load it via AJAX
						//Router.load(href);

						// Add it to the history object
						history.pushState('', 'New URL: ' + href, href);

						if(Router.first)
						{
							Router.first = false;

							// Make it load the page if they press back or forward
							$(window).bind('popstate', function()
							{
								$(".active").removeClass("active");
								Router.load(location.pathname);
							});
						}

						// Prevent it from refreshing the whole page
						event.preventDefault();
					});
				}
			});
		}
	},

	/**
	 * Load the link into the content area
	 * @param String link
	 */
	load: function(link)
	{
		Router.page = link;

		$("#tooltip").hide();
		
		if(link == Config.URL + "ucp")
		{
			window.location = link;
		}
		else
		{
			// Load the page
			$.get(link, { is_json_ajax: "1", is_acp: "1", is_mod: "1" }, function(data)
			{
				if(Router.page == link)
				{
					window.scrollTo(0, 0);
					
					try
					{
						data = JSON.parse(data);
					}
					catch(error)
					{
						data = {
							title: "Error",
							content: "Something went wrong!<br /><br /><b>Technical data:</b>" + data,
							js: null,
							css: null
						};
					}

					// Change the cursor back to normal
					$("body").css("cursor", "default");

					// Change the content
					$("#content_ajax").html(data.content);
					
					//Tooltip.refresh();
					//UI.dropdown.initialize();

					// Change the title
					if(data.title.length > 0)
					{
						$("title").html(data.title +  " FusionGen");
					}
					else
					{
						$("title").html("FusionGen");
					}

					// Make sure to assign the router to all new internal links
					Router.initialize();

					// Add the CSS if it exists and hasn't been loaded already
					if(data.css.length > 0 && $.inArray(data.css, Router.loadedCSS) == -1)
					{
						Router.loadedCSS.push(data.css);

						$("head").append('<link rel="stylesheet" type="text/css" href="' + Config.URL + 'application/' + data.css + '" />');
					}

					// Add the JS if it exists and hasn't been loaded already
					if(data.js.length > 0 && $.inArray(data.js, Router.loadedJS) == -1)
					{
						Router.loadedJS.push(data.js);

						require([Config.URL + "application/" + data.js]);
					}
				}
			}).error(function()
			{
				if(Router.page == link)
				{
					$("body").css("cursor", "default");
					$("title").html("FusionGen");
					var HTML = '<h1 id="page_title">Something went wrong</h1><section id="content"><section class="box big"><h2>Page not found</h2><span>The page you have requested does not seem to exist.</span></section></section>';
					$("#content_ajax").html(HTML);
				}
			});
		}
	}
}

//$(document).ready(Router.initialize);