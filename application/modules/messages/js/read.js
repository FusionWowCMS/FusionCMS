const Read = {

    reply: function (id) {
        tinyMCE.triggerSave();

        const content = $("textarea.tinymce").val();

        if (content.length <= 3) {
            Swal.fire({
                text: "Message must be longer than 3 characters!",
                icon: 'error',
            });
        } else {
            $("#pm_form").fadeOut(300, function () {
                $(this).html('<a class="nice_button" href="' + Config.URL + 'messages">&larr; ' + lang("inbox", "messages") + '</a>').fadeIn(300);
            });

            $("#pm_spot_ajax").html('<div style="text-align:right;margin-bottom:10px;"><img src="' + Config.image_path + 'ajax.gif" /></div>');

            $.post(Config.URL + "messages/read/reply/" + id, {
                content: content,
                csrf_token_name: Config.CSRF
            }, function (data) {
                window.location.reload(true);
            });
        }
    }
};