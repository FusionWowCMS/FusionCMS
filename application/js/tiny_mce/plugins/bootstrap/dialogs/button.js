!(function () {
    "use strict";
    var t = function (e, s) {
        return (t =
            Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array &&
                function (t, e) {
                    t.__proto__ = e;
                }) ||
            function (t, e) {
                for (var s in e) Object.prototype.hasOwnProperty.call(e, s) && (t[s] = e[s]);
            })(e, s);
    };
    var e = function () {
        return (e =
            Object.assign ||
            function (t) {
                for (var e, s = 1, i = arguments.length; s < i; s++) for (var n in (e = arguments[s])) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
                return t;
            }).apply(this, arguments);
    };
    function s() {
        for (var t = 0, e = 0, s = arguments.length; e < s; e++) t += arguments[e].length;
        var i = Array(t),
            n = 0;
        for (e = 0; e < s; e++) for (var a = arguments[e], r = 0, o = a.length; r < o; r++, n++) i[n] = a[r];
        return i;
    }
    new ((function (i) {
        function n() {
            var t = i.call(this) || this;
            return (
                (t.blockLevel = !1),
                (t.disabled = !1),
                (t.hasIcon = !1),
                (t.href = ""),
                (t.icon = ""),
                (t.iconFont = t.bsInstance.iconFont),
                (t.iconPos = "prepend"),
                (t.size = ""),
                (t.style = "btn-primary"),
                (t.tag = "button"),
                (t.tagType = "button"),
                (t.text = "My Button"),
                t
            );
        }
        return (
            (function (e, s) {
                if ("function" != typeof s && null !== s) throw new TypeError("Class extends value " + String(s) + " is not a constructor or null");
                function i() {
                    this.constructor = e;
                }
                t(e, s), (e.prototype = null === s ? Object.create(s) : ((i.prototype = s.prototype), new i()));
            })(n, i),
            (n.prototype.init = function () {
                var t = this,
                    i = e(e({}, lang), dotData),
                    n = document.querySelector("body").innerHTML,
                    a = doT.template(n);
                (document.querySelector("body").innerHTML = a(i)),
                    (this.availableSizes = ["btn-sm", "btn-lg"]),
                    (this.availableStyles = [
                        "btn-primary",
                        "btn-secondary",
                        "btn-success",
                        "btn-danger",
                        "btn-warning",
                        "btn-info",
                        "btn-light",
                        "btn-dark",
                        "btn-link",
                        "btn-outline-primary",
                        "btn-outline-secondary",
                        "btn-outline-success",
                        "btn-outline-danger",
                        "btn-outline-warning",
                        "btn-outline-info",
                        "btn-outline-light",
                        "btn-outline-dark",
                    ]),
                    (this.availableTags = ["button", "a", "input"]),
                    (this.reservedAttributes = ["disabled", "href", "type"]),
                    (this.reservedClasses = s(this.availableSizes, this.availableStyles, ["btn", "tbp-active"])),
                    this.setInitialProperties(this.editor.dom.select(".tbp-active")),
                    this.initEvents(),
                    loadjs(
                        ["../lib/iconpicker/css/bootstrap-iconpicker.min.css", "../lib/iconpicker/fonts/" + this.bsInstance.iconCss, "../lib/iconpicker/js/bootstrap.bundle.min.js", "../lib/iconpicker/js/bootstrap-iconpicker.bundle.min.js"],
                        "iconpicker"
                    ),
                    loadjs.ready("iconpicker", function () {
                        t.initIconPicker();
                    });
            }),
            (n.prototype.setPluginMode = function () {
                var t = this.editor.dom.select(".tbp-active");
                t.length > 0 && jQuery(t).hasClass("btn") && (this.pluginMode = "replace");
            }),
            (n.prototype.render = function () {
                var t = "",
                    e = { class: "", content: "", disabled: "", href: this.href, originalAttributes: "", tagType: this.tagType, text: this.text, textCode: "" };
                (e.class = this.style),
                    "" !== this.size && (e.class += " " + this.size),
                    this.blockLevel && (e.class += " btn-block"),
                    (e.class += this.addOriginalClasses()),
                    (e.originalAttributes = this.addOriginalAttributes()),
                    this.hasIcon && "input" !== this.tag && ("prepend" === this.iconPos ? (e.text = '<i class="' + this.icon + '"></i> ' + this.text) : (e.text = this.text + ' <i class="' + this.icon + '"></i>')),
                    this.disabled && (e.disabled = " disabled"),
                    "a" === this.tag
                        ? (t = '<a href="' + e.href + '" class="btn ' + e.class + '"' + e.originalAttributes + ">" + e.text + "</a>")
                        : "button" === this.tag
                        ? (t = '<button type="' + e.tagType + '" class="btn ' + e.class + '"' + e.disabled + e.originalAttributes + ">" + e.text + "</button>")
                        : "input" === this.tag && (t = '<input type="' + e.tagType + '" class="btn ' + e.class + '"' + e.disabled + ' value="' + e.text + '"' + e.originalAttributes + " />"),
                    jQuery("#preview-content").html(t),
                    (t = Prism.highlight(t, Prism.languages.markup)),
                    jQuery("#code-content pre").html(t);
            }),
            (n.prototype.initIconPicker = function () {
                var t = this;
                jQuery("#iconpicker")
                    .iconpicker({
                        arrowClass: "btn-light",
                        arrowPrevIconClass: "bootstrap-icon-circle-left",
                        arrowNextIconClass: "bootstrap-icon-circle-right",
                        icon: this.icon,
                        iconset: this.iconFont,
                        labelHeader: "{0} / {1} " + lang.pages,
                        labelFooter: "{0} - {1} of {2}" + lang.icons,
                        placement: "top",
                        rows: 6,
                        cols: 10,
                        selectedClass: "btn-outline-secondary",
                        unselectedClass: "",
                    })
                    .on("change", function (e) {
                        (t.icon = e.icon), t.render();
                    });
            }),
            (n.prototype.setInitialProperties = function (t) {
                var e = this;
                if ("replace" === this.pluginMode) {
                    if (
                        (this.availableStyles.forEach(function (s) {
                            jQuery(t).hasClass(s) && (e.style = s);
                        }),
                        this.availableSizes.forEach(function (s) {
                            jQuery(t).hasClass(s) && (e.size = s);
                        }),
                        this.availableTags.forEach(function (s) {
                            jQuery(t).is(s) && (e.tag = s), "a" === e.tag ? (e.href = jQuery(t).attr("href")) : (e.tagType = jQuery(t).prop("type"));
                        }),
                        (this.blockLevel = jQuery(t).hasClass("btn-block")),
                        jQuery(t).find("span, i")[0] && ((this.icon = this.getIconClass(jQuery(t).find("span, i").get(0))), "" !== this.icon))
                    ) {
                        this.hasIcon = !0;
                        var s = this.icon.replace(" ", "."),
                            i = jQuery(t).clone();
                        i.find("." + s).remove(), (this.text = i.html()), !0 === new RegExp("^" + this.text.trim()).test(jQuery(t).html().trim()) && (this.iconPos = "append");
                    }
                    "button" === this.tag || "a" === this.tag ? !0 !== this.hasIcon && (this.text = jQuery(t).html()) : (this.text = jQuery(t).val()), this.getOriginalAttributes(t);
                }
                this.updateDialog("style", this.style),
                    this.updateDialog("size", this.size),
                    this.updateDialog("tag", this.tag),
                    this.updateDialog("tagType", this.tagType, "radio"),
                    this.updateDialog("hasIcon", this.hasIcon, "boolean"),
                    this.updateDialog("iconPos", this.iconPos, "radio"),
                    this.updateDialog("disabled", this.disabled, "boolean"),
                    this.updateDialog("blockLevel", this.blockLevel, "boolean"),
                    this.updateDialog("text", this.text, "text"),
                    this.render();
            }),
            n
        );
    })(
        (function () {
            function t() {
                var t = this;
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
                var e = this.bsInstance.pluginUrl;
                loadjs(this.bsInstance.bootstrapCss),
                    loadjs(
                        [
                            "https://code.jquery.com/jquery-3.4.1.min.js",
                            e + "langs/" + this.bsInstance.language + "-dialogs.js",
                            e + "assets/js/dialogs-dot-data.js",
                            e + "lib/dot/dot.min.js",
                            e + "lib/prism/prism.min.css",
                            e + "lib/prism/prism.min.js",
                        ],
                        "bundle1"
                    ),
                    loadjs.ready("bundle1", function () {
                        t.setPluginMode(),
                            jQuery.noConflict(),
                            jQuery(window.parent.document).find(".tox-dialog__header").prepend(t.bootstrapDialogLogo),
                            jQuery(".selector *[data-value]").each(function () {
                                jQuery(this).closest(".selector").attr("title", jQuery(this).data("value"));
                            }),
                            loadjs([e + "lib/js-beautify/beautify-html.min.js"], "js-beautify"),
                            loadjs([e + "lib/nice-check/dist/js/jquery.nice-check.min.js", e + "lib/nice-check/dist/css/nice-check-gray-dark.min.css"], "niceCheck"),
                            loadjs.ready("niceCheck", function () {
                                jQuery("body").niceCheck();
                            }),
                            loadjs.ready("js-beautify", function () {
                                t.init();
                            });
                    });
            }
            return (
                (t.prototype.init = function () {}),
                (t.prototype.addOriginalAttributes = function () {
                    if (!Object.keys(this.miscAttributes).length) return "";
                    for (var t = " ", e = 0, s = Object.entries(this.miscAttributes); e < s.length; e++) {
                        var i = s[e];
                        t += i[0] + '="' + i[1] + '"';
                    }
                    return t;
                }),
                (t.prototype.addOriginalClasses = function () {
                    return this.miscClasses.length ? " " + this.miscClasses.join(" ") : "";
                }),
                (t.prototype.escapeHtml = function (t) {
                    var e = { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;" };
                    return t.replace(/[&<>"']/g, function (t) {
                        return e[t];
                    });
                }),
                (t.prototype.getOriginalAttributes = function (t) {
                    var e = this;
                    void 0 === t.classList && (t = t[0]);
                    for (
                        var i = s(this.reservedAttributes, ["data-mce-href", "data-mce-selected", "data-mce-src", "data-mce-style", "src", "style"]),
                            n = this.reservedClasses,
                            a = this.reservedStyles,
                            r = void 0,
                            o = 0,
                            c = t.classList,
                            l = c.length;
                        o < l;
                        o++
                    )
                        if (((r = c[o]), -1 === n.indexOf(r)))
                            if (this.reservedClassesRegex.length < 1) this.miscClasses.push(r);
                            else
                                for (var u = 0; u < this.reservedClassesRegex.length; u++) {
                                    var h = new RegExp(this.reservedClassesRegex[u], "g");
                                    r.match(h) || this.miscClasses.push(r);
                                }
                    var p = void 0,
                        d = ((o = 0), t.attributes);
                    for (l = d.length; o < l; o++) "class" !== (p = d[o]).nodeName && -1 === i.indexOf(p.nodeName) && (this.miscAttributes[p.nodeName] = p.nodeValue);
                    var g = "";
                    if (
                        (Object.keys(this.elStyles).forEach(function (t) {
                            -1 === a.indexOf(t) && (g += " " + e.reverseCamelize(t) + ":" + e.elStyles[t] + ";");
                        }),
                        g.length > 0)
                    ) {
                        this.miscAttributes.style = g.trim();
                    }
                }),
                (t.prototype.getIconClass = function (t) {
                    var e = this,
                        s = [],
                        i = jQuery(t).attr("class").split(" "),
                        n = this.bsInstance.iconBaseClasses.join("|").length,
                        a = new RegExp(this.bsInstance.iconSearchClass, "g"),
                        r = new RegExp(this.bsInstance.iconBaseClasses.join("|"), "g");
                    return (
                        jQuery.each(i, function (t, i) {
                            if (i.match(a)) {
                                var o = !1;
                                if (-1 !== e.reservedIconClasses.indexOf(i) || -1 !== e.reservedClasses.indexOf(i)) o = !0;
                                else
                                    for (var c = 0; c < e.reservedIconClassesRegex.length; c++) {
                                        var l = new RegExp(e.reservedIconClassesRegex[c], "g");
                                        i.match(l) && (o = !0);
                                    }
                                !1 === o && s.push(i);
                            } else n > 0 && i.match(r) && s.push(i);
                        }),
                        s.join(" ")
                    );
                }),
                (t.prototype.getStyles = function (t) {
                    var e = {};
                    if (!t || !t.style || !t.style.cssText) return e;
                    for (var s = t.style.cssText.split(";"), i = 0; i < s.length; ++i) {
                        var n = s[i].trim();
                        if (n) {
                            var a = n.split(":");
                            e[this.camelize(a[0].trim())] = a[1].trim();
                        }
                    }
                    return e;
                }),
                (t.prototype.initEvents = function (t) {
                    var e = this;
                    void 0 === t && (t = !0),
                        !0 === t &&
                            (jQuery(".selector").on("click", function (t) {
                                var s = jQuery(t.target);
                                s.hasClass("selector") && (s = s.find(":first-child[data-prop]"));
                                var i = s.data("prop");
                                (e[i] = s.data("value")), e.updateDialog(i, e[i]), e.render();
                            }),
                            jQuery('input[type="radio"]').on("change keyup", function (t) {
                                var s = jQuery(t.target).data("prop");
                                (e[s] = jQuery(t.target).val()), e.updateDialog(s, e[s]), e.render();
                            }),
                            jQuery('input[type="text"], input[type="number"]').on("change keyup", function (t) {
                                var s = jQuery(t.target).data("prop");
                                (e[s] = jQuery(t.target).val()), e.updateDialog(s, e[s], "text"), e.render();
                            }),
                            jQuery("select").on("change", function (t) {
                                var s = jQuery(t.target).data("prop");
                                (e[s] = jQuery(t.target).val()), e.render();
                            }),
                            jQuery(".btn-group button").on("click", function (t) {
                                var s = jQuery(t.target).data("prop");
                                (e[s] = jQuery(t.target).data("value")), e.updateDialog(s, e[s], "boolean"), e.render();
                            }),
                            jQuery("a.dropdown-item").on("click", function (t) {
                                var s = jQuery(t.target).data("prop");
                                (e[s] = jQuery(t.target).data("value")), e.updateDialog(s, e[s], "dropdown"), e.render();
                            })),
                        window.addEventListener("message", function (t) {
                            if ("customInsertAndClose" === t.data.mceAction) {
                                e.onBeforeMessage();
                                var s = { pluginMode: e.pluginMode, outputCode: e.gc() };
                                jQuery("#preview-content").html().length > 0 && window.parent.postMessage({ mceAction: "execCommand", cmd: "iframeCommand", value: s }, origin), window.parent.postMessage({ mceAction: "close" }, origin);
                            }
                        });
                }),
                (t.prototype.onBeforeMessage = function () {
                    window.parent.tinymce.dom.DomQuery(this.editor.dom.select(".tbp-context-active")).removeClass("tbp-context-active").children(".context-trigger-wrapper").remove();
                }),
                (t.prototype.render = function () {}),
                (t.prototype.setPluginMode = function () {
                    console.log("No Action defined!");
                }),
                (t.prototype.updateDialog = function (t, e, s) {
                    void 0 === s && (s = "array-value"),
                        "array-value" === s
                            ? (jQuery("#" + t)
                                  .find(".selector")
                                  .removeClass("active"),
                              jQuery("#" + t + ' [data-value="' + e + '"]')
                                  .closest(".selector")
                                  .addClass("active"))
                            : "boolean" === s
                            ? (jQuery('button[data-prop="' + t + '"][data-value!="' + e + '"]')
                                  .removeClass(this.btnToggleActiveClass)
                                  .addClass(this.btnToggleInactiveClass),
                              jQuery('button[data-prop="' + t + '"][data-value="' + e + '"]')
                                  .removeClass(this.btnToggleInactiveClass)
                                  .addClass(this.btnToggleActiveClass))
                            : "radio" === s
                            ? jQuery('input[name="' + t + '"]').each(function () {
                                  jQuery(this).prop("checked", !1), jQuery(this).val() === e && jQuery(this).prop("checked", !0);
                              })
                            : "text" === s || "number" === s || "select" === s
                            ? jQuery("#" + t).val(e)
                            : "dropdown" === s && jQuery('*[data-content="' + t + '"]').html(e),
                        jQuery("." + t + "-toggle")[0] && (jQuery("." + t + "-toggle").removeClass("active"), jQuery("." + t + '-toggle[data-activate*="' + e + '"]').addClass("active"));
                }),
                (t.prototype.camelize = function (t) {
                    return t.replace(/(?:^|[-])(\w)/g, function (t, e) {
                        return (e = "-" === t.substr(0, 1) ? e.toUpperCase() : e) || "";
                    });
                }),
                (t.prototype.gc = function () {
                    return jQuery("#preview-content").html();
                }),
                (t.prototype.reverseCamelize = function (t) {
                    return t.replace(/([A-Z])/g, function (t, e) {
                        return "-" + e.toLowerCase();
                    });
                }),
                t
            );
        })()
    ))();
})();
