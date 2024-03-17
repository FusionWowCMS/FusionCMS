const UI = {

    /**
     * Initialize the installation UI
     */
    initialize: function () {
        this.Tooltip.initialize();

        // how-to box
        $('.how_to_box .title').click(function () {
            $(this).parent().children('.content').slideToggle();
        });

        // bind previous buttons
        $('.installer_navigation .prev').click(function () {
            UI.Navigation.previous();
        });

        // bind next buttons, without validation
        $('.installer_navigation .next').click(function () {
            UI.Navigation.next();
        });

        // navigation
        $('.menus li').click(function () {
            UI.Navigation.goTo($(this).attr('id'));
        });

        // Select Navigation
		$('.option-menu').click(function(e) {
			$('.option-menu svg').addClass('rotate-180');
			$('.menus').removeClass('opacity-0 translate-y-1 hidden').addClass('opacity-100 translate-y-0');
			e.stopPropagation();
		});

		// Hide Navigation Menu
		$('body').click(function(e){
			if ($('.option-menu svg').hasClass('rotate-180')) {
				$('.option-menu svg').removeClass('rotate-180');
				$('.menus').removeClass('opacity-100 translate-y-0').addClass('opacity-0 translate-y-1 hidden');
				e.stopPropagation();
			}
		});
    },

    /**
     * Displays a loading animation in the next / previous
     * navigation area
     * @param onComplete
     */
    displayLoading: function (onComplete) {
        $('.installer_navigation:visible').fadeOut(100, function () {
            $(this).find('a').hide();

            $(this).append('<img src="../application/modules/install/images/ajax.gif" />').fadeIn(100, function () {
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
    completeLoading: function () {
        $('.installer_navigation').find('img').remove();
        $('.installer_navigation a:not(:visible)').show();
    },

    Validation:
        {
            requirements: function (notifyResult) {
                // check folder permissions
                Ajax.checkPermissions(function () {
                    if ($('.folder-permissions .error').length) {
                        notifyResult(false, 'Please fix all folder permissions to continue.');
                    } else {
                        // check Apache or Nginx Modules
                        Ajax.checkApacheModules(function (result) {
                            if (result == '2') {
                                notifyResult(false, 'Unable to check Apache or Nginx Modules, make sure required modules are enabled.');
                            } else if (result != '1') {
                                notifyResult(false, 'Please enable all required Apache or Nginx modules to continue.');
                            }
                        });
                        // check php extensions
                        Ajax.checkPhpExtensions(function (result) {
                            if (result == '1') {
                                // check php version
                                Ajax.checkPhpVersion(function (result) {
                                    if (result == '1') {
                                        notifyResult(true);
                                    } else {
                                        notifyResult(false, 'FusionCMS requires at least PHP 8.0');
                                    }
                                });
                            } else {
                                notifyResult(false, 'Please enable all required PHP extensions to continue.');
                            }
                        });
                    }
                });
            },

            database: function (notifyResult) {
                // check cms db connection
				const dbData = {
					cms_hostname: $('#cms_hostname').val(),
					cms_username: $('#cms_username').val(),
					cms_password: $('#cms_password').val(),
					cms_database: $('#cms_database').val(),
                    auth_hostname: $('#realmd_hostname').val(),
                    auth_username: $('#realmd_username').val(),
                    auth_password: $('#realmd_password').val(),
                    auth_database: $('#realmd_database').val()
				};

				if ($('#cms_port').val())
                    dbData['cms_port'] = $('#cms_port').val();

                if ($('#realmd_port').val())
                    dbData['auth_port'] = $('#realmd_port').val();

				// Auth config (config/auth.php)
				const authSettings = {
					realmd_rbac: $('#realmd_rbac').val(),
					realmd_battle_net: $('#realmd_battle_net').val(),
					realmd_totp_secret: $('#realmd_totp_secret').val(),
					realmd_totp_secret_name: $('#realmd_totp_secret_name').val(),
					realmd_account_encryption: $('#realmd_account_encryption').val(),
					realmd_battle_net_encryption: $('#realmd_battle_net_encryption').val()
				};

                // check if all required fields filled
				const required = ['cms_hostname', 'cms_username', 'cms_password', 'cms_database', 'auth_hostname', 'auth_username', 'auth_password', 'auth_database'];
				let all_filled = true;

				for (let key in required) {
                    key = required[key];

                    if ((dbData[key] === undefined || !dbData[key].length)) {
                        all_filled = false;
                        break;
                    }
                }

                if (!all_filled) {
                    notifyResult(false, 'Please fill all fields.');
                    return;
                }

                // all filled, check connections
                Ajax.setAndCheckDbConnection(dbData, function (result) {
                    if (result != '1') {
                        notifyResult(false, 'database connection failed:<br />' + result);
                    } else {
                        Ajax.checkAuthConfig(authSettings, function (result) {
                            if (result != '1') {
                                notifyResult(false, 'Missing config:<br />' + result);
                            } else {
                                notifyResult(true);
                            }
                        });
                    }
                })
            },

            realms: function (notifyResult) {
                // Save realms data
                Ajax.Realms.saveAll();

                // Perform AJAX to check realms data
                $.post('install/next?step=realms', {
                    realms: JSON.stringify(Ajax.Realms.data),
                    insert: false
                }, function (response) {
                    // Invalid response.. Exit
                    if (response !== '1') {
                        // Show error message
                        UI.alert(response);

                        // Remove loading
                        UI.completeLoading();

                        // Exit
                        return false;
                    }

                    UI.confirm('<input type="text" id="superadmin" class="nui-focus border-muted-300 text-white placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-4 rounded" placeholder="Enter username that will receive owner access..." autofocus />', 'Accept', function () {
							const name = $("#superadmin").val();
							if (name.length) {
                                notifyResult(true);
                                Ajax.Realms.saveAll();
                                Ajax.Install.initialize(name);
                            } else {
                                notifyResult(false, 'Invalid username.');
                            }
                        },
                        function () {
                            notifyResult(false);
                        });
                });
            }
        },

    /**
     * Shows an alert box
     * @param String message
     */
    alert: function (question, time) {
        // Put question and button text
        $("#alert_message").html(question);

        // Show box
        $("#popup_bg").fadeTo(200, 0.5);
        $("#alert").fadeTo(200, 1);

        if (typeof time == "undefined") {
            $("#alert_message").css({marginBottom: "10px"});
            $(".popup_links").show();

            // Assign click event
            $("#alert_button").bind('click', function () {
                UI.hidePopup();
            });
        } else {
            $("#alert_message").css({marginBottom: "0px"});
            $(".popup_links").hide();

            setTimeout(function () {
                UI.hidePopup();
            }, time);
        }

        // Assign hide-function to background
        $("#popup_bg").bind('click', function () {
            UI.hidePopup();
        });

        // Assign key events
        $(document).keypress(function (event) {
            // If "enter"
            if (event.which == 13) {
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
    confirm: function (question, button, callback, callback_false) {
        $(".popup_links").show();

        // Put question and button text
        $("#confirm_question").html(question);
        $("#confirm_button").html(button);

        // Show box
        $("#popup_bg").fadeTo(200, 0.5);
        $("#confirm").fadeTo(200, 1);

        // Assign click event
        $("#confirm_button").bind('click', function () {
            callback();
            UI.hidePopup();
        });

        if (callback_false !== undefined)
            $('#confirm_hide').bind('click', callback_false);

        // Assign hide-function to background
        $("#popup_bg").bind('click', function () {
            UI.hidePopup();
        });

        // Assign key events
        $(document).keypress(function (event) {
            // If "enter"
            if (event.which == 13) {
                callback();
                UI.hidePopup();
            }
        });
    },

    /**
     * Hides the current popup box
     */
    hidePopup: function () {
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

        next: function (onComplete) {
            if (this.current < ($('.step').length + 1))
                UI.Navigation.goTo(UI.Navigation.current + 1);
        },

        previous: function (onComplete) {
            if (this.current > 1)
                UI.Navigation.goTo(UI.Navigation.current - 1);
        },

        goTo: function (id, onComplete) {
            id = parseInt(id);

            // Menu: Define
            const $menu = document.querySelector('[id="' + id + '"]');

            // Step: Define
            const $step        = document.querySelector('[_step_]');
            const step_lang             = JSON.parse($step.getAttribute('_lang_'));
            const $step_name   = $step.querySelector('[_step_name_]');
            const $step_number = $step.querySelector('[_step_number_]');

            // Step: Update
            $step_name.innerHTML   = $menu.querySelector('h4').innerHTML;
            $step_number.innerHTML = step_lang.step + ' ' + id + ': ';

            if (UI.Navigation.current == id)
                return;

            // check if step is accessible yet (is next step, is first step or was completed before)
            if (!(UI.Navigation.current == 1 && id == 2) && id != (UI.Navigation.current + 1) && !$('.menus li:nth-child(' + id + ') a').hasClass('unlocked')) {
                console.log('goto failed: ' + id);
                return;
            }

            $('#progressbar .nui-progress-bar').width((id - 1) * 14.285 + '%');

            const showRequestedStep = function () {
                // Save the current step's fields
                Memory.save(UI.Navigation.current);

                // display tick in navigation for current step
                $('.menus li:nth-child(' + UI.Navigation.current + ') a').addClass('unlocked');
                $(".menus li .router-link-active").removeClass('router-link-active');

                // fade current step out, requested step in
                $(".step:eq(" + (UI.Navigation.current - 1) + ")").fadeOut(200, function () {
                    UI.Navigation.current = id;

                    $('.menus li:nth-child(' + UI.Navigation.current + ') a').addClass('router-link-active');
                    $('.step:eq(' + (UI.Navigation.current - 1) + ')').fadeIn(200, function () {
                        $('document').scrollTop();

                        if (onComplete !== undefined)
                            onComplete();
                    });
                });
            };

            // validate current step (only if moving forward)
			const validation = $('.step:eq(' + (UI.Navigation.current - 1) + ')').attr('data-validation');

			if (id > UI.Navigation.current && validation && UI.Validation[validation] !== undefined) {
                // display loading animation, run validation, remove loading
                UI.displayLoading(function () {
					UI.Validation[validation](function (result, errorMsg) {
						UI.completeLoading();

						if (!result) {
							$('.menus li:nth-child(' + id + ') a').removeClass('unlocked');

							if (errorMsg !== undefined)
								UI.alert(errorMsg);

							if (onComplete !== undefined)
								onComplete();
						} else {
							// validation OK, show requested step page
							showRequestedStep();
						}
					});
				});
            } else {
                showRequestedStep();
            }
        }
    },

    Tooltip: {

        /**
         * Add event-listeners
         */
        initialize: function () {
            // Add the tooltip element
            $("body").prepend('<div id="tooltip"></div>');

            // Add mouse-over event listeners
            this.addEvents();

            // Add mouse listener
            $(document).mousemove(function (e) {
                UI.Tooltip.move(e.pageX, e.pageY);
            });
        },

        /**
         * Used to support Ajax content
         * Reloads the tooltip elements
         */
        refresh: function () {
            // Remove all
            $("[data-tip]").unbind('hover');

            // Re-add
            this.addEvents();
        },

        addEvents: function () {
            // Add mouse-over event listeners
            $("[data-tip]").hover(
                function () {
                    UI.Tooltip.show($(this).attr("data-tip"));
                },
                function () {
                    $("#tooltip").hide();
                }
            );
        },

        /**
         * Moves tooltip
         * @param Int x
         * @param Int y
         */
        move: function (x, y) {
            // Get half of the width
            var width = ($("#tooltip").css("width").replace("px", "") / 2);

            // Position it at the mouse, and center
            $("#tooltip").css("left", x - width).css("top", y + 25);
        },

        /**
         * Displays the tooltip
         * @param Object element
         */
        show: function (data) {
            $("#tooltip").html(data).show();
        }
    }
};