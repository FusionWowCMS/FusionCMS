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
                for (var t, s = 1, a = arguments.length; s < a; s++) for (var r in (t = arguments[s])) Object.prototype.hasOwnProperty.call(t, r) && (e[r] = t[r]);
                return e;
            }).apply(this, arguments);
    };
    function s() {
        for (var e = 0, t = 0, s = arguments.length; t < s; t++) e += arguments[t].length;
        var a = Array(e),
            r = 0;
        for (t = 0; t < s; t++) for (var i = arguments[t], n = 0, o = i.length; n < o; n++, r++) a[r] = i[n];
        return a;
    }
    new ((function (a) {
        function r() {
            var e = a.call(this) || this;
            return (e.badgePill = !1), (e.href = ""), (e.style = "badge-primary"), (e.tag = "span"), (e.tagType = "span"), (e.text = "My Badge"), e;
        }
        return (
            (function (t, s) {
                if ("function" != typeof s && null !== s) throw new TypeError("Class extends value " + String(s) + " is not a constructor or null");
                function a() {
                    this.constructor = t;
                }
                e(t, s), (t.prototype = null === s ? Object.create(s) : ((a.prototype = s.prototype), new a()));
            })(r, a),
            (r.prototype.init = function () {
                var e = t(t({}, lang), dotData),
                    a = document.querySelector("body").innerHTML,
                    r = doT.template(a);
                (document.querySelector("body").innerHTML = r(e)),
                    (this.availableStyles = ["badge-primary", "badge-secondary", "badge-success", "badge-danger", "badge-warning", "badge-info", "badge-light", "badge-dark"]),
                    (this.availableTags = ["span", "a"]),
                    (this.reservedAttributes = ["href"]),
                    (this.reservedClasses = s(this.availableStyles, ["badge", "badge-pill", "tbp-active"])),
                    this.setInitialProperties(this.editor.dom.select(".tbp-active")),
                    this.initEvents();
            }),
            (r.prototype.setPluginMode = function () {
                var e = this.editor.dom.select(".tbp-active");
                e.length > 0 && jQuery(e).hasClass("badge") && (this.pluginMode = "replace");
            }),
            (r.prototype.render = function () {
                var e = "",
                    t = { class: "", content: "", href: this.href, originalAttributes: "", tagType: this.tagType, text: this.text };
                (t.class = this.style),
                    !0 === this.badgePill && (t.class += " badge-pill"),
                    (t.class += this.addOriginalClasses()),
                    (t.originalAttributes = this.addOriginalAttributes()),
                    "a" === this.tag
                        ? (e = '<a href="' + t.href + '" class="badge ' + t.class + '"' + t.originalAttributes + ">" + t.text + "</a>")
                        : "span" === this.tag && (e = '<span class="badge ' + t.class + '"' + t.originalAttributes + ">" + t.text + "</span>"),
                    jQuery("#preview-content").html(e),
                    (e = Prism.highlight(e, Prism.languages.markup)),
                    jQuery("#code-content pre").html(e);
            }),
            (r.prototype.setInitialProperties = function (e) {
                var t = this;
                "replace" === this.pluginMode &&
                    (this.availableStyles.forEach(function (s) {
                        jQuery(e).hasClass(s) && (t.style = s);
                    }),
                    (this.badgePill = jQuery(e).hasClass("badge-pill")),
                    this.availableTags.forEach(function (s) {
                        jQuery(e).is(s) && (t.tag = s), "a" === t.tag && (t.href = jQuery(e).attr("href"));
                    }),
                    (this.text = jQuery(e).html()),
                    this.getOriginalAttributes(e)),
                    this.updateDialog("badgePill", this.badgePill, "boolean"),
                    this.updateDialog("style", this.style),
                    this.updateDialog("tag", this.tag),
                    this.updateDialog("tagType", this.tagType, "radio"),
                    this.updateDialog("text", this.text, "text"),
                    this.render();
            }),
            r
        );
    })(
        (function () {
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
                        var a = s[t];
                        e += a[0] + '="' + a[1] + '"';
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
                        var a = s(this.reservedAttributes, ["data-mce-href", "data-mce-selected", "data-mce-src", "data-mce-style", "src", "style"]),
                            r = this.reservedClasses,
                            i = this.reservedStyles,
                            n = void 0,
                            o = 0,
                            l = e.classList,
                            c = l.length;
                        o < c;
                        o++
                    )
                        if (((n = l[o]), -1 === r.indexOf(n)))
                            if (this.reservedClassesRegex.length < 1) this.miscClasses.push(n);
                            else
                                for (var u = 0; u < this.reservedClassesRegex.length; u++) {
                                    var d = new RegExp(this.reservedClassesRegex[u], "g");
                                    n.match(d) || this.miscClasses.push(n);
                                }
                    var p = void 0,
                        h = ((o = 0), e.attributes);
                    for (c = h.length; o < c; o++) "class" !== (p = h[o]).nodeName && -1 === a.indexOf(p.nodeName) && (this.miscAttributes[p.nodeName] = p.nodeValue);
                    var g = "";
                    if (
                        (Object.keys(this.elStyles).forEach(function (e) {
                            -1 === i.indexOf(e) && (g += " " + t.reverseCamelize(e) + ":" + t.elStyles[e] + ";");
                        }),
                        g.length > 0)
                    ) {
                        this.miscAttributes.style = g.trim();
                    }
                }),
                (e.prototype.getIconClass = function (e) {
                    var t = this,
                        s = [],
                        a = jQuery(e).attr("class").split(" "),
                        r = this.bsInstance.iconBaseClasses.join("|").length,
                        i = new RegExp(this.bsInstance.iconSearchClass, "g"),
                        n = new RegExp(this.bsInstance.iconBaseClasses.join("|"), "g");
                    return (
                        jQuery.each(a, function (e, a) {
                            if (a.match(i)) {
                                var o = !1;
                                if (-1 !== t.reservedIconClasses.indexOf(a) || -1 !== t.reservedClasses.indexOf(a)) o = !0;
                                else
                                    for (var l = 0; l < t.reservedIconClassesRegex.length; l++) {
                                        var c = new RegExp(t.reservedIconClassesRegex[l], "g");
                                        a.match(c) && (o = !0);
                                    }
                                !1 === o && s.push(a);
                            } else r > 0 && a.match(n) && s.push(a);
                        }),
                        s.join(" ")
                    );
                }),
                (e.prototype.getStyles = function (e) {
                    var t = {};
                    if (!e || !e.style || !e.style.cssText) return t;
                    for (var s = e.style.cssText.split(";"), a = 0; a < s.length; ++a) {
                        var r = s[a].trim();
                        if (r) {
                            var i = r.split(":");
                            t[this.camelize(i[0].trim())] = i[1].trim();
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
                                var a = s.data("prop");
                                (t[a] = s.data("value")), t.updateDialog(a, t[a]), t.render();
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
        })()
    ))();
})();
