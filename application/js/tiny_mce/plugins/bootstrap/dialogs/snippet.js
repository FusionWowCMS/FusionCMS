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
                for (var t, s = 1, n = arguments.length; s < n; s++) for (var r in (t = arguments[s])) Object.prototype.hasOwnProperty.call(t, r) && (e[r] = t[r]);
                return e;
            }).apply(this, arguments);
    };
    new ((function (s) {
        function n() {
            var e = s.call(this) || this;
            return (e.jsonSnippets = []), (e.editorClosestContainer = ""), (e.editorClosestRow = ""), (e.insertPosition = ""), (e.snippetName = ""), (e.snippetCode = ""), e;
        }
        return (
            (function (t, s) {
                if ("function" != typeof s && null !== s) throw new TypeError("Class extends value " + String(s) + " is not a constructor or null");
                function n() {
                    this.constructor = t;
                }
                e(t, s), (t.prototype = null === s ? Object.create(s) : ((n.prototype = s.prototype), new n()));
            })(n, s),
            (n.prototype.init = function () {
                var e = this,
                    s = t(t({}, lang), dotData),
                    n = document.querySelector("body").innerHTML,
                    r = doT.template(n);
                document.querySelector("body").innerHTML = r(s);
                var i = new XMLHttpRequest();
                i.open("GET", this.bsInstance.jsonSnippetsUrl, !0),
                    (i.onload = function () {
                        i.status >= 200 && i.status < 400
                            ? ((e.jsonSnippets = JSON.parse(i.response)),
                              e.loadSnippets(function () {
                                  loadjs(
                                      [
                                          "//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js",
                                          "//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js",
                                          "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css",
                                      ],
                                      "bootstrapJsAndFontawesome"
                                  ),
                                      loadjs.ready("bootstrapJsAndFontawesome", function () {
                                          e.render(), e.initEvents(), e.initPositionEvents();
                                      });
                              }))
                            : console.log(i.response);
                    }),
                    (i.onerror = function () {
                        console.log(i.response);
                    }),
                    i.send();
            }),
            (n.prototype.setPluginMode = function () {
                this.pluginMode = "snippetInsert";
            }),
            (n.prototype.onBeforeMessage = function () {
                s.prototype.onBeforeMessage.call(this);
                var e = window.parent.tinymce.dom.DomQuery,
                    t = this.editor.selection.getNode();
                switch (this.insertPosition) {
                    case "":
                        e('<div id="tbp-snippet-insert"></div>').appendTo(t);
                        break;
                    case "insertBeginningContainer":
                        e(t).closest('[class*="container"]').prepend('<div id="tbp-snippet-insert"></div>');
                        break;
                    case "insertEndContainer":
                        e('<div id="tbp-snippet-insert"></div>').appendTo(e(t).closest('[class*="container"]'));
                        break;
                    case "insertBeginning":
                        e(this.editor.dom.select("body")).prepend('<div id="tbp-snippet-insert"></div>');
                        break;
                    case "insertEnd":
                        e('<div id="tbp-snippet-insert"></div>').appendTo(this.editor.dom.select("body"));
                }
                this.editor.selection.setCursorLocation(this.editor.dom.select("div#tbp-snippet-insert")[0], 0);
            }),
            (n.prototype.render = function () {
                var e = this;
                (this.category = jQuery("#snippets-nav").find(".nav-link.active").text()),
                    this.jsonSnippets.forEach(function (t) {
                        if (t.name === e.category)
                            for (var s = 0, n = Object.values(t.snippets); s < n.length; s++) {
                                var r = n[s];
                                r.name === e.snippetName && (e.snippetCode = r.code);
                            }
                    });
                var t = this.replaceRandomRecursive(this.snippetCode, 0, this.snippetName);
                jQuery("#preview-content").html(t);
                var s = Prism.highlight(html_beautify(t, this.beautifyOptions), Prism.languages.markup);
                jQuery("#code-content pre").html(s);
            }),
            (n.prototype.initPositionEvents = function () {
                var e = this.editor.selection.getNode();
                (this.editorClosestContainer = jQuery(e).closest('[class*="container"]')),
                    e.length < 1 && jQuery("select#insertPosition").children('option[value=""]').remove(),
                    this.editorClosestContainer.length < 1 && jQuery("select#insertPosition").children('option[value="insertBeginningContainer"], option[value="insertEndContainer"]').remove(),
                    jQuery("select#insertPosition").children("option:first-child").attr("selected", !0).trigger("change");
            }),
            (n.prototype.loadSnippets = function (e) {
                var t = this;
                jQuery.each(this.jsonSnippets, function (e, s) {
                    var n = jQuery("<li />", { class: "nav-item" }),
                        r = Math.random()
                            .toString(36)
                            .replace(/[^a-z]+/g, "")
                            .substr(0, 8),
                        i = jQuery("<a />", { "aria-controls": r, class: "nav-link", "data-toggle": "tab", href: "#" + r, id: r + "-tab", role: "tab", text: s.name });
                    0 === e && i.addClass("active").attr("selected", !0), n.append(i);
                    var a = jQuery("<div />", { "aria-labelledby": r + "-tab", class: "tab-pane", id: r, role: "tabpanel" });
                    0 === e && a.addClass("active");
                    var o = jQuery("<ul />", { class: "list-group list-group-horizontal align-items-stretch flex-wrap" });
                    jQuery.each(s.snippets, function (e, s) {
                        var n = "",
                            r = s.name;
                        -1 !== r.indexOf("[w-100]") && ((n = " w-100"), (r = r.replace("[w-100]", "")));
                        var i = jQuery("<li />", { class: "list-group-item selector pt-0 pl-0 pr-0 mb-4" + n }),
                            c = jQuery("<button />", { class: "btn btn-block p-0 snippet-preview", "data-prop": "snippetName", "data-value": s.name }),
                            p = jQuery("<div />", { class: "small text-left" }),
                            l = jQuery("<h6 />", { text: r, class: "text-center font-weight-normal bg-dark text-white text-uppercase px-2 py-2 mb-3" }),
                            d = t.replaceRandomRecursive(s.code, 0, r),
                            u = jQuery(d);
                        p.append(l), p.append(u), c.html(p), i.append(c), o.append(i), a.append(o);
                    }),
                        jQuery("#snippets-nav").append(n),
                        jQuery("#tabs").append(a);
                }),
                    e();
            }),
            (n.prototype.replaceRandomRecursive = function (e, t, s) {
                if (0 === t)
                    e.match(/{random}/) &&
                        (e = e.replace(
                            /{random}/g,
                            Math.random()
                                .toString(36)
                                .replace(/[^a-z]+/g, "")
                                .substr(0, 8)
                        ));
                else {
                    var n = new RegExp("{random-" + t.toString() + "}", "g");
                    e = e.replace(
                        n,
                        Math.random()
                            .toString(36)
                            .replace(/[^a-z]+/g, "")
                            .substr(0, 8)
                    );
                }
                var r = new RegExp("{random-" + (t + 1).toString() + "}");
                return e.match(r) ? this.replaceRandomRecursive(e, t + 1, s) : e;
            }),
            n
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
                        var n = s[t];
                        e += n[0] + '="' + n[1] + '"';
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
                        var s = (function () {
                                for (var e = 0, t = 0, s = arguments.length; t < s; t++) e += arguments[t].length;
                                var n = Array(e),
                                    r = 0;
                                for (t = 0; t < s; t++) for (var i = arguments[t], a = 0, o = i.length; a < o; a++, r++) n[r] = i[a];
                                return n;
                            })(this.reservedAttributes, ["data-mce-href", "data-mce-selected", "data-mce-src", "data-mce-style", "src", "style"]),
                            n = this.reservedClasses,
                            r = this.reservedStyles,
                            i = void 0,
                            a = 0,
                            o = e.classList,
                            c = o.length;
                        a < c;
                        a++
                    )
                        if (((i = o[a]), -1 === n.indexOf(i)))
                            if (this.reservedClassesRegex.length < 1) this.miscClasses.push(i);
                            else
                                for (var p = 0; p < this.reservedClassesRegex.length; p++) {
                                    var l = new RegExp(this.reservedClassesRegex[p], "g");
                                    i.match(l) || this.miscClasses.push(i);
                                }
                    var d = void 0,
                        u = ((a = 0), e.attributes);
                    for (c = u.length; a < c; a++) "class" !== (d = u[a]).nodeName && -1 === s.indexOf(d.nodeName) && (this.miscAttributes[d.nodeName] = d.nodeValue);
                    var h = "";
                    if (
                        (Object.keys(this.elStyles).forEach(function (e) {
                            -1 === r.indexOf(e) && (h += " " + t.reverseCamelize(e) + ":" + t.elStyles[e] + ";");
                        }),
                        h.length > 0)
                    ) {
                        this.miscAttributes.style = h.trim();
                    }
                }),
                (e.prototype.getIconClass = function (e) {
                    var t = this,
                        s = [],
                        n = jQuery(e).attr("class").split(" "),
                        r = this.bsInstance.iconBaseClasses.join("|").length,
                        i = new RegExp(this.bsInstance.iconSearchClass, "g"),
                        a = new RegExp(this.bsInstance.iconBaseClasses.join("|"), "g");
                    return (
                        jQuery.each(n, function (e, n) {
                            if (n.match(i)) {
                                var o = !1;
                                if (-1 !== t.reservedIconClasses.indexOf(n) || -1 !== t.reservedClasses.indexOf(n)) o = !0;
                                else
                                    for (var c = 0; c < t.reservedIconClassesRegex.length; c++) {
                                        var p = new RegExp(t.reservedIconClassesRegex[c], "g");
                                        n.match(p) && (o = !0);
                                    }
                                !1 === o && s.push(n);
                            } else r > 0 && n.match(a) && s.push(n);
                        }),
                        s.join(" ")
                    );
                }),
                (e.prototype.getStyles = function (e) {
                    var t = {};
                    if (!e || !e.style || !e.style.cssText) return t;
                    for (var s = e.style.cssText.split(";"), n = 0; n < s.length; ++n) {
                        var r = s[n].trim();
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
                                var n = s.data("prop");
                                (t[n] = s.data("value")), t.updateDialog(n, t[n]), t.render();
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
