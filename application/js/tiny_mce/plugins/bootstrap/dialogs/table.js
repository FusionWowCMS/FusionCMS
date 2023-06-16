!(function () {
    "use strict";
    var e = function (t, a) {
        return (e =
            Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array &&
                function (e, t) {
                    e.__proto__ = t;
                }) ||
            function (e, t) {
                for (var a in t) Object.prototype.hasOwnProperty.call(t, a) && (e[a] = t[a]);
            })(t, a);
    };
    var t = function () {
        return (t =
            Object.assign ||
            function (e) {
                for (var t, a = 1, s = arguments.length; a < s; a++) for (var r in (t = arguments[a])) Object.prototype.hasOwnProperty.call(t, r) && (e[r] = t[r]);
                return e;
            }).apply(this, arguments);
    };
    function a() {
        for (var e = 0, t = 0, a = arguments.length; t < a; t++) e += arguments[t].length;
        var s = Array(e),
            r = 0;
        for (t = 0; t < a; t++) for (var i = arguments[t], n = 0, o = i.length; n < o; n++, r++) s[r] = i[n];
        return s;
    }
    new ((function (s) {
        function r() {
            var e = s.call(this) || this;
            return (
                (e.border = ""),
                (e.caption = ""),
                (e.horizontalHeader = ""),
                (e.nakedTableCode = ""),
                (e.tableCols = 5),
                (e.tableDark = !1),
                (e.tableHover = !1),
                (e.tableResponsive = ""),
                (e.tableRows = 5),
                (e.tableSmall = !1),
                (e.tableStriped = !1),
                (e.verticalHeader = !1),
                (e.defaultContent = [
                    ["Name", "Company", "Street Adress", "City", "Region", "Postal / Zip", "Country", "Phone / Fax", "Email", "Date"],
                    ["Raymond", "Sed Hendrerit Limited", "7434 Ut", "Rd.", "Belfast", "U", "36240", "Aruba", "712-9512", "non.magna.Nam@dapibus.ca", "non.magna.Nam@dapibus.ca", "Mon, Sep 28"],
                    ["Sylvester", "Elit Etiam Laoreet Company", "Ap #910-7911 Nunc. St.", "Alandur", "Tamil Nadu", "60-231", "Suriname", "1-744-173-8448", "nibh@est.com", "Sun, Jul 20"],
                    ["Wayne", "Dolor Donec Corporation", "8118 Donec St.", "Billings", "Montana", "619879", "Qatar", "850-7630", "vulputate@lacus.net", "Fri, May 02"],
                    ["Hakeem", "Etiam Corp.", "723-503 Molestie Street", "Cork", "Munster", "2837", "Northern Mariana Islands", "636-9924", "hendrerit.neque@Mauris.co.uk", "Wed, Sep 17"],
                    ["Noah", "Lectus Rutrum Corporation", "P.O. Box 835", "1423 Cras Avenue", "Galashiels", "SE", "11506", "Slovenia", "918-6912", "dolor@interdumCurabitur.edu", "Fri, Oct 16"],
                    ["Upton", "Blandit LLP", "Ap #270-7313 Adipiscing", "Ave", "Middelburg", "Zeeland", "23967", "Dominica", "1-765-258-3249", "ultrices.Vivamus.rhoncus@amet.co.uk", "Tue, Jul 21"],
                    ["Nehru", "Vitae Sodales At Industries", "303-180 Etiam Avenue", "Cartago", "C", "3940", "Heard Island and Mcdonald Islands", "1-750-269-5948", "consequat.purus.Maecenas@mus.net", "Thu, Dec 18"],
                    ["Jonah", "Consectetuer Adipiscing Consulting", "P.O. Box 844", "1463 Lorem", "Rd.", "St. Andrä", "Carinthia", "91826", "Congo (Brazzaville)", "770-0620", "tristique.senectus@ridiculusmus.co.uk", "Mon, Jul 07"],
                    ["Charles", "Phasellus Incorporated", "P.O. Box 396", "3093 Egestas. St.", "Sluis", "Zeeland", "28-939", "Ghana", "1-652-482-1968", "natoque@vitaeeratVivamus.ca", "Fri, Jan 30"],
                ]),
                e
            );
        }
        return (
            (function (t, a) {
                if ("function" != typeof a && null !== a) throw new TypeError("Class extends value " + String(a) + " is not a constructor or null");
                function s() {
                    this.constructor = t;
                }
                e(t, a), (t.prototype = null === a ? Object.create(a) : ((s.prototype = a.prototype), new s()));
            })(r, s),
            (r.prototype.init = function () {
                var e = this,
                    s = t(t({}, lang), dotData),
                    r = document.querySelector("body").innerHTML,
                    i = doT.template(r);
                (document.querySelector("body").innerHTML = i(s)),
                    (this.availableHeaderClass = ["default", "thead-light", "thead-dark"]),
                    (this.availableBorderClass = ["table-bordered", "table-borderless"]),
                    (this.availableResponsiveClass = ["table-responsive", "table-responsive-sm", "table-responsive-md", "table-responsive-lg", "table-responsive-xl"]),
                    (this.reservedClasses = a(this.availableHeaderClass, this.availableBorderClass, this.availableResponsiveClass, ["table", "table-striped", "table-dark", "table-hover", "table-sm", "mce-item-table", "tbp-active"])),
                    this.setInitialProperties(this.editor.selection.getNode()),
                    this.initEvents(),
                    "replace" === this.pluginMode
                        ? (jQuery("#cellpicker").attr("disabled", !0).toggleClass("btn-primary", "btn-secondary").parent("div").removeClass("my-5"), jQuery("#my-popper").remove(), jQuery("#table-edit-disabled-info").removeClass("d-none"))
                        : ((this.nakedTableCode = this.buildTable()),
                          loadjs(["../lib/popper-js/popper.min.js"], "popper"),
                          loadjs.ready("popper", function () {
                              var t = document.querySelector("#cellpicker"),
                                  a = document.querySelector("#my-popper");
                              a.innerHTML = jQuery("#table-builder-wrapper").append('<div class="popper__arrow" x-arrow=""></div>').html();
                              new Popper(t, a, {
                                  placement: "bottom",
                                  onCreate: function (t) {
                                      jQuery("#table-builder td")
                                          .on("mouseover", function (t) {
                                              var a = t.target;
                                              (e.tableCols = jQuery(a).prevAll("td").length + 1),
                                                  (e.tableRows = jQuery(a).parent("tr").prevAll("tr").length + 1),
                                                  jQuery("#cellNumbers").html(e.tableCols + " x " + e.tableRows),
                                                  jQuery("#table-builder tr:nth-child(-n + " + e.tableRows + ") td:nth-child(-n + " + e.tableCols + ")").addClass("active bg-primary"),
                                                  jQuery("#table-builder tr:nth-child(n + " + (e.tableRows + 1) + ") td")
                                                      .add("#table-builder tr:nth-child(-n + " + e.tableRows + ") td:nth-child(n + " + (e.tableCols + 1) + ")")
                                                      .removeClass("active bg-primary");
                                          })
                                          .on("click", function () {
                                              jQuery("#cellpicker").trigger("click"), (e.nakedTableCode = e.buildTable()), e.render();
                                          }),
                                          jQuery(a).hide();
                                  },
                              });
                              jQuery(t).on("click", function () {
                                  jQuery(a).toggle();
                              });
                          }));
            }),
            (r.prototype.setPluginMode = function () {
                var e = this.editor.dom.select(".tbp-active");
                e.length > 0 && (jQuery(e).is("table") || jQuery(e).children(".table")[0]) && (this.pluginMode = "replace");
            }),
            (r.prototype.render = function () {
                var e,
                    t = { class: "table", originalAttributes: "" },
                    a = !1;
                jQuery(this.nakedTableCode).find("thead").length > 0 && (a = !0);
                var s = !1;
                "" !== this.horizontalHeader && (s = !0);
                var r = !1;
                if (
                    (jQuery(this.nakedTableCode).find("tbody > tr > th:first-child").length > 0 && (r = !0),
                    (a === s && r === this.verticalHeader) || this.toggleHeaders(),
                    (e = jQuery(this.nakedTableCode)),
                    "" !== this.border && (t.class += " " + this.border),
                    !0 === this.tableDark && (t.class += " table-dark"),
                    !0 === this.tableHover && (t.class += " table-hover"),
                    !0 === this.tableSmall && (t.class += " table-sm"),
                    !0 === this.tableStriped && (t.class += " table-striped"),
                    (t.class += this.addOriginalClasses()),
                    (t.originalAttributes = this.addOriginalAttributes()),
                    "" !== this.horizontalHeader && "default" !== this.horizontalHeader && e.find("thead").addClass(this.horizontalHeader),
                    e.addClass(t.class.trim()),
                    Object.keys(this.miscAttributes).length)
                )
                    for (var i = 0, n = Object.entries(this.miscAttributes); i < n.length; i++) {
                        var o = n[i],
                            l = o[0],
                            d = o[1];
                        e.attr(l, d);
                    }
                "" !== this.caption && e.prepend("<caption>" + this.caption + "</caption>"), "" !== this.tableResponsive && (e = jQuery('<div class="' + this.tableResponsive + '"></div>').html(e)), jQuery("#preview-content").html(e);
                var c = Prism.highlight(html_beautify(jQuery(e)[0].outerHTML, this.beautifyOptions), Prism.languages.markup);
                jQuery("#code-content pre").html(c);
            }),
            (r.prototype.buildTable = function () {
                var e = "";
                e += '<table class="">\n';
                for (var t = 0; t <= this.tableRows - 1; t++) {
                    0 === t && ("" !== this.horizontalHeader ? ("default" === this.horizontalHeader ? (e += "    <thead>\n") : (e += '    <thead class="' + this.horizontalHeader + '">\n')) : (e += "    <tbody>\n")), (e += "        <tr>\n");
                    for (var a = 0; a <= this.tableCols - 1; a++)
                        0 === t && "" !== this.horizontalHeader
                            ? (e += "            <th>" + this.defaultContent[t][a] + "</th>\n")
                            : this.verticalHeader && 0 === a
                            ? (e += "            <th>" + this.defaultContent[t][a] + "</th>\n")
                            : (e += "            <td>" + this.defaultContent[t][a] + "</td>\n");
                    (e += "        </tr>\n"), 0 === t && "" !== this.horizontalHeader && ((e += "    </thead>\n"), (e += "    <tbody>\n"));
                }
                return (e += "    </tbody>\n"), (e += "</table>\n");
            }),
            (r.prototype.setInitialProperties = function (e) {
                var t = this;
                if ("replace" === this.pluginMode) {
                    var a = jQuery(e).closest("table").clone(),
                        s = jQuery(a[0].rows);
                    if (
                        ((this.tableRows = s.length),
                        (this.tableCols = jQuery(s.get(0)).find("th, td").length),
                        this.availableBorderClass.forEach(function (e) {
                            a.hasClass(e) && (t.border = e);
                        }),
                        a.find("caption")[0] && ((this.caption = a.find("caption").html()), a.find("caption").remove()),
                        a.find("> thead")[0])
                    ) {
                        var r = a.find("> thead");
                        (this.horizontalHeader = "default"),
                            this.availableHeaderClass.forEach(function (e) {
                                jQuery(r).hasClass(e) && (t.horizontalHeader = e);
                            });
                    }
                    (this.tableDark = a.hasClass("table-dark")),
                        (this.tableHover = a.hasClass("table-hover")),
                        this.availableResponsiveClass.forEach(function (e) {
                            a.parent("div." + e)[0] && (t.tableResponsive = e);
                        }),
                        (this.tableSmall = a.hasClass("table-sm")),
                        (this.tableStriped = a.hasClass("table-striped")),
                        (this.verticalHeader = !0),
                        jQuery(s).find("td:first-child").length > 0 && (this.verticalHeader = !1),
                        this.getOriginalAttributes(a.get(0)),
                        (this.nakedTableCode = jQuery("<div></div>").html(a.removeClass().removeAttr()).html());
                } else this.nakedTableCode = this.buildTable();
                this.updateDialog("border", this.border, "select"),
                    this.updateDialog("caption", this.caption, "text"),
                    this.updateDialog("horizontalHeader", this.horizontalHeader, "select"),
                    this.updateDialog("tableDark", this.tableDark, "boolean"),
                    this.updateDialog("tableHover", this.tableHover, "boolean"),
                    this.updateDialog("tableResponsive", this.tableResponsive, "select"),
                    this.updateDialog("tableSmall", this.tableSmall, "boolean"),
                    this.updateDialog("tableStriped", this.tableStriped, "boolean"),
                    this.updateDialog("verticalHeader", this.verticalHeader, "boolean"),
                    this.render();
            }),
            (r.prototype.toggleHeaders = function () {
                var e = jQuery("<div>").html(this.nakedTableCode);
                if ((e.find("thead")[0] && e.find("table tr").unwrap("thead"), e.find("table tbody")[0])) {
                    var t = e.find("table tbody").html();
                    e.find("table tbody").replaceWith(t);
                }
                if (
                    (!0 === this.verticalHeader
                        ? e.find("table tr td:first-child").each(function () {
                              jQuery(this).replaceWith('<th scope="row">' + jQuery(this).text() + "</th>");
                          })
                        : e.find("table tr th:first-child").each(function () {
                              jQuery(this).replaceWith("<td>" + jQuery(this).text() + "</td>");
                          }),
                    "" !== this.horizontalHeader
                        ? e
                              .find("table tr:first-child")
                              .find("td")
                              .each(function () {
                                  jQuery(this).replaceWith('<th scope="col">' + jQuery(this).text() + "</th>");
                              })
                        : (e
                              .find("table tr:first-child")
                              .find("th")
                              .each(function () {
                                  jQuery(this).replaceWith("<td>" + jQuery(this).text() + "</td>");
                              }),
                          !0 === this.verticalHeader &&
                              e.find("table tr:first-child td:first-child").each(function () {
                                  jQuery(this).replaceWith('<th scope="row">' + jQuery(this).text() + "</th>");
                              })),
                    e.find("table").wrapInner("<tbody>"),
                    e.find("table tbody tr:first-child th:nth-child(2)")[0])
                ) {
                    var a = e.find("table tbody > tr:first-child").clone();
                    e.find("table tbody > tr:first-child").remove(), jQuery("<thead></thead>").prependTo(e.find("table")), e.find("table thead").append(a);
                }
                this.nakedTableCode = e.html();
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
                    for (var e = " ", t = 0, a = Object.entries(this.miscAttributes); t < a.length; t++) {
                        var s = a[t];
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
                        var s = a(this.reservedAttributes, ["data-mce-href", "data-mce-selected", "data-mce-src", "data-mce-style", "src", "style"]),
                            r = this.reservedClasses,
                            i = this.reservedStyles,
                            n = void 0,
                            o = 0,
                            l = e.classList,
                            d = l.length;
                        o < d;
                        o++
                    )
                        if (((n = l[o]), -1 === r.indexOf(n)))
                            if (this.reservedClassesRegex.length < 1) this.miscClasses.push(n);
                            else
                                for (var c = 0; c < this.reservedClassesRegex.length; c++) {
                                    var h = new RegExp(this.reservedClassesRegex[c], "g");
                                    n.match(h) || this.miscClasses.push(n);
                                }
                    var u = void 0,
                        p = ((o = 0), e.attributes);
                    for (d = p.length; o < d; o++) "class" !== (u = p[o]).nodeName && -1 === s.indexOf(u.nodeName) && (this.miscAttributes[u.nodeName] = u.nodeValue);
                    var b = "";
                    if (
                        (Object.keys(this.elStyles).forEach(function (e) {
                            -1 === i.indexOf(e) && (b += " " + t.reverseCamelize(e) + ":" + t.elStyles[e] + ";");
                        }),
                        b.length > 0)
                    ) {
                        this.miscAttributes.style = b.trim();
                    }
                }),
                (e.prototype.getIconClass = function (e) {
                    var t = this,
                        a = [],
                        s = jQuery(e).attr("class").split(" "),
                        r = this.bsInstance.iconBaseClasses.join("|").length,
                        i = new RegExp(this.bsInstance.iconSearchClass, "g"),
                        n = new RegExp(this.bsInstance.iconBaseClasses.join("|"), "g");
                    return (
                        jQuery.each(s, function (e, s) {
                            if (s.match(i)) {
                                var o = !1;
                                if (-1 !== t.reservedIconClasses.indexOf(s) || -1 !== t.reservedClasses.indexOf(s)) o = !0;
                                else
                                    for (var l = 0; l < t.reservedIconClassesRegex.length; l++) {
                                        var d = new RegExp(t.reservedIconClassesRegex[l], "g");
                                        s.match(d) && (o = !0);
                                    }
                                !1 === o && a.push(s);
                            } else r > 0 && s.match(n) && a.push(s);
                        }),
                        a.join(" ")
                    );
                }),
                (e.prototype.getStyles = function (e) {
                    var t = {};
                    if (!e || !e.style || !e.style.cssText) return t;
                    for (var a = e.style.cssText.split(";"), s = 0; s < a.length; ++s) {
                        var r = a[s].trim();
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
                                var a = jQuery(e.target);
                                a.hasClass("selector") && (a = a.find(":first-child[data-prop]"));
                                var s = a.data("prop");
                                (t[s] = a.data("value")), t.updateDialog(s, t[s]), t.render();
                            }),
                            jQuery('input[type="radio"]').on("change keyup", function (e) {
                                var a = jQuery(e.target).data("prop");
                                (t[a] = jQuery(e.target).val()), t.updateDialog(a, t[a]), t.render();
                            }),
                            jQuery('input[type="text"], input[type="number"]').on("change keyup", function (e) {
                                var a = jQuery(e.target).data("prop");
                                (t[a] = jQuery(e.target).val()), t.updateDialog(a, t[a], "text"), t.render();
                            }),
                            jQuery("select").on("change", function (e) {
                                var a = jQuery(e.target).data("prop");
                                (t[a] = jQuery(e.target).val()), t.render();
                            }),
                            jQuery(".btn-group button").on("click", function (e) {
                                var a = jQuery(e.target).data("prop");
                                (t[a] = jQuery(e.target).data("value")), t.updateDialog(a, t[a], "boolean"), t.render();
                            }),
                            jQuery("a.dropdown-item").on("click", function (e) {
                                var a = jQuery(e.target).data("prop");
                                (t[a] = jQuery(e.target).data("value")), t.updateDialog(a, t[a], "dropdown"), t.render();
                            })),
                        window.addEventListener("message", function (e) {
                            if ("customInsertAndClose" === e.data.mceAction) {
                                t.onBeforeMessage();
                                var a = { pluginMode: t.pluginMode, outputCode: t.gc() };
                                jQuery("#preview-content").html().length > 0 && window.parent.postMessage({ mceAction: "execCommand", cmd: "iframeCommand", value: a }, origin), window.parent.postMessage({ mceAction: "close" }, origin);
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
                (e.prototype.updateDialog = function (e, t, a) {
                    void 0 === a && (a = "array-value"),
                        "array-value" === a
                            ? (jQuery("#" + e)
                                  .find(".selector")
                                  .removeClass("active"),
                              jQuery("#" + e + ' [data-value="' + t + '"]')
                                  .closest(".selector")
                                  .addClass("active"))
                            : "boolean" === a
                            ? (jQuery('button[data-prop="' + e + '"][data-value!="' + t + '"]')
                                  .removeClass(this.btnToggleActiveClass)
                                  .addClass(this.btnToggleInactiveClass),
                              jQuery('button[data-prop="' + e + '"][data-value="' + t + '"]')
                                  .removeClass(this.btnToggleInactiveClass)
                                  .addClass(this.btnToggleActiveClass))
                            : "radio" === a
                            ? jQuery('input[name="' + e + '"]').each(function () {
                                  jQuery(this).prop("checked", !1), jQuery(this).val() === t && jQuery(this).prop("checked", !0);
                              })
                            : "text" === a || "number" === a || "select" === a
                            ? jQuery("#" + e).val(t)
                            : "dropdown" === a && jQuery('*[data-content="' + e + '"]').html(t),
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
