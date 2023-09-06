const Security = {
    onChange: function (value) {
        if (value === 'true') {
            $('#security_help').fadeIn(150);
            $('#security_code').fadeIn(150);
        } else {
            $('#security_help').fadeOut(150);
            $('#security_code').fadeOut(150);
        }
    },

    canSubmit: true,

    submit: function()
    {
        // Client-side validation authentication code
        if($("#security_enabled").val() === 'true' && $("#auth_code").val() == '')
        {
            if(Security.canSubmit)
            {
                Swal.fire({
                    text: lang('six_digit_not_empty', 'ucp'),
                    icon: 'error'
                });

                Security.canSubmit = false;
            }
        }
        else
        {
            Security.canSubmit = true;

            // Show that we're loading something
            $("#security_ajax").html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

            // Gather the values
            const values = {
                security_enabled: $("#security_enabled").val(),
                auth_code: $("#auth_code").val(),
                secret: $("#secret").val(),
                csrf_token_name: Config.CSRF
            };

            // Submit the request
            $.post(Config.URL + "ucp/security/submit", values, function(data)
            {
                $("#security_ajax").html('');

                if(/yes/.test(data))
                {
                    Swal.fire({
                        text: lang("changes_saved", "ucp"),
                        icon: 'success',
                        willClose: () => {
                            window.location.reload(true);
                        }
                    });
                }
                else if(/no/.test(data))
                {
                    Swal.fire({
                        text: lang('six_digit_not_true', 'ucp'),
                        icon: 'error'
                    });
                }
                else
                {
                    Swal.fire({
                        text: data,
                        icon: 'error',
                    });
                }
            });
        }
    },
};