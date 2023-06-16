!(function () {
    "use strict";
    var e = function (t, s) {
        return (e =
            Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array &&
                function (e, t) {
                    e.__proto__ = t;
                }) ||
            function (e, t) {
                for (var s in t) Object.prototype.hasOwnProperty.call(t, s) && (e[s] = t[s]);
            })(t, s);
    };
    var t = function () {
        return (t =
            Object.assign ||
            function (e) {
                for (var t, s = 1, i = arguments.length; s < i; s++) for (var o in (t = arguments[s])) Object.prototype.hasOwnProperty.call(t, o) && (e[o] = t[o]);
                return e;
            }).apply(this, arguments);
    };
    function s() {
        for (var e = 0, t = 0, s = arguments.length; t < s; t++) e += arguments[t].length;
        var i = Array(e),
            o = 0;
        for (t = 0; t < s; t++) for (var n = arguments[t], a = 0, r = n.length; a < r; a++, o++) i[o] = n[a];
        return i;
    }
    var i = (function () {
            function e() {
                var e = this;
                (this.pluginMode = "insert"),
                    (this.elStyles = {}),
                    (this.miscAttributes = []),
                    (this.miscClasses = []),
                    (this.reservedAttributes = []),
                    (this.reservedClasses = []),
                    (this.reservedClassesRegex = []),
                    (this.reservedIconClasses = []),
                    (this.reservedIconClassesRegex = []),
                    (this.reservedStyles = []),
                    (this.btnToggleActiveClass = "btn-primary"),
                    (this.btnToggleInactiveClass = "btn-outline-secondary"),
                    (this.beautifyOptions = {
                        indent_size: "4",
                        indent_char: " ",
                        max_preserve_newlines: "5",
                        preserve_newlines: !0,
                        keep_array_indentation: !1,
                        break_chained_methods: !1,
                        indent_scripts: "normal",
                        brace_style: "collapse",
                        space_before_conditional: !0,
                        unescape_strings: !1,
                        jslint_happy: !1,
                        end_with_newline: !1,
                        wrap_line_length: "0",
                        indent_inner_html: !1,
                        comma_first: !1,
                        e4x: !1,
                        indent_empty_lines: !1,
                    }),
                    (this.bootstrapDialogLogo =
                        '<span id="bootstrap-dialog-logo"><svg width="24" height="24"><path d="M16.7 11.7c2 1 2.8 2.6 2.6 4.6-.4 2.1-1.5 3.4-3.6 3.8-1 .2-2.2.2-3.3.2H6v-16H14c2.3 0 4 1.2 4.4 3 .3 1.8-.1 3.3-1.8 4.4zM9 17.8h4.8c1.4 0 2.3-.8 2.4-2 .1-1.4-.6-2.4-2-2.5-1.7-.2-3.4 0-5.2 0v4.5zm0-11v4h4.6c1.2 0 1.8-.8 1.8-2s-.5-2-1.8-2H9z"></path></svg></span>'),
                    (this.editor = window.parent.tinymce.activeEditor),
                    (this.bsInstance = window.parent.tinymce.activeEditor.plugins.bootstrap.getInstance()),
                    (this.parentDocument = window.parent.document);
                var t = this.bsInstance.pluginUrl;
                loadjs(this.bsInstance.bootstrapCss),
                    loadjs(
                        [
                            "https://code.jquery.com/jquery-3.4.1.min.js",
                            t + "langs/" + this.bsInstance.language + "-dialogs.js",
                            t + "assets/js/dialogs-dot-data.js",
                            t + "lib/dot/dot.min.js",
                            t + "lib/prism/prism.min.css",
                            t + "lib/prism/prism.min.js",
                        ],
                        "bundle1"
                    ),
                    loadjs.ready("bundle1", function () {
                        e.setPluginMode(),
                            jQuery.noConflict(),
                            jQuery(window.parent.document).find(".tox-dialog__header").prepend(e.bootstrapDialogLogo),
                            jQuery(".selector *[data-value]").each(function () {
                                jQuery(this).closest(".selector").attr("title", jQuery(this).data("value"));
                            }),
                            loadjs([t + "lib/js-beautify/beautify-html.min.js"], "js-beautify"),
                            loadjs([t + "lib/nice-check/dist/js/jquery.nice-check.min.js", t + "lib/nice-check/dist/css/nice-check-gray-dark.min.css"], "niceCheck"),
                            loadjs.ready("niceCheck", function () {
                                jQuery("body").niceCheck();
                            }),
                            loadjs.ready("js-beautify", function () {
                                e.init();
                            });
                    });
            }
            return (
                (e.prototype.init = function () {}),
                (e.prototype.addOriginalAttributes = function () {
                    if (!Object.keys(this.miscAttributes).length) return "";
                    for (var e = " ", t = 0, s = Object.entries(this.miscAttributes); t < s.length; t++) {
                        var i = s[t];
                        e += i[0] + '="' + i[1] + '"';
                    }
                    return e;
                }),
                (e.prototype.addOriginalClasses = function () {
                    return this.miscClasses.length ? " " + this.miscClasses.join(" ") : "";
                }),
                (e.prototype.escapeHtml = function (e) {
                    var t = { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;" };
                    return e.replace(/[&<>"']/g, function (e) {
                        return t[e];
                    });
                }),
                (e.prototype.getOriginalAttributes = function (e) {
                    var t = this;
                    void 0 === e.classList && (e = e[0]);
                    for (
                        var i = s(this.reservedAttributes, ["data-mce-href", "data-mce-selected", "data-mce-src", "data-mce-style", "src", "style"]),
                            o = this.reservedClasses,
                            n = this.reservedStyles,
                            a = void 0,
                            r = 0,
                            c = e.classList,
                            l = c.length;
                        r < l;
                        r++
                    )
                        if (((a = c[r]), -1 === o.indexOf(a)))
                            if (this.reservedClassesRegex.length < 1) this.miscClasses.push(a);
                            else
                                for (var u = 0; u < this.reservedClassesRegex.length; u++) {
                                    var h = new RegExp(this.reservedClassesRegex[u], "g");
                                    a.match(h) || this.miscClasses.push(a);
                                }
                    var p = void 0,
                        d = ((r = 0), e.attributes);
                    for (l = d.length; r < l; r++) "class" !== (p = d[r]).nodeName && -1 === i.indexOf(p.nodeName) && (this.miscAttributes[p.nodeName] = p.nodeValue);
                    var f = "";
                    if (
                        (Object.keys(this.elStyles).forEach(function (e) {
                            -1 === n.indexOf(e) && (f += " " + t.reverseCamelize(e) + ":" + t.elStyles[e] + ";");
                        }),
                        f.length > 0)
                    ) {
                        this.miscAttributes.style = f.trim();
                    }
                }),
                (e.prototype.getIconClass = function (e) {
                    var t = this,
                        s = [],
                        i = jQuery(e).attr("class").split(" "),
                        o = this.bsInstance.iconBaseClasses.join("|").length,
                        n = new RegExp(this.bsInstance.iconSearchClass, "g"),
                        a = new RegExp(this.bsInstance.iconBaseClasses.join("|"), "g");
                    return (
                        jQuery.each(i, function (e, i) {
                            if (i.match(n)) {
                                var r = !1;
                                if (-1 !== t.reservedIconClasses.indexOf(i) || -1 !== t.reservedClasses.indexOf(i)) r = !0;
                                else
                                    for (var c = 0; c < t.reservedIconClassesRegex.length; c++) {
                                        var l = new RegExp(t.reservedIconClassesRegex[c], "g");
                                        i.match(l) && (r = !0);
                                    }
                                !1 === r && s.push(i);
                            } else o > 0 && i.match(a) && s.push(i);
                        }),
                        s.join(" ")
                    );
                }),
                (e.prototype.getStyles = function (e) {
                    var t = {};
                    if (!e || !e.style || !e.style.cssText) return t;
                    for (var s = e.style.cssText.split(";"), i = 0; i < s.length; ++i) {
                        var o = s[i].trim();
                        if (o) {
                            var n = o.split(":");
                            t[this.camelize(n[0].trim())] = n[1].trim();
                        }
                    }
                    return t;
                }),
                (e.prototype.initEvents = function (e) {
                    var t = this;
                    void 0 === e && (e = !0),
                        !0 === e &&
                            (jQuery(".selector").on("click", function (e) {
                                var s = jQuery(e.target);
                                s.hasClass("selector") && (s = s.find(":first-child[data-prop]"));
                                var i = s.data("prop");
                                (t[i] = s.data("value")), t.updateDialog(i, t[i]), t.render();
                            }),
                            jQuery('input[type="radio"]').on("change keyup", function (e) {
                                var s = jQuery(e.target).data("prop");
                                (t[s] = jQuery(e.target).val()), t.updateDialog(s, t[s]), t.render();
                            }),
                            jQuery('input[type="text"], input[type="number"]').on("change keyup", function (e) {
                                var s = jQuery(e.target).data("prop");
                                (t[s] = jQuery(e.target).val()), t.updateDialog(s, t[s], "text"), t.render();
                            }),
                            jQuery("select").on("change", function (e) {
                                var s = jQuery(e.target).data("prop");
                                (t[s] = jQuery(e.target).val()), t.render();
                            }),
                            jQuery(".btn-group button").on("click", function (e) {
                                var s = jQuery(e.target).data("prop");
                                (t[s] = jQuery(e.target).data("value")), t.updateDialog(s, t[s], "boolean"), t.render();
                            }),
                            jQuery("a.dropdown-item").on("click", function (e) {
                                var s = jQuery(e.target).data("prop");
                                (t[s] = jQuery(e.target).data("value")), t.updateDialog(s, t[s], "dropdown"), t.render();
                            })),
                        window.addEventListener("message", function (e) {
                            if ("customInsertAndClose" === e.data.mceAction) {
                                t.onBeforeMessage();
                                var s = { pluginMode: t.pluginMode, outputCode: t.gc() };
                                jQuery("#preview-content").html().length > 0 && window.parent.postMessage({ mceAction: "execCommand", cmd: "iframeCommand", value: s }, origin), window.parent.postMessage({ mceAction: "close" }, origin);
                            }
                        });
                }),
                (e.prototype.onBeforeMessage = function () {
                    window.parent.tinymce.dom.DomQuery(this.editor.dom.select(".tbp-context-active")).removeClass("tbp-context-active").children(".context-trigger-wrapper").remove();
                }),
                (e.prototype.render = function () {}),
                (e.prototype.setPluginMode = function () {
                    console.log("No Action defined!");
                }),
                (e.prototype.updateDialog = function (e, t, s) {
                    void 0 === s && (s = "array-value"),
                        "array-value" === s
                            ? (jQuery("#" + e)
                                  .find(".selector")
                                  .removeClass("active"),
                              jQuery("#" + e + ' [data-value="' + t + '"]')
                                  .closest(".selector")
                                  .addClass("active"))
                            : "boolean" === s
                            ? (jQuery('button[data-prop="' + e + '"][data-value!="' + t + '"]')
                                  .removeClass(this.btnToggleActiveClass)
                                  .addClass(this.btnToggleInactiveClass),
                              jQuery('button[data-prop="' + e + '"][data-value="' + t + '"]')
                                  .removeClass(this.btnToggleInactiveClass)
                                  .addClass(this.btnToggleActiveClass))
                            : "radio" === s
                            ? jQuery('input[name="' + e + '"]').each(function () {
                                  jQuery(this).prop("checked", !1), jQuery(this).val() === t && jQuery(this).prop("checked", !0);
                              })
                            : "text" === s || "number" === s || "select" === s
                            ? jQuery("#" + e).val(t)
                            : "dropdown" === s && jQuery('*[data-content="' + e + '"]').html(t),
                        jQuery("." + e + "-toggle")[0] && (jQuery("." + e + "-toggle").removeClass("active"), jQuery("." + e + '-toggle[data-activate*="' + t + '"]').addClass("active"));
                }),
                (e.prototype.camelize = function (e) {
                    return e.replace(/(?:^|[-])(\w)/g, function (e, t) {
                        return (t = "-" === e.substr(0, 1) ? t.toUpperCase() : t) || "";
                    });
                }),
                (e.prototype.gc = function () {
                    return jQuery("#preview-content").html();
                }),
                (e.prototype.reverseCamelize = function (e) {
                    return e.replace(/([A-Z])/g, function (e, t) {
                        return "-" + t.toLowerCase();
                    });
                }),
                e
            );
        })(),
        o = {
            elusiveicon: { css: "elusiveicon/css/elusive-icons.min.css", defaultIcon: "el-icon-home", homeIcon: "el-icon-home", selector: "el-icon-", baseClasses: [] },
            flagicon: { css: "flagicon/css/flag-icon.min.css", defaultIcon: "flag-icon flag-icon-eu", homeIcon: "", selector: "flag-icon-", baseClasses: ["flag-icon"] },
            fontawesome5: { css: "fontawesome5/css/all.min.css", defaultIcon: "fas fa-home", homeIcon: "fas fa-home", selector: "fa-[a-z]+", baseClasses: ["far", "fas", "fab"] },
            ionicon: { css: "ionicon/css/ionicons.min.css", defaultIcon: "ion-home", homeIcon: "ion-home", selector: "ion-", baseClasses: [] },
            mapicon: { css: "mapicon/css/map-icons.min.css", defaultIcon: "map-icon-art-gallery", homeIcon: "", selector: "map-icon-", baseClasses: [] },
            materialdesign: { css: "materialdesign/css/material-design-iconic-font.min.css", defaultIcon: "zmdi zmdi-home", homeIcon: "zmdi zmdi-home", selector: "zmdi-", baseClasses: ["zmdi"] },
            octicon: { css: "octicon/octicons.min.css", defaultIcon: "octicon octicon-home", homeIcon: "octicon octicon-home", selector: "octicon-", baseClasses: ["octicon"] },
            typicon: { css: "typicon/css/typicons.min.css", defaultIcon: "typcn typcn-home", homeIcon: "typcn typcn-home", selector: "typcn-", baseClasses: ["typcn"] },
            weathericon: { css: "weathericon/css/weather-icons.min.css", defaultIcon: "wi wi-horizon-alt", homeIcon: "", selector: "wi-", baseClasses: ["wi"] },
        };
    new ((function (i) {
        function n() {
            var e = i.call(this) || this;
            return (
                (e.border = !1),
                (e.color = "text-dark"),
                (e.colorCustom = ""),
                (e.flip = ""),
                (e.icon = ""),
                (e.iconFont = e.bsInstance.iconFont),
                (e.pulse = !1),
                (e.rotate = ""),
                (e.size = ""),
                (e.sizeCustom = null),
                (e.sizeCustomUnit = "px"),
                (e.spin = !1),
                (e.defaultIcon = ""),
                e
            );
        }
        return (
            (function (t, s) {
                if ("function" != typeof s && null !== s) throw new TypeError("Class extends value " + String(s) + " is not a constructor or null");
                function i() {
                    this.constructor = t;
                }
                e(t, s), (t.prototype = null === s ? Object.create(s) : ((i.prototype = s.prototype), new i()));
            })(n, i),
            (n.prototype.init = function () {
                var e = this;
                this.defaultIcon = o[this.bsInstance.iconFont].defaultIcon;
                var i = t(t(t({}, lang), dotData), { defaultIcon: this.defaultIcon }),
                    n = document.querySelector("body").innerHTML,
                    a = doT.template(n);
                (document.querySelector("body").innerHTML = a(i)),
                    (this.availableSizes = ["", "h6", "h5", "h4", "h3", "h2", "h1"]),
                    "fontawesome5" === this.iconFont ? this.availableSizes.push("fa-xs", "fa-sm", "fa-lg", "fa-2x", "fa-3x", "fa-5x", "fa-7x", "fa-10x") : "flagicon" === this.iconFont && jQuery("section#color").css("display", "none"),
                    (this.availableColors = ["text-primary", "text-secondary", "text-success", "text-danger", "text-warning", "text-info", "text-light", "text-dark"]),
                    (this.reservedClasses = s(this.availableSizes, this.availableColors, o[this.bsInstance.iconFont].baseClasses, ["icon", "tbp-active"])),
                    (this.reservedClassesRegex = [o[this.bsInstance.iconFont].selector]),
                    (this.reservedIconClasses = ["fa-pulse", "fa-spin", "fa-border"]),
                    (this.reservedIconClassesRegex = ["fa-flip-", "fa-rotate-"]),
                    (this.reservedStyles = ["fontSize", "color"]),
                    this.setInitialProperties(this.editor.selection.getNode()),
                    this.initEvents(),
                    loadjs(
                        ["../lib/iconpicker/css/bootstrap-iconpicker.min.css", "../lib/iconpicker/fonts/" + this.bsInstance.iconCss, "../lib/iconpicker/js/bootstrap.bundle.min.js", "../lib/iconpicker/js/bootstrap-iconpicker.bundle.min.js"],
                        "iconpicker"
                    ),
                    loadjs.ready("iconpicker", function () {
                        e.initIconPicker();
                    }),
                    loadjs(["../lib/minicolors/jquery.minicolors.min.css", "../lib/minicolors/jquery.minicolors.min.js"], "minicolors"),
                    loadjs.ready("minicolors", function () {
                        e.initColorPicker();
                    });
            }),
            (n.prototype.setPluginMode = function () {
                var e = this.editor.dom.select(".tbp-active");
                e.length > 0 && this.bsInstance.isIcon(jQuery(e).get(0)) && (this.pluginMode = "replace");
            }),
            (n.prototype.initEvents = function () {
                i.prototype.initEvents.call(this),
                    jQuery("#size .selector").on("click", function (e) {
                        "custom" !== jQuery(e.target).data("value") && jQuery("#sizeCustom").val("").trigger("change");
                    }),
                    jQuery("#color .selector").on("click", function (e) {
                        "custom" !== jQuery(e.target).data("value") && jQuery("#colorCustom").val("").trigger("change");
                    });
            }),
            (n.prototype.render = function () {
                var e = "",
                    t = { class: "", content: "", miscAttributes: "", style: "" };
                (t.class = this.icon),
                    null !== this.sizeCustom && this.sizeCustom > 0 ? (t.style += "font-size:" + this.sizeCustom + this.sizeCustomUnit + ";") : "" !== this.size && "custom" !== this.size && (t.class += " " + this.size),
                    "" !== this.colorCustom ? (t.style += "color:" + this.colorCustom + ";") : "" !== this.color && "custom" !== this.color && (t.class += " " + this.color),
                    this.border && (t.class += " fa-border"),
                    this.flip.length > 0 && (t.class += " " + this.flip),
                    this.pulse && (t.class += " fa-pulse"),
                    this.rotate.length > 0 && (t.class += " " + this.rotate),
                    this.spin && (t.class += " fa-spin"),
                    (t.class += this.addOriginalClasses()),
                    (t.miscAttributes = this.addOriginalAttributes()),
                    "" !== t.style && (t.style = ' style="' + t.style + '"'),
                    (e = '<i class="' + t.class + '"' + t.style + t.miscAttributes + "></i>"),
                    jQuery("#preview-content").html(e),
                    (e = Prism.highlight(e, Prism.languages.markup)),
                    jQuery("#code-content pre").html(e);
            }),
            (n.prototype.switchIcons = function (e, t) {
                jQuery(".selector ." + e.replace(" ", "."))
                    .removeClass(e)
                    .addClass(t);
            }),
            (n.prototype.initColorPicker = function () {
                jQuery("#colorCustom").minicolors({
                    theme: "bootstrap",
                    change: function (e, t) {
                        jQuery("#colorCustom").val(e);
                    },
                });
            }),
            (n.prototype.initIconPicker = function () {
                var e = this,
                    t = this.icon;
                if (1 === o[this.bsInstance.iconFont].baseClasses.length) {
                    var s = o[this.bsInstance.iconFont].baseClasses[0];
                    t = this.icon.replace(s, "").trim();
                }
                jQuery("#iconpicker")
                    .iconpicker({
                        arrowClass: "btn-light",
                        arrowPrevIconClass: "bootstrap-icon-circle-left",
                        arrowNextIconClass: "bootstrap-icon-circle-right",
                        icon: t,
                        iconset: this.iconFont,
                        labelHeader: "{0} / {1} " + lang.pages,
                        labelFooter: "{0} - {1} of {2}" + lang.icons,
                        placement: "top",
                        rows: 6,
                        cols: 10,
                        selectedClass: "btn-outline-secondary",
                        unselectedClass: "",
                    })
                    .on("change", function (t) {
                        var s = t.icon;
                        if (1 === o[e.bsInstance.iconFont].baseClasses.length) {
                            var i = o[e.bsInstance.iconFont].baseClasses[0];
                            jQuery(s).hasClass(i) || (s = i + " " + s);
                        }
                        e.switchIcons(e.icon, s), (e.icon = s), e.render();
                    });
            }),
            (n.prototype.setInitialProperties = function (e) {
                var t = this;
                if ("replace" === this.pluginMode) {
                    if (
                        ((this.elStyles = this.getStyles(e)),
                        this.getOriginalAttributes(e),
                        this.availableColors.forEach(function (s) {
                            jQuery(e).hasClass(s) && (t.color = s);
                        }),
                        "fontSize" in this.elStyles)
                    ) {
                        this.size = "custom";
                        var s = "fontSize",
                            i = (s = this.elStyles[s]).match(/[a-z]+|[^a-z]+/gi);
                        2 === i.length && ((this.sizeCustom = Number(i[0])), (this.sizeCustomUnit = i[1]));
                    }
                    if ("color" in this.elStyles) {
                        this.color = "custom";
                        this.colorCustom = this.elStyles.color;
                    }
                    this.availableSizes.forEach(function (s) {
                        jQuery(e).hasClass(s) && (t.size = s);
                    }),
                        jQuery(e).hasClass("fa-border") && (this.border = !0);
                    ["fa-flip-horizontal", "fa-flip-vertical", "fa-flip-both"].forEach(function (s) {
                        jQuery(e).hasClass(s) && (t.flip = s);
                    }),
                        jQuery(e).hasClass("fa-pulse") && (this.pulse = !0);
                    ["fa-rotate-90", "fa-rotate-180", "fa-rotate-270"].forEach(function (s) {
                        jQuery(e).hasClass(s) && (t.rotate = s);
                    }),
                        jQuery(e).hasClass("fa-spin") && (this.spin = !0),
                        (this.icon = this.getIconClass(jQuery(e).get(0)));
                } else this.icon = this.defaultIcon;
                this.switchIcons(this.defaultIcon, this.icon),
                    this.updateDialog("color", this.color),
                    this.updateDialog("colorCustom", this.colorCustom, "text"),
                    this.updateDialog("border", this.border, "boolean"),
                    this.updateDialog("flip", this.flip, "select"),
                    this.updateDialog("iconFont", this.iconFont),
                    this.updateDialog("pulse", this.pulse, "boolean"),
                    this.updateDialog("rotate", this.rotate, "select"),
                    this.updateDialog("size", this.size),
                    this.updateDialog("spin", this.spin, "boolean"),
                    this.updateDialog("sizeCustom", this.sizeCustom, "number"),
                    this.updateDialog("sizeCustomUnit", this.sizeCustomUnit, "dropdown"),
                    this.render();
            }),
            n
        );
    })(i))();
})();
