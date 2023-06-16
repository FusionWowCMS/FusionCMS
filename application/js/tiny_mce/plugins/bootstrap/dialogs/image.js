!(function () {
    "use strict";
    var e = function (t, i) {
        return (e =
            Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array &&
                function (e, t) {
                    e.__proto__ = t;
                }) ||
            function (e, t) {
                for (var i in t) Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i]);
            })(t, i);
    };
    var t = function () {
        return (t =
            Object.assign ||
            function (e) {
                for (var t, i = 1, s = arguments.length; i < s; i++) for (var r in (t = arguments[i])) Object.prototype.hasOwnProperty.call(t, r) && (e[r] = t[r]);
                return e;
            }).apply(this, arguments);
    };
    function i() {
        for (var e = 0, t = 0, i = arguments.length; t < i; t++) e += arguments[t].length;
        var s = Array(e),
            r = 0;
        for (t = 0; t < i; t++) for (var n = arguments[t], a = 0, o = n.length; a < o; a++, r++) s[r] = n[a];
        return s;
    }
    new ((function (s) {
        function r() {
            var e = s.call(this) || this;
            return (e.imgSrc = e.bsInstance.pluginUrl + "assets/images/default-thumb.jpg"), (e.imgAlt = ""), (e.imgWidth = ""), (e.imgHeight = ""), (e.position = ""), (e.responsive = !0), (e.style = ""), e;
        }
        return (
            (function (t, i) {
                if ("function" != typeof i && null !== i) throw new TypeError("Class extends value " + String(i) + " is not a constructor or null");
                function s() {
                    this.constructor = t;
                }
                e(t, i), (t.prototype = null === i ? Object.create(i) : ((s.prototype = i.prototype), new s()));
            })(r, s),
            (r.prototype.init = function () {
                var e = this,
                    s = t(t({}, lang), dotData),
                    r = document.querySelector("body").innerHTML,
                    n = doT.template(r);
                (document.querySelector("body").innerHTML = n(s)),
                    (this.availablePositions = ["float-left", "float-right", "mx-auto", "d-block"]),
                    (this.availableStyles = ["img-thumbnail", "rounded", "rounded-circle", "rounded-pill", "rounded-sm", "rounded-lg"]),
                    (this.reservedAttributes = ["alt"]),
                    (this.reservedClasses = i(this.availableStyles, this.availablePositions, ["img-fluid", "tbp-active"])),
                    this.setInitialProperties(this.editor.selection.getNode()),
                    this.initEvents(),
                    loadjs(["../lib/file-tree/js/file-tree.js"], "fileTree"),
                    loadjs.ready("fileTree", function () {
                        jQuery(document).ready(function () {
                            e.initFileTree();
                        });
                    });
            }),
            (r.prototype.setPluginMode = function () {
                var e = this.editor.dom.select(".tbp-active");
                e.length > 0 && jQuery(e).is("img") && (this.pluginMode = "replace");
            }),
            (r.prototype.render = function () {
                var e = "",
                    t = { class: "", imgAlt: this.imgAlt, imgSrc: this.imgSrc, imgHeight: "", imgWidth: "", originalAttributes: "" };
                (t.class = this.style),
                    "" !== this.position && (t.class += " " + this.position),
                    !0 === this.responsive && (t.class += " img-fluid"),
                    "" !== this.imgWidth && (t.imgWidth = ' width:"' + this.imgWidth + 'px"'),
                    "" !== this.imgHeight && (t.imgHeight = ' height:"' + this.imgHeight + 'px"'),
                    (t.class += this.addOriginalClasses()),
                    (t.originalAttributes = this.addOriginalAttributes()),
                    "" !== t.class && (t.class = ' class="' + t.class.trim() + '"'),
                    (e = '<img src="' + t.imgSrc + '"' + t.class + t.imgWidth + t.imgHeight + t.originalAttributes + ' alt="' + this.imgAlt + '" />'),
                    jQuery("#preview-content").html(e),
                    (e = Prism.highlight(e, Prism.languages.markup)),
                    jQuery("#code-content pre").html(e),
                    jQuery(".selector img").prop("src", t.imgSrc);
            }),
            (r.prototype.initFileTree = function () {
                var e = this,
                    t = {
                        mainDir: this.bsInstance.imagesPath.substring(0, this.bsInstance.imagesPath.length - 1),
                        explorerMode: "grid",
                        extensions: [".bmp", ".gif", ".jpg", ".jpeg", ".png", ".svg", ".tif", ".tiff", ".webp"],
                        dragAndDrop: !0,
                        cancelBtnText: window.parent.tinymce.util.I18n.translate("Cancel"),
                        okBtnText: window.parent.tinymce.util.I18n.translate("OK"),
                        elementClick: function (e, t) {},
                        cancelBtnClick: function (e, t) {
                            jQuery("#file-tree-modal").removeClass("show-modal");
                        },
                        okBtnClick: function (t, i) {
                            if (((e.imgSrc = t), !1 === e.editor.settings.relative_urls)) {
                                var s = window.parent.document.createElement("a");
                                (s.href = t), (e.imgSrc = s.protocol + "//" + s.host + s.pathname + s.search + s.hash);
                            }
                            var r = new Image();
                            (r.src = e.imgSrc),
                                (r.onload = function () {
                                    (e.imgWidth = r.width.toString()),
                                        (e.imgHeight = r.height.toString()),
                                        e.updateDialog("imgSrc", e.imgSrc),
                                        e.updateDialog("imgHeight", e.imgHeight, "text"),
                                        e.updateDialog("imgWidth", e.imgWidth, "text"),
                                        e.render();
                                }),
                                jQuery("#file-tree-modal").removeClass("show-modal");
                        },
                    };
                new fileTree("file-tree-wrapper", t);
                jQuery(window).on("click", function (e) {
                    e.target === jQuery("#file-tree-modal") && jQuery("#file-tree-modal").toggleClass("show-modal");
                }),
                    jQuery("#trigger-modal-btn, #file-tree-modal #ft-close-btn").on("click", function () {
                        jQuery("#file-tree-modal").toggleClass("show-modal");
                    });
            }),
            (r.prototype.setInitialProperties = function (e) {
                var t = this;
                if ("replace" === this.pluginMode) {
                    (this.imgSrc = jQuery(e).attr("src")), (this.imgAlt = jQuery(e).attr("alt")), (this.imgHeight = jQuery(e).prop("height")), (this.imgWidth = jQuery(e).prop("width"));
                    var i = [];
                    this.availablePositions.forEach(function (t) {
                        jQuery(e).hasClass(t) && i.push(t);
                    }),
                        (this.position = i.join(" ")),
                        jQuery(e).hasClass("img-fluid") || (this.responsive = !1),
                        this.availableStyles.forEach(function (i) {
                            jQuery(e).hasClass(i) && (t.style = i);
                        }),
                        this.getOriginalAttributes(e);
                }
                this.updateDialog("imgSrc", this.imgSrc),
                    this.updateDialog("imgAlt", this.imgAlt, "text"),
                    this.updateDialog("imgHeight", this.imgHeight, "text"),
                    this.updateDialog("imgWidth", this.imgWidth, "text"),
                    this.updateDialog("position", this.position),
                    this.updateDialog("responsive", this.responsive, "boolean"),
                    this.updateDialog("style", this.style),
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
                    for (var e = " ", t = 0, i = Object.entries(this.miscAttributes); t < i.length; t++) {
                        var s = i[t];
                        e += s[0] + '="' + s[1] + '"';
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
                        var s = i(this.reservedAttributes, ["data-mce-href", "data-mce-selected", "data-mce-src", "data-mce-style", "src", "style"]),
                            r = this.reservedClasses,
                            n = this.reservedStyles,
                            a = void 0,
                            o = 0,
                            l = e.classList,
                            c = l.length;
                        o < c;
                        o++
                    )
                        if (((a = l[o]), -1 === r.indexOf(a)))
                            if (this.reservedClassesRegex.length < 1) this.miscClasses.push(a);
                            else
                                for (var u = 0; u < this.reservedClassesRegex.length; u++) {
                                    var d = new RegExp(this.reservedClassesRegex[u], "g");
                                    a.match(d) || this.miscClasses.push(a);
                                }
                    var h = void 0,
                        g = ((o = 0), e.attributes);
                    for (c = g.length; o < c; o++) "class" !== (h = g[o]).nodeName && -1 === s.indexOf(h.nodeName) && (this.miscAttributes[h.nodeName] = h.nodeValue);
                    var p = "";
                    if (
                        (Object.keys(this.elStyles).forEach(function (e) {
                            -1 === n.indexOf(e) && (p += " " + t.reverseCamelize(e) + ":" + t.elStyles[e] + ";");
                        }),
                        p.length > 0)
                    ) {
                        this.miscAttributes.style = p.trim();
                    }
                }),
                (e.prototype.getIconClass = function (e) {
                    var t = this,
                        i = [],
                        s = jQuery(e).attr("class").split(" "),
                        r = this.bsInstance.iconBaseClasses.join("|").length,
                        n = new RegExp(this.bsInstance.iconSearchClass, "g"),
                        a = new RegExp(this.bsInstance.iconBaseClasses.join("|"), "g");
                    return (
                        jQuery.each(s, function (e, s) {
                            if (s.match(n)) {
                                var o = !1;
                                if (-1 !== t.reservedIconClasses.indexOf(s) || -1 !== t.reservedClasses.indexOf(s)) o = !0;
                                else
                                    for (var l = 0; l < t.reservedIconClassesRegex.length; l++) {
                                        var c = new RegExp(t.reservedIconClassesRegex[l], "g");
                                        s.match(c) && (o = !0);
                                    }
                                !1 === o && i.push(s);
                            } else r > 0 && s.match(a) && i.push(s);
                        }),
                        i.join(" ")
                    );
                }),
                (e.prototype.getStyles = function (e) {
                    var t = {};
                    if (!e || !e.style || !e.style.cssText) return t;
                    for (var i = e.style.cssText.split(";"), s = 0; s < i.length; ++s) {
                        var r = i[s].trim();
                        if (r) {
                            var n = r.split(":");
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
                                var i = jQuery(e.target);
                                i.hasClass("selector") && (i = i.find(":first-child[data-prop]"));
                                var s = i.data("prop");
                                (t[s] = i.data("value")), t.updateDialog(s, t[s]), t.render();
                            }),
                            jQuery('input[type="radio"]').on("change keyup", function (e) {
                                var i = jQuery(e.target).data("prop");
                                (t[i] = jQuery(e.target).val()), t.updateDialog(i, t[i]), t.render();
                            }),
                            jQuery('input[type="text"], input[type="number"]').on("change keyup", function (e) {
                                var i = jQuery(e.target).data("prop");
                                (t[i] = jQuery(e.target).val()), t.updateDialog(i, t[i], "text"), t.render();
                            }),
                            jQuery("select").on("change", function (e) {
                                var i = jQuery(e.target).data("prop");
                                (t[i] = jQuery(e.target).val()), t.render();
                            }),
                            jQuery(".btn-group button").on("click", function (e) {
                                var i = jQuery(e.target).data("prop");
                                (t[i] = jQuery(e.target).data("value")), t.updateDialog(i, t[i], "boolean"), t.render();
                            }),
                            jQuery("a.dropdown-item").on("click", function (e) {
                                var i = jQuery(e.target).data("prop");
                                (t[i] = jQuery(e.target).data("value")), t.updateDialog(i, t[i], "dropdown"), t.render();
                            })),
                        window.addEventListener("message", function (e) {
                            if ("customInsertAndClose" === e.data.mceAction) {
                                t.onBeforeMessage();
                                var i = { pluginMode: t.pluginMode, outputCode: t.gc() };
                                jQuery("#preview-content").html().length > 0 && window.parent.postMessage({ mceAction: "execCommand", cmd: "iframeCommand", value: i }, origin), window.parent.postMessage({ mceAction: "close" }, origin);
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
                (e.prototype.updateDialog = function (e, t, i) {
                    void 0 === i && (i = "array-value"),
                        "array-value" === i
                            ? (jQuery("#" + e)
                                  .find(".selector")
                                  .removeClass("active"),
                              jQuery("#" + e + ' [data-value="' + t + '"]')
                                  .closest(".selector")
                                  .addClass("active"))
                            : "boolean" === i
                            ? (jQuery('button[data-prop="' + e + '"][data-value!="' + t + '"]')
                                  .removeClass(this.btnToggleActiveClass)
                                  .addClass(this.btnToggleInactiveClass),
                              jQuery('button[data-prop="' + e + '"][data-value="' + t + '"]')
                                  .removeClass(this.btnToggleInactiveClass)
                                  .addClass(this.btnToggleActiveClass))
                            : "radio" === i
                            ? jQuery('input[name="' + e + '"]').each(function () {
                                  jQuery(this).prop("checked", !1), jQuery(this).val() === t && jQuery(this).prop("checked", !0);
                              })
                            : "text" === i || "number" === i || "select" === i
                            ? jQuery("#" + e).val(t)
                            : "dropdown" === i && jQuery('*[data-content="' + e + '"]').html(t),
                        jQuery("." + e + "-toggle")[0] && (jQuery("." + e + "-toggle").removeClass("active"), jQuery("." + e + '-toggle[data-activate*="' + t + '"]').addClass("active"));
                }),
                (e.prototype.camelize = function (e) {
                    return e.replace(/(?:^|[-])(\w)/g, function (e, t) {
                        return (t = "-" === e.substr(0, 1) ? t.toUpperCase() : t) || "";
                    });
                }),
                (e.prototype.gc = function () {
                    return  jQuery("#preview-content").html();
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
