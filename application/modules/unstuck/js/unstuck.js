var Unstuck = {

    User: {

        dp: null,
        price: 0,
        toolid: 0,
        realm: 0,
        character: 0,
        faction: 0,

        initialize: function (config) {
            this.dp = config.dp;
            this.price = config.price;
            this.realm = config.realm;
        }
    },

    RealmChanged: function (selectField) {
        var selected = $(selectField).find('option:selected');

        if (typeof selected != 'undefined' && selected.length > 0) {
            var visible = $('.character_select:visible');
            var id = parseInt(selected.val());

            if (typeof visible != 'undefined' && visible.length > 0) {
                visible.fadeOut('fast', function () {
                    $('#character_select_' + id).fadeIn('fast');
                });
            } else {
                $('#character_select_' + id).fadeIn('fast');
            }

            this.User.realm = id;
        }
    },
    CharacterChanged: function (selectField, realmId) {
        var selected = $(selectField).find('option:selected');

        if (typeof selected != 'undefined' && selected.length > 0) {
            var guid = parseInt(selected.val());

            this.User.character = guid;

        }

        this.User.realm = realmId;
    },
    getPrice: function () {
        var price = this.User.price;


        return price;
    },

    busy: false,

    Submit: function (form) {
        if (Unstuck.busy)
            return;

        //Check if we have selected realm
        if (this.User.realm == 0) {
            
            Swal.fire({
                icon: 'error',
                title: 'character tools',
                text: lang("no_realm_selected", "unstuck"),
            })
            return;
        }

        //Check if we have selected character
        if (this.User.character == 0) 

            Swal.fire({
                icon: 'error',
                title: 'character tools',
                text: lang("no_char_selected", "unstuck"),
            })
            return;
        }

        var CanAfford = false;

        if (this.getPrice() == 0) {
            CanAfford = true;
        } else {
            if (Unstuck.User.dp < this.getPrice()) {

                Swal.fire({
                    icon: 'error',
                    title: 'character tools',
                    text: lang("cant_afford", "unstuck"),
                })


            } else {
                CanAfford = true;
            }
        }

        if (CanAfford) {
            // Make the user confirm the purchase

            Swal.fire({

                title: lang("want_to_buy", "Unstuck"),
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Mark as busy
                    Unstuck.busy = true;
                    Unstuck.DisplayMessage(lang('processing', 'unstuck') + '<br><img src="' + Config.image_path + 'ajax.gif" />');

                    // Post the data
                    $.post(Config.URL + "unstuck/submit", {

                        realm: Unstuck.User.realm,
                        guid: Unstuck.User.character,
                        csrf_token_name: Config.CSRF
                    }, function (data) {
                        // Display the returned message
                        Unstuck.DisplayMessage(data);

                        // Mark the store as no longer bussy
                        Unstuck.busy = false;
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
        window.location = Config.URL + "Unstuck";
    }
}