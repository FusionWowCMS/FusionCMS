var Settings = {
	
	/**
	 * Removes a realm
	 * @param  Int id
	 * @param  Object element
	 */
	remove: function(id, element)
	{
		if($("#realm_count").html() == "1")
		{
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'You must always have at least one realm!',
			})
		}
		else
		{
			Swal.fire({
				title: 'Do you really want to delete this realm?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			if (result.isConfirmed) {
				$("#realm_count").html(parseInt($("#realm_count").html()) - 1);

				$(element).parents("tr").slideUp(300, function()
				{
					$(this).remove();
				});

				$.get(Config.URL + "admin/realmmanager/delete/" + id, function(data)
				{
					console.log(data);
				});
			}
			})
		}
	},

	showAddRealm: function()
	{
		if ($("#add_realm").css('display') == 'none')
		{
			var div = document.getElementById('add_realm');
			div.style.display = 'block';
		}
		else
		{
			var div = document.getElementById('add_realm');
			div.style.display = 'none';
		}
	},

	addRealm: function()
	{
		var data = {
			name: $("#realmName").val(),
			hostname: $("#hostname").val(),
			username: $("#username").val(),
			password: $("#password").val(),
			characters: $("#characters").val(),
			world: $("#world").val(),
			cap: $("#cap").val(),
			port: $("#port").val(),
			emulator: $("#emulator").val(),
			console_username: $("#console_username").val(),
			console_password: $("#console_password").val(),
			console_port: $("#console_port").val(),
			csrf_token_name: Config.CSRF
		};

		if($("#server_structure").val() == "2")
		{
			data.override_hostname_char = $("#override_hostname_char").val();
			data.override_username_char = $("#override_username_char").val();
			data.override_password_char = $("#override_password_char").val();
			data.override_port_char = $("#override_port_char").val();
			data.override_hostname_world = $("#override_hostname_char").val();
			data.override_username_world = $("#override_username_char").val();
			data.override_password_world = $("#override_password_char").val();
			data.override_port_world = $("#override_port_char").val();
		}
		else if($("#server_structure").val() == "3")
		{
			data.override_hostname_char = $("#override_hostname_char_three").val();
			data.override_username_char = $("#override_username_char_three").val();
			data.override_password_char = $("#override_password_char_three").val();
			data.override_port_char = $("#override_port_char_three").val();
			data.override_hostname_world = $("#override_hostname_world_three").val();
			data.override_username_world = $("#override_username_world_three").val();
			data.override_password_world = $("#override_password_world_three").val();
			data.override_port_world = $("#override_port_world_three").val();
		}

		var emulatorText = data.emulator.toUpperCase();

		$.post(Config.URL + "admin/realmmanager/create", data, function(id)
		{
			if(/^[0-9]*$/.test(id))
			{
				var realmHTML = '<li class="list-group-item">\
								<table width="100%">\
									<tr>\
										<td width="10%">ID: ' + id + '</td>\
										<td width="30%"><b>' + data.name + '</b></td>\
										<td width="30%">' + data.hostname + '</td>\
										<td width="20%">' + emulatorText + '</td>\
										<td style="text-align:right;">\
											<a href="' + id + '" data-tip="Edit"><img src="' + Config.URL + 'application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;\
											<a href="javascript:void(0)" onClick="Settings.remove(' + id + ', this)" data-tip="Delete"><img src="' + Config.URL + 'application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>\
										</td>\
									</tr>\
								</table>\
							</li>';

				$("#realm_count").html(parseInt($("#realm_count").html()) + 1);
				$("#realm_list").append(realmHTML);
				$("#add_realm").fadeOut(100, function()
				{
					$("#realm_settings").fadeIn(100, function()
					{
						$("#non_realm").fadeIn(100);
					});
				});
			}
			else
			{
				UI.alert(id);
			}
		});
	},

	saveRealm: function(id)
	{
		var data = {
			realmName: $("#realmName").val(),
			hostname: $("#hostname").val(),
			username: $("#username").val(),
			password: $("#password").val(),
			characters: $("#characters").val(),
			world: $("#world").val(),
			cap: $("#cap").val(),
			port: $("#port").val(),
			emulator: $("#emulator").val(),
			console_username: $("#console_username").val(),
			console_password: $("#console_password").val(),
			console_port: $("#console_port").val(),
			csrf_token_name: Config.CSRF
		};

		data.override_hostname_char = $("#override_hostname_char").val();
		data.override_username_char = $("#override_username_char").val();
		data.override_password_char = $("#override_password_char").val();
		data.override_port_char = $("#override_port_char").val();
		data.override_hostname_world = $("#override_hostname_world").val();
		data.override_username_world = $("#override_username_world").val();
		data.override_password_world = $("#override_password_world").val();
		data.override_port_world = $("#override_port_world").val();

		$.post(Config.URL + "admin/realmmanager/save/" + id, data, function(result)
		{
			if(result == "success")
			{
				window.location = Config.URL + "admin/settings";
			}
			else
			{
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: result,
				})
			}
		});
	},

	toggleVoteReminder: function(object)
	{
		if(object.value == '1')
		{
			$('#vote_reminder_settings').fadeIn(300);
		}
		else
		{
			$('#vote_reminder_settings').fadeOut(300);
		}
	},

	saveWebsiteSettings: function()
	{
		var data = {
			title:$("#title").val(),
			server_name:$("#server_name").val(),
			realmlist:$("#realmlist").val(),
			max_expansion:$("#max_expansion").val(),
			keywords:$("#keywords").val(),
			description:$("#description").val(),
			analytics:$("#analytics").val(),
			vote_reminder:$("#vote_reminder").val(),
			vote_reminder_image:$("#vote_reminder_image").val(),
			reminder_interval:$("#reminder_interval").val(),
			has_smtp:$("#has_smtp").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/settings/saveWebsite", data, function(response)
		{
			if(response == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "Website settings have been saved!",
				});
			}
			else
			{
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
				})
			}
		});
	},

	saveSmtpSettings: function()
	{
		var data = {
			use_own_smtp_settings:$("#use_own_smtp_settings").val(),
			smtp_protocol:$("#smtp_protocol").val(),
			smtp_sender:$("#smtp_sender").val(),
			smtp_host:$("#smtp_host").val(),
			smtp_user:$("#smtp_user").val(),
			smtp_pass:$("#smtp_pass").val(),
			smtp_port:$("#smtp_port").val(),
			smtp_crypto:$("#smtp_crypto").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/settings/saveSmtp", data, function(response)
		{
			if(response == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "SMTP settings have been saved!",
				});
			}
			else
			{
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
				})
			}
		});
	},

	savePerformanceSettings: function()
	{
		var data = {
			disable_visitor_graph:$("#disable_visitor_graph").val(),
			disable_realm_status:$("#disable_realm_status").val(),
			cache:$("#cache").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/settings/savePerformance", data, function(response)
		{
			if(response == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "Performance settings have been saved!",
				});
			}
			else
			{
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
				})
			}
		});
	},
	
	saveSocialMedia: function()
	{
		var values = {
			fb_link:$("#fb_link").val(),
			twitter_link:$("#twitter_link").val(),
			yt_link:$("#yt_link").val(),
			discord_link:$("#discord_link").val(),
			insta_link:$("#insta_link").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/settings/saveSocialMedia", values, function(response)
		{
			if(response == "yes")
			{
				console.log(values);
				Swal.fire({
					icon: "success",
					title: "Social media links have been saved!",
				});
			}
			else
			{
				console.log(values);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
				})
			}
		});
	},

	saveCDN: function()
	{
		var values = {
			cdn_value:$("#cdn_value").val(),
			cdn_link:$("#cdn_link").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/settings/saveCDN", values, function(response)
		{
			if(response == "yes")
			{
				console.log(values);
				Swal.fire({
					icon: "success",
					title: "CDN have been saved!",
				});
			}
			else
			{
				console.log(values);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
				})
			}
		});
	},

	saveSecurity: function()
	{
		var values = {
			use_captcha:$("#use_captcha").val(),
			captcha_attemps:$("#captcha_attemps").val(),
			block_attemps:$("#block_attemps").val(),
			block_duration:$("#block_duration").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/settings/saveSecurity", values, function(response)
		{
			if(response == "yes")
			{
				console.log(values);
				Swal.fire({
					icon: "success",
					title: "Security settings has been saved!",
				});
			}
			else
			{
				console.log(values);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response,
				})
			}
		});
	},

	mailDebug: function()
	{
		var values = {csrf_token_name: Config.CSRF};
        var protocol = $("#smtp_protocol").val();
        var host = $("#smtp_host").val();
        var user = $("#smtp_user").val();
		var pass = $("#smtp_pass").val();
        var port = $("#smtp_port").val();
		var crypto = $("#smtp_crypto").val();

		values['protocol'] = protocol;
		values['host'] = host;
		values['user'] = user;
		values['pass'] = pass;
		values['port'] = port;
		values['crypto'] = crypto;

		$.post(Config.URL + "admin/settings/mailDebug", values, function(data)
		{
			console.log(data);
			try {
				data = JSON.parse(data);

				if(data['error']) {
					Swal.fire({
					icon: 'error',
					html: data['error'],
					allowOutsideClick: false
				})
					return;
				} else {
					Swal.fire({
					icon: "success",
					title: 'Mail sent!',
					text: data['success'],
				})
				}
			} catch(e) {
				console.error(e);
				return;
			}
		});
	},

	toggleSMTPusage: function()
	{
		if ($("#use_smtp").css('display') == 'none')
		{
			$("#use_smtp").show();
			if( $('[value="smtp"][selected="selected"]') ) {
				var div = document.getElementById('toggle_protocol');
				div.style.display = 'block';
			}
		}
		else
		{
			$("#use_smtp").hide();
			$("#toggle_protocol").hide();
		}

	},

	toggleProtocol: function(element)
	{
		switch(element.value)
		{
			case "mail":
				$("#toggle_protocol").hide();
			break;

			case "smtp":
				$("#toggle_protocol").show();
			break;
		}

	},

	submitConfig: function(form, moduleName, configName)
	{
		var values = {csrf_token_name: Config.CSRF};
		
		$("input, select", $(form)).each(function(i, e)
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		$.post(Config.URL + "admin/edit/save/" + moduleName + "/" + configName, values, function(data)
		{
			if(data == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "The settings have been saved!",
				});
			}
			else
			{
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: data,
				})
			}
		});
	},

	submitConfigSource: function(moduleName, configName)
	{
		var values = {
			csrf_token_name: Config.CSRF,
			source: $("#source_" + configName).val()
		};

		$.post(Config.URL + "admin/edit/saveSource/" + moduleName + "/" + configName, values, function(data)
		{
			if(data == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "The settings have been saved!",
				});
			}
			else
			{
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: data,
				})
			}
		});
	},

	submitThemeConfig: function(form, themeName, configName)
	{
		var values = {csrf_token_name: Config.CSRF};
		
		$("input, select", $(form)).each(function(i, e)
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		$.post(Config.URL + "admin/theme/edit/save/" + themeName + "/" + configName, values, function(data)
		{
			if(data == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "Theme settings have been saved!",
				});
			}
			else
			{
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: data,
				})
			}
		});
	},

	submitThemeConfigSource: function(themeName, configName)
	{
		var values = {
			csrf_token_name: Config.CSRF,
			source: $("#source_" + configName).val()
		};

		$.post(Config.URL + "admin/theme/edit/saveSource/" + themeName + "/" + configName, values, function(data)
		{
			if(data == "yes")
			{
				console.log(data);
				Swal.fire({
					icon: "success",
					title: "Theme settings have been saved!",
				});
			}
			else
			{
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: data,
				})
			}
		});
	},

	toggleSource: function(id, field)
	{
		if($("#advanced_" + id).is(":visible"))
		{
			$(field).html("Edit source code (advanced)");

			$("#advanced_" + id).fadeOut(150, function()
			{
				$("#gui_" + id).fadeIn(150);
			});
		}
		else
		{
			$(field).html("Edit values (simple)");

			$("#gui_" + id).fadeOut(150, function()
			{
				$("#advanced_" + id).fadeIn(150);
			});
		}
	},

	submitMessage: function(form)
	{
		var data = {
			message_enabled:$("#message_enabled").val(),
			message_headline:$("#message_headline").val(),
			message_headline_size:$("#message_headline_size").val(),
			message_text:$("#message_text").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/message/save", data, function(response)
		{
			console.log(data);
			Swal.fire({
				icon: 'success',
				title: response,
			})
		});
	},

	liveUpdate: function(element, type)
	{
		if(type == "headline_size")
		{
			$("#live_headline").css("font-size", element.value + "px");
		}
		else
		{
			$("#live_" + type).html(element.value);
		}
	},

	changeStructure: function(element)
	{
		switch(element.value)
		{
			case "1":
				$("#two, #three").hide();
				$("#one").show();
			break;

			case "2":
				$("#one, #three").hide();
				$("#two").show();
			break;

			case "3":
				$("#two, #one").hide();
				$("#three").show();
			break;
		}
	},

	showHelp: function(element)
	{
		Swal.fire({
			html:'<h2>mail</h2>' +

				'<p>The default value is <code>mail</code>.</p>' +

				'<p>It means that the CodeIgniter library will use the internal <a href="https://www.php.net/manual/en/function.mail.php" rel="noreferrer"><code>mail()</code> PHP function</a> to try to send the mail.</p>' +

				'<p>How does it works? How does PHP know how to send the mail?</p>' +

				'<blockquote>' +
				'<p>On Unix/Linux it invokes the <code>sendmail</code> binary, which then uses the mail' +
				'configuration to route the email. On Windows, it sends to a SMTP' +
				'server. In both cases the sysadmin sets up the mail system.</p>' +
				'</blockquote>' +

				'<p>In any case, the <code>sendmail</code> binary will then use a SMTP server to send the mail, as configured by the admin.</p>' +

				'<h2>sendmail (linux only)</h2>' +

				'<p>The second possible value is <code>sendmail</code>.</p>' +

				'<p>Using <code>sendmail</code> value for the configuration means that the CodeIgniter library will use directly the <code>sendmail</code> binary without using the PHP <code>mail()</code> function.</p>' +

				'<p>The path to the binary can be configured through the option <code>mailpath</code> (which is <code>/usr/sbin/sendmail</code> by default).</p>' +

				'<p>This means that this can only be used on Linux/Unix platform, as Windows doesnt have any <code>sendmail</code> binary.</p>' +

				'<p>Now why would you want to use the <code>sendmail</code> binary directly since the PHP internal <code>mail()</code> function already uses it (and is compatible with Windows)?</p>' +

				'<p>Well, for one the <code>mail()</code> internal function could be disabled in your PHP environment by your hosting provider. Or you may want to call a special <code>sendmail</code> binary different than the one used by the PHP internal function.</p>' +

				'<p>In any case, the <code>sendmail</code> binary will then use a SMTP server to send the mail, as configured by the admin.</p>' +

				'<h2>SMTP</h2>' +

				'<p>The last possible value is <code>smtp</code>.</p>' +

				'<p>Using <code>smtp</code> value for the configuration means that the CodeIgniter library will connect directly to a SMTP server in order to send the mail.</p>' +

				'<p>The way the connection is performed can be configured with the relevant <code>smtp_*</code> options, which are <code>smtp_host</code>, <code>smtp_user</code>, <code>smtp_pass</code>, <code>smtp_port</code> and so on...</p>' +

				'<p>This option is really useful when you are not the admin of the server (e.g. in a shared hosting environment) and thus cant configure the SMTP provider for the server.</p>' +

				'<p>It is also better to choose this rather than the other alternative, because your application will no longer depends on the server proper configuration.</p>' +

				'<hr>' +

				'<h2>Summary</h2>' +

				'<p>The main issue here is that the class and the documentation wrongly use the term <code>protocol</code>.</p>' +

				'<p>SMTP is the protocol for email.</p>' +

				'<p>The option <code>mail</code>, <code>sendmail</code> and <code>smtp</code> are more like <em>endpoints</em>, or <em>sending methods</em>, i.e. what the library should use in order to send the mail.</p>' +

				'<p>I hope this clarifies the documentation a little bit.</p>',
			allowOutsideClick: false,
			showCancelButton: false,
		})
	}
}