const Ajax = {
    initialize: function () {
        $.get("install/next?step=getEmulators", function (data) {
            data = JSON.parse(data);

            $("#emulator").html("");

            $.each(data, function (key, value) {
                $("#emulator").append('<option value=' + key + '>' + value + '</option>');
            });
        });
    },

    Realms: {
        data: [],

        saveAll: function () {
            Ajax.Realms.data = [];
            $("#realm_field form").each(function () {
				const values = {};
				$(this).find("input, select").each(function () {
                    if ($(this).attr("type") != "submit") {
                        values[$(this).attr("id")] = $(this).val();
                    }
                });
                Ajax.Realms.data.push(values);
            })
        },

        addRealm: function (form) {
            UI.confirm('<input id="realmname_preserve" class="nui-focus border-muted-300 text-white placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 pe-4 ps-4 rounded" placeholder="Enter the realm name" autofocus />', 'Add', function () {
				const name = $("#realmname_preserve").val();

				if (!name)
                    return;

                $("#realm_field").append("<div class=\"realmHeader\" data-active=\"true\"><a onclick='Ajax.Realms.show(this);'><img class='realmExtend' src='" + Config.url + "application/modules/install/images/icons/ic_minus.png' /> " + name + "</a> <img class='realmDelete' src='" + Config.url + "application/modules/install/images/icons/ic_delete.png' onclick='Ajax.Realms.deleteRealm(this);' /></div><div class='realmForm'></div>");
                $("#realm_field .realmForm").html($("#loader").html()).find('#realmName').val(name);
                UI.Tooltip.refresh();
            });
        },

        deleteRealm: function (img) {
            UI.confirm('Are you sure?', 'Yes', function () {
                $(img).parents('.realmHeader, .realmHeader + div.realmForm').fadeOut(200, function () {
                    $(img).parent('.realmHeader').next('.realmForm').remove();
                    $(img).parent('.realmHeader').remove();
                    Ajax.Realms.saveAll();
                });
            });
        },

        show: function (anchor) {
			const div = $(anchor).parents('div.realmHeader');

			if (div.attr("data-active") == "true") {
                div.next('.realmForm').slideUp(200, function () {
                    div.find('img.realmExtend').attr('src', Config.url + "application/modules/install/images/icons/ic_plus.png");
                    div.removeAttr("data-active");
                });

                Ajax.Realms.saveAll();
            } else {
                div.next('.realmForm').slideDown(200, function () {
                    div.find('img.realmExtend').attr('src', Config.url + "application/modules/install/images/icons/ic_minus.png");
                    div.attr("data-active", "true");
                });
            }
        }
    },

    checkPhpVersion: function (onComplete) {
        $.get("install/next?step=checkPhpVersion", function (data) {
            if (data == '1')
                $('.php-version .check-result').css('color', 'green').html('OK!');
            else
                $('.php-version .check-result').addClass('error').css('color', 'red').html('Not installed.');

            if (onComplete !== undefined)
                onComplete(data == '1');
        });
    },

    setAndCheckDbConnection: function (data, onComplete) {
        $.post("install/next?step=setAndCheckDbConnection", data, function (data) {
            if (onComplete !== undefined)
                onComplete(data);
        })
    },

    checkAuthConfig: function (data, onComplete) {
        $.post("install/next?step=checkAuthConfig", data, function (data) {
            if (onComplete !== undefined)
                onComplete(data);
        })
    },

    checkPermissions: function (onComplete) {
		let done = 0;

		if (onComplete !== undefined) {
			const id = setInterval(function () {
				if (done == 6) {
					clearInterval(id);
					onComplete();
				}
			}, 100);
		}

        $.get("install/next?step=folder&test=config&path=application", function (data) {
            if (data == '1') {
                $("#config_folder").css({color: "green"}).removeClass('error').html("/application/config/ is writable");
            } else {
                $("#config_folder").css({color: "red"}).addClass('error').html('/application/config/ needs to be writable (see <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)');
            }

            done++;
        });

        $.get("install/next?step=folder&test=modules&path=application", function (data) {
            if (data == '1') {
                $("#modules_folder").css({color: "green"}).removeClass('error').html("/application/modules/ is writable");
            } else {
                $("#modules_folder").css({color: "red"}).addClass('error').html('/application/modules/ needs to be writable (see <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)');
            }

            done++;
        });

        $.get("install/next?step=folder&test=cache&path=writable", function (data) {
            if (data == '1') {
                $("#cache_folder").css({color: "green"}).removeClass('error').html("/writable/cache/ is writable");
            } else {
                $("#cache_folder").css({color: "red"}).addClass('error').html('/writable/cache/ needs to be writable (see <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)');
            }

            done++;
        });

        $.get("install/next?step=folder&test=backups&path=writable", function (data) {
            if (data == '1') {
                $("#backups_folder").css({color: "green"}).removeClass('error').html("/writable/backups/ is writable");
            } else {
                $("#backups_folder").css({color: "red"}).addClass('error').html('/writable/backups/ needs to be writable (see <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)');
            }

            done++;
        });

        $.get("install/next?step=folder&test=logs&path=writable", function (data) {
            if (data == '1') {
                $("#logs_folder").css({color: "green"}).removeClass('error').html("/writable/logs/ is writable");
            } else {
                $("#logs_folder").css({color: "red"}).addClass('error').html('/writable/logs/ needs to be writable (see <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)');
            }

            done++;
        });

        $.get("install/next?step=folder&test=uploads&path=writable", function (data) {
            if (data == '1') {
                $("#uploads_folder").css({color: "green"}).removeClass('error').html("/writable/uploads/ is writable");
            } else {
                $("#uploads_folder").css({color: "red"}).addClass('error').html('/writable/uploads/ needs to be writable (see <a href="http://en.wikipedia.org/wiki/Chmod" target="_blank">chmod</a>)');
            }

            done++;
        });
    },

    checkPhpExtensions: function (onComplete) {
        $.get("install/next?step=checkPhpExtensions", function (data) {

            if (data != '1') {
                $("#php-extensions-missing .extensions").text(data).parent().show();
                $('.php-extensions .check-result').hide();
            } else {
                $('#php-extensions-missing').hide();
                $('.php-extensions .check-result').css('color', 'green').html('OK!').show();
            }

            if (onComplete !== undefined)
                onComplete(data);
        });
    },

    checkApacheModules: function (onComplete) {
        $.get("install/next?step=checkApacheModules", function (data) {

            if (data == '1') {
                $('#apache-modules-missing').hide();
                $('.apache-modules .check-result').css('color', 'green').html('OK!').show();
            } else if (data == '2') {
                $("#apache-modules-missing .modules").text('Unable to check Apache Modules, make sure required modules are enabled.').parent().show();
                $('.apache-modules .check-result').hide();
            } else {
                $("#apache-modules-missing .modules").text(data).parent().show();
                $('.apache-modules .check-result').hide();
            }

            if (onComplete !== undefined)
                onComplete(data);
        });
    },

    Install: {

        initialize: function (name) {
            $('#install').text('');

            Ajax.Install.configs(name, function () {
                Ajax.Install.database(function () {
                    Ajax.Install.realms(function () {
                        $.get("install/next?step=final", function (data) {
                            if (data != "success") {
                                UI.alert('Please delete or rename the "install" folder and then visit your site again.');
                            } else {
                                UI.alert('Installation successful', 500);

                                setTimeout(function () {
                                    Memory.clear();

                                    // Display actions
                                    $('#install_after_actions').fadeIn();
                                }, 500);
                            }
                        });
                    });
                });
            });
        },

        complete: function () {
            $("#install").append("<div style='color:green;display:inline;'>done</div><br />");
        },

        configs: function (name, callback) {
            $("#install").append("Writing configs...");

			const data = {
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
                cdn_link: $("#cdn_link").val(),
				security_code: $("#security_code").val(),
				emulator: $("#emulator").val(),
				superadmin: name,

				// Auth config (config/auth.php)
				realmd_rbac: $('#realmd_rbac').val(),
				realmd_battle_net: $('#realmd_battle_net').val(),
				realmd_totp_secret: $('#realmd_totp_secret').val(),
				realmd_totp_secret_name: $('#realmd_totp_secret_name').val(),
				realmd_account_encryption: $('#realmd_account_encryption').val(),
				realmd_battle_net_encryption: $('#realmd_battle_net_encryption').val()
			};

			$.post("install/next?step=config", data, function (res) {
                if (res != '1') {
                    UI.alert("Something went wrong: " + res);
                } else {
                    Ajax.Install.complete();
                    callback();
                }
            });
        },

        database: function (callback) {
            $("#install").append("Importing database...");

            $.post("install/next?step=database", function (res) {
                if (res != '1') {
                    UI.alert("Something went wrong: " + res);
                } else {
                    Ajax.Install.complete();
                    callback();
                }
            });
        },

        realms: function (callback) {
            $("#install").append("Creating realms...");

			const data = {
				realms: JSON.stringify(Ajax.Realms.data),
				emulator: $("#emulator").val()
			};

			$.post("install/next?step=realms", data, function (res) {
                if (res != '1') {
                    UI.alert("Something went wrong: " + res);
                } else {
                    Ajax.Install.complete();
                    callback();
                }
            });
        }
    }
};
