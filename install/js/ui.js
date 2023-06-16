var UI = {

	/**
	 * Initialize the installation UI
	 */
	initialize: function()
	{
		this.Tooltip.initialize();

        // how-to box
        $('.how_to_box .title').click(function() {
            $(this).parent().children('.content').slideToggle();
        });

        // bind previous buttons
        $('.installer_navigation .prev').click(function() { 
            UI.Navigation.previous();
        });

        // bind next buttons, without validation
        $('.installer_navigation .next').click(function() { 
            UI.Navigation.next();
        });

        // navigation
        $('.sub li').click(function() {
            UI.Navigation.goTo( $(this).attr('id') );
        });
	},

    /**
     * Displays a loading animation in the next / previous 
     * navigation area
     * @param onComplete
     */
    displayLoading: function(onComplete)
    {
        $('.installer_navigation:visible').fadeOut(100, function() {
            $(this).find('a').hide();

			$(this).append('<img src="images/ajax.gif" />').fadeIn(100, function()
            {
                if (onComplete !== undefined)
                    onComplete();
            });
        });
    },

    /**
     * Remove the loading animation in the next / previous 
     * navigation area
     * @param onComplete
     */
    completeLoading: function() 
    {
        $('.installer_navigation').find('img').remove();
        $('.installer_navigation a:not(:visible)').show();
    },

    Validation: 
	{
        requirements: function(notifyResult)
		{
            // check folder permissions
            Ajax.checkPermissions(function() {
                if ($('.folder-permissions .error').length) {
					notifyResult(false, 'Please fix all folder permissions to continue.');
                }
                else {
                    // check Apache Modules
                    Ajax.checkApacheModules(function(result) {
                        if (result != '1') 
						{
                            notifyResult(false, 'Please enable all required Apache modules to continue.');
                        }
                    });
                    // check php extensions
                    Ajax.checkPhpExtensions(function(result) {
                        if (result == '1') 
						{
							// check php version
							Ajax.checkPhpVersion(function(result) {
								if (result == '1') {
									notifyResult(true);
								}
								else {
	                                notifyResult(false, 'FusionCMS requires at least PHP 8.0');
								}
							});
                        }
                        else {
                            notifyResult(false, 'Please enable all required PHP extensions to continue.');
                        }
                    });
                }
            });
        },

		database: function(notifyResult) 
		{
			// check cms db connection
			var dbCMS = {
				hostname: $('#cms_hostname').val(),
				username: $('#cms_username').val(),
				password: $('#cms_password').val(),
				database: $('#cms_database').val()
			};

			if ($('#cms_port').val())
				dbCMS['port'] = $('#cms_port').val();

			var dbLogon = {
				hostname: $('#realmd_hostname').val(),
				username: $('#realmd_username').val(),
				password: $('#realmd_password').val(),
				database: $('#realmd_database').val()
			};

			if ($('#realmd_port').val())
				dbLogon['port'] = $('#realmd_port').val();

			// check if all required fields filled
			var required = ['hostname', 'username', 'password', 'database'];
			var all_filled = true;

			for (var key in required) {
				key = required[key];
				
				if ( (dbCMS[key] === undefined || ! dbCMS[key].length) || 
				     (dbLogon[key] === undefined || ! dbLogon[key].length)) 
				{
					all_filled = false;
					break;
				}
			}

			if ( ! all_filled) {
				notifyResult(false, 'Please fill all fields.');
				return;
			}

			// all filled, check connections
			Ajax.checkDbConnection(dbCMS, function(result) {
				if (result != '1') {
					notifyResult(false, 'CMS database connection failed:<br />' + result);
				}
				else {
					Ajax.checkDbConnection(dbLogon, function(result) {
						
						if (result != '1') {
							notifyResult(false, 'Logon database connection failed:<br />' + result);
						}
						else {
							notifyResult(true);
						}
					});
				}
			})
		},

        realms: function(notifyResult) {			
			UI.confirm('<input type="text" id="superadmin" class="nui-focus border-muted-300 text-white placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-4 rounded" placeholder="Enter username that will receive owner access..." autofocus />', 'Accept', function()
			{
				var name = $("#superadmin").val();
				if (name.length) {
					notifyResult(true);
					Ajax.Realms.saveAll();
					Ajax.Install.initialize(name);
				}
				else {
					notifyResult(false, 'Invalid username.');
				}
			},
			function() {
				notifyResult(false);
			});
        }
    },

	/**
	 * Shows an alert box
	 * @param String message
	 */
	alert: function(question, time)
	{
		// Put question and button text
		$("#alert_message").html(question);

		// Show box
		$("#popup_bg").fadeTo(200, 0.5);
		$("#alert").fadeTo(200, 1);

		if(typeof time == "undefined")
		{
			$("#alert_message").css({marginBottom:"10px"});
			$(".popup_links").show();

			// Assign click event
			$("#alert_button").bind('click', function()
			{
				UI.hidePopup();	
			});
		}
		else
		{
			$("#alert_message").css({marginBottom:"0px"});
			$(".popup_links").hide();

			setTimeout(function()
			{
				UI.hidePopup();
			}, time);
		}

		// Assign hide-function to background
		$("#popup_bg").bind('click', function()
		{
			UI.hidePopup();
		});

		// Assign key events
		$(document).keypress(function(event)
		{
			// If "enter"
			if(event.which == 13)
			{
				UI.hidePopup();
			}
		});
	},

	/**
	 * Shows a confirm box
	 * @param String question
	 * @param String button
	 * @param Function callback
	 */
	confirm: function(question, button, callback, callback_false)
	{
		$(".popup_links").show();

		// Put question and button text
		$("#confirm_question").html(question);
		$("#confirm_button").html(button);

		// Show box
		$("#popup_bg").fadeTo(200, 0.5);
		$("#confirm").fadeTo(200, 1);

		// Assign click event
		$("#confirm_button").bind('click', function()
		{
			callback();
			UI.hidePopup();	
		});

		if (callback_false !== undefined)
			$('#confirm_hide').bind('click', callback_false);

		// Assign hide-function to background
		$("#popup_bg").bind('click', function()
		{
			UI.hidePopup();
		});

		// Assign key events
		$(document).keypress(function(event)
		{
			// If "enter"
			if(event.which == 13)
			{
				callback();
				UI.hidePopup();
			}
		});
	},

	/**
	 * Hides the current popup box
	 */
	hidePopup: function()
	{
		// Hide box
		$("#popup_bg").hide();
		$("#confirm").hide();
		$("#alert").hide();
		$("#vote_reminder").hide();

		// Remove events
		$("#confirm_button").unbind('click');
		$("#alert_button").unbind('click');
		$(document).unbind('keypress');
	},

	Navigation: {
		current: 1,

		next: function(onComplete)
		{
			if (this.current < ($('.step').length + 1))
				UI.Navigation.goTo(UI.Navigation.current + 1);
		},

		previous: function(onComplete)
		{
			if(this.current > 1)
				UI.Navigation.goTo(UI.Navigation.current - 1);
		},

		goTo: function(id, onComplete)
		{
			id = parseInt(id);
			
			if (UI.Navigation.current == id)
				return;

			// check if step is accessible yet (is next step, is first step or was completed before)
			if ( ! (UI.Navigation.current == 1 && id == 2) && id != (UI.Navigation.current + 1)  && ! $('.sub li:nth-child(' + id + ') a').hasClass('unlocked')) {
				console.log('goto failed: '+id);
				return;
			}

			console.log('current=' + UI.Navigation.current, 'loading next='+id);

			var showRequestedStep = function()
			{
	            // Save the current step's fields
				Memory.save(UI.Navigation.current);

				// display tick in navigation for current step
				$('.sub li:nth-child(' + UI.Navigation.current + ') a').addClass('unlocked');				
				$(".sub li .router-link-active").removeClass('router-link-active !text-white !bg-primary-600');

				// fade current step out, requested step in
				$(".step:eq(" + (UI.Navigation.current - 1) + ")").fadeOut(200, function()
				{
					UI.Navigation.current = id;

					$('.sub li:nth-child(' + UI.Navigation.current + ') a').addClass('router-link-active !text-white !bg-primary-600');
					$('.step:eq(' + (UI.Navigation.current - 1) + ')').fadeIn(200, function() {
						$('document').scrollTop();
						
					   if (onComplete !== undefined)
                           onComplete();
					});
				});
			}

			// validate current step (only if moving forward)
			var validation = $('.step:eq(' + (UI.Navigation.current - 1) + ')').attr('data-validation');

			if (id > UI.Navigation.current && validation && UI.Validation[validation] !== undefined) 
			{
				// display loading animation, run validation, remove loading
				UI.displayLoading(function() {
					var result = UI.Validation[validation](function(result, errorMsg) 
					{
						UI.completeLoading();

						if ( ! result) {
							$('.sub li:nth-child(' + id + ') a').removeClass('unlocked');

							if (errorMsg !== undefined)
								UI.alert(errorMsg);

 						   if (onComplete !== undefined)
 	                           onComplete();
						}
						else {
							// validation OK, show requested step page
							showRequestedStep();
						}
					});
				});
			}
			else {
				showRequestedStep();
			}
		}
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