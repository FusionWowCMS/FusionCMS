<script type="text/javascript">
	var shoutCount = {$count},
		shoutsPerPage = {$shoutsPerPage},
		currentShout = 0;

	{literal}
	var Shoutbox = {

		/**
		 * Load more shouts
		 * @param number
		 */
		load: function(number)
		{
			var element = $("#the_shouts");

			currentShout = number;

			element.slideUp(500, function()
			{
				$.get(Config.URL + "sidebox_shoutbox/shoutbox/get/" + number, function(data)
				{
					element.html(data).slideDown(300);

					if(currentShout != 0)
					{
						$("#shoutbox_newer").show();
					}
					else
					{
						$("#shoutbox_newer").hide();
					}

					if(currentShout + shoutsPerPage >= shoutCount)
					{
						$("#shoutbox_older").hide();
					}
					else
					{
						$("#shoutbox_older").show();
					}

				});
			});
		},

		submit: function()
		{
			var message = $("#shoutbox_content");

			if(message.val().length == 0
			|| message.val().length > 255)
			{
				UI.alert("The message must be between 0-255 characters long!");
			}
			else
			{
				// Disable fields
				message.attr("disabled", "disabled");
				$("#shoutbox_submit").attr("disabled", "disabled");

				$.post(Config.URL + "sidebox_shoutbox/shoutbox/submit", {message: message.val(), csrf_token_name: Config.CSRF}, function(data)
				{
					message.val("");
					message.removeAttr("disabled");
					$("#shoutbox_submit").removeAttr("disabled");
					$("#shoutbox_characters_remaining").html("0 / 255");

					var content = JSON.parse(data);

					$("#the_shouts").prepend('<div class="shout" id="my_shout_' + content.uniqueId + '" style="display:none">'+
												'<span class="shout_date">' + content.time + ' ago</span>' +
												'<div class="shout_author"><a href="' + Config.URL + 'profile/' + content.id + '" data-tip="View profile">' + content.name + '</a> said:</div>' +
												content.message +
											'</div>');

					$("#my_shout_" + content.uniqueId).slideDown(300, function()
					{
						Tooltip.refresh();
					});
				});
			}
		},

		remove: function(field, id)
		{
			$(field).parent().parent().slideUp(150, function()
			{
				$(this).remove();
			});
			
			$.get(Config.URL + "sidebox_shoutbox/shoutbox/delete/" + id, function(data)
			{
				console.log(data);
			});
		}
	};
	{/literal}
</script>

<div id="shoutbox">
{if $logged_in == false}
	<form onSubmit="UI.alert('Please log in to shout!');return false;">
		<textarea name="shoutbox_content" placeholder="Please log in to shout!" disabled="disabled"></textarea>
		<div class="shout_characters_remaining"><span id="shoutbox_characters_remaining">0 / 255</span></div>
		<input type="submit" id="shoutbox_submit" value="Submit message"/>
		<div class="clear"></div>
	</form>
{else}
	<form onSubmit="Shoutbox.submit(); return false">
		<textarea
			id="shoutbox_content"
			placeholder="Enter a message..."
			onFocus="this.style.height='70px';"
			onBlur="this.style.height='16px'"
			onkeyup="UI.limitCharacters(this, 'shoutbox_characters_remaining')"
			maxlength="255"
			spellcheck="false"></textarea>
		<div class="shout_characters_remaining"><span id="shoutbox_characters_remaining">0 / 255</span></div>
		<input type="submit" name="shoutbox_submit" value="Submit message" />
		<div class="clear"></div>
	</form>
{/if}

<div class="side_divider"></div>

<div id="the_shouts">{$shouts}</div>

{if $count > 5}
	<div id="shoutbox_view">
		<a href="javascript:void(0)" onClick="Shoutbox.load(currentShout - shoutsPerPage)" id="shoutbox_newer" style="display:none;">&larr; Newer</a>&nbsp;
		&nbsp;<a href="javascript:void(0)" onClick="Shoutbox.load(currentShout + shoutsPerPage)" id="shoutbox_older">Older &rarr;</a>
	</div>
{/if}
</div>