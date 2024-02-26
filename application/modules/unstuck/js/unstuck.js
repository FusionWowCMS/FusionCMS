const Unstuck = {

    User: {
        vp: null,
        price: 0,
        character: 0,

        initialize: function (config) {
            this.vp = config.vp;
            this.price = config.price;
        }
    },

    RealmChanged: function () {
        const realmId = $('select[id="realm"]').val();

        $(`[data-character]`).each(function() {
            $(this).next().hide();
        });
        $(`select[id="character_select_${realmId}"]`).next().show();

        this.User.realm = realmId;
    },
    CharacterChanged: function (selectField, realmId) {
        const selected = $(selectField).find('option:selected');

        if (typeof selected != 'undefined' && selected.length > 0) {
            this.User.character = parseInt(selected.val());
        }

        this.User.realm = realmId;
    },

    getPrice: function () {
        return this.User.price;
    },

    busy: false,

    Submit: function (form) {
        if (Unstuck.busy)
            return;

        //Check if we have selected realm
        if (this.User.realm == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Unstuck',
                text: lang("no_realm_selected", "unstuck"),
            })
            return;
        }

        //Check if we have selected character
        if (this.User.character == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Unstuck',
                text: lang("no_char_selected", "unstuck"),
            })
            return;
        }

        var CanAfford = false;

        if (this.getPrice() == 0) {
            CanAfford = true;
        } else {
            if (Unstuck.User.vp < this.getPrice()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Unstuck',
                    text: lang("cant_afford", "unstuck"),
                })
            } else {
                CanAfford = true;
            }
        }

        if (CanAfford) {
            // Make the user confirm the purchase
            Swal.fire({
                title: 'Unstuck',
                text: lang("sure_want_unstack", "unstuck"),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mark as busy
                    Unstuck.busy = true;

                    // Post the data
                    $.post(Config.URL + "unstuck/submit", {
                        realm: Unstuck.User.realm,
                        guid: Unstuck.User.character,
                        csrf_token_name: Config.CSRF
                    }, function (data) {
                        Unstuck.busy = false;
                        data = JSON.parse(data);
                        Swal.fire({
                            text: data.text,
                            icon: data.icon,
                            willClose: () => {
                                if (data.status)
                                    window.location.reload();
                            }
                        });
                    });
                }
            });
        }
    },

    Back: function () {
        window.location = Config.URL + "unstuck";
    }
};