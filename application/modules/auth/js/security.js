const OTP = (() => {
    const self = {};

    const els = (sel, par) => (par || document).querySelectorAll(sel);

    self.getData = (name) => {
        const Inp = document.querySelectorAll('[name="' + name + '"] > input');

        let data = '';

        Inp.forEach((item, ) => {
            data = String(data) + String(item.value);
        });

        return data;
    }

    self.init = () => {
        els(".otp").forEach((elGroup) => {

            const elsInput = [...elGroup.children];
            const len = elsInput.length;

            const handlePaste = (ev) => {
                const clip = ev.clipboardData.getData('text');     // Get clipboard data
                const pin = clip.replace(/\s/g, "");               // Sanitize string
                const ch = [...pin];                               // Create an array of chars

                // Allow numbers only
                if(!/^\d+$/.test(pin) || ch.length !== len) return ev.preventDefault(); // Invalid. Exit here

                elsInput.forEach((el, i) => el.value = ch[i]??""); // Populate inputs
                elsInput[pin.length - 1].focus();                  // Focus input
            };

            const handleInput = (ev) => {
                const val = (ev.data) ? ev.data.replace(/\s/g, '') : '';
                const elInp = ev.currentTarget;
                const i = elsInput.indexOf(elInp);

                // Allow numbers only
                if(val && !/^\d+$/.test(val))
                {
                    elInp.value = '';
                    elInp.focus();
                    return ev.preventDefault()
                }

                if (elInp.value && (i+1) % len) elsInput[i + 1].focus();  // focus next
            };

            const handleKeyDn = (ev) => {
                const elInp = ev.currentTarget
                const i = elsInput.indexOf(elInp);
                if (!elInp.value && ev.key === "Backspace" && i) elsInput[i - 1].focus(); // Focus previous
            };

            // Add the same events to every input in the group:
            elsInput.forEach(elInp => {
                elInp.addEventListener("paste", handlePaste);   // Handle pasting
                elInp.addEventListener("input", handleInput);   // Handle typing
                elInp.addEventListener("keydown", handleKeyDn); // Handle deleting
            });
        });
    };

    return self;
})();

// Call OTP when content is loaded
(document.readyState !== 'loading') ? OTP.init() : document.addEventListener('DOMContentLoaded', () => { OTP.init(); });

const Security = {
    canSubmit: true,

    submit: function()
    {
        const Otp = OTP.getData('otp');

        if(!Security.canSubmit)
            return false;

        // Client-side validation authentication code
        if(Otp.length < 6)
        {
            Swal.fire({
                text: lang('six_digit_not_empty', 'security'),
                icon: 'error'
            });
        }
        else
        {
            Security.canSubmit = false;

            // Show that we're loading something
            $("#security_ajax").html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

            // Gather the values
            const values = {
                digit: Otp,
                csrf_token_name: Config.CSRF
            };

            // Submit the request
            $.post(Config.URL + "auth/checkTotp", values, function(data)
            {
                $("#security_ajax").html('');

                Swal.fire({
                    text: data.text,
                    icon: data.icon,
                    willClose: () => {
                        if (data.status)
                            window.location.replace(Config.URL + 'ucp');
                    }
                });

                Security.canSubmit = true;
            }, 'json');
        }
    },
};