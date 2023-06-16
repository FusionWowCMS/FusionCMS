var Topsites = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "topsites",

	/**
	 * The ID of the fusionEditor (like "#news_content"), if any, otherwise put false
	 */
	fusionEditor: false,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "vote/admin/delete/",
		create: "vote/admin/create/",
		save: "vote/admin/save/",
		move: "vote/admin/move/",
		getAutoFillData: "vote/admin/ajaxAutoFillData",
	},

	/**
	 * Removes an entry from the list
	 * @param  Int id
	 * @param  Object element
	 */
	remove: function(id, element)
	{
		var identifier = this.identifier,
			removeLink = this.Links.remove;

		Swal.fire({
			title: 'Do you really want to delete this vote site?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		if (result.isConfirmed) {
			$("#" + identifier + "_count").html(parseInt($("#" + identifier + "_count").html()) - 1);

			$(element).parents("tr").slideUp(300, function()
			{
				$(this).remove();
			});

			$.get(Config.URL + removeLink + id, function(data)
			{
				console.log(data);
			});
		}
		})
	},

	/**
	 * Submit the form contents to the create link
	 * @param Object form
	 */
	create: function(form)
	{
		var values = {
			vote_url:$("#vote_url").val(),
			vote_sitename:$("#vote_sitename").val(),
			vote_image:$("#vote_image").val(),
			hour_interval:$("#hour_interval").val(),
			points_per_vote:$("#points_per_vote").val(),
			callback_enabled:$("#callback_enabled").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + this.Links.create, values, function(response)
		{
			if(response == "yes")
			{
				window.location = Config.URL + "vote/admin";
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

	/**
	 * Submit the form contents to the save link
	 * @param Object form
	 */
	save: function(form, id)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + this.Links.save + id, values, function(data)
		{
			console.log(data);
			eval(data);
		});
	},

	/**
	 * ----------- Module specific code -----------
	 */
	
	/**
	 * Checks if the topsite is known, auto fills data for it.
	 * @param Object field
	 */
	check: function(field)
	{
		$('#callback_form .not-supported').show();
		$('#callback_form .form').hide();
		
		$.ajax({
			url: Config.URL + this.Links.getAutoFillData,
			method: 'POST',
			data: {
				url: field.value,
				csrf_token_name: Config.CSRF
			},
			dataType: 'json',
			success: function(data) 
			{
				// image url autocomplete
				if (data.image) {
					$('#vote_image').val(data.image);
					Topsites.updateImagePreview(data.image);
				}
				
				if ( ! $('#vote_sitename').val())
					$('#vote_sitename').val(data.url);
				
				if (data.callback_support) {
					$('#vote_url').attr('data-format', data.votelink_format);
					
					// update help text
					$('#callback_form .form .dropdown h3 .sitename').remove();
					$('#callback_form .form .dropdown h3').append('<span class="sitename" style="display:inline;margin:0;padding:0">' + data.url + '</span>');
					$('#callback_form .form .dropdown div').html(data.callback_help);
					dropdown.initialize();
					
					// display callback form
					$('#callback_form .not-supported').hide();
					$('#callback_form .form').slideDown(200);
					
					Topsites.updateLinkFormat();
				}
				else {
					$('#callback_form .form select').val(0);
				}
			}
		});
	},
	
	/**
	 * Updates the site image preview pic
	 * @param String url
	 */
	updateImagePreview: function(url)
	{
		$('#vote_image_preview img').attr('src', url).parent().show();
	},
	
	/**
	 * Updates the vote link to include the user id, as required
	 * for vote callbacks.
	 */
	updateLinkFormat: function(selectbox)
	{
		var val = $('#callback_enabled').val();
		var url = $('#vote_url');
		
		if (url.attr('data-format'))
		{
			url.val(
				Topsites.voteLinkFormat( (val == '1' ? 'apply' : 'remove'), url.attr('data-format'), url.val())
			);
		}
		
		return true;
	},
	
	/**
	 * Formats the URL for callback using the given format.
	 * @param String task
	 * @param String format
	 * @param String url
	 * @return String
	 */
	voteLinkFormat: function(task, format, url)
	{
		if (task == 'remove') {
			return url.replace( format.replace('{vote_link}', ''), '');
		}
		else if (task, 'apply') {
			return format.replace('{vote_link}', url);
		}
	}
}
	
	var dropdown = {
		initialize: function()
		{
			$(document).ready(function() {
				dropdown.create('.dropdown');
			});
		},
		
		create: function(element)
		{
			$(element)
				.not('[data-dropdown-initialized]')
				.attr('data-dropdown-initialized', 'true')
				.children('h3')
				.bind('click', function() 
				{
					$(this).next('div').slideToggle(200, function() {

						if ($(this).is(':visible'))
							$(this).parent('.dropdown').addClass('active');
						else
							$(this).parent('.dropdown').removeClass('active');
					});
				});
		}
	}
