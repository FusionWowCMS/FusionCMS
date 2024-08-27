const LevelUp = {

    User: {
        dp: null,
        realm: 0,
        character: 0,

        initialize: function (config) {
            this.dp = config.dp;
            this.price = config.price;
        }
    },

    RealmChanged: function () {
        const realmId = $('select[id="realm"]').val();

        $(`[data-character]`).each(function() {
            const nextElement = $(this).next();
            const parentElement = $(this).parent();
            if (nextElement.hasClass('sbHolder')) {
                nextElement.hide();
            } else if (parentElement.hasClass('selectboxit-container')) {
                parentElement.hide();
            } else {
                $(this).hide();
            }
        });

        const selectedElement = $(`select[id="character_select_${realmId}"]`);

        const nextSelectedElement = selectedElement.next();
        if (nextSelectedElement.hasClass('sbHolder') || nextSelectedElement.hasClass('selectboxit-container')) {
            nextSelectedElement.show();
        } else {
            selectedElement.show();
        }

        this.User.realm = realmId;
    },
    CharacterChanged: function (selectField, realmId) {
        var selected = $(selectField).find('option:selected');

        if (typeof selected != 'undefined' && selected.length > 0) {
            this.User.character = parseInt(selected.val());
        }

        this.User.realm = realmId;
    },

    CharacterPrice: function (selectField) {
        var selected = $(selectField).find('option:selected');

        if (typeof selected != 'undefined' && selected.length > 0) {
            this.User.price = parseInt(selected.val());
        }
    },

    busy: false,

    Submit: function () {
        if (this.busy)
            return;

        //Check if we have selected realm
        if (this.User.realm == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Level up',
                text: lang("no_realm_selected", "levelup"),
            })
            return;
        }

        //Check if we have selected character
        if (this.User.character == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Level up',
                text: lang("no_char_selected", "levelup"),
            })
            return;
        }

        var CanAfford = false;

        if (this.User.price == 0) {
            CanAfford = true;
        } else {
            if (LevelUp.User.dp < this.User.price) {
                Swal.fire({
                    icon: 'error',
                    title: 'Level up',
                    text: lang("cant_afford", "levelup"),
                })
            } else {
                CanAfford = true;
            }
        }

        if (CanAfford) {
            // Make the user confirm the purchase
            Swal.fire({
                title: lang("want_to_buy", "levelup"),
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mark as busy
                    LevelUp.busy = true;
                    LevelUp.DisplayMessage(lang('processing', 'levelup') + '<br><img src="' + Config.image_path + 'ajax.gif" />');

                    // Post the data
                    $.post(Config.URL + "levelup/submit", {
                        realm: LevelUp.User.realm,
                        guid: LevelUp.User.character,
                        price: LevelUp.User.price,
                        csrf_token_name: Config.CSRF
                    }, function (data) {
                        // Display the returned message
                        LevelUp.DisplayMessage(data);

                        // Mark the store as no longer bussy
                        LevelUp.busy = false;
                    });
                }
            });
        }
    },

    DisplayMessage: function (data) {
        if ($('#character_tools_message').is(':visible')) {
            $('#character_tools_message').fadeOut('fast', function () {
                $('#character_tools_message').html(data);
                $('#character_tools_message').fadeIn('fast');
            });
        } else {
            $('#character_tools').fadeOut('fast', function () {
                $('#character_tools_message').html(data);
                $('#character_tools_message').fadeIn('fast');
            });
        }
    },

    Back: function () {
        window.location = Config.URL + "levelup";
    }
};