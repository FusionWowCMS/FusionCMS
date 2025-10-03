{if $polls}
    <script type="text/javascript">
        var show_results = "{lang("show_results", "sidebox_poll")}";
        var show_options = "{lang("show_options", "sidebox_poll")}";

        const Poll = {
            toggle: function (field, pollId) {
                if ($("#poll_results_" + pollId).is(":visible")) {
                    $("#poll_results_" + pollId).slideUp(300, function () {
                        $(field).html(show_results);
                        $("#poll_answers_" + pollId).slideDown(300);
                    });
                } else {
                    $("#poll_answers_" + pollId).slideUp(300, function () {
                        $(field).html(show_options);
                        $("#poll_results_" + pollId).slideDown(300);
                    });
                }
            },

            vote: function (questionid, id, element) {
                const isOnline = {$online ? 'true' : 'false'};

                if (!isOnline) {
                    UI.alert('{lang("log_in", "sidebox_poll")}');
                    return;
                }

                if (element.checked) {
                    $("#poll_actions_" + questionid).fadeOut(150, function () {
                        $(this).remove();
                    });

                    $("#poll_answers_" + questionid).fadeOut(300, function () {
                        $(this).html('<i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i>')
                            .fadeIn(150, function () {

                                $.post(Config.URL + "sidebox_poll/poll/vote/" + questionid + "/" + id,
                                    { csrf_token_name: Config.CSRF },
                                    function (data) {
                                        var voteBox = $("#poll_option_" + id + "_votes");
                                        var currentVotes = parseInt(voteBox.html()) || 0;
                                        voteBox.html(currentVotes + 1);

                                        $("#poll_answers_" + questionid).fadeOut(150, function () {
                                            $("#poll_results_" + questionid).fadeIn(300, function () {
                                                var pollTotal = 0;

                                                $("#poll_results_" + questionid + " .poll_votes_count").each(function () {
                                                    var v = parseInt($(this).html()) || 0;
                                                    pollTotal += v;
                                                });

                                                $("#poll_results_" + questionid + " .poll_answer").each(function () {
                                                    var votes = parseInt($(this).find(".poll_votes_count").html()) || 0;
                                                    var percent = 0;

                                                    if (votes > 0 && pollTotal > 0) {
                                                        percent = (votes / pollTotal) * 100;
                                                        if (percent > 99) {
                                                            percent = 99;
                                                        }
                                                    }

                                                    $(this).find(".poll_bar_fill")
                                                        .animate({ width: percent + "%" }, 300);
                                                });
                                            });
                                        });
                                    }
                                );
                            });
                    });
                }
            },

            bindRadios: function () {
                var $radios = $('input.poll_radio');

                if ($.fn.iCheck) {
                    $radios.each(function () {
                        var $r = $(this);

                        if ($r.parent().hasClass('iradio_futurico')) {
                            $r.iCheck('destroy');
                        }

                        $r.iCheck({
                            radioClass: 'iradio_futurico',
                            increaseArea: '20%'
                        });

                        $r.off('ifChecked.poll').on('ifChecked.poll', function () {
                            var $this = $(this);
                            var pollId = $this.data('pollid');
                            var answerId = $this.data('answerid');
                            Poll.vote(pollId, answerId, this);
                        });
                    });
                } else {
                    $radios.off('click.poll').on('click.poll', function () {
                        var $this = $(this);
                        var pollId = $this.data('pollid');
                        var answerId = $this.data('answerid');
                        Poll.vote(pollId, answerId, this);
                    });
                }
            }
        };

        $(document).ready(function () {
            Poll.bindRadios();
        });
    </script>

    {foreach from=$polls item=poll}
        <div class="poll_box">
            <div class="poll_question">{$poll.question}</div>

            {if $poll.answers}
                {if !$poll.myVote}
                    <div id="poll_answers_{$poll.questionid}">
                        {foreach from=$poll.answers item=answer}
                            <div class="poll_answer">
                                <label for="poll_option_{$answer.answerid}">
                                    <input type="radio" class="poll_radio" name="poll_options_{$poll.questionid}" id="poll_option_{$answer.answerid}" data-pollid="{$answer.questionid}" data-answerid="{$answer.answerid}"/>
                                    {$answer.answer}
                                </label>
                            </div>
                        {/foreach}
                    </div>
                {/if}

                <div id="poll_results_{$poll.questionid}" {if !$poll.myVote}style="display:none;"{/if}>
                    {foreach from=$poll.answers item=answer}
                        <div class="poll_answer">
                            {if $poll.myVote == $answer.answerid}
                                <b>{$answer.answer} (<span class="poll_votes_count" id="poll_option_{$answer.answerid}_votes">{$answer.votes}</span>)
                                </b>
                            {else}
                                {$answer.answer} (<span class="poll_votes_count" id="poll_option_{$answer.answerid}_votes">{$answer.votes}</span>)
                            {/if}

                            <div class="poll_bar">
                                <div class="poll_bar_fill" id="poll_option_{$answer.answerid}_bar" style="width:{$answer.percent}%"></div>
                            </div>
                        </div>
                    {/foreach}
                </div>

                {if !$poll.myVote}
                    <a id="poll_actions_{$poll.questionid}" class="nice_button poll_actions" href="javascript:void(0)" onClick="Poll.toggle(this, {$poll.questionid})">
                        {lang("show_results", "sidebox_poll")}
                    </a>
                    <div style="height:10px"></div>
                {/if}
            {else}
                <center>{lang("no_poll", "sidebox_poll")}</center>
            {/if}
        </div>
        {if !$poll@last}<hr/>{/if}
    {/foreach}
{/if}
