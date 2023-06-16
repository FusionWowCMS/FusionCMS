var Mod = {
	kick: function(realm)
	{	
		Swal.fire({
			title: 'Kick',
			html: '<input class="swal2-input" type="text" id="kick_character" placeholder="Character name" value="">',
			preConfirm: () => {
				if((document.getElementById('kick_character').value == "") || (document.getElementById('kick_character').value == '') || ((document.getElementById('kick_character').value == null)) ){
				  Swal.showValidationMessage(
					`Character name can't be empty`
				  )
				}
			}
		}).then(function(result) {
		if (result.isConfirmed) {
			var character = $("#kick_character").val();

			$.get(Config.URL + "mod/tickets/kick/" + realm + "/" + character, function(data)
			{
				console.log(data);
				Swal.fire({
				icon: "success",
				title: 'Character' + " " + character + " " + 'has been kicked',
				});
			});
		}
		})
	},

	close: function(realm, id, element)
	{

		Swal.fire({
				title: 'Do you really want to close this ticket?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, close it!'
			}).then((result) => {
			if (result.isConfirmed) {
				$(element).parents("tr").slideUp(300, function()
				{
					$(this).remove();
				});

				$.get(Config.URL + "mod/tickets/close/" + realm + "/" + id, function(data)
				{
					console.log(data);
				});
			}
			})
	},

	answer: function(realm, id, field)
	{		
		Swal.fire({
			title: 'Answer',
			html: '<textarea id="answer_message" class="swal2-textarea" maxlength="7999"></textarea>',
		}).then(function(result) {
		if (result.isConfirmed) {
			var message = $("#answer_message").val();

			$.post(Config.URL + "mod/tickets/answer/" + realm + "/" + id, {csrf_token_name: Config.CSRF, message:message}, function(data)
			{
				console.log(data);
				Swal.fire({
				icon: "success",
				title: "Mail has been sent",
				});
			});
		}
		})
	},

	unstuck: function(realm, id, field)
	{
		$.post(Config.URL + "mod/tickets/unstuck/" + realm + "/" + id, {csrf_token_name: Config.CSRF}, function(data)
		{
			console.log(data);

			if(data == '1')
			{
				Swal.fire({
					icon: "success",
					title: "The character has been teleported",
				});
			}
			else
			{
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: data,
				})
			}
		});
	},

	banAcc: function()
	{
		Swal.fire({
			title: 'Ban',
			html: '<input type="text" id="ban_account" class="swal2-input" placeholder="Account" value=""><br><input id="reason" class="swal2-input" placeholder="Ban reason" value=""><br><div data-plugin-datepicker data-plugin-skin="primary" id="date" name="date"></div>',
			didOpen: function() {
				$("#date").bootstrapDP({
					todayHighlight: true
				});
			},
		}).then(function(result) {
		if (result.isConfirmed) {
			var account = $("#ban_account").val();
			var reason = $("#reason").val();
			var dateObject = $("#date").bootstrapDP("getDate");
			let date = JSON.stringify(dateObject)
			var date2 = date.slice(1,11)

			$.post(Config.URL + "mod/bans/banAcc/" + account, {reason: reason, date: date2, csrf_token_name: Config.CSRF}, function(data)
			{
				if(data == "1")
				{
					Swal.fire({
						icon: "success",
						title: 'Account' + " " + account + " " + 'has been banned',
					});
					window.location = Config.URL + "mod/bans/";
				}
				else
				{
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
	
	unbanAcc: function(id, element)
	{
		Swal.fire({
				title: 'Do you really want to unban this account?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, unban him!'
			}).then((result) => {
			if (result.isConfirmed) {
				$(element).parents("tr").slideUp(300, function()
				{
					$(this).remove();
				});

				$.get(Config.URL + "mod/bans/unban/" + id, function(data)
				{
					if(data == "1")
					{
						Swal.fire({
							icon: "success",
							title: 'Account has been unbanned',
						});
						window.location = Config.URL + "mod/bans/";
					}
					else
					{
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
	
	banIP: function()
	{
		Swal.fire({
			title: 'Ban',
			html: '<input type="text" id="ban_ip" class="swal2-input" placeholder="IP" value=""><br><input id="reason" class="swal2-input" placeholder="Ban reason" value=""><br><div data-plugin-datepicker data-plugin-skin="primary" id="date" name="date"></div>',
			didOpen: function() {
				$("#date").bootstrapDP({
					todayHighlight: true,
				});
			},
		}).then(function(result) {
		if (result.isConfirmed) {
			var ip = $("#ban_ip").val();
			var reason = $("#reason").val();
			var dateObject = $("#date").bootstrapDP("getDate");
			let date = JSON.stringify(dateObject)
			var date2 = date.slice(1,11)
			console.log(dateObject);
			console.log(date);

			$.post(Config.URL + "mod/bans/banIP", {ip: ip, reason: reason, date: date2, csrf_token_name: Config.CSRF}, function(data)
			{
				if(data == "1")
				{
					Swal.fire({
						icon: "success",
						title: 'IP' + " " + ip + " " + 'has been banned',
					});
				}
				else
				{
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
}