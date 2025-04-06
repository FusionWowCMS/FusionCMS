/**
 * Tooltip related functions
 */
function Tooltip() {
    this.tooltip_element = "fusion_tooltip";
    /**
     * Add event-listeners
     */
    this.initialize = function () {
        // Add the tooltip element
        $("body").prepend('<div id="' + Tooltip.tooltip_element + '" style="display:none;"></div>');

        // Add mouse-over event listeners
        this.addEvents();
    }

    /**
     * Used to support Ajax content
     * Reloads the tooltip elements
     */
    this.refresh = function () {
        // Remove all
        $("[data-tip]").unbind('hover');
        $("[data-character-tip]").unbind('hover');

        // Re-add
        this.addEvents();
    }

    /**
     * Adds mouseover events to all elements
     * that should show a tooltip.
     */
    this.addEvents = function () {
        Tooltip.addEvents.handleMouseMove = function (e) {
            Tooltip.move(e.pageX, e.pageY);
        }

        // Add mouse-over event listeners
        $("[data-tip]").hover(
            function () {
                $(document).bind('mousemove', Tooltip.addEvents.handleMouseMove);
                Tooltip.show($(this).attr("data-tip"));
            },
            function () {
                $("#" + Tooltip.tooltip_element).hide();
                $(document).unbind('mousemove', Tooltip.addEvents.handleMouseMove);
            }
        );

        // Characters
        $("[data-character-tip]").hover(
            function () {
                $(document).bind('mousemove', Tooltip.addEvents.handleMouseMove);

                // `Attributes`: Initialize
                const attributes = this.dataset;

                Tooltip.Character.get(this, function (data) {
                    Tooltip.show(data, attributes);
                });
            },
            function () {
                $("#" + Tooltip.tooltip_element).hide();
                $(document).unbind('mousemove', Tooltip.addEvents.handleMouseMove);
            }
        );

        if (Config.UseFusionTooltip) {
            $("[rel]").hover(
                function () {
                    $(document).bind('mousemove', Tooltip.addEvents.handleMouseMove);

                    // `Attributes`: Initialize
                    let attributes = {};

                    // `Rel`: Get attribute
                    let rel = $(this).attr('rel');

                    // `Rel`: Explode attribute
                    rel = rel.split('&');

                    // `Rel`: Loop through
                    Object.keys(rel).map((key) => {
                        // `Rel`: Explode
                        rel[key] = rel[key].split('=');

                        // `Rel`: Invalid
                        if (rel[key].length !== 2)
                            return;

                        // `Attributes`: Push
                        attributes[rel[key][0]] = rel[key][1];
                    });

                    if (typeof attributes.item !== 'undefined') {
                        Tooltip.Item.get(this, attributes, function (data) {
                            Tooltip.show(data, attributes);
                        });
                    }
                },
                function () {
                    $(document).unbind('mousemove', Tooltip.addEvents.handleMouseMove);
                    $("#" + Tooltip.tooltip_element).hide();
                }
            );
        }
    }

    /**
     * Moves tooltip
     * @param Int x
     * @param Int y
     */
    this.move = function (x, y) {
        // Get half of the width
        var width = ($("#" + Tooltip.tooltip_element).css("width").replace("px", "") / 2);

        // Position it at the mouse, and center
        $("#" + Tooltip.tooltip_element).css("left", x - width).css("top", y + 25);
    }

    /**
     * Displays the tooltip
     * @param Object element
     * @param Object attributes
     */
    this.show = function (data, attributes) {
        if (attributes) {
            // `Attributes`: Loop through
            Object.keys(attributes).map((key) => {
                // Modifier available
                if (typeof Tooltip['modifier_' + key] === 'function')
                    data = Tooltip['modifier_' + key](attributes[key], data);
            });
        }

        $("#" + Tooltip.tooltip_element).html(data).show();
    }

    /**
     * Modifier: Transmog
     * Apply tooltip data modifier
     *
     * @param  string value
     * @param  string data
     * @return string data
     */
    this.modifier_transmog = function (value, data) {
        return data = data.replace('<!--nend-->', '<!--nend--><div style="color: #e060df; font-weight: bold;">Transmogrified to:<br />' + value + '</div>');
    }

    /**
     * Item tooltip object
     */
    this.Item = new function () {
        /**
         * Loading HTML
         */
        this.loading = "<i class=\"fa-duotone fa-spinner-third fa-spin\"></i> Loading...";

        /**
         * Runtime cache
         */
        this.cache = [];

        /**
         * The currently displayed item ID
         */
        this.currentId = false;

        /**
         * Load an item and display it in the tooltip
         * @param Object element
         * @param Object attributes
         * @param Function callback
         */
        this.get = function (element, attributes, callback) {
            var obj = $(element);
            var realm = obj.attr("data-realm");
            var id = attributes.item;
            Tooltip.Item.currentId = id;

            if (id in this.cache) {
                callback(this.cache[id])
            } else {
                var cache = Tooltip.Item.CacheObj.get("item_" + realm + "_" + id + "_" + Config.language);

                if (cache !== false) {
                    callback(cache);
                } else {
                    callback(this.loading);

                    $.get(Config.URL + "tooltip/" + realm + "/" + id, function (data) {
                        // Cache it this visit
                        Tooltip.Item.cache[id] = data;
                        Tooltip.Item.CacheObj.save("item_" + realm + "_" + id + "_" + Config.language, data);

                        // Make sure it's still visible
                        if ($("#" + Tooltip.tooltip_element).is(":visible") && Tooltip.Item.currentId == id) {
                            callback(data);
                        }
                    });
                }
            }
        }

        this.CacheObj = new function () {
            /**
             * Get cache from localStorage
             * @param String name
             * @return Mixed
             */
            this.get = function (name) {
                if (typeof localStorage != "undefined") {
                    var cache = localStorage.getItem(name);

                    if (cache) {
                        cache = JSON.parse(cache);

                        // If it hasn't expired
                        if (cache.expiration > Math.round((new Date()).getTime() / 1000)) {
                            return cache.data;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }

            /**
             * Save data to localStorage
             * @param String name
             * @param String data
             * @param Int expiration
             */
            this.save = function (name, data) {
                if (typeof localStorage != "undefined") {
                    var time = Math.round((new Date()).getTime() / 1000);
                    var expiration = time + 60 * 60 * 24;

                    localStorage.setItem(name, JSON.stringify({"data": data, "expiration": expiration}));
                }
            }
        }
    }

    this.Character = new function (e) {
        /**
         * Loading HTML
         */
        this.loading = "<i class=\"fa-duotone fa-spinner-third fa-spin\"></i> Loading...";

        /**
         * Runtime cache
         */
        this.cache = [];

        /**
         * The current character ID
         */
        this.currentId = false;

        /**
         * Load an item and display it in the tooltip
         * @param Object element
         * @param Object attributes
         * @param Function callback
         */
        this.get = function (element, callback) {
            if (typeof $(element).attr('data-character-tip') == 'undefined' || $(element).attr('data-character-tip').length == 0)
                return;

            if (typeof $(element).attr('data-realm') == 'undefined' || $(element).attr('data-realm').length == 0)
                return;

            const characterId = $(element).attr('data-character-tip');
            const realmId = $(element).attr('data-realm');
            Tooltip.Character.currentId = characterId;

            if (characterId in this.cache) {
                callback(this.cache[characterId])
            } else {
                var cache = Tooltip.Character.CacheObj.get("character_" + realmId + "_" + characterId + "_" + Config.language);

                if (cache !== false) {
                    callback(cache);
                } else {
                    callback(this.loading);

                    // Make the request
                    this.request = $.ajax(
                        {
                            type: "GET",
                            url: Config.URL + 'character_tooltip/' + realmId + '/' + characterId,
                        })
                        .done(function (data) {
                            // Cache it this visit
                            Tooltip.Character.cache[characterId] = data;
                            Tooltip.Character.CacheObj.save("character_" + realmId + "_" + characterId + "_" + Config.language, data);

                            // Make sure it's still visible
                            if ($("#" + Tooltip.tooltip_element).is(":visible") && Tooltip.Character.currentId == characterId) {
                                callback(data);
                            }
                        });
                }
            }

        }

        this.CacheObj = new function () {
            /**
             * Get cache from localStorage
             * @param String name
             * @return Mixed
             */
            this.get = function (name) {
                if (typeof localStorage != "undefined") {
                    var cache = localStorage.getItem(name);

                    if (cache) {
                        cache = JSON.parse(cache);

                        // If it hasn't expired
                        if (cache.expiration > Math.round((new Date()).getTime() / 1000)) {
                            return cache.data;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }

            /**
             * Save data to localStorage
             * @param String name
             * @param String data
             * @param Int expiration
             */
            this.save = function (name, data) {
                if (typeof localStorage != "undefined") {
                    var time = Math.round((new Date()).getTime() / 1000);
                    var expiration = time + 60 * 60 * 24;

                    localStorage.setItem(name, JSON.stringify({"data": data, "expiration": expiration}));
                }
            }
        }
    }
}

var Tooltip = new Tooltip();
