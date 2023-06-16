var Ajax = {
	initialize: function()
	{
		$.get("system.php?step=getEmulators", function(data)
		{
			data = JSON.parse(data);

			$("#emulator").html("");

			$.each(data, function(key, value)
			{
				$("#emulator").append('<option value=' + key + '>' + value + '</option>');
			});
		});
	},

	Realms: {
		data: [],

		saveAll: function()
		{
			Ajax.Realms.data = [];
			$("#realm_field form").each(function() {
				var values = {};
			    $( this ).find("input, select").each(function()
				{
					if($(this).attr("type") != "submit")
					{
						values[$(this).attr("id")] = $(this).val();
					}
				});
				Ajax.Realms.data.push(values);
			})
		},

		addRealm: function(form)
		{
			UI.confirm('<input id="realmname_preserve" class="nui-focus border-muted-300 text-white placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-4 rounded" placeholder="Enter the realm name" autofocus />', 'Add', function()
			{
				var name = $("#realmname_preserve").val();
				
				if ( ! name)
					return;
				
				$("#realm_field").append("<div class=\"realmHeader\"><a onclick='Ajax.Realms.show(this);'><img class='realmExtend' src='images/icons/black16x16/ic_plus.png' /> " + name + "</a> <img class='realmDelete' src='images/icons/black16x16/ic_delete.png' onclick='Ajax.Realms.deleteRealm(this);' /></div><div class='realmForm' style='display: none;'></div>");
				$("#realm_field .realmForm").html($("#loader").html()).find('#realmName').val(name);
				UI.Tooltip.refresh();
			});
		},
		
		deleteRealm: function(img)
		{
			UI.confirm('Are you sure?', 'Yes', function() {
				$(img).parents('.realmHeader, .realmHeader + div.realmForm').fadeOut(200, function() {
					Ajax.Realms.saveAll();
				});
			});
		},

		show: function(anchor)
		{
			var div = $(anchor).parents('div.realmHeader');

			if (div.attr("data-active") == "true")
			{
				div.next('.realmForm').slideUp(200, function() {
					div.find('img.realmExtend').attr('src', "images/icons/black16x16/ic_plus.png");
					div.removeAttr("data-active");
				});
				
				Ajax.Realms.saveAll();
			}
			else
			{
				div.next('.realmForm').slideDown(200, function() {
					div.find('img.realmExtend').attr('src', "images/icons/black16x16/ic_minus.png");
					div.attr("data-active", "true");
				});
			}
		}
	},
	
	checkPhpVersion: function(onComplete)
	{
		$.get("system.php?step=checkPhpVersion", function(data)
		{
			if (data == '1')
				$('.php-version .check-result').css('color', 'green').html('OK!');
			else
				$('.php-version .check-result').addClass('error').css('color','red').html('Not installed.');
            
			if (onComplete !== undefined)
				onComplete(data == '1');
		});
	},
	
	checkDbConnection: function(data, onComplete)
	{
		$.post("system.php?step=checkDbConnection", data, function(data) {
			if (onComplete !== undefined)
				onComplete(data);
		})
	},

	checkPermissions: function(onComplete)
	{
        var done = 0;
        
        if (onComplete !== undefined) 
        {
            var id = setInterval(function() {
                if (done == 3) {
                    clearInterval(id);
                    onComplete();
                }
            }, 100);
        }
        
		$.get("system.php?step=folder&test=config", function(data)
		{
			if(data == '1')
			{
				$("#config_folder").css({color:"green"}).removeClass('error').html("/application/config/ is writable");
			}
			else
			{
				$("#config_folder").css({color:"red"}).addClass('error').html('/application/config/ needs to be writable (see <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)');
			}
            
            done++;
		});

		$.get("system.php?step=folder&test=cache", function(data)
		{
			if(data == '1')
			{
				$("#cache_folder").css({color:"green"}).removeClass('error').html("/application/cache/ is writable");
			}
			else
			{
				$("#cache_folder").css({color:"red"}).addClass('error').html('/application/cache/ needs to be writable (see <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)');
			}
            
            done++;
		});

		$.get("system.php?step=folder&test=modules", function(data)
		{
			if(data == '1')
			{
				$("#modules_folder").css({color:"green"}).removeClass('error').html("/application/modules/ is writable");
			}
			else
			{
				$("#modules_folder").css({color:"red"}).addClass('error').html('/application/modules/ needs to be writable (see <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)');
			}
            
            done++;
		});
	},
    
    checkPhpExtensions: function(onComplete) {
        $.get("system.php?step=checkPhpExtensions", function(data) {
            
            if (data != '1') {
                $("#php-extensions-missing .extensions").text(data).parent().show();
				$('.php-extensions .check-result').hide();
            }
            else {
                $('#php-extensions-missing').hide();
				$('.php-extensions .check-result').css('color', 'green').html('OK!').show();
            }
			
            if (onComplete !== undefined)
                onComplete(data);
        });
    },
    
    checkApacheModules: function(onComplete) {
        $.get("system.php?step=checkApacheModules", function(data) {
            
            if (data != '1') {
                $("#apache-modules-missing .modules").text(data).parent().show();
				$('.apache-modules .check-result').hide();
            }
            else {
                $('#apache-modules-missing').hide();
				$('.apache-modules .check-result').css('color', 'green').html('OK!').show();
            }
            
            if (onComplete !== undefined)
                onComplete(data);
        });
    },

	Install: {

		initialize: function(name)
		{
			$('#install').text('');

			Ajax.Install.configs(name, function()
			{
				Ajax.Install.database(function()
				{
					Ajax.Install.realms(function()
					{
						$.get("system.php?step=final", function(data)
						{
							if(data != "success")
							{
								UI.alert('Please delete or rename the "install" folder and then visit <a href="../">your site</a> again.');
							}
							else
							{
								UI.alert('Installation successful', 500);

								setTimeout(function()
								{
									Memory.clear();
									window.location = "../";
								}, 500);
							}
						});
					});
				});
			});
		},

		complete: function()
		{
			$("#install").append("<div style='color:green;display:inline;'>done</div><br />");
		},

		configs: function(name, callback)
		{
			$("#install").append("Writing configs...");

			var data = {
				title: $("#title").val(),
				server_name: $("#server_name").val(),
				realmlist: $("#realmlist").val(),
				max_expansion: $("#max_expansion").val(),
				keywords: $("#keywords").val(),
				description: $("#description").val(),
				analytics: $("#analytics").val(),
				captcha: $("#captcha").val(),
				site_key: $("#site_key").val(),
				secret_key: $("#secret_key").val(),
				cdn: $("#cdn").val(),
				cms_hostname: $("#cms_hostname").val(),
				cms_username: $("#cms_username").val(),
				cms_password: $("#cms_password").val(),
				cms_database: $("#cms_database").val(),
				cms_port: $("#cms_port").val(),
				realmd_hostname: $("#realmd_hostname").val(),
				realmd_username: $("#realmd_username").val(),
				realmd_password: $("#realmd_password").val(),
				realmd_database: $("#realmd_database").val(),
				realmd_port: $("#realmd_port").val(),
				security_code: $("#security_code").val(),
				emulator: $("#emulator").val(),
				superadmin: name
			};

			$.post("system.php?step=config", data, function(res)
			{
				if(res != '1')
				{
					UI.alert("Something went wrong: " + res);
				}
				else
				{
					Ajax.Install.complete();
					callback();
				}
			});
		},

		database: function(callback)
		{
			$("#install").append("Importing database...");

			$.post("system.php?step=database", function(res)
			{
				if(res != '1')
				{
					UI.alert("Something went wrong: " + res);
				}
				else
				{
					Ajax.Install.complete();
					callback();
				}
			});
		},

		realms: function(callback)
		{
			$("#install").append("Creating realms...");

			var data = {
				realms: JSON.stringify(Ajax.Realms.data),
				emulator: $("#emulator").val()
			}

			$.post("system.php?step=realms", data, function(res)
			{
				if(res != '1')
				{
					UI.alert("Something went wrong: " + res);
				}
				else
				{
					Ajax.Install.complete();
					callback();
				}
			});
		}
	}
}