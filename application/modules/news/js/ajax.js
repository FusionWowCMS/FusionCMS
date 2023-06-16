/**
 * @package FusionCMS
 * @version 6.X
 * @author Jesper Lindström
 * @author Xavier Geernick
 * @link http://fusion-hub.com
 */

function Ajax()
{
	this.loaderHTML = '<div style="padding:10px;text-align:center;"><div class="lds-ring"><div></div></div>';
	this.commentCount = 0;

	/**
	 * Show comments
	 * @param Int id
	 */
	this.showComments = function(id)
	{
		var element = $("#comments_" + id);
	
		// If loaded already 
		if(element.html().length > 0)
		{
			if(element.is(":visible"))
			{
				element.slideUp(500);
			}
			else
			{
				element.slideDown(500);
			}
		}
		else
		{
			// Set loading image
			element.html(Ajax.loaderHTML)

			// Show loading image
			element.slideDown(200, function()
			{
				// Load the comments
				$.get(Config.URL + "news/comments/get/" + id,
				function(data)
				{
					element.fadeOut(300, function()
					{
						element.html(data);

						element.fadeIn(300);

						Tooltip.refresh();
					});
				});
			});
		}
	}

	/**
	 * Submit a news comment
	 * @param Int id
	 */
	this.submitComment = function(id)
	{
		var content = $("#comment_field_" + id);

		// Prevent blank comments
		if(content.val().length > 0)
		{
			var message = content.val();

			// Prevent more submissions
			content.attr("disabled", "disabled");
			$("#comment_button_" + id).attr("disabled", "disabled");

			$.post(Config.URL + "news/comments/add/" + id,
			{
				content: message,
				csrf_token_name: Config.CSRF
			},
			function(data)
			{
				content.val('');
				$("#characters_remaining_" + id).html("0 / 255");
				content.removeAttr("disabled");
				$("#comment_button_" + id).removeAttr("disabled", "disabled");

				var button = $("#comments_button_" + id);
				var count = button.html().replace(/[^0-9.]/, "")
				Ajax.commentCount++;

				$("#comments_area_" + id).prepend('<div id="my_comment_' + Ajax.commentCount + '" style="display:none;"></div>');
				$("#my_comment_" + Ajax.commentCount).html(data).slideDown(300);
			});
		}
		else
		{
			UI.alert("The message must be between 0-255 characters long!")
		}
	}

	this.remove = function(field, id)
	{
		$(field).parent().parent().slideUp(function()
		{
			$("#" + id).remove();
		});
		
		$.get(Config.URL + "news/comments/delete/" + id, function(data)
		{
			console.log(data);
		});
	}
}

var Ajax = new Ajax();