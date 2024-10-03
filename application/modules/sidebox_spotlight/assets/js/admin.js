var Spotlight = {

	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "item",

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "sidebox_spotlight/admin/delete/",
		create: "sidebox_spotlight/admin/create/",
		move: "sidebox_spotlight/admin/move/",
		save: "sidebox_spotlight/admin/save/",
	},

	/**
	 * Removes an entry from the list
	 * @param  Int id
	 * @param  Object element
	 */
	remove: function (id, element) {
		var identifier = this.identifier,
			removeLink = this.Links.remove;

		Swal.fire({
			title: 'Do you really want to delete this Spotlight?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				$("#" + identifier + "_count").html(parseInt($("#" + identifier + "_count").html()) - 1);

				$(element).parents(".card-header").slideUp(300, function () {
					$(this).remove();
				});

				$.get(Config.URL + removeLink + id, function (data) {
					console.log(data);
					window.location = Config.URL + "sidebox_spotlight/admin";

				});
			}
		})
	},

	/**
	 * Submit the form contents to the create link
	 * @param Object form
	 */
	create: function (form) {
		var values = {
			csrf_token_name: Config.CSRF
		};

		$(form).find("input, select").each(function () {
			if ($(this).attr("type") != "submit") {
				values[$(this).attr("name")] = $(this).val();
			}
		});

		$.post(Config.URL + this.Links.create, values, function (data) {
			if (data == "yes") {
				window.location = Config.URL + "sidebox_spotlight/admin";
			} else {
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: data,
				})
			}
		});
	},
	add: function () {
		var id = this.identifier;

		if ($("#add_" + id).is(":visible")) {
			$("#add_" + id).fadeOut(150, function () {
				$("#main_" + id).fadeIn(150);
			});
		} else {
			$("#main_" + id).fadeOut(150, function () {
				$("#add_" + id).fadeIn(150);
			});
		}
	},

	move: function (direction, id, element) {
		var row = $(element).parents("tr");
		var targetRow = (direction == "up") ? row.prev("tr") : row.next("tr");

		if (targetRow.length) {
			$.get(Config.URL + this.Links.move + id + "/" + direction, function (data) {
				console.log(data);
			});

			row.hide(300, function () {
				if (direction == "down") {
					targetRow.after(row);
				} else {
					targetRow.before(row);
				}

				row.slideDown(300);
			});
		}
	},
	edit: function (form, id) {
		var values = {
			csrf_token_name: Config.CSRF
		};

		$(form).find("input, select, textarea").each(function () {
			if ($(this).attr("type") == "checkbox") {
				values[$(this).attr("name")] = this.checked;
			} else if ($(this).attr("type") != "submit") {
				values[$(this).attr("name")] = $(this).val();
			}
		});


		$.post(Config.URL + this.Links.save + id, values, function (data) {
			if (data == "yes") {
				window.location = Config.URL + "sidebox_spotlight/admin";
			} else {
				console.log(data);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: data,
				})
			}
		});
	},


}
