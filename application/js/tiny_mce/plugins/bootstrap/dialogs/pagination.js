!(function () {
    "use strict";
    var e = function (t, n) {
        return (e =
            Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array &&
                function (e, t) {
                    e.__proto__ = t;
                }) ||
            function (e, t) {
                for (var n in t) Object.prototype.hasOwnProperty.call(t, n) && (e[n] = t[n]);
            })(t, n);
    };
    var t = function () {
        return (t =
            Object.assign ||
            function (e) {
                for (var t, n = 1, r = arguments.length; n < r; n++) for (var a in (t = arguments[n])) Object.prototype.hasOwnProperty.call(t, a) && (e[a] = t[a]);
                return e;
            }).apply(this, arguments);
    };
    function n() {
        for (var e = 0, t = 0, n = arguments.length; t < n; t++) e += arguments[t].length;
        var r = Array(e),
            a = 0;
        for (t = 0; t < n; t++) for (var i = arguments[t], s = 0, o = i.length; s < o; s++, a++) r[a] = i[s];
        return r;
    }
    new ((function (r) {
        function a() {
            var e = r.call(this) || this;
            return (
                (e.items = []),
                (e.alignment = "justify-content-center"),
                (e.availableAlignments = ["", "justify-content-center", "justify-content-end"]),
                (e.availableSizes = ["", "pagination-sm", "pagination-lg"]),
                (e.dialogHeaderTemplate = ""),
                (e.dialogItemTemplate = ""),
                (e.size = ""),
                e
            );
        }
        return (
            (function (t, n) {
                if ("function" != typeof n && null !== n) throw new TypeError("Class extends value " + String(n) + " is not a constructor or null");
                function r() {
                    this.constructor = t;
                }
                e(t, n), (t.prototype = null === n ? Object.create(n) : ((r.prototype = n.prototype), new r()));
            })(a, r),
            (a.prototype.init = function () {
                var e = t(t({}, lang), dotData),
                    r = document.querySelector("body").innerHTML,
                    a = doT.template(r);
                (document.querySelector("body").innerHTML = a(e)),
                    (this.dialogItemTemplate =
                        '\n        <div class="row mb-3">\n            <div class="col-sm-2 mb-2 d-flex align-items-center"><input type="text" value="" class="form-control form-control-sm" data-prop="text" name="text"></div>\n            <div class="col-sm-5 mb-2 d-flex align-items-center"><input type="text" value="" class="form-control form-control-sm" data-prop="url" name="url"></div>\n            <div class="choice col-sm-3 mx-0 mb-2 d-flex align-items-center">\n                <div class="btn-group" role="group">\n                    <button type="button" class="btn btn-sm" data-prop="current" data-value="false">' +
                        lang.no +
                        '</button>\n                    <button type="button" class="btn btn-sm" data-prop="current" data-value="true">' +
                        lang.yes +
                        '</button>\n                </div>\n            </div>\n            <div class="col-sm-2 mb-2 d-flex align-items-center"><button type="button" class="btn btn-danger btn-sm btn-delete-item"><i class="bootstrap-icon-minus"></i></button></div>\n        </div>'),
                    (this.reservedClasses = n(this.availableAlignments, this.availableSizes, ["pagination", "tbp-active"])),
                    this.setInitialProperties(this.editor.selection.getNode()),
                    this.initEvents(!1),
                    this.initPaginationEvents();
            }),
            (a.prototype.setPluginMode = function () {
                var e = this.editor.dom.select(".tbp-active");
                e.length > 0 && jQuery(e).find(".pagination").length > 0 && (this.pluginMode = "replace");
            }),
            (a.prototype.initPaginationEvents = function () {
                var e = this;
                jQuery(".btn-delete-item")
                    .off("click")
                    .on("click", function (t) {
                        var n = jQuery("#pagination-items").find(".row");
                        (e.currentItemIndex = n.index(jQuery(t.target).closest(".row"))), e.removeItem(), e.renderDialog(), e.render(), e.initPaginationEvents();
                    }),
                    jQuery('input[type="text"]').on("change keyup", function (t) {
                        var n = jQuery("#pagination-items").find(".row");
                        e.currentItemIndex = n.index(jQuery(t.target).closest(".row"));
                        var r = jQuery(t.target).data("prop");
                        (e.items[e.currentItemIndex][r] = jQuery(t.target).val()), e.render();
                    }),
                    jQuery('button[data-prop="current"]')
                        .off("click")
                        .on("click", function (t) {
                            var n = jQuery("#pagination-items").find(".row");
                            e.currentItemIndex = n.index(jQuery(t.target).closest(".row"));
                            var r = jQuery(n[e.currentItemIndex]),
                                a = jQuery(t.target).attr("data-value");
                            if (((e.items[e.currentItemIndex].current = "true" === a), "true" === a)) {
                                e.toggleBtnCurrent(r, !0);
                                for (var i = 0; i < e.items.length; i++)
                                    i !== e.currentItemIndex && ((e.items[i].current = !1), e.items[i].url.length < 1 && jQuery(n[i]).find('input[data-prop="url"]').val("#").trigger("change"), e.toggleBtnCurrent(jQuery(n[i]), !1));
                            } else e.toggleBtnCurrent(r, !1);
                            e.render();
                        }),
                    jQuery("select").on("change", function (t) {
                        var n = jQuery(t.target).data("prop");
                        (e[n] = jQuery(t.target).val()), e.render();
                    }),
                    jQuery("#btn-add-new-item")
                        .off("click")
                        .on("click", function (t) {
                            e.addNewItem(), e.initPaginationEvents();
                        });
            }),
            (a.prototype.render = function () {
                var e,
                    t = { class: "", originalAttributes: "" };
                (t.class += this.addOriginalClasses()),
                    (t.originalAttributes = this.addOriginalAttributes()),
                    "" !== t.class && (t.class = ' class="' + t.class.trim() + '"'),
                    (e = '<nav aria-label="pagination"' + t.class + t.originalAttributes + ">");
                var n = "";
                this.size.length > 0 && (n += " " + this.size),
                    this.alignment.length > 0 && (n += " " + this.alignment),
                    (e += '<ul class="pagination' + n + '">'),
                    this.items.forEach(function (t) {
                        var n = t.text,
                            r = "",
                            a = "";
                        n.toLowerCase() === lang.paginationfirst.toLowerCase()
                            ? ((n = '<span aria-hidden="true">&laquo;</span>'), (a = ' aria-label="' + lang.paginationfirst + '"'))
                            : n.toLowerCase() === lang.paginationlast.toLowerCase() && ((n = '<span aria-hidden="true">&raquo;</span>'), (a = ' aria-label="' + lang.paginationlast + '"')),
                            (r = !0 === t.current ? '<span class="page-link">' + n + '<span class="sr-only">(' + lang.current + ")</span></span>" : '<a class="page-link" href="' + t.url + '"' + a + ">" + n + "</a>"),
                            !1 === t.current ? (e += '<li class="page-item">' + r + "</li>") : (e += '<li class="page-item active" aria-current="page">' + r + "</li>");
                    }),
                    (e += "</ul>"),
                    (e += "</nav>"),
                    jQuery("#preview-content").html(e),
                    (e = Prism.highlight(html_beautify(jQuery(e)[0].outerHTML, this.beautifyOptions), Prism.languages.markup)),
                    jQuery("#code-content pre").html(e);
            }),
            (a.prototype.renderDialog = function () {
                var e = this,
                    t = jQuery("<div></div>");
                this.items.forEach(function (n) {
                    var r = jQuery(e.dialogItemTemplate);
                    r.find('[data-prop="text"]').attr("value", n.text), r.find('[data-prop="url"]').attr("value", n.url), e.toggleBtnCurrent(r, n.current), e.items[0] === n && r.find(".btn-delete-item").remove(), t.append(r);
                }),
                    jQuery("#pagination-items").html(t.html());
            }),
            (a.prototype.renderDialogHeader = function () {
                this.dialogHeaderTemplate =
                    '\n        <div class="row">\n            <div class="col-sm-2 mb-2 text-secondary" id="item-text-label">' +
                    lang.text +
                    '</div>\n            <div class="col-sm-5 mb-2 text-secondary" id="item-url-label">' +
                    lang.link +
                    '</div>\n            <div class="col-sm-3 mb-2 text-secondary" id="item-url-label">' +
                    lang.current +
                    "</div>\n        </div>";
                var e = jQuery("<div></div>"),
                    t = jQuery(this.dialogHeaderTemplate);
                e.append(t), jQuery("#pagination-header").html(e.html());
            }),
            (a.prototype.addNewItem = function () {
                this.items.push({ text: "last", url: window.location.origin, current: !1 }), this.renderDialog(), this.render();
            }),
            (a.prototype.removeItem = function () {
                this.items.splice(this.currentItemIndex, 1);
            }),
            (a.prototype.setInitialProperties = function (e) {
                var t = this;
                if ("replace" === this.pluginMode) {
                    var n = jQuery(e).closest(".pagination");
                    this.availableAlignments.forEach(function (e) {
                        n.hasClass(e) && (t.alignment = e);
                    }),
                        this.availableSizes.forEach(function (e) {
                            n.hasClass(e) && (t.size = e);
                        }),
                        n.find(".page-item").each(function (e, n) {
                            var r = jQuery(n).text(),
                                a = "",
                                i = !1;
                            if ((jQuery(n).children("a")[0] && ((r = jQuery(n).children("a").text()), (a = jQuery(n).children("a").attr("href"))), jQuery(n).hasClass("active"))) {
                                i = !0;
                                var s = "\\(" + lang.current + "\\)",
                                    o = new RegExp(s, "gi");
                                r = r.replace(o, "").trim();
                            }
                            t.items.push({ text: r, url: a, current: i });
                        }),
                        this.getOriginalAttributes(n.get(0));
                } else
                    this.items = [
                        { text: "first", url: window.location.origin, current: !1 },
                        { text: "1", url: window.location.origin, current: !1 },
                        { text: "2", url: "#", current: !0 },
                        { text: "3", url: window.location.origin, current: !1 },
                        { text: "last", url: window.location.origin, current: !1 },
                    ];
                this.updateDialog("alignment", this.alignment, "select"), this.updateDialog("size", this.size, "select"), this.renderDialogHeader(), this.renderDialog(), this.render();
            }),
            (a.prototype.toggleBtnCurrent = function (e, t) {
                if (!0 !== t)
                    return (
                        e.find('button[data-prop="current"][data-value="true"]').removeClass(this.btnToggleActiveClass).addClass(this.btnToggleInactiveClass),
                        void e.find('button[data-prop="current"][data-value="false"]').removeClass(this.btnToggleInactiveClass).addClass(this.btnToggleActiveClass)
                    );
                e.find('button[data-prop="current"][data-value="false"]').removeClass(this.btnToggleActiveClass).addClass(this.btnToggleInactiveClass),
                    e.find('button[data-prop="current"][data-value="true"]').removeClass(this.btnToggleInactiveClass).addClass(this.btnToggleActiveClass);
            }),
            a
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
                    for (var e = " ", t = 0, n = Object.entries(this.miscAttributes); t < n.length; t++) {
                        var r = n[t];
                        e += r[0] + '="' + r[1] + '"';
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
                        var r = n(this.reservedAttributes, ["data-mce-href", "data-mce-selected", "data-mce-src", "data-mce-style", "src", "style"]),
                            a = this.reservedClasses,
                            i = this.reservedStyles,
                            s = void 0,
                            o = 0,
                            l = e.classList,
                            c = l.length;
                        o < c;
                        o++
                    )
                        if (((s = l[o]), -1 === a.indexOf(s)))
                            if (this.reservedClassesRegex.length < 1) this.miscClasses.push(s);
                            else
                                for (var u = 0; u < this.reservedClassesRegex.length; u++) {
                                    var d = new RegExp(this.reservedClassesRegex[u], "g");
                                    s.match(d) || this.miscClasses.push(s);
                                }
                    var p = void 0,
                        g = ((o = 0), e.attributes);
                    for (c = g.length; o < c; o++) "class" !== (p = g[o]).nodeName && -1 === r.indexOf(p.nodeName) && (this.miscAttributes[p.nodeName] = p.nodeValue);
                    var h = "";
                    if (
                        (Object.keys(this.elStyles).forEach(function (e) {
                            -1 === i.indexOf(e) && (h += " " + t.reverseCamelize(e) + ":" + t.elStyles[e] + ";");
                        }),
                        h.length > 0)
                    ) {
                        this.miscAttributes.style = h.trim();
                    }
                }),
                (e.prototype.getIconClass = function (e) {
                    var t = this,
                        n = [],
                        r = jQuery(e).attr("class").split(" "),
                        a = this.bsInstance.iconBaseClasses.join("|").length,
                        i = new RegExp(this.bsInstance.iconSearchClass, "g"),
                        s = new RegExp(this.bsInstance.iconBaseClasses.join("|"), "g");
                    return (
                        jQuery.each(r, function (e, r) {
                            if (r.match(i)) {
                                var o = !1;
                                if (-1 !== t.reservedIconClasses.indexOf(r) || -1 !== t.reservedClasses.indexOf(r)) o = !0;
                                else
                                    for (var l = 0; l < t.reservedIconClassesRegex.length; l++) {
                                        var c = new RegExp(t.reservedIconClassesRegex[l], "g");
                                        r.match(c) && (o = !0);
                                    }
                                !1 === o && n.push(r);
                            } else a > 0 && r.match(s) && n.push(r);
                        }),
                        n.join(" ")
                    );
                }),
                (e.prototype.getStyles = function (e) {
                    var t = {};
                    if (!e || !e.style || !e.style.cssText) return t;
                    for (var n = e.style.cssText.split(";"), r = 0; r < n.length; ++r) {
                        var a = n[r].trim();
                        if (a) {
                            var i = a.split(":");
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
                                var n = jQuery(e.target);
                                n.hasClass("selector") && (n = n.find(":first-child[data-prop]"));
                                var r = n.data("prop");
                                (t[r] = n.data("value")), t.updateDialog(r, t[r]), t.render();
                            }),
                            jQuery('input[type="radio"]').on("change keyup", function (e) {
                                var n = jQuery(e.target).data("prop");
                                (t[n] = jQuery(e.target).val()), t.updateDialog(n, t[n]), t.render();
                            }),
                            jQuery('input[type="text"], input[type="number"]').on("change keyup", function (e) {
                                var n = jQuery(e.target).data("prop");
                                (t[n] = jQuery(e.target).val()), t.updateDialog(n, t[n], "text"), t.render();
                            }),
                            jQuery("select").on("change", function (e) {
                                var n = jQuery(e.target).data("prop");
                                (t[n] = jQuery(e.target).val()), t.render();
                            }),
                            jQuery(".btn-group button").on("click", function (e) {
                                var n = jQuery(e.target).data("prop");
                                (t[n] = jQuery(e.target).data("value")), t.updateDialog(n, t[n], "boolean"), t.render();
                            }),
                            jQuery("a.dropdown-item").on("click", function (e) {
                                var n = jQuery(e.target).data("prop");
                                (t[n] = jQuery(e.target).data("value")), t.updateDialog(n, t[n], "dropdown"), t.render();
                            })),
                        window.addEventListener("message", function (e) {
                            if ("customInsertAndClose" === e.data.mceAction) {
                                t.onBeforeMessage();
                                var n = { pluginMode: t.pluginMode, outputCode: t.gc() };
                                jQuery("#preview-content").html().length > 0 && window.parent.postMessage({ mceAction: "execCommand", cmd: "iframeCommand", value: n }, origin), window.parent.postMessage({ mceAction: "close" }, origin);
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
                (e.prototype.updateDialog = function (e, t, n) {
                    void 0 === n && (n = "array-value"),
                        "array-value" === n
                            ? (jQuery("#" + e)
                                  .find(".selector")
                                  .removeClass("active"),
                              jQuery("#" + e + ' [data-value="' + t + '"]')
                                  .closest(".selector")
                                  .addClass("active"))
                            : "boolean" === n
                            ? (jQuery('button[data-prop="' + e + '"][data-value!="' + t + '"]')
                                  .removeClass(this.btnToggleActiveClass)
                                  .addClass(this.btnToggleInactiveClass),
                              jQuery('button[data-prop="' + e + '"][data-value="' + t + '"]')
                                  .removeClass(this.btnToggleInactiveClass)
                                  .addClass(this.btnToggleActiveClass))
                            : "radio" === n
                            ? jQuery('input[name="' + e + '"]').each(function () {
                                  jQuery(this).prop("checked", !1), jQuery(this).val() === t && jQuery(this).prop("checked", !0);
                              })
                            : "text" === n || "number" === n || "select" === n
                            ? jQuery("#" + e).val(t)
                            : "dropdown" === n && jQuery('*[data-content="' + e + '"]').html(t),
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
