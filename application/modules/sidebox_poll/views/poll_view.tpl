{if $poll}
	<script type="text/javascript">
		var pollTotal = {$total};

		var show_results = "{lang("show_results", "sidebox_poll")}";
		var show_options = "{lang("show_options", "sidebox_poll")}";

		{literal}
			var Poll = {

				toggle: function(field)
				{
					if($("#poll_results").is(":visible"))
					{
						$("#poll_results").slideUp(300, function()
						{
							$(field).html(show_results);
							$("#poll_answers").slideDown(300);
						});
					}
					else
					{
						$("#poll_answers").slideUp(300, function()
						{
							$(field).html(show_options);
							$("#poll_results").slideDown(300);
						});
					}
				},

				vote: function(questionid, id, element)
				{
					if(element.checked)
					{
						$("#poll_actions").fadeOut(150, function()
						{
							$(this).remove();
						});

						$("#poll_answers").fadeOut(300, function()
						{
							$(this).html('<i class="fas fa-spinner fa-pulse"></i>').fadeIn(150, function()
							{
								$.post(Config.URL + "sidebox_poll/poll/vote/" + questionid + "/" + id, {csrf_token_name: Config.CSRF}, function(data)
								{
									$("#poll_option_" + id +"_votes").html(parseInt($("#poll_option_" + id +"_votes").html()) + 1);

									$("#poll_answers").fadeOut(150, function()
									{
										$("#poll_results").fadeIn(300, function()
										{
											var percent;
											pollTotal++;

											$(".poll_answer").each(function()
											{
												if(parseInt($(this).find(".poll_votes_count").html()) == 0)
												{
													percent = 0;
												}
												else
												{
													percent = (parseInt($(this).find(".poll_votes_count").html()) / (pollTotal)) * 100;

													if(percent > 99)
													{
														percent = 99;
													}
												}

												$(this).find(".poll_bar_fill").animate({width:percent + "%"}, 300);
											});
										});
									});
								});
							});
						});
					}
				}
			};
		{/literal}
	</script>

	<div class="poll_question">{$poll.question}</div>

	{if $poll.answers}

		{if !$myVote}
			<div id="poll_answers">
				{foreach from=$poll.answers item=answer}
					<div class="poll_answer">
						<label for="poll_option_{$answer.answerid}">
							<input type="radio" name="poll_options" id="poll_option_{$answer.answerid}" {if $online}onChange="Poll.vote({$answer.questionid}, {$answer.answerid}, this)"{else}onClick="UI.alert('{lang("log_in", "sidebox_poll")}')"{/if}/>
							{$answer.answer}
					</label>
					</div>
				{/foreach}
			</div>
		{/if}

		<div id="poll_results" {if !$myVote}style="display:none;"{/if}>
			{foreach from=$poll.answers item=answer}
				<div class="poll_answer">
					<div class="poll_votes_count" id="poll_option_{$answer.answerid}_votes">
						{$answer.votes}
					</div>

					{if $myVote == $answer.answerid}
						<b>{$answer.answer}</b>
					{else}
						{$answer.answer}
					{/if}

					<div class="poll_bar">
						<div class="poll_bar_fill" id="poll_option_{$answer.answerid}_bar" style="width:{$answer.percent}%"></div>
					</div>
				</div>
			{/foreach}
		</div>

		{if !$myVote}
			<a id="poll_actions" class="nice_button" href="javascript:void(0)" onClick="Poll.toggle(this)">
				{lang("show_results", "sidebox_poll")}
			</a>
			<div style="height:10px"></div>
		{/if}
	{else}
		<center>{lang("no_poll", "sidebox_poll")}</center>
	{/if}
{/if}