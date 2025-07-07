const Gm = {

    view: function (field) {
        const ticket = $(field).parents(".gm_ticket");

        ticket.children(".gm_ticket_info").slideUp(300, function () {
            ticket.children(".gm_ticket_info_full").slideDown(300, function () {
                ticket.children(".gm_tools").fadeIn(300);
            });
        });
    },

    hide: function (field) {
		const ticket = $(field).parents(".gm_ticket");

		ticket.children(".gm_tools").fadeOut(300, function () {
            ticket.children(".gm_ticket_info_full").slideUp(300, function () {
                ticket.children(".gm_ticket_info").slideDown(300);
            });
        });
    },

    ban: function () {
        Swal.fire({
            title: 'Ban',
            html: '<input type="text" id="ban_account" class="mb-3" placeholder="' + lang("account_name", "gm") + '" value=""><br><input type="text" id="reason" class="mb-3" placeholder="' + lang("ban_reason", "gm") + '" value=""><br><input type="number" min="1" id="day" class="mb-3" placeholder="' + lang("day", "gm") + '" value="">'
        }).then(function (result) {
            if (result.isConfirmed) {
				const account = $("#ban_account").val();
				const reason = $("#reason").val();
				const day = $("#day").val();

				$.post(Config.URL + "gm/ban/" + account, {
                    reason: reason,
                    day: day,
                    csrf_token_name: Config.CSRF
                }, function (data) {
                    if (data == "1") {
                        Swal.fire({
                            icon: "success",
                            title: lang("account", "gm") + " " + account + " " + lang("has_been_banned", "gm"),
                        });
                        window.location = Config.URL + "gm/account_banned";
                    } else {
                        console.log(data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: data,
                        })
                    }
                });
            }
        })
    },

    unbanAccount: function (id) {
        Swal.fire({
            title: 'Do you really want to unban this account?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, unban him!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.get(Config.URL + "gm/account_banned/unban/" + id, function (data) {
                    if (data == "1") {
                        Swal.fire({
                            icon: "success",
                            title: 'Account has been unbanned',
                        });
                        window.location = Config.URL + "gm/account_banned";
                    } else {
                        console.log(data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: data,
                        })
                    }
                });
            }
        })
    },

    kick: function (realm) {
        Swal.fire({
            title: 'Kick',
            html: '<input type="text" id="kick_character" placeholder="' + lang("character_name", "gm") + '" value="">',
            preConfirm: () => {
                if ((document.getElementById('kick_character').value == "") || (document.getElementById('kick_character').value == '') || ((document.getElementById('kick_character').value == null))) {
                    Swal.showValidationMessage(
                        `Character name can't be empty`
                    )
                }
            }
        }).then(function (result) {
            if (result.isConfirmed) {
				const character = $("#kick_character").val();

				$.get(Config.URL + "gm/kick/" + realm + "/" + character, function (data) {
                    console.log(data);
                    Swal.fire({
                        icon: "success",
                        title: lang("character_has_been_kicked", "gm"),
                    });
                });
            }
        })
    },

    close: function (realm, id, field) {
        Swal.fire({
            title: lang("close_ticket", "gm"),
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: lang("close_short", "gm")
        }).then((result) => {
            if (result.isConfirmed) {
                $(field).parents("div.gm_ticket").slideUp(300, function () {
                    $(this).remove();
                });

                $.get(Config.URL + "gm/close/" + realm + "/" + id);
            }
        })
    },

    answer: function (realm, id, field) {
        Swal.fire({
            title: 'Answer',
            html: '<textarea id="answer_message" class="swal2-textarea" maxlength="7999"></textarea>',
        }).then(function (result) {
            if (result.isConfirmed) {
				const message = $("#answer_message").val();

				$.post(Config.URL + "gm/answer/" + realm + "/" + id, {
                    csrf_token_name: Config.CSRF,
                    message: message
                }, function (data) {
                    console.log(data);
                    Swal.fire({
                        icon: "success",
                        title: "Mail has been sent",
                    });
                });
            }
        })
    },

    unstuck: function (realm, id, field) {
        $.post(Config.URL + "gm/unstuck/" + realm + "/" + id, {csrf_token_name: Config.CSRF}, function (data) {
            console.log(data);

            if (data == '1') {
                Swal.fire({
                    icon: "success",
                    title: lang("teleported", "gm"),
                });
            } else if (data == '3') {
                Swal.fire({
                    icon: "error",
                    title: lang("must_be_offline", "gm"),
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data,
                })
            }
        });
    },

    sendItem: function (realm, id, field) {
        Swal.fire({
            title: 'Send Item',
            html: '<input type="text" id="item_id" placeholder="Item ID" value=""/>'
        }).then(function (result) {
            if (result.isConfirmed) {
				const item = $("#item_id").val();

				$.post(Config.URL + "gm/sendItem/" + realm + "/" + id, {
                    csrf_token_name: Config.CSRF,
                    item: item
                }, function (data) {
                    Swal.fire({
                        icon: "success",
                        title: lang("item_sent", "gm"),
                    });
                });
            }
        })
    },

    banIP: function () {
        Swal.fire({
            title: 'Ban Ip',
            html: '<input type="text" id="ban_ip" class="mb-3" placeholder="' + lang("ip", "gm") + '" value=""><br><input type="text" id="reason" class="mb-3" placeholder="' + lang("ban_reason", "gm") + '" value=""><br><input type="number" min="1" id="day" class="mb-3" placeholder="' + lang("day", "gm") + '" value="">'
        }).then(function (result) {
            if (result.isConfirmed) {
				const ip = $("#ban_ip").val();
				const reason = $("#reason").val();
				const day = $("#day").val();

				$.post(Config.URL + "gm/ip_banned/banIP", {
                    ip: ip,
                    reason: reason,
                    day: day,
                    csrf_token_name: Config.CSRF
                }, function (data) {
                    if (data == "1") {
                        Swal.fire({
                            icon: "success",
                            title: 'IP' + " " + ip + " " + 'has been banned',
                        });
                        window.location = Config.URL + "gm/ip_banned";
                    } else {
                        console.log(data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: data,
                        })
                    }
                });
            }
        })
    },

    unbanIp: function (ip) {
        Swal.fire({
            title: 'Do you really want to unban this ip?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, unban him!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.post(Config.URL + "gm/ip_banned/unbanIP", {ip: ip, csrf_token_name: Config.CSRF}, function (data) {
                    if (data == "1") {
                        Swal.fire({
                            icon: "success",
                            title: 'ip has been unbanned',
                        });
                        window.location = Config.URL + "gm/ip_banned";
                    } else {
                        console.log(data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: data,
                        })
                    }
                });
            }
        })
    }
};