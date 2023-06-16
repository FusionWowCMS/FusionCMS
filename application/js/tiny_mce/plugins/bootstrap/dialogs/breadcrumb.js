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
                for (var t, s = 1, n = arguments.length; s < n; s++) for (var i in (t = arguments[s])) Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i]);
                return e;
            }).apply(this, arguments);
    };
    var s = (function () {
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
                                    i = 0;
                                for (t = 0; t < s; t++) for (var r = arguments[t], a = 0, o = r.length; a < o; a++, i++) n[i] = r[a];
                                return n;
                            })(this.reservedAttributes, ["data-mce-href", "data-mce-selected", "data-mce-src", "data-mce-style", "src", "style"]),
                            n = this.reservedClasses,
                            i = this.reservedStyles,
                            r = void 0,
                            a = 0,
                            o = e.classList,
                            c = o.length;
                        a < c;
                        a++
                    )
                        if (((r = o[a]), -1 === n.indexOf(r)))
                            if (this.reservedClassesRegex.length < 1) this.miscClasses.push(r);
                            else
                                for (var l = 0; l < this.reservedClassesRegex.length; l++) {
                                    var u = new RegExp(this.reservedClassesRegex[l], "g");
                                    r.match(u) || this.miscClasses.push(r);
                                }
                    var d = void 0,
                        p = ((a = 0), e.attributes);
                    for (c = p.length; a < c; a++) "class" !== (d = p[a]).nodeName && -1 === s.indexOf(d.nodeName) && (this.miscAttributes[d.nodeName] = d.nodeValue);
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
                        s = [],
                        n = jQuery(e).attr("class").split(" "),
                        i = this.bsInstance.iconBaseClasses.join("|").length,
                        r = new RegExp(this.bsInstance.iconSearchClass, "g"),
                        a = new RegExp(this.bsInstance.iconBaseClasses.join("|"), "g");
                    return (
                        jQuery.each(n, function (e, n) {
                            if (n.match(r)) {
                                var o = !1;
                                if (-1 !== t.reservedIconClasses.indexOf(n) || -1 !== t.reservedClasses.indexOf(n)) o = !0;
                                else
                                    for (var c = 0; c < t.reservedIconClassesRegex.length; c++) {
                                        var l = new RegExp(t.reservedIconClassesRegex[c], "g");
                                        n.match(l) && (o = !0);
                                    }
                                !1 === o && s.push(n);
                            } else i > 0 && n.match(a) && s.push(n);
                        }),
                        s.join(" ")
                    );
                }),
                (e.prototype.getStyles = function (e) {
                    var t = {};
                    if (!e || !e.style || !e.style.cssText) return t;
                    for (var s = e.style.cssText.split(";"), n = 0; n < s.length; ++n) {
                        var i = s[n].trim();
                        if (i) {
                            var r = i.split(":");
                            t[this.camelize(r[0].trim())] = r[1].trim();
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
        })(),
        n = {
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
    new ((function (s) {
        function i() {
            var e = s.call(this) || this;
            return (
                (e.items = []),
                (e.dialogHeaderTemplate = ""),
                (e.dialogItemTemplate =
                    '\n        <div class="row mb-3">\n            <div class="col-sm-4 mb-2"><input type="text" value="" class="form-control form-control-sm" data-prop="text" name="text"></div>\n            <div class="col-sm-6 mb-2"><input type="text" value="" class="form-control form-control-sm" data-prop="url" name="url"></div>\n            <div class="col-sm-2 mb-2"><button type="button" class="btn btn-danger btn-sm btn-delete-item"><i class="bootstrap-icon-minus"></i></button></div>\n        </div>'),
                (e.homeIcon = ""),
                (e.isNavTag = !0),
                e
            );
        }
        return (
            (function (t, s) {
                if ("function" != typeof s && null !== s) throw new TypeError("Class extends value " + String(s) + " is not a constructor or null");
                function n() {
                    this.constructor = t;
                }
                e(t, s), (t.prototype = null === s ? Object.create(s) : ((n.prototype = s.prototype), new n()));
            })(i, s),
            (i.prototype.init = function () {
                var e = t(t({}, lang), dotData),
                    s = document.querySelector("body").innerHTML,
                    i = doT.template(s);
                (document.querySelector("body").innerHTML = i(e)),
                    (this.homeIcon = n[this.bsInstance.iconFont].homeIcon),
                    this.homeIcon.length > 0 && loadjs(["../lib/iconpicker/fonts/" + this.bsInstance.iconCss]),
                    this.setInitialProperties(this.editor.selection.getNode()),
                    this.initEvents(!1),
                    this.initBreadcrumbEvents();
            }),
            (i.prototype.setPluginMode = function () {
                var e = this.editor.dom.select(".tbp-active");
                e.length > 0 && (jQuery(e).hasClass("breadcrumb") || jQuery(e).children(".breadcrumb")[0]) && (this.pluginMode = "replace");
            }),
            (i.prototype.initBreadcrumbEvents = function () {
                var e = this;
                jQuery(".btn-delete-item")
                    .off("click")
                    .on("click", function (t) {
                        var s = jQuery("#breadcrumb-items").find(".row");
                        (e.currentItemIndex = s.index(jQuery(t.target).closest(".row"))), e.removeItem(), e.renderDialog(), e.render(), e.initBreadcrumbEvents();
                    }),
                    jQuery('input[type="text"]').on("change keyup", function (t) {
                        var s = jQuery("#breadcrumb-items").find(".row");
                        e.currentItemIndex = s.index(jQuery(t.target).closest(".row"));
                        var n = jQuery(t.target).data("prop");
                        (e.items[e.currentItemIndex][n] = jQuery(t.target).val()), e.render();
                    }),
                    jQuery("#btn-add-new-item")
                        .off("click")
                        .on("click", function (t) {
                            e.addNewItem(), e.initBreadcrumbEvents();
                        });
            }),
            (i.prototype.render = function () {
                var e,
                    t = this,
                    s = { class: "breadcrumb", originalAttributes: "" };
                (s.class += this.addOriginalClasses()),
                    (s.originalAttributes = this.addOriginalAttributes()),
                    "" !== s.class && (s.class = ' class="' + s.class.trim() + '"'),
                    (e = !0 === this.isNavTag ? '<nav aria-label="breadcrumb"' + s.class + s.originalAttributes + '>\n                        <ol class="breadcrumb">' : '<ol class="breadcrumb"' + s.class + s.originalAttributes + ">"),
                    this.items.forEach(function (s) {
                        var n = s.text,
                            i = "";
                        t.homeIcon.length > 0 && (n = n.replace("icon-home", '<i class="' + t.homeIcon + '"></i>')),
                            (i = s.url.length > 0 ? '<a href="' + s.url + '">' + n + "</a>" : n),
                            t.items[t.items.length - 1] !== s ? (e += '<li class="breadcrumb-item">' + i + "</li>") : (e += '<li class="breadcrumb-item active" aria-current="page">' + i + "</li>");
                    }),
                    (e += "</ol>"),
                    !0 === this.isNavTag && (e += "</nav>"),
                    jQuery("#preview-content").html(e),
                    (e = Prism.highlight(html_beautify(jQuery(e)[0].outerHTML, this.beautifyOptions), Prism.languages.markup)),
                    jQuery("#code-content pre").html(e);
            }),
            (i.prototype.renderDialog = function () {
                var e = this,
                    t = jQuery("<div></div>");
                this.items.forEach(function (s) {
                    var n = jQuery(e.dialogItemTemplate);
                    n.find('[data-prop="text"]').attr("value", s.text), n.find('[data-prop="url"]').attr("value", s.url), e.items[0] === s && n.find(".btn-delete-item").remove(), t.append(n);
                }),
                    jQuery("#breadcrumb-items").html(t.html());
            }),
            (i.prototype.renderDialogHeader = function () {
                this.dialogHeaderTemplate =
                    '\n        <div class="row">\n            <div class="col-sm-4" id="item-text-label">' + lang.text + '</div>\n            <div class="col-sm-6" id="item-url-label">' + lang.link + "</div>\n        </div>";
                var e = jQuery("<div></div>"),
                    t = jQuery(this.dialogHeaderTemplate);
                e.append(t), jQuery("#breadcrumb-header").html(e.html());
            }),
            (i.prototype.addNewItem = function () {
                this.items.push({ text: "", url: "" }), this.renderDialog(), this.render();
            }),
            (i.prototype.removeItem = function () {
                this.items.splice(this.currentItemIndex, 1);
            }),
            (i.prototype.setInitialProperties = function (e) {
                var t = this;
                if ("replace" === this.pluginMode) {
                    var s = jQuery(e).closest(".breadcrumb");
                    (this.isNavTag = !1),
                        s.parent('nav[aria-label="breadcrumb"]')[0] && (this.isNavTag = !0),
                        s.find(".breadcrumb-item").each(function (e, s) {
                            var n = jQuery(s).html(),
                                i = "";
                            jQuery(s).children("a")[0] && ((n = jQuery(s).children("a").html()), (i = jQuery(s).children("a").attr("href"))), n.match(t.homeIcon) && (n = "icon-home"), t.items.push({ text: n, url: i });
                        }),
                        this.getOriginalAttributes(s.get(0));
                } else
                    this.items = [
                        { text: "icon-home", url: "#" },
                        { text: "Library", url: "#" },
                        { text: "Data", url: "" },
                    ];
                this.renderDialogHeader(), this.renderDialog(), this.render();
            }),
            i
        );
    })(s))();
})();
