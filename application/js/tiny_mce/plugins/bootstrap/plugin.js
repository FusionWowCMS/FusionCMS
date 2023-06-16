(function () {
    'use strict';

    function __spreadArrays() {
      for (var s = 0, i = 0, il = arguments.length; i < il; i++)
        s += arguments[i].length;
      for (var r = Array(s), k = 0, i = 0; i < il; i++)
        for (var a = arguments[i], j = 0, jl = a.length; j < jl; j++, k++)
          r[k] = a[j];
      return r;
    }

    var bsItems = {
      btn: {
        text: 'Button',
        icon: 'btn',
        tooltip: 'Insert/Edit Bootstrap Button'
      },
      icon: {
        text: 'Icon',
        icon: 'icon',
        tooltip: 'Insert/Edit Bootstrap Icon'
      },
      image: {
        text: 'Image',
        icon: 'image',
        tooltip: 'Insert/Edit Bootstrap Image'
      },
      table: {
        text: 'Table',
        icon: 'table',
        tooltip: 'Insert/Edit Bootstrap Table'
      },
      template: {
        text: 'Template',
        icon: 'template',
        tooltip: 'Insert Bootstrap Template'
      },
      breadcrumb: {
        text: 'Breadcrumb',
        icon: 'breadcrumb',
        tooltip: 'Insert/Edit Bootstrap Breadcrumb'
      },
      pagination: {
        text: 'Pagination',
        icon: 'pagination',
        tooltip: 'Insert/Edit Bootstrap Pagination'
      },
      badge: {
        text: 'Badge',
        icon: 'badge',
        tooltip: 'Insert/Edit Bootstrap Badge'
      },
      alert: {
        text: 'Alert',
        icon: 'alert',
        tooltip: 'Insert/Edit Bootstrap Alert'
      },
      card: {
        text: 'Card',
        icon: 'card',
        tooltip: 'Insert/Edit Bootstrap Card'
      },
      snippet: {
        text: 'Snippet',
        icon: 'snippet',
        tooltip: 'Insert/Edit Snippet'
      }
    };

    var iconFonts = {
      elusiveicon: {
        css: 'elusiveicon/css/elusive-icons.min.css',
        defaultIcon: 'el-icon-home',
        homeIcon: 'el-icon-home',
        selector: 'el-icon-',
        baseClasses: []
      },
      flagicon: {
        css: 'flagicon/css/flag-icon.min.css',
        defaultIcon: 'flag-icon flag-icon-eu',
        homeIcon: '',
        selector: 'flag-icon-',
        baseClasses: ['flag-icon']
      },
      fontawesome5: {
        css: 'fontawesome5/css/all.min.css',
        defaultIcon: 'fas fa-home',
        homeIcon: 'fas fa-home',
        selector: 'fa-[a-z]+',
        baseClasses: [
          'far',
          'fas',
          'fab'
        ]
      },
      ionicon: {
        css: 'ionicon/css/ionicons.min.css',
        defaultIcon: 'ion-home',
        homeIcon: 'ion-home',
        selector: 'ion-',
        baseClasses: []
      },
      mapicon: {
        css: 'mapicon/css/map-icons.min.css',
        defaultIcon: 'map-icon-art-gallery',
        homeIcon: '',
        selector: 'map-icon-',
        baseClasses: []
      },
      materialdesign: {
        css: 'materialdesign/css/material-design-iconic-font.min.css',
        defaultIcon: 'zmdi zmdi-home',
        homeIcon: 'zmdi zmdi-home',
        selector: 'zmdi-',
        baseClasses: ['zmdi']
      },
      octicon: {
        css: 'octicon/octicons.min.css',
        defaultIcon: 'octicon octicon-home',
        homeIcon: 'octicon octicon-home',
        selector: 'octicon-',
        baseClasses: ['octicon']
      },
      typicon: {
        css: 'typicon/css/typicons.min.css',
        defaultIcon: 'typcn typcn-home',
        homeIcon: 'typcn typcn-home',
        selector: 'typcn-',
        baseClasses: ['typcn']
      },
      weathericon: {
        css: 'weathericon/css/weather-icons.min.css',
        defaultIcon: 'wi wi-horizon-alt',
        homeIcon: '',
        selector: 'wi-',
        baseClasses: ['wi']
      }
    };

    var defaultConfig = {
      bootstrapColumns: 12,
      bootstrapCss: 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',
      editorStyleFormats: {
        textStyles: true,
        blockStyles: true,
        containerStyles: true,
        responsive: [
          'xs',
          'sm'
        ],
        spacing: [
          'all',
          'x',
          'y',
          'top',
          'right',
          'bottom',
          'left'
        ]
      },
      elements: {
        btn: true,
        icon: true,
        image: true,
        table: true,
        template: true,
        breadcrumb: true,
        pagination: true,
        badge: true,
        alert: true,
        card: true,
        snippet: true
      },
      enableTemplateEdition: true,
      hasMenu: true,
      hasToolbar: true,
      iconFont: 'fontawesome5',
      imagesPath: '/assets/images/',
      key: 'key',
      label: 'Elements',
      language: 'en',
      toolbarStyle: 'buttons',
      visualAids: true
    };

    var StyleFormatConfig = function () {
      function StyleFormatConfig() {
        this.textSelector = 'a,abbr,acronym,button,cite,code,dfn,em,i,kbd,label,q,samp,small,span,strong,sub,sup,time,address,h1,h2,h3,h4,h5,h6,p';
        this.blockSelector = 'article,aside,blockquote,dd,div,dl,dt,fieldset,figcaption,figure,footer,header,img,li,main,nav,ol,pre,section,table,tbody,td,tfoot,th,thead,ul,video';
        this.containerSelector = '.container,.container-fluid';
        this.editorStyleFormats = [
          { title: 'STYLES' },
          {
            title: 'Text styles',
            items: [
              {
                title: 'Margin',
                items: [
                  {
                    title: 'All screens',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'text m-0',
                            selector: this.textSelector,
                            classes: 'm-0'
                          },
                          {
                            title: 'text m-1',
                            selector: this.textSelector,
                            classes: 'm-1'
                          },
                          {
                            title: 'text m-2',
                            selector: this.textSelector,
                            classes: 'm-2'
                          },
                          {
                            title: 'text m-3',
                            selector: this.textSelector,
                            classes: 'm-3'
                          },
                          {
                            title: 'text m-4',
                            selector: this.textSelector,
                            classes: 'm-4'
                          },
                          {
                            title: 'text m-5',
                            selector: this.textSelector,
                            classes: 'm-5'
                          },
                          {
                            title: 'text m-auto',
                            selector: this.textSelector,
                            classes: 'm-auto'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'text mx-0',
                            selector: this.textSelector,
                            classes: 'mx-0'
                          },
                          {
                            title: 'text mx-1',
                            selector: this.textSelector,
                            classes: 'mx-1'
                          },
                          {
                            title: 'text mx-2',
                            selector: this.textSelector,
                            classes: 'mx-2'
                          },
                          {
                            title: 'text mx-3',
                            selector: this.textSelector,
                            classes: 'mx-3'
                          },
                          {
                            title: 'text mx-4',
                            selector: this.textSelector,
                            classes: 'mx-4'
                          },
                          {
                            title: 'text mx-5',
                            selector: this.textSelector,
                            classes: 'mx-5'
                          },
                          {
                            title: 'text mx-auto',
                            selector: this.textSelector,
                            classes: 'mx-auto'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'text my-0',
                            selector: this.textSelector,
                            classes: 'my-0'
                          },
                          {
                            title: 'text my-1',
                            selector: this.textSelector,
                            classes: 'my-1'
                          },
                          {
                            title: 'text my-2',
                            selector: this.textSelector,
                            classes: 'my-2'
                          },
                          {
                            title: 'text my-3',
                            selector: this.textSelector,
                            classes: 'my-3'
                          },
                          {
                            title: 'text my-4',
                            selector: this.textSelector,
                            classes: 'my-4'
                          },
                          {
                            title: 'text my-5',
                            selector: this.textSelector,
                            classes: 'my-5'
                          },
                          {
                            title: 'text my-auto',
                            selector: this.textSelector,
                            classes: 'my-auto'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'text mt-0',
                            selector: this.textSelector,
                            classes: 'mt-0'
                          },
                          {
                            title: 'text mt-1',
                            selector: this.textSelector,
                            classes: 'mt-1'
                          },
                          {
                            title: 'text mt-2',
                            selector: this.textSelector,
                            classes: 'mt-2'
                          },
                          {
                            title: 'text mt-3',
                            selector: this.textSelector,
                            classes: 'mt-3'
                          },
                          {
                            title: 'text mt-4',
                            selector: this.textSelector,
                            classes: 'mt-4'
                          },
                          {
                            title: 'text mt-5',
                            selector: this.textSelector,
                            classes: 'mt-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'text mr-0',
                            selector: this.textSelector,
                            classes: 'mr-0'
                          },
                          {
                            title: 'text mr-1',
                            selector: this.textSelector,
                            classes: 'mr-1'
                          },
                          {
                            title: 'text mr-2',
                            selector: this.textSelector,
                            classes: 'mr-2'
                          },
                          {
                            title: 'text mr-3',
                            selector: this.textSelector,
                            classes: 'mr-3'
                          },
                          {
                            title: 'text mr-4',
                            selector: this.textSelector,
                            classes: 'mr-4'
                          },
                          {
                            title: 'text mr-5',
                            selector: this.textSelector,
                            classes: 'mr-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'text mb-0',
                            selector: this.textSelector,
                            classes: 'mb-0'
                          },
                          {
                            title: 'text mb-1',
                            selector: this.textSelector,
                            classes: 'mb-1'
                          },
                          {
                            title: 'text mb-2',
                            selector: this.textSelector,
                            classes: 'mb-2'
                          },
                          {
                            title: 'text mb-3',
                            selector: this.textSelector,
                            classes: 'mb-3'
                          },
                          {
                            title: 'text mb-4',
                            selector: this.textSelector,
                            classes: 'mb-4'
                          },
                          {
                            title: 'text mb-5',
                            selector: this.textSelector,
                            classes: 'mb-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'text ml-0',
                            selector: this.textSelector,
                            classes: 'ml-0'
                          },
                          {
                            title: 'text ml-1',
                            selector: this.textSelector,
                            classes: 'ml-1'
                          },
                          {
                            title: 'text ml-2',
                            selector: this.textSelector,
                            classes: 'ml-2'
                          },
                          {
                            title: 'text ml-3',
                            selector: this.textSelector,
                            classes: 'ml-3'
                          },
                          {
                            title: 'text ml-4',
                            selector: this.textSelector,
                            classes: 'ml-4'
                          },
                          {
                            title: 'text ml-5',
                            selector: this.textSelector,
                            classes: 'ml-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Small screens and larger',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'text m-sm-0',
                            selector: this.textSelector,
                            classes: 'm-sm-0'
                          },
                          {
                            title: 'text m-sm-1',
                            selector: this.textSelector,
                            classes: 'm-sm-1'
                          },
                          {
                            title: 'text m-sm-2',
                            selector: this.textSelector,
                            classes: 'm-sm-2'
                          },
                          {
                            title: 'text m-sm-3',
                            selector: this.textSelector,
                            classes: 'm-sm-3'
                          },
                          {
                            title: 'text m-sm-4',
                            selector: this.textSelector,
                            classes: 'm-sm-4'
                          },
                          {
                            title: 'text m-sm-5',
                            selector: this.textSelector,
                            classes: 'm-sm-5'
                          },
                          {
                            title: 'text m-sm-auto',
                            selector: this.textSelector,
                            classes: 'm-sm-auto'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'text mx-sm-0',
                            selector: this.textSelector,
                            classes: 'mx-sm-0'
                          },
                          {
                            title: 'text mx-sm-1',
                            selector: this.textSelector,
                            classes: 'mx-sm-1'
                          },
                          {
                            title: 'text mx-sm-2',
                            selector: this.textSelector,
                            classes: 'mx-sm-2'
                          },
                          {
                            title: 'text mx-sm-3',
                            selector: this.textSelector,
                            classes: 'mx-sm-3'
                          },
                          {
                            title: 'text mx-sm-4',
                            selector: this.textSelector,
                            classes: 'mx-sm-4'
                          },
                          {
                            title: 'text mx-sm-5',
                            selector: this.textSelector,
                            classes: 'mx-sm-5'
                          },
                          {
                            title: 'text mx-sm-auto',
                            selector: this.textSelector,
                            classes: 'mx-sm-auto'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'text my-sm-0',
                            selector: this.textSelector,
                            classes: 'my-sm-0'
                          },
                          {
                            title: 'text my-sm-1',
                            selector: this.textSelector,
                            classes: 'my-sm-1'
                          },
                          {
                            title: 'text my-sm-2',
                            selector: this.textSelector,
                            classes: 'my-sm-2'
                          },
                          {
                            title: 'text my-sm-3',
                            selector: this.textSelector,
                            classes: 'my-sm-3'
                          },
                          {
                            title: 'text my-sm-4',
                            selector: this.textSelector,
                            classes: 'my-sm-4'
                          },
                          {
                            title: 'text my-sm-5',
                            selector: this.textSelector,
                            classes: 'my-sm-5'
                          },
                          {
                            title: 'text my-sm-auto',
                            selector: this.textSelector,
                            classes: 'my-sm-auto'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'text mt-sm-0',
                            selector: this.textSelector,
                            classes: 'mt-sm-0'
                          },
                          {
                            title: 'text mt-sm-1',
                            selector: this.textSelector,
                            classes: 'mt-sm-1'
                          },
                          {
                            title: 'text mt-sm-2',
                            selector: this.textSelector,
                            classes: 'mt-sm-2'
                          },
                          {
                            title: 'text mt-sm-3',
                            selector: this.textSelector,
                            classes: 'mt-sm-3'
                          },
                          {
                            title: 'text mt-sm-4',
                            selector: this.textSelector,
                            classes: 'mt-sm-4'
                          },
                          {
                            title: 'text mt-sm-5',
                            selector: this.textSelector,
                            classes: 'mt-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'text mr-sm-0',
                            selector: this.textSelector,
                            classes: 'mr-sm-0'
                          },
                          {
                            title: 'text mr-sm-1',
                            selector: this.textSelector,
                            classes: 'mr-sm-1'
                          },
                          {
                            title: 'text mr-sm-2',
                            selector: this.textSelector,
                            classes: 'mr-sm-2'
                          },
                          {
                            title: 'text mr-sm-3',
                            selector: this.textSelector,
                            classes: 'mr-sm-3'
                          },
                          {
                            title: 'text mr-sm-4',
                            selector: this.textSelector,
                            classes: 'mr-sm-4'
                          },
                          {
                            title: 'text mr-sm-5',
                            selector: this.textSelector,
                            classes: 'mr-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'text mb-sm-0',
                            selector: this.textSelector,
                            classes: 'mb-sm-0'
                          },
                          {
                            title: 'text mb-sm-1',
                            selector: this.textSelector,
                            classes: 'mb-sm-1'
                          },
                          {
                            title: 'text mb-sm-2',
                            selector: this.textSelector,
                            classes: 'mb-sm-2'
                          },
                          {
                            title: 'text mb-sm-3',
                            selector: this.textSelector,
                            classes: 'mb-sm-3'
                          },
                          {
                            title: 'text mb-sm-4',
                            selector: this.textSelector,
                            classes: 'mb-sm-4'
                          },
                          {
                            title: 'text mb-sm-5',
                            selector: this.textSelector,
                            classes: 'mb-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'text ml-sm-0',
                            selector: this.textSelector,
                            classes: 'ml-sm-0'
                          },
                          {
                            title: 'text ml-sm-1',
                            selector: this.textSelector,
                            classes: 'ml-sm-1'
                          },
                          {
                            title: 'text ml-sm-2',
                            selector: this.textSelector,
                            classes: 'ml-sm-2'
                          },
                          {
                            title: 'text ml-sm-3',
                            selector: this.textSelector,
                            classes: 'ml-sm-3'
                          },
                          {
                            title: 'text ml-sm-4',
                            selector: this.textSelector,
                            classes: 'ml-sm-4'
                          },
                          {
                            title: 'text ml-sm-5',
                            selector: this.textSelector,
                            classes: 'ml-sm-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Medium screens and larger',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'text m-md-0',
                            selector: this.textSelector,
                            classes: 'm-md-0'
                          },
                          {
                            title: 'text m-md-1',
                            selector: this.textSelector,
                            classes: 'm-md-1'
                          },
                          {
                            title: 'text m-md-2',
                            selector: this.textSelector,
                            classes: 'm-md-2'
                          },
                          {
                            title: 'text m-md-3',
                            selector: this.textSelector,
                            classes: 'm-md-3'
                          },
                          {
                            title: 'text m-md-4',
                            selector: this.textSelector,
                            classes: 'm-md-4'
                          },
                          {
                            title: 'text m-md-5',
                            selector: this.textSelector,
                            classes: 'm-md-5'
                          },
                          {
                            title: 'text m-md-auto',
                            selector: this.textSelector,
                            classes: 'm-md-auto'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'text mx-md-0',
                            selector: this.textSelector,
                            classes: 'mx-md-0'
                          },
                          {
                            title: 'text mx-md-1',
                            selector: this.textSelector,
                            classes: 'mx-md-1'
                          },
                          {
                            title: 'text mx-md-2',
                            selector: this.textSelector,
                            classes: 'mx-md-2'
                          },
                          {
                            title: 'text mx-md-3',
                            selector: this.textSelector,
                            classes: 'mx-md-3'
                          },
                          {
                            title: 'text mx-md-4',
                            selector: this.textSelector,
                            classes: 'mx-md-4'
                          },
                          {
                            title: 'text mx-md-5',
                            selector: this.textSelector,
                            classes: 'mx-md-5'
                          },
                          {
                            title: 'text mx-md-auto',
                            selector: this.textSelector,
                            classes: 'mx-md-auto'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'text my-md-0',
                            selector: this.textSelector,
                            classes: 'my-md-0'
                          },
                          {
                            title: 'text my-md-1',
                            selector: this.textSelector,
                            classes: 'my-md-1'
                          },
                          {
                            title: 'text my-md-2',
                            selector: this.textSelector,
                            classes: 'my-md-2'
                          },
                          {
                            title: 'text my-md-3',
                            selector: this.textSelector,
                            classes: 'my-md-3'
                          },
                          {
                            title: 'text my-md-4',
                            selector: this.textSelector,
                            classes: 'my-md-4'
                          },
                          {
                            title: 'text my-md-5',
                            selector: this.textSelector,
                            classes: 'my-md-5'
                          },
                          {
                            title: 'text my-md-auto',
                            selector: this.textSelector,
                            classes: 'my-md-auto'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'text mt-md-0',
                            selector: this.textSelector,
                            classes: 'mt-md-0'
                          },
                          {
                            title: 'text mt-md-1',
                            selector: this.textSelector,
                            classes: 'mt-md-1'
                          },
                          {
                            title: 'text mt-md-2',
                            selector: this.textSelector,
                            classes: 'mt-md-2'
                          },
                          {
                            title: 'text mt-md-3',
                            selector: this.textSelector,
                            classes: 'mt-md-3'
                          },
                          {
                            title: 'text mt-md-4',
                            selector: this.textSelector,
                            classes: 'mt-md-4'
                          },
                          {
                            title: 'text mt-md-5',
                            selector: this.textSelector,
                            classes: 'mt-md-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'text mr-md-0',
                            selector: this.textSelector,
                            classes: 'mr-md-0'
                          },
                          {
                            title: 'text mr-md-1',
                            selector: this.textSelector,
                            classes: 'mr-md-1'
                          },
                          {
                            title: 'text mr-md-2',
                            selector: this.textSelector,
                            classes: 'mr-md-2'
                          },
                          {
                            title: 'text mr-md-3',
                            selector: this.textSelector,
                            classes: 'mr-md-3'
                          },
                          {
                            title: 'text mr-md-4',
                            selector: this.textSelector,
                            classes: 'mr-md-4'
                          },
                          {
                            title: 'text mr-md-5',
                            selector: this.textSelector,
                            classes: 'mr-md-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'text mb-md-0',
                            selector: this.textSelector,
                            classes: 'mb-md-0'
                          },
                          {
                            title: 'text mb-md-1',
                            selector: this.textSelector,
                            classes: 'mb-md-1'
                          },
                          {
                            title: 'text mb-md-2',
                            selector: this.textSelector,
                            classes: 'mb-md-2'
                          },
                          {
                            title: 'text mb-md-3',
                            selector: this.textSelector,
                            classes: 'mb-md-3'
                          },
                          {
                            title: 'text mb-md-4',
                            selector: this.textSelector,
                            classes: 'mb-md-4'
                          },
                          {
                            title: 'text mb-md-5',
                            selector: this.textSelector,
                            classes: 'mb-md-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'text ml-md-0',
                            selector: this.textSelector,
                            classes: 'ml-md-0'
                          },
                          {
                            title: 'text ml-md-1',
                            selector: this.textSelector,
                            classes: 'ml-md-1'
                          },
                          {
                            title: 'text ml-md-2',
                            selector: this.textSelector,
                            classes: 'ml-md-2'
                          },
                          {
                            title: 'text ml-md-3',
                            selector: this.textSelector,
                            classes: 'ml-md-3'
                          },
                          {
                            title: 'text ml-md-4',
                            selector: this.textSelector,
                            classes: 'ml-md-4'
                          },
                          {
                            title: 'text ml-md-5',
                            selector: this.textSelector,
                            classes: 'ml-md-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Large screens',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'text m-lg-0',
                            selector: this.textSelector,
                            classes: 'm-lg-0'
                          },
                          {
                            title: 'text m-lg-1',
                            selector: this.textSelector,
                            classes: 'm-lg-1'
                          },
                          {
                            title: 'text m-lg-2',
                            selector: this.textSelector,
                            classes: 'm-lg-2'
                          },
                          {
                            title: 'text m-lg-3',
                            selector: this.textSelector,
                            classes: 'm-lg-3'
                          },
                          {
                            title: 'text m-lg-4',
                            selector: this.textSelector,
                            classes: 'm-lg-4'
                          },
                          {
                            title: 'text m-lg-5',
                            selector: this.textSelector,
                            classes: 'm-lg-5'
                          },
                          {
                            title: 'text m-lg-auto',
                            selector: this.textSelector,
                            classes: 'm-lg-auto'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'text mx-lg-0',
                            selector: this.textSelector,
                            classes: 'mx-lg-0'
                          },
                          {
                            title: 'text mx-lg-1',
                            selector: this.textSelector,
                            classes: 'mx-lg-1'
                          },
                          {
                            title: 'text mx-lg-2',
                            selector: this.textSelector,
                            classes: 'mx-lg-2'
                          },
                          {
                            title: 'text mx-lg-3',
                            selector: this.textSelector,
                            classes: 'mx-lg-3'
                          },
                          {
                            title: 'text mx-lg-4',
                            selector: this.textSelector,
                            classes: 'mx-lg-4'
                          },
                          {
                            title: 'text mx-lg-5',
                            selector: this.textSelector,
                            classes: 'mx-lg-5'
                          },
                          {
                            title: 'text mx-lg-auto',
                            selector: this.textSelector,
                            classes: 'mx-lg-auto'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'text my-lg-0',
                            selector: this.textSelector,
                            classes: 'my-lg-0'
                          },
                          {
                            title: 'text my-lg-1',
                            selector: this.textSelector,
                            classes: 'my-lg-1'
                          },
                          {
                            title: 'text my-lg-2',
                            selector: this.textSelector,
                            classes: 'my-lg-2'
                          },
                          {
                            title: 'text my-lg-3',
                            selector: this.textSelector,
                            classes: 'my-lg-3'
                          },
                          {
                            title: 'text my-lg-4',
                            selector: this.textSelector,
                            classes: 'my-lg-4'
                          },
                          {
                            title: 'text my-lg-5',
                            selector: this.textSelector,
                            classes: 'my-lg-5'
                          },
                          {
                            title: 'text my-lg-auto',
                            selector: this.textSelector,
                            classes: 'my-lg-auto'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'text mt-lg-0',
                            selector: this.textSelector,
                            classes: 'mt-lg-0'
                          },
                          {
                            title: 'text mt-lg-1',
                            selector: this.textSelector,
                            classes: 'mt-lg-1'
                          },
                          {
                            title: 'text mt-lg-2',
                            selector: this.textSelector,
                            classes: 'mt-lg-2'
                          },
                          {
                            title: 'text mt-lg-3',
                            selector: this.textSelector,
                            classes: 'mt-lg-3'
                          },
                          {
                            title: 'text mt-lg-4',
                            selector: this.textSelector,
                            classes: 'mt-lg-4'
                          },
                          {
                            title: 'text mt-lg-5',
                            selector: this.textSelector,
                            classes: 'mt-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'text mr-lg-0',
                            selector: this.textSelector,
                            classes: 'mr-lg-0'
                          },
                          {
                            title: 'text mr-lg-1',
                            selector: this.textSelector,
                            classes: 'mr-lg-1'
                          },
                          {
                            title: 'text mr-lg-2',
                            selector: this.textSelector,
                            classes: 'mr-lg-2'
                          },
                          {
                            title: 'text mr-lg-3',
                            selector: this.textSelector,
                            classes: 'mr-lg-3'
                          },
                          {
                            title: 'text mr-lg-4',
                            selector: this.textSelector,
                            classes: 'mr-lg-4'
                          },
                          {
                            title: 'text mr-lg-5',
                            selector: this.textSelector,
                            classes: 'mr-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'text mb-lg-0',
                            selector: this.textSelector,
                            classes: 'mb-lg-0'
                          },
                          {
                            title: 'text mb-lg-1',
                            selector: this.textSelector,
                            classes: 'mb-lg-1'
                          },
                          {
                            title: 'text mb-lg-2',
                            selector: this.textSelector,
                            classes: 'mb-lg-2'
                          },
                          {
                            title: 'text mb-lg-3',
                            selector: this.textSelector,
                            classes: 'mb-lg-3'
                          },
                          {
                            title: 'text mb-lg-4',
                            selector: this.textSelector,
                            classes: 'mb-lg-4'
                          },
                          {
                            title: 'text mb-lg-5',
                            selector: this.textSelector,
                            classes: 'mb-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'text ml-lg-0',
                            selector: this.textSelector,
                            classes: 'ml-lg-0'
                          },
                          {
                            title: 'text ml-lg-1',
                            selector: this.textSelector,
                            classes: 'ml-lg-1'
                          },
                          {
                            title: 'text ml-lg-2',
                            selector: this.textSelector,
                            classes: 'ml-lg-2'
                          },
                          {
                            title: 'text ml-lg-3',
                            selector: this.textSelector,
                            classes: 'ml-lg-3'
                          },
                          {
                            title: 'text ml-lg-4',
                            selector: this.textSelector,
                            classes: 'ml-lg-4'
                          },
                          {
                            title: 'text ml-lg-5',
                            selector: this.textSelector,
                            classes: 'ml-lg-5'
                          }
                        ]
                      }
                    ]
                  }
                ]
              },
              {
                title: 'Padding',
                items: [
                  {
                    title: 'All screens',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'text p-0',
                            selector: this.textSelector,
                            classes: 'p-0'
                          },
                          {
                            title: 'text p-1',
                            selector: this.textSelector,
                            classes: 'p-1'
                          },
                          {
                            title: 'text p-2',
                            selector: this.textSelector,
                            classes: 'p-2'
                          },
                          {
                            title: 'text p-3',
                            selector: this.textSelector,
                            classes: 'p-3'
                          },
                          {
                            title: 'text p-4',
                            selector: this.textSelector,
                            classes: 'p-4'
                          },
                          {
                            title: 'text p-5',
                            selector: this.textSelector,
                            classes: 'p-5'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'text px-0',
                            selector: this.textSelector,
                            classes: 'px-0'
                          },
                          {
                            title: 'text px-1',
                            selector: this.textSelector,
                            classes: 'px-1'
                          },
                          {
                            title: 'text px-2',
                            selector: this.textSelector,
                            classes: 'px-2'
                          },
                          {
                            title: 'text px-3',
                            selector: this.textSelector,
                            classes: 'px-3'
                          },
                          {
                            title: 'text px-4',
                            selector: this.textSelector,
                            classes: 'px-4'
                          },
                          {
                            title: 'text px-5',
                            selector: this.textSelector,
                            classes: 'px-5'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'text py-0',
                            selector: this.textSelector,
                            classes: 'py-0'
                          },
                          {
                            title: 'text py-1',
                            selector: this.textSelector,
                            classes: 'py-1'
                          },
                          {
                            title: 'text py-2',
                            selector: this.textSelector,
                            classes: 'py-2'
                          },
                          {
                            title: 'text py-3',
                            selector: this.textSelector,
                            classes: 'py-3'
                          },
                          {
                            title: 'text py-4',
                            selector: this.textSelector,
                            classes: 'py-4'
                          },
                          {
                            title: 'text py-5',
                            selector: this.textSelector,
                            classes: 'py-5'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'text pt-0',
                            selector: this.textSelector,
                            classes: 'pt-0'
                          },
                          {
                            title: 'text pt-1',
                            selector: this.textSelector,
                            classes: 'pt-1'
                          },
                          {
                            title: 'text pt-2',
                            selector: this.textSelector,
                            classes: 'pt-2'
                          },
                          {
                            title: 'text pt-3',
                            selector: this.textSelector,
                            classes: 'pt-3'
                          },
                          {
                            title: 'text pt-4',
                            selector: this.textSelector,
                            classes: 'pt-4'
                          },
                          {
                            title: 'text pt-5',
                            selector: this.textSelector,
                            classes: 'pt-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'text pr-0',
                            selector: this.textSelector,
                            classes: 'pr-0'
                          },
                          {
                            title: 'text pr-1',
                            selector: this.textSelector,
                            classes: 'pr-1'
                          },
                          {
                            title: 'text pr-2',
                            selector: this.textSelector,
                            classes: 'pr-2'
                          },
                          {
                            title: 'text pr-3',
                            selector: this.textSelector,
                            classes: 'pr-3'
                          },
                          {
                            title: 'text pr-4',
                            selector: this.textSelector,
                            classes: 'pr-4'
                          },
                          {
                            title: 'text pr-5',
                            selector: this.textSelector,
                            classes: 'pr-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'text pb-0',
                            selector: this.textSelector,
                            classes: 'pb-0'
                          },
                          {
                            title: 'text pb-1',
                            selector: this.textSelector,
                            classes: 'pb-1'
                          },
                          {
                            title: 'text pb-2',
                            selector: this.textSelector,
                            classes: 'pb-2'
                          },
                          {
                            title: 'text pb-3',
                            selector: this.textSelector,
                            classes: 'pb-3'
                          },
                          {
                            title: 'text pb-4',
                            selector: this.textSelector,
                            classes: 'pb-4'
                          },
                          {
                            title: 'text pb-5',
                            selector: this.textSelector,
                            classes: 'pb-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'text pl-0',
                            selector: this.textSelector,
                            classes: 'pl-0'
                          },
                          {
                            title: 'text pl-1',
                            selector: this.textSelector,
                            classes: 'pl-1'
                          },
                          {
                            title: 'text pl-2',
                            selector: this.textSelector,
                            classes: 'pl-2'
                          },
                          {
                            title: 'text pl-3',
                            selector: this.textSelector,
                            classes: 'pl-3'
                          },
                          {
                            title: 'text pl-4',
                            selector: this.textSelector,
                            classes: 'pl-4'
                          },
                          {
                            title: 'text pl-5',
                            selector: this.textSelector,
                            classes: 'pl-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Small screens and larger',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'text p-sm-0',
                            selector: this.textSelector,
                            classes: 'p-sm-0'
                          },
                          {
                            title: 'text p-sm-1',
                            selector: this.textSelector,
                            classes: 'p-sm-1'
                          },
                          {
                            title: 'text p-sm-2',
                            selector: this.textSelector,
                            classes: 'p-sm-2'
                          },
                          {
                            title: 'text p-sm-3',
                            selector: this.textSelector,
                            classes: 'p-sm-3'
                          },
                          {
                            title: 'text p-sm-4',
                            selector: this.textSelector,
                            classes: 'p-sm-4'
                          },
                          {
                            title: 'text p-sm-5',
                            selector: this.textSelector,
                            classes: 'p-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'text px-sm-0',
                            selector: this.textSelector,
                            classes: 'px-sm-0'
                          },
                          {
                            title: 'text px-sm-1',
                            selector: this.textSelector,
                            classes: 'px-sm-1'
                          },
                          {
                            title: 'text px-sm-2',
                            selector: this.textSelector,
                            classes: 'px-sm-2'
                          },
                          {
                            title: 'text px-sm-3',
                            selector: this.textSelector,
                            classes: 'px-sm-3'
                          },
                          {
                            title: 'text px-sm-4',
                            selector: this.textSelector,
                            classes: 'px-sm-4'
                          },
                          {
                            title: 'text px-sm-5',
                            selector: this.textSelector,
                            classes: 'px-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'text py-sm-0',
                            selector: this.textSelector,
                            classes: 'py-sm-0'
                          },
                          {
                            title: 'text py-sm-1',
                            selector: this.textSelector,
                            classes: 'py-sm-1'
                          },
                          {
                            title: 'text py-sm-2',
                            selector: this.textSelector,
                            classes: 'py-sm-2'
                          },
                          {
                            title: 'text py-sm-3',
                            selector: this.textSelector,
                            classes: 'py-sm-3'
                          },
                          {
                            title: 'text py-sm-4',
                            selector: this.textSelector,
                            classes: 'py-sm-4'
                          },
                          {
                            title: 'text py-sm-5',
                            selector: this.textSelector,
                            classes: 'py-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'text pt-sm-0',
                            selector: this.textSelector,
                            classes: 'pt-sm-0'
                          },
                          {
                            title: 'text pt-sm-1',
                            selector: this.textSelector,
                            classes: 'pt-sm-1'
                          },
                          {
                            title: 'text pt-sm-2',
                            selector: this.textSelector,
                            classes: 'pt-sm-2'
                          },
                          {
                            title: 'text pt-sm-3',
                            selector: this.textSelector,
                            classes: 'pt-sm-3'
                          },
                          {
                            title: 'text pt-sm-4',
                            selector: this.textSelector,
                            classes: 'pt-sm-4'
                          },
                          {
                            title: 'text pt-sm-5',
                            selector: this.textSelector,
                            classes: 'pt-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'text pr-sm-0',
                            selector: this.textSelector,
                            classes: 'pr-sm-0'
                          },
                          {
                            title: 'text pr-sm-1',
                            selector: this.textSelector,
                            classes: 'pr-sm-1'
                          },
                          {
                            title: 'text pr-sm-2',
                            selector: this.textSelector,
                            classes: 'pr-sm-2'
                          },
                          {
                            title: 'text pr-sm-3',
                            selector: this.textSelector,
                            classes: 'pr-sm-3'
                          },
                          {
                            title: 'text pr-sm-4',
                            selector: this.textSelector,
                            classes: 'pr-sm-4'
                          },
                          {
                            title: 'text pr-sm-5',
                            selector: this.textSelector,
                            classes: 'pr-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'text pb-sm-0',
                            selector: this.textSelector,
                            classes: 'pb-sm-0'
                          },
                          {
                            title: 'text pb-sm-1',
                            selector: this.textSelector,
                            classes: 'pb-sm-1'
                          },
                          {
                            title: 'text pb-sm-2',
                            selector: this.textSelector,
                            classes: 'pb-sm-2'
                          },
                          {
                            title: 'text pb-sm-3',
                            selector: this.textSelector,
                            classes: 'pb-sm-3'
                          },
                          {
                            title: 'text pb-sm-4',
                            selector: this.textSelector,
                            classes: 'pb-sm-4'
                          },
                          {
                            title: 'text pb-sm-5',
                            selector: this.textSelector,
                            classes: 'pb-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'text pl-sm-0',
                            selector: this.textSelector,
                            classes: 'pl-sm-0'
                          },
                          {
                            title: 'text pl-sm-1',
                            selector: this.textSelector,
                            classes: 'pl-sm-1'
                          },
                          {
                            title: 'text pl-sm-2',
                            selector: this.textSelector,
                            classes: 'pl-sm-2'
                          },
                          {
                            title: 'text pl-sm-3',
                            selector: this.textSelector,
                            classes: 'pl-sm-3'
                          },
                          {
                            title: 'text pl-sm-4',
                            selector: this.textSelector,
                            classes: 'pl-sm-4'
                          },
                          {
                            title: 'text pl-sm-5',
                            selector: this.textSelector,
                            classes: 'pl-sm-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Medium screens and larger',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'text p-md-0',
                            selector: this.textSelector,
                            classes: 'p-md-0'
                          },
                          {
                            title: 'text p-md-1',
                            selector: this.textSelector,
                            classes: 'p-md-1'
                          },
                          {
                            title: 'text p-md-2',
                            selector: this.textSelector,
                            classes: 'p-md-2'
                          },
                          {
                            title: 'text p-md-3',
                            selector: this.textSelector,
                            classes: 'p-md-3'
                          },
                          {
                            title: 'text p-md-4',
                            selector: this.textSelector,
                            classes: 'p-md-4'
                          },
                          {
                            title: 'text p-md-5',
                            selector: this.textSelector,
                            classes: 'p-md-5'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'text px-md-0',
                            selector: this.textSelector,
                            classes: 'px-md-0'
                          },
                          {
                            title: 'text px-md-1',
                            selector: this.textSelector,
                            classes: 'px-md-1'
                          },
                          {
                            title: 'text px-md-2',
                            selector: this.textSelector,
                            classes: 'px-md-2'
                          },
                          {
                            title: 'text px-md-3',
                            selector: this.textSelector,
                            classes: 'px-md-3'
                          },
                          {
                            title: 'text px-md-4',
                            selector: this.textSelector,
                            classes: 'px-md-4'
                          },
                          {
                            title: 'text px-md-5',
                            selector: this.textSelector,
                            classes: 'px-md-5'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'text py-md-0',
                            selector: this.textSelector,
                            classes: 'py-md-0'
                          },
                          {
                            title: 'text py-md-1',
                            selector: this.textSelector,
                            classes: 'py-md-1'
                          },
                          {
                            title: 'text py-md-2',
                            selector: this.textSelector,
                            classes: 'py-md-2'
                          },
                          {
                            title: 'text py-md-3',
                            selector: this.textSelector,
                            classes: 'py-md-3'
                          },
                          {
                            title: 'text py-md-4',
                            selector: this.textSelector,
                            classes: 'py-md-4'
                          },
                          {
                            title: 'text py-md-5',
                            selector: this.textSelector,
                            classes: 'py-md-5'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'text pt-md-0',
                            selector: this.textSelector,
                            classes: 'pt-md-0'
                          },
                          {
                            title: 'text pt-md-1',
                            selector: this.textSelector,
                            classes: 'pt-md-1'
                          },
                          {
                            title: 'text pt-md-2',
                            selector: this.textSelector,
                            classes: 'pt-md-2'
                          },
                          {
                            title: 'text pt-md-3',
                            selector: this.textSelector,
                            classes: 'pt-md-3'
                          },
                          {
                            title: 'text pt-md-4',
                            selector: this.textSelector,
                            classes: 'pt-md-4'
                          },
                          {
                            title: 'text pt-md-5',
                            selector: this.textSelector,
                            classes: 'pt-md-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'text pr-md-0',
                            selector: this.textSelector,
                            classes: 'pr-md-0'
                          },
                          {
                            title: 'text pr-md-1',
                            selector: this.textSelector,
                            classes: 'pr-md-1'
                          },
                          {
                            title: 'text pr-md-2',
                            selector: this.textSelector,
                            classes: 'pr-md-2'
                          },
                          {
                            title: 'text pr-md-3',
                            selector: this.textSelector,
                            classes: 'pr-md-3'
                          },
                          {
                            title: 'text pr-md-4',
                            selector: this.textSelector,
                            classes: 'pr-md-4'
                          },
                          {
                            title: 'text pr-md-5',
                            selector: this.textSelector,
                            classes: 'pr-md-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'text pb-md-0',
                            selector: this.textSelector,
                            classes: 'pb-md-0'
                          },
                          {
                            title: 'text pb-md-1',
                            selector: this.textSelector,
                            classes: 'pb-md-1'
                          },
                          {
                            title: 'text pb-md-2',
                            selector: this.textSelector,
                            classes: 'pb-md-2'
                          },
                          {
                            title: 'text pb-md-3',
                            selector: this.textSelector,
                            classes: 'pb-md-3'
                          },
                          {
                            title: 'text pb-md-4',
                            selector: this.textSelector,
                            classes: 'pb-md-4'
                          },
                          {
                            title: 'text pb-md-5',
                            selector: this.textSelector,
                            classes: 'pb-md-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'text pl-md-0',
                            selector: this.textSelector,
                            classes: 'pl-md-0'
                          },
                          {
                            title: 'text pl-md-1',
                            selector: this.textSelector,
                            classes: 'pl-md-1'
                          },
                          {
                            title: 'text pl-md-2',
                            selector: this.textSelector,
                            classes: 'pl-md-2'
                          },
                          {
                            title: 'text pl-md-3',
                            selector: this.textSelector,
                            classes: 'pl-md-3'
                          },
                          {
                            title: 'text pl-md-4',
                            selector: this.textSelector,
                            classes: 'pl-md-4'
                          },
                          {
                            title: 'text pl-md-5',
                            selector: this.textSelector,
                            classes: 'pl-md-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Large screens',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'text p-lg-0',
                            selector: this.textSelector,
                            classes: 'p-lg-0'
                          },
                          {
                            title: 'text p-lg-1',
                            selector: this.textSelector,
                            classes: 'p-lg-1'
                          },
                          {
                            title: 'text p-lg-2',
                            selector: this.textSelector,
                            classes: 'p-lg-2'
                          },
                          {
                            title: 'text p-lg-3',
                            selector: this.textSelector,
                            classes: 'p-lg-3'
                          },
                          {
                            title: 'text p-lg-4',
                            selector: this.textSelector,
                            classes: 'p-lg-4'
                          },
                          {
                            title: 'text p-lg-5',
                            selector: this.textSelector,
                            classes: 'p-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'text px-lg-0',
                            selector: this.textSelector,
                            classes: 'px-lg-0'
                          },
                          {
                            title: 'text px-lg-1',
                            selector: this.textSelector,
                            classes: 'px-lg-1'
                          },
                          {
                            title: 'text px-lg-2',
                            selector: this.textSelector,
                            classes: 'px-lg-2'
                          },
                          {
                            title: 'text px-lg-3',
                            selector: this.textSelector,
                            classes: 'px-lg-3'
                          },
                          {
                            title: 'text px-lg-4',
                            selector: this.textSelector,
                            classes: 'px-lg-4'
                          },
                          {
                            title: 'text px-lg-5',
                            selector: this.textSelector,
                            classes: 'px-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'text py-lg-0',
                            selector: this.textSelector,
                            classes: 'py-lg-0'
                          },
                          {
                            title: 'text py-lg-1',
                            selector: this.textSelector,
                            classes: 'py-lg-1'
                          },
                          {
                            title: 'text py-lg-2',
                            selector: this.textSelector,
                            classes: 'py-lg-2'
                          },
                          {
                            title: 'text py-lg-3',
                            selector: this.textSelector,
                            classes: 'py-lg-3'
                          },
                          {
                            title: 'text py-lg-4',
                            selector: this.textSelector,
                            classes: 'py-lg-4'
                          },
                          {
                            title: 'text py-lg-5',
                            selector: this.textSelector,
                            classes: 'py-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'text pt-lg-0',
                            selector: this.textSelector,
                            classes: 'pt-lg-0'
                          },
                          {
                            title: 'text pt-lg-1',
                            selector: this.textSelector,
                            classes: 'pt-lg-1'
                          },
                          {
                            title: 'text pt-lg-2',
                            selector: this.textSelector,
                            classes: 'pt-lg-2'
                          },
                          {
                            title: 'text pt-lg-3',
                            selector: this.textSelector,
                            classes: 'pt-lg-3'
                          },
                          {
                            title: 'text pt-lg-4',
                            selector: this.textSelector,
                            classes: 'pt-lg-4'
                          },
                          {
                            title: 'text pt-lg-5',
                            selector: this.textSelector,
                            classes: 'pt-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'text pr-lg-0',
                            selector: this.textSelector,
                            classes: 'pr-lg-0'
                          },
                          {
                            title: 'text pr-lg-1',
                            selector: this.textSelector,
                            classes: 'pr-lg-1'
                          },
                          {
                            title: 'text pr-lg-2',
                            selector: this.textSelector,
                            classes: 'pr-lg-2'
                          },
                          {
                            title: 'text pr-lg-3',
                            selector: this.textSelector,
                            classes: 'pr-lg-3'
                          },
                          {
                            title: 'text pr-lg-4',
                            selector: this.textSelector,
                            classes: 'pr-lg-4'
                          },
                          {
                            title: 'text pr-lg-5',
                            selector: this.textSelector,
                            classes: 'pr-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'text pb-lg-0',
                            selector: this.textSelector,
                            classes: 'pb-lg-0'
                          },
                          {
                            title: 'text pb-lg-1',
                            selector: this.textSelector,
                            classes: 'pb-lg-1'
                          },
                          {
                            title: 'text pb-lg-2',
                            selector: this.textSelector,
                            classes: 'pb-lg-2'
                          },
                          {
                            title: 'text pb-lg-3',
                            selector: this.textSelector,
                            classes: 'pb-lg-3'
                          },
                          {
                            title: 'text pb-lg-4',
                            selector: this.textSelector,
                            classes: 'pb-lg-4'
                          },
                          {
                            title: 'text pb-lg-5',
                            selector: this.textSelector,
                            classes: 'pb-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'text pl-lg-0',
                            selector: this.textSelector,
                            classes: 'pl-lg-0'
                          },
                          {
                            title: 'text pl-lg-1',
                            selector: this.textSelector,
                            classes: 'pl-lg-1'
                          },
                          {
                            title: 'text pl-lg-2',
                            selector: this.textSelector,
                            classes: 'pl-lg-2'
                          },
                          {
                            title: 'text pl-lg-3',
                            selector: this.textSelector,
                            classes: 'pl-lg-3'
                          },
                          {
                            title: 'text pl-lg-4',
                            selector: this.textSelector,
                            classes: 'pl-lg-4'
                          },
                          {
                            title: 'text pl-lg-5',
                            selector: this.textSelector,
                            classes: 'pl-lg-5'
                          }
                        ]
                      }
                    ]
                  }
                ]
              },
              {
                title: 'Color',
                items: [
                  {
                    title: 'text text-primary',
                    selector: this.textSelector,
                    classes: 'text-primary'
                  },
                  {
                    title: 'text text-secondary',
                    selector: this.textSelector,
                    classes: 'text-secondary'
                  },
                  {
                    title: 'text text-success',
                    selector: this.textSelector,
                    classes: 'text-success'
                  },
                  {
                    title: 'text text-danger',
                    selector: this.textSelector,
                    classes: 'text-danger'
                  },
                  {
                    title: 'text text-warning',
                    selector: this.textSelector,
                    classes: 'text-warning'
                  },
                  {
                    title: 'text text-info',
                    selector: this.textSelector,
                    classes: 'text-info'
                  },
                  {
                    title: 'text text-light',
                    selector: this.textSelector,
                    classes: 'text-light'
                  },
                  {
                    title: 'text text-dark',
                    selector: this.textSelector,
                    classes: 'text-dark'
                  },
                  {
                    title: 'text text-body',
                    selector: this.textSelector,
                    classes: 'text-body'
                  },
                  {
                    title: 'text text-muted',
                    selector: this.textSelector,
                    classes: 'text-muted'
                  },
                  {
                    title: 'text text-white',
                    selector: this.textSelector,
                    classes: 'text-white'
                  },
                  {
                    title: 'text text-black-50',
                    selector: this.textSelector,
                    classes: 'text-black-50'
                  },
                  {
                    title: 'text text-white-50',
                    selector: this.textSelector,
                    classes: 'text-white-50'
                  }
                ]
              },
              {
                title: 'Background',
                items: [
                  {
                    title: 'text bg-primary',
                    selector: this.textSelector,
                    classes: 'bg-primary'
                  },
                  {
                    title: 'text bg-secondary',
                    selector: this.textSelector,
                    classes: 'bg-secondary'
                  },
                  {
                    title: 'text bg-success',
                    selector: this.textSelector,
                    classes: 'bg-success'
                  },
                  {
                    title: 'text bg-danger',
                    selector: this.textSelector,
                    classes: 'bg-danger'
                  },
                  {
                    title: 'text bg-warning',
                    selector: this.textSelector,
                    classes: 'bg-warning'
                  },
                  {
                    title: 'text bg-info',
                    selector: this.textSelector,
                    classes: 'bg-info'
                  },
                  {
                    title: 'text bg-light',
                    selector: this.textSelector,
                    classes: 'bg-light'
                  },
                  {
                    title: 'text bg-dark',
                    selector: this.textSelector,
                    classes: 'bg-dark'
                  },
                  {
                    title: 'text bg-white',
                    selector: this.textSelector,
                    classes: 'bg-white'
                  },
                  {
                    title: 'text bg-transparent',
                    selector: this.textSelector,
                    classes: 'bg-transparent'
                  }
                ]
              },
              {
                title: 'Border',
                items: [
                  {
                    title: 'all',
                    items: [
                      {
                        title: 'text border border-primary',
                        selector: this.textSelector,
                        classes: 'border border-primary'
                      },
                      {
                        title: 'text border border-secondary',
                        selector: this.textSelector,
                        classes: 'border border-secondary'
                      },
                      {
                        title: 'text border border-success',
                        selector: this.textSelector,
                        classes: 'border border-success'
                      },
                      {
                        title: 'text border border-danger',
                        selector: this.textSelector,
                        classes: 'border border-danger'
                      },
                      {
                        title: 'text border border-warning',
                        selector: this.textSelector,
                        classes: 'border border-warning'
                      },
                      {
                        title: 'text border border-info',
                        selector: this.textSelector,
                        classes: 'border border-info'
                      },
                      {
                        title: 'text border border-light',
                        selector: this.textSelector,
                        classes: 'border border-light'
                      },
                      {
                        title: 'text border border-dark',
                        selector: this.textSelector,
                        classes: 'border border-dark'
                      },
                      {
                        title: 'text border border-white',
                        selector: this.textSelector,
                        classes: 'border border-white'
                      }
                    ]
                  },
                  {
                    title: 'top',
                    items: [
                      {
                        title: 'text border-top border-primary',
                        selector: this.textSelector,
                        classes: 'border-top border-primary'
                      },
                      {
                        title: 'text border-top border-secondary',
                        selector: this.textSelector,
                        classes: 'border-top border-secondary'
                      },
                      {
                        title: 'text border-top border-success',
                        selector: this.textSelector,
                        classes: 'border-top border-success'
                      },
                      {
                        title: 'text border-top border-danger',
                        selector: this.textSelector,
                        classes: 'border-top border-danger'
                      },
                      {
                        title: 'text border-top border-warning',
                        selector: this.textSelector,
                        classes: 'border-top border-warning'
                      },
                      {
                        title: 'text border-top border-info',
                        selector: this.textSelector,
                        classes: 'border-top border-info'
                      },
                      {
                        title: 'text border-top border-light',
                        selector: this.textSelector,
                        classes: 'border-top border-light'
                      },
                      {
                        title: 'text border-top border-dark',
                        selector: this.textSelector,
                        classes: 'border-top border-dark'
                      },
                      {
                        title: 'text border-top border-white',
                        selector: this.textSelector,
                        classes: 'border-top border-white'
                      }
                    ]
                  },
                  {
                    title: 'right',
                    items: [
                      {
                        title: 'text border-right border-primary',
                        selector: this.textSelector,
                        classes: 'border-right border-primary'
                      },
                      {
                        title: 'text border-right border-secondary',
                        selector: this.textSelector,
                        classes: 'border-right border-secondary'
                      },
                      {
                        title: 'text border-right border-success',
                        selector: this.textSelector,
                        classes: 'border-right border-success'
                      },
                      {
                        title: 'text border-right border-danger',
                        selector: this.textSelector,
                        classes: 'border-right border-danger'
                      },
                      {
                        title: 'text border-right border-warning',
                        selector: this.textSelector,
                        classes: 'border-right border-warning'
                      },
                      {
                        title: 'text border-right border-info',
                        selector: this.textSelector,
                        classes: 'border-right border-info'
                      },
                      {
                        title: 'text border-right border-light',
                        selector: this.textSelector,
                        classes: 'border-right border-light'
                      },
                      {
                        title: 'text border-right border-dark',
                        selector: this.textSelector,
                        classes: 'border-right border-dark'
                      },
                      {
                        title: 'text border-right border-white',
                        selector: this.textSelector,
                        classes: 'border-right border-white'
                      }
                    ]
                  },
                  {
                    title: 'bottom',
                    items: [
                      {
                        title: 'text border-bottom border-primary',
                        selector: this.textSelector,
                        classes: 'border-bottom border-primary'
                      },
                      {
                        title: 'text border-bottom border-secondary',
                        selector: this.textSelector,
                        classes: 'border-bottom border-secondary'
                      },
                      {
                        title: 'text border-bottom border-success',
                        selector: this.textSelector,
                        classes: 'border-bottom border-success'
                      },
                      {
                        title: 'text border-bottom border-danger',
                        selector: this.textSelector,
                        classes: 'border-bottom border-danger'
                      },
                      {
                        title: 'text border-bottom border-warning',
                        selector: this.textSelector,
                        classes: 'border-bottom border-warning'
                      },
                      {
                        title: 'text border-bottom border-info',
                        selector: this.textSelector,
                        classes: 'border-bottom border-info'
                      },
                      {
                        title: 'text border-bottom border-light',
                        selector: this.textSelector,
                        classes: 'border-bottom border-light'
                      },
                      {
                        title: 'text border-bottom border-dark',
                        selector: this.textSelector,
                        classes: 'border-bottom border-dark'
                      },
                      {
                        title: 'text border-bottom border-white',
                        selector: this.textSelector,
                        classes: 'border-bottom border-white'
                      }
                    ]
                  },
                  {
                    title: 'left',
                    items: [
                      {
                        title: 'text border-left border-primary',
                        selector: this.textSelector,
                        classes: 'border-left border-primary'
                      },
                      {
                        title: 'text border-left border-secondary',
                        selector: this.textSelector,
                        classes: 'border-left border-secondary'
                      },
                      {
                        title: 'text border-left border-success',
                        selector: this.textSelector,
                        classes: 'border-left border-success'
                      },
                      {
                        title: 'text border-left border-danger',
                        selector: this.textSelector,
                        classes: 'border-left border-danger'
                      },
                      {
                        title: 'text border-left border-warning',
                        selector: this.textSelector,
                        classes: 'border-left border-warning'
                      },
                      {
                        title: 'text border-left border-info',
                        selector: this.textSelector,
                        classes: 'border-left border-info'
                      },
                      {
                        title: 'text border-left border-light',
                        selector: this.textSelector,
                        classes: 'border-left border-light'
                      },
                      {
                        title: 'text border-left border-dark',
                        selector: this.textSelector,
                        classes: 'border-left border-dark'
                      },
                      {
                        title: 'text border-left border-white',
                        selector: this.textSelector,
                        classes: 'border-left border-white'
                      }
                    ]
                  },
                  {
                    title: 'radius',
                    items: [
                      {
                        title: 'text rounded',
                        selector: this.textSelector,
                        classes: 'rounded'
                      },
                      {
                        title: 'text rounded-top',
                        selector: this.textSelector,
                        classes: 'rounded-top'
                      },
                      {
                        title: 'text rounded-right',
                        selector: this.textSelector,
                        classes: 'rounded-right'
                      },
                      {
                        title: 'text rounded-bottom',
                        selector: this.textSelector,
                        classes: 'rounded-bottom'
                      },
                      {
                        title: 'text rounded-left',
                        selector: this.textSelector,
                        classes: 'rounded-left'
                      },
                      {
                        title: 'text rounded-circle',
                        selector: this.textSelector,
                        classes: 'rounded-circle'
                      },
                      {
                        title: 'text rounded-pill',
                        selector: this.textSelector,
                        classes: 'rounded-pill'
                      },
                      {
                        title: 'text rounded-0',
                        selector: this.textSelector,
                        classes: 'rounded-0'
                      }
                    ]
                  }
                ]
              }
            ]
          },
          {
            title: 'Block styles',
            items: [
              {
                title: 'Margin',
                items: [
                  {
                    title: 'All screens',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'block m-0',
                            selector: this.blockSelector,
                            classes: 'm-0'
                          },
                          {
                            title: 'block m-1',
                            selector: this.blockSelector,
                            classes: 'm-1'
                          },
                          {
                            title: 'block m-2',
                            selector: this.blockSelector,
                            classes: 'm-2'
                          },
                          {
                            title: 'block m-3',
                            selector: this.blockSelector,
                            classes: 'm-3'
                          },
                          {
                            title: 'block m-4',
                            selector: this.blockSelector,
                            classes: 'm-4'
                          },
                          {
                            title: 'block m-5',
                            selector: this.blockSelector,
                            classes: 'm-5'
                          },
                          {
                            title: 'block m-auto',
                            selector: this.blockSelector,
                            classes: 'm-auto'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'block mx-0',
                            selector: this.blockSelector,
                            classes: 'mx-0'
                          },
                          {
                            title: 'block mx-1',
                            selector: this.blockSelector,
                            classes: 'mx-1'
                          },
                          {
                            title: 'block mx-2',
                            selector: this.blockSelector,
                            classes: 'mx-2'
                          },
                          {
                            title: 'block mx-3',
                            selector: this.blockSelector,
                            classes: 'mx-3'
                          },
                          {
                            title: 'block mx-4',
                            selector: this.blockSelector,
                            classes: 'mx-4'
                          },
                          {
                            title: 'block mx-5',
                            selector: this.blockSelector,
                            classes: 'mx-5'
                          },
                          {
                            title: 'block mx-auto',
                            selector: this.blockSelector,
                            classes: 'mx-auto'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'block my-0',
                            selector: this.blockSelector,
                            classes: 'my-0'
                          },
                          {
                            title: 'block my-1',
                            selector: this.blockSelector,
                            classes: 'my-1'
                          },
                          {
                            title: 'block my-2',
                            selector: this.blockSelector,
                            classes: 'my-2'
                          },
                          {
                            title: 'block my-3',
                            selector: this.blockSelector,
                            classes: 'my-3'
                          },
                          {
                            title: 'block my-4',
                            selector: this.blockSelector,
                            classes: 'my-4'
                          },
                          {
                            title: 'block my-5',
                            selector: this.blockSelector,
                            classes: 'my-5'
                          },
                          {
                            title: 'block my-auto',
                            selector: this.blockSelector,
                            classes: 'my-auto'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'block mt-0',
                            selector: this.blockSelector,
                            classes: 'mt-0'
                          },
                          {
                            title: 'block mt-1',
                            selector: this.blockSelector,
                            classes: 'mt-1'
                          },
                          {
                            title: 'block mt-2',
                            selector: this.blockSelector,
                            classes: 'mt-2'
                          },
                          {
                            title: 'block mt-3',
                            selector: this.blockSelector,
                            classes: 'mt-3'
                          },
                          {
                            title: 'block mt-4',
                            selector: this.blockSelector,
                            classes: 'mt-4'
                          },
                          {
                            title: 'block mt-5',
                            selector: this.blockSelector,
                            classes: 'mt-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'block mr-0',
                            selector: this.blockSelector,
                            classes: 'mr-0'
                          },
                          {
                            title: 'block mr-1',
                            selector: this.blockSelector,
                            classes: 'mr-1'
                          },
                          {
                            title: 'block mr-2',
                            selector: this.blockSelector,
                            classes: 'mr-2'
                          },
                          {
                            title: 'block mr-3',
                            selector: this.blockSelector,
                            classes: 'mr-3'
                          },
                          {
                            title: 'block mr-4',
                            selector: this.blockSelector,
                            classes: 'mr-4'
                          },
                          {
                            title: 'block mr-5',
                            selector: this.blockSelector,
                            classes: 'mr-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'block mb-0',
                            selector: this.blockSelector,
                            classes: 'mb-0'
                          },
                          {
                            title: 'block mb-1',
                            selector: this.blockSelector,
                            classes: 'mb-1'
                          },
                          {
                            title: 'block mb-2',
                            selector: this.blockSelector,
                            classes: 'mb-2'
                          },
                          {
                            title: 'block mb-3',
                            selector: this.blockSelector,
                            classes: 'mb-3'
                          },
                          {
                            title: 'block mb-4',
                            selector: this.blockSelector,
                            classes: 'mb-4'
                          },
                          {
                            title: 'block mb-5',
                            selector: this.blockSelector,
                            classes: 'mb-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'block ml-0',
                            selector: this.blockSelector,
                            classes: 'ml-0'
                          },
                          {
                            title: 'block ml-1',
                            selector: this.blockSelector,
                            classes: 'ml-1'
                          },
                          {
                            title: 'block ml-2',
                            selector: this.blockSelector,
                            classes: 'ml-2'
                          },
                          {
                            title: 'block ml-3',
                            selector: this.blockSelector,
                            classes: 'ml-3'
                          },
                          {
                            title: 'block ml-4',
                            selector: this.blockSelector,
                            classes: 'ml-4'
                          },
                          {
                            title: 'block ml-5',
                            selector: this.blockSelector,
                            classes: 'ml-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Small screens and larger',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'block m-sm-0',
                            selector: this.blockSelector,
                            classes: 'm-sm-0'
                          },
                          {
                            title: 'block m-sm-1',
                            selector: this.blockSelector,
                            classes: 'm-sm-1'
                          },
                          {
                            title: 'block m-sm-2',
                            selector: this.blockSelector,
                            classes: 'm-sm-2'
                          },
                          {
                            title: 'block m-sm-3',
                            selector: this.blockSelector,
                            classes: 'm-sm-3'
                          },
                          {
                            title: 'block m-sm-4',
                            selector: this.blockSelector,
                            classes: 'm-sm-4'
                          },
                          {
                            title: 'block m-sm-5',
                            selector: this.blockSelector,
                            classes: 'm-sm-5'
                          },
                          {
                            title: 'block m-sm-auto',
                            selector: this.blockSelector,
                            classes: 'm-sm-auto'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'block mx-sm-0',
                            selector: this.blockSelector,
                            classes: 'mx-sm-0'
                          },
                          {
                            title: 'block mx-sm-1',
                            selector: this.blockSelector,
                            classes: 'mx-sm-1'
                          },
                          {
                            title: 'block mx-sm-2',
                            selector: this.blockSelector,
                            classes: 'mx-sm-2'
                          },
                          {
                            title: 'block mx-sm-3',
                            selector: this.blockSelector,
                            classes: 'mx-sm-3'
                          },
                          {
                            title: 'block mx-sm-4',
                            selector: this.blockSelector,
                            classes: 'mx-sm-4'
                          },
                          {
                            title: 'block mx-sm-5',
                            selector: this.blockSelector,
                            classes: 'mx-sm-5'
                          },
                          {
                            title: 'block mx-sm-auto',
                            selector: this.blockSelector,
                            classes: 'mx-sm-auto'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'block my-sm-0',
                            selector: this.blockSelector,
                            classes: 'my-sm-0'
                          },
                          {
                            title: 'block my-sm-1',
                            selector: this.blockSelector,
                            classes: 'my-sm-1'
                          },
                          {
                            title: 'block my-sm-2',
                            selector: this.blockSelector,
                            classes: 'my-sm-2'
                          },
                          {
                            title: 'block my-sm-3',
                            selector: this.blockSelector,
                            classes: 'my-sm-3'
                          },
                          {
                            title: 'block my-sm-4',
                            selector: this.blockSelector,
                            classes: 'my-sm-4'
                          },
                          {
                            title: 'block my-sm-5',
                            selector: this.blockSelector,
                            classes: 'my-sm-5'
                          },
                          {
                            title: 'block my-sm-auto',
                            selector: this.blockSelector,
                            classes: 'my-sm-auto'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'block mt-sm-0',
                            selector: this.blockSelector,
                            classes: 'mt-sm-0'
                          },
                          {
                            title: 'block mt-sm-1',
                            selector: this.blockSelector,
                            classes: 'mt-sm-1'
                          },
                          {
                            title: 'block mt-sm-2',
                            selector: this.blockSelector,
                            classes: 'mt-sm-2'
                          },
                          {
                            title: 'block mt-sm-3',
                            selector: this.blockSelector,
                            classes: 'mt-sm-3'
                          },
                          {
                            title: 'block mt-sm-4',
                            selector: this.blockSelector,
                            classes: 'mt-sm-4'
                          },
                          {
                            title: 'block mt-sm-5',
                            selector: this.blockSelector,
                            classes: 'mt-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'block mr-sm-0',
                            selector: this.blockSelector,
                            classes: 'mr-sm-0'
                          },
                          {
                            title: 'block mr-sm-1',
                            selector: this.blockSelector,
                            classes: 'mr-sm-1'
                          },
                          {
                            title: 'block mr-sm-2',
                            selector: this.blockSelector,
                            classes: 'mr-sm-2'
                          },
                          {
                            title: 'block mr-sm-3',
                            selector: this.blockSelector,
                            classes: 'mr-sm-3'
                          },
                          {
                            title: 'block mr-sm-4',
                            selector: this.blockSelector,
                            classes: 'mr-sm-4'
                          },
                          {
                            title: 'block mr-sm-5',
                            selector: this.blockSelector,
                            classes: 'mr-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'block mb-sm-0',
                            selector: this.blockSelector,
                            classes: 'mb-sm-0'
                          },
                          {
                            title: 'block mb-sm-1',
                            selector: this.blockSelector,
                            classes: 'mb-sm-1'
                          },
                          {
                            title: 'block mb-sm-2',
                            selector: this.blockSelector,
                            classes: 'mb-sm-2'
                          },
                          {
                            title: 'block mb-sm-3',
                            selector: this.blockSelector,
                            classes: 'mb-sm-3'
                          },
                          {
                            title: 'block mb-sm-4',
                            selector: this.blockSelector,
                            classes: 'mb-sm-4'
                          },
                          {
                            title: 'block mb-sm-5',
                            selector: this.blockSelector,
                            classes: 'mb-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'block ml-sm-0',
                            selector: this.blockSelector,
                            classes: 'ml-sm-0'
                          },
                          {
                            title: 'block ml-sm-1',
                            selector: this.blockSelector,
                            classes: 'ml-sm-1'
                          },
                          {
                            title: 'block ml-sm-2',
                            selector: this.blockSelector,
                            classes: 'ml-sm-2'
                          },
                          {
                            title: 'block ml-sm-3',
                            selector: this.blockSelector,
                            classes: 'ml-sm-3'
                          },
                          {
                            title: 'block ml-sm-4',
                            selector: this.blockSelector,
                            classes: 'ml-sm-4'
                          },
                          {
                            title: 'block ml-sm-5',
                            selector: this.blockSelector,
                            classes: 'ml-sm-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Medium screens and larger',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'block m-md-0',
                            selector: this.blockSelector,
                            classes: 'm-md-0'
                          },
                          {
                            title: 'block m-md-1',
                            selector: this.blockSelector,
                            classes: 'm-md-1'
                          },
                          {
                            title: 'block m-md-2',
                            selector: this.blockSelector,
                            classes: 'm-md-2'
                          },
                          {
                            title: 'block m-md-3',
                            selector: this.blockSelector,
                            classes: 'm-md-3'
                          },
                          {
                            title: 'block m-md-4',
                            selector: this.blockSelector,
                            classes: 'm-md-4'
                          },
                          {
                            title: 'block m-md-5',
                            selector: this.blockSelector,
                            classes: 'm-md-5'
                          },
                          {
                            title: 'block m-md-auto',
                            selector: this.blockSelector,
                            classes: 'm-md-auto'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'block mx-md-0',
                            selector: this.blockSelector,
                            classes: 'mx-md-0'
                          },
                          {
                            title: 'block mx-md-1',
                            selector: this.blockSelector,
                            classes: 'mx-md-1'
                          },
                          {
                            title: 'block mx-md-2',
                            selector: this.blockSelector,
                            classes: 'mx-md-2'
                          },
                          {
                            title: 'block mx-md-3',
                            selector: this.blockSelector,
                            classes: 'mx-md-3'
                          },
                          {
                            title: 'block mx-md-4',
                            selector: this.blockSelector,
                            classes: 'mx-md-4'
                          },
                          {
                            title: 'block mx-md-5',
                            selector: this.blockSelector,
                            classes: 'mx-md-5'
                          },
                          {
                            title: 'block mx-md-auto',
                            selector: this.blockSelector,
                            classes: 'mx-md-auto'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'block my-md-0',
                            selector: this.blockSelector,
                            classes: 'my-md-0'
                          },
                          {
                            title: 'block my-md-1',
                            selector: this.blockSelector,
                            classes: 'my-md-1'
                          },
                          {
                            title: 'block my-md-2',
                            selector: this.blockSelector,
                            classes: 'my-md-2'
                          },
                          {
                            title: 'block my-md-3',
                            selector: this.blockSelector,
                            classes: 'my-md-3'
                          },
                          {
                            title: 'block my-md-4',
                            selector: this.blockSelector,
                            classes: 'my-md-4'
                          },
                          {
                            title: 'block my-md-5',
                            selector: this.blockSelector,
                            classes: 'my-md-5'
                          },
                          {
                            title: 'block my-md-auto',
                            selector: this.blockSelector,
                            classes: 'my-md-auto'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'block mt-md-0',
                            selector: this.blockSelector,
                            classes: 'mt-md-0'
                          },
                          {
                            title: 'block mt-md-1',
                            selector: this.blockSelector,
                            classes: 'mt-md-1'
                          },
                          {
                            title: 'block mt-md-2',
                            selector: this.blockSelector,
                            classes: 'mt-md-2'
                          },
                          {
                            title: 'block mt-md-3',
                            selector: this.blockSelector,
                            classes: 'mt-md-3'
                          },
                          {
                            title: 'block mt-md-4',
                            selector: this.blockSelector,
                            classes: 'mt-md-4'
                          },
                          {
                            title: 'block mt-md-5',
                            selector: this.blockSelector,
                            classes: 'mt-md-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'block mr-md-0',
                            selector: this.blockSelector,
                            classes: 'mr-md-0'
                          },
                          {
                            title: 'block mr-md-1',
                            selector: this.blockSelector,
                            classes: 'mr-md-1'
                          },
                          {
                            title: 'block mr-md-2',
                            selector: this.blockSelector,
                            classes: 'mr-md-2'
                          },
                          {
                            title: 'block mr-md-3',
                            selector: this.blockSelector,
                            classes: 'mr-md-3'
                          },
                          {
                            title: 'block mr-md-4',
                            selector: this.blockSelector,
                            classes: 'mr-md-4'
                          },
                          {
                            title: 'block mr-md-5',
                            selector: this.blockSelector,
                            classes: 'mr-md-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'block mb-md-0',
                            selector: this.blockSelector,
                            classes: 'mb-md-0'
                          },
                          {
                            title: 'block mb-md-1',
                            selector: this.blockSelector,
                            classes: 'mb-md-1'
                          },
                          {
                            title: 'block mb-md-2',
                            selector: this.blockSelector,
                            classes: 'mb-md-2'
                          },
                          {
                            title: 'block mb-md-3',
                            selector: this.blockSelector,
                            classes: 'mb-md-3'
                          },
                          {
                            title: 'block mb-md-4',
                            selector: this.blockSelector,
                            classes: 'mb-md-4'
                          },
                          {
                            title: 'block mb-md-5',
                            selector: this.blockSelector,
                            classes: 'mb-md-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'block ml-md-0',
                            selector: this.blockSelector,
                            classes: 'ml-md-0'
                          },
                          {
                            title: 'block ml-md-1',
                            selector: this.blockSelector,
                            classes: 'ml-md-1'
                          },
                          {
                            title: 'block ml-md-2',
                            selector: this.blockSelector,
                            classes: 'ml-md-2'
                          },
                          {
                            title: 'block ml-md-3',
                            selector: this.blockSelector,
                            classes: 'ml-md-3'
                          },
                          {
                            title: 'block ml-md-4',
                            selector: this.blockSelector,
                            classes: 'ml-md-4'
                          },
                          {
                            title: 'block ml-md-5',
                            selector: this.blockSelector,
                            classes: 'ml-md-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Large screens',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'block m-lg-0',
                            selector: this.blockSelector,
                            classes: 'm-lg-0'
                          },
                          {
                            title: 'block m-lg-1',
                            selector: this.blockSelector,
                            classes: 'm-lg-1'
                          },
                          {
                            title: 'block m-lg-2',
                            selector: this.blockSelector,
                            classes: 'm-lg-2'
                          },
                          {
                            title: 'block m-lg-3',
                            selector: this.blockSelector,
                            classes: 'm-lg-3'
                          },
                          {
                            title: 'block m-lg-4',
                            selector: this.blockSelector,
                            classes: 'm-lg-4'
                          },
                          {
                            title: 'block m-lg-5',
                            selector: this.blockSelector,
                            classes: 'm-lg-5'
                          },
                          {
                            title: 'block m-lg-auto',
                            selector: this.blockSelector,
                            classes: 'm-lg-auto'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'block mx-lg-0',
                            selector: this.blockSelector,
                            classes: 'mx-lg-0'
                          },
                          {
                            title: 'block mx-lg-1',
                            selector: this.blockSelector,
                            classes: 'mx-lg-1'
                          },
                          {
                            title: 'block mx-lg-2',
                            selector: this.blockSelector,
                            classes: 'mx-lg-2'
                          },
                          {
                            title: 'block mx-lg-3',
                            selector: this.blockSelector,
                            classes: 'mx-lg-3'
                          },
                          {
                            title: 'block mx-lg-4',
                            selector: this.blockSelector,
                            classes: 'mx-lg-4'
                          },
                          {
                            title: 'block mx-lg-5',
                            selector: this.blockSelector,
                            classes: 'mx-lg-5'
                          },
                          {
                            title: 'block mx-lg-auto',
                            selector: this.blockSelector,
                            classes: 'mx-lg-auto'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'block my-lg-0',
                            selector: this.blockSelector,
                            classes: 'my-lg-0'
                          },
                          {
                            title: 'block my-lg-1',
                            selector: this.blockSelector,
                            classes: 'my-lg-1'
                          },
                          {
                            title: 'block my-lg-2',
                            selector: this.blockSelector,
                            classes: 'my-lg-2'
                          },
                          {
                            title: 'block my-lg-3',
                            selector: this.blockSelector,
                            classes: 'my-lg-3'
                          },
                          {
                            title: 'block my-lg-4',
                            selector: this.blockSelector,
                            classes: 'my-lg-4'
                          },
                          {
                            title: 'block my-lg-5',
                            selector: this.blockSelector,
                            classes: 'my-lg-5'
                          },
                          {
                            title: 'block my-lg-auto',
                            selector: this.blockSelector,
                            classes: 'my-lg-auto'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'block mt-lg-0',
                            selector: this.blockSelector,
                            classes: 'mt-lg-0'
                          },
                          {
                            title: 'block mt-lg-1',
                            selector: this.blockSelector,
                            classes: 'mt-lg-1'
                          },
                          {
                            title: 'block mt-lg-2',
                            selector: this.blockSelector,
                            classes: 'mt-lg-2'
                          },
                          {
                            title: 'block mt-lg-3',
                            selector: this.blockSelector,
                            classes: 'mt-lg-3'
                          },
                          {
                            title: 'block mt-lg-4',
                            selector: this.blockSelector,
                            classes: 'mt-lg-4'
                          },
                          {
                            title: 'block mt-lg-5',
                            selector: this.blockSelector,
                            classes: 'mt-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'block mr-lg-0',
                            selector: this.blockSelector,
                            classes: 'mr-lg-0'
                          },
                          {
                            title: 'block mr-lg-1',
                            selector: this.blockSelector,
                            classes: 'mr-lg-1'
                          },
                          {
                            title: 'block mr-lg-2',
                            selector: this.blockSelector,
                            classes: 'mr-lg-2'
                          },
                          {
                            title: 'block mr-lg-3',
                            selector: this.blockSelector,
                            classes: 'mr-lg-3'
                          },
                          {
                            title: 'block mr-lg-4',
                            selector: this.blockSelector,
                            classes: 'mr-lg-4'
                          },
                          {
                            title: 'block mr-lg-5',
                            selector: this.blockSelector,
                            classes: 'mr-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'block mb-lg-0',
                            selector: this.blockSelector,
                            classes: 'mb-lg-0'
                          },
                          {
                            title: 'block mb-lg-1',
                            selector: this.blockSelector,
                            classes: 'mb-lg-1'
                          },
                          {
                            title: 'block mb-lg-2',
                            selector: this.blockSelector,
                            classes: 'mb-lg-2'
                          },
                          {
                            title: 'block mb-lg-3',
                            selector: this.blockSelector,
                            classes: 'mb-lg-3'
                          },
                          {
                            title: 'block mb-lg-4',
                            selector: this.blockSelector,
                            classes: 'mb-lg-4'
                          },
                          {
                            title: 'block mb-lg-5',
                            selector: this.blockSelector,
                            classes: 'mb-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'block ml-lg-0',
                            selector: this.blockSelector,
                            classes: 'ml-lg-0'
                          },
                          {
                            title: 'block ml-lg-1',
                            selector: this.blockSelector,
                            classes: 'ml-lg-1'
                          },
                          {
                            title: 'block ml-lg-2',
                            selector: this.blockSelector,
                            classes: 'ml-lg-2'
                          },
                          {
                            title: 'block ml-lg-3',
                            selector: this.blockSelector,
                            classes: 'ml-lg-3'
                          },
                          {
                            title: 'block ml-lg-4',
                            selector: this.blockSelector,
                            classes: 'ml-lg-4'
                          },
                          {
                            title: 'block ml-lg-5',
                            selector: this.blockSelector,
                            classes: 'ml-lg-5'
                          }
                        ]
                      }
                    ]
                  }
                ]
              },
              {
                title: 'Padding',
                items: [
                  {
                    title: 'All screens',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'block p-0',
                            selector: this.blockSelector,
                            classes: 'p-0'
                          },
                          {
                            title: 'block p-1',
                            selector: this.blockSelector,
                            classes: 'p-1'
                          },
                          {
                            title: 'block p-2',
                            selector: this.blockSelector,
                            classes: 'p-2'
                          },
                          {
                            title: 'block p-3',
                            selector: this.blockSelector,
                            classes: 'p-3'
                          },
                          {
                            title: 'block p-4',
                            selector: this.blockSelector,
                            classes: 'p-4'
                          },
                          {
                            title: 'block p-5',
                            selector: this.blockSelector,
                            classes: 'p-5'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'block px-0',
                            selector: this.blockSelector,
                            classes: 'px-0'
                          },
                          {
                            title: 'block px-1',
                            selector: this.blockSelector,
                            classes: 'px-1'
                          },
                          {
                            title: 'block px-2',
                            selector: this.blockSelector,
                            classes: 'px-2'
                          },
                          {
                            title: 'block px-3',
                            selector: this.blockSelector,
                            classes: 'px-3'
                          },
                          {
                            title: 'block px-4',
                            selector: this.blockSelector,
                            classes: 'px-4'
                          },
                          {
                            title: 'block px-5',
                            selector: this.blockSelector,
                            classes: 'px-5'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'block py-0',
                            selector: this.blockSelector,
                            classes: 'py-0'
                          },
                          {
                            title: 'block py-1',
                            selector: this.blockSelector,
                            classes: 'py-1'
                          },
                          {
                            title: 'block py-2',
                            selector: this.blockSelector,
                            classes: 'py-2'
                          },
                          {
                            title: 'block py-3',
                            selector: this.blockSelector,
                            classes: 'py-3'
                          },
                          {
                            title: 'block py-4',
                            selector: this.blockSelector,
                            classes: 'py-4'
                          },
                          {
                            title: 'block py-5',
                            selector: this.blockSelector,
                            classes: 'py-5'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'block pt-0',
                            selector: this.blockSelector,
                            classes: 'pt-0'
                          },
                          {
                            title: 'block pt-1',
                            selector: this.blockSelector,
                            classes: 'pt-1'
                          },
                          {
                            title: 'block pt-2',
                            selector: this.blockSelector,
                            classes: 'pt-2'
                          },
                          {
                            title: 'block pt-3',
                            selector: this.blockSelector,
                            classes: 'pt-3'
                          },
                          {
                            title: 'block pt-4',
                            selector: this.blockSelector,
                            classes: 'pt-4'
                          },
                          {
                            title: 'block pt-5',
                            selector: this.blockSelector,
                            classes: 'pt-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'block pr-0',
                            selector: this.blockSelector,
                            classes: 'pr-0'
                          },
                          {
                            title: 'block pr-1',
                            selector: this.blockSelector,
                            classes: 'pr-1'
                          },
                          {
                            title: 'block pr-2',
                            selector: this.blockSelector,
                            classes: 'pr-2'
                          },
                          {
                            title: 'block pr-3',
                            selector: this.blockSelector,
                            classes: 'pr-3'
                          },
                          {
                            title: 'block pr-4',
                            selector: this.blockSelector,
                            classes: 'pr-4'
                          },
                          {
                            title: 'block pr-5',
                            selector: this.blockSelector,
                            classes: 'pr-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'block pb-0',
                            selector: this.blockSelector,
                            classes: 'pb-0'
                          },
                          {
                            title: 'block pb-1',
                            selector: this.blockSelector,
                            classes: 'pb-1'
                          },
                          {
                            title: 'block pb-2',
                            selector: this.blockSelector,
                            classes: 'pb-2'
                          },
                          {
                            title: 'block pb-3',
                            selector: this.blockSelector,
                            classes: 'pb-3'
                          },
                          {
                            title: 'block pb-4',
                            selector: this.blockSelector,
                            classes: 'pb-4'
                          },
                          {
                            title: 'block pb-5',
                            selector: this.blockSelector,
                            classes: 'pb-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'block pl-0',
                            selector: this.blockSelector,
                            classes: 'pl-0'
                          },
                          {
                            title: 'block pl-1',
                            selector: this.blockSelector,
                            classes: 'pl-1'
                          },
                          {
                            title: 'block pl-2',
                            selector: this.blockSelector,
                            classes: 'pl-2'
                          },
                          {
                            title: 'block pl-3',
                            selector: this.blockSelector,
                            classes: 'pl-3'
                          },
                          {
                            title: 'block pl-4',
                            selector: this.blockSelector,
                            classes: 'pl-4'
                          },
                          {
                            title: 'block pl-5',
                            selector: this.blockSelector,
                            classes: 'pl-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Small screens and larger',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'block p-sm-0',
                            selector: this.blockSelector,
                            classes: 'p-sm-0'
                          },
                          {
                            title: 'block p-sm-1',
                            selector: this.blockSelector,
                            classes: 'p-sm-1'
                          },
                          {
                            title: 'block p-sm-2',
                            selector: this.blockSelector,
                            classes: 'p-sm-2'
                          },
                          {
                            title: 'block p-sm-3',
                            selector: this.blockSelector,
                            classes: 'p-sm-3'
                          },
                          {
                            title: 'block p-sm-4',
                            selector: this.blockSelector,
                            classes: 'p-sm-4'
                          },
                          {
                            title: 'block p-sm-5',
                            selector: this.blockSelector,
                            classes: 'p-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'block px-sm-0',
                            selector: this.blockSelector,
                            classes: 'px-sm-0'
                          },
                          {
                            title: 'block px-sm-1',
                            selector: this.blockSelector,
                            classes: 'px-sm-1'
                          },
                          {
                            title: 'block px-sm-2',
                            selector: this.blockSelector,
                            classes: 'px-sm-2'
                          },
                          {
                            title: 'block px-sm-3',
                            selector: this.blockSelector,
                            classes: 'px-sm-3'
                          },
                          {
                            title: 'block px-sm-4',
                            selector: this.blockSelector,
                            classes: 'px-sm-4'
                          },
                          {
                            title: 'block px-sm-5',
                            selector: this.blockSelector,
                            classes: 'px-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'block py-sm-0',
                            selector: this.blockSelector,
                            classes: 'py-sm-0'
                          },
                          {
                            title: 'block py-sm-1',
                            selector: this.blockSelector,
                            classes: 'py-sm-1'
                          },
                          {
                            title: 'block py-sm-2',
                            selector: this.blockSelector,
                            classes: 'py-sm-2'
                          },
                          {
                            title: 'block py-sm-3',
                            selector: this.blockSelector,
                            classes: 'py-sm-3'
                          },
                          {
                            title: 'block py-sm-4',
                            selector: this.blockSelector,
                            classes: 'py-sm-4'
                          },
                          {
                            title: 'block py-sm-5',
                            selector: this.blockSelector,
                            classes: 'py-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'block pt-sm-0',
                            selector: this.blockSelector,
                            classes: 'pt-sm-0'
                          },
                          {
                            title: 'block pt-sm-1',
                            selector: this.blockSelector,
                            classes: 'pt-sm-1'
                          },
                          {
                            title: 'block pt-sm-2',
                            selector: this.blockSelector,
                            classes: 'pt-sm-2'
                          },
                          {
                            title: 'block pt-sm-3',
                            selector: this.blockSelector,
                            classes: 'pt-sm-3'
                          },
                          {
                            title: 'block pt-sm-4',
                            selector: this.blockSelector,
                            classes: 'pt-sm-4'
                          },
                          {
                            title: 'block pt-sm-5',
                            selector: this.blockSelector,
                            classes: 'pt-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'block pr-sm-0',
                            selector: this.blockSelector,
                            classes: 'pr-sm-0'
                          },
                          {
                            title: 'block pr-sm-1',
                            selector: this.blockSelector,
                            classes: 'pr-sm-1'
                          },
                          {
                            title: 'block pr-sm-2',
                            selector: this.blockSelector,
                            classes: 'pr-sm-2'
                          },
                          {
                            title: 'block pr-sm-3',
                            selector: this.blockSelector,
                            classes: 'pr-sm-3'
                          },
                          {
                            title: 'block pr-sm-4',
                            selector: this.blockSelector,
                            classes: 'pr-sm-4'
                          },
                          {
                            title: 'block pr-sm-5',
                            selector: this.blockSelector,
                            classes: 'pr-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'block pb-sm-0',
                            selector: this.blockSelector,
                            classes: 'pb-sm-0'
                          },
                          {
                            title: 'block pb-sm-1',
                            selector: this.blockSelector,
                            classes: 'pb-sm-1'
                          },
                          {
                            title: 'block pb-sm-2',
                            selector: this.blockSelector,
                            classes: 'pb-sm-2'
                          },
                          {
                            title: 'block pb-sm-3',
                            selector: this.blockSelector,
                            classes: 'pb-sm-3'
                          },
                          {
                            title: 'block pb-sm-4',
                            selector: this.blockSelector,
                            classes: 'pb-sm-4'
                          },
                          {
                            title: 'block pb-sm-5',
                            selector: this.blockSelector,
                            classes: 'pb-sm-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'block pl-sm-0',
                            selector: this.blockSelector,
                            classes: 'pl-sm-0'
                          },
                          {
                            title: 'block pl-sm-1',
                            selector: this.blockSelector,
                            classes: 'pl-sm-1'
                          },
                          {
                            title: 'block pl-sm-2',
                            selector: this.blockSelector,
                            classes: 'pl-sm-2'
                          },
                          {
                            title: 'block pl-sm-3',
                            selector: this.blockSelector,
                            classes: 'pl-sm-3'
                          },
                          {
                            title: 'block pl-sm-4',
                            selector: this.blockSelector,
                            classes: 'pl-sm-4'
                          },
                          {
                            title: 'block pl-sm-5',
                            selector: this.blockSelector,
                            classes: 'pl-sm-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Medium screens and larger',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'block p-md-0',
                            selector: this.blockSelector,
                            classes: 'p-md-0'
                          },
                          {
                            title: 'block p-md-1',
                            selector: this.blockSelector,
                            classes: 'p-md-1'
                          },
                          {
                            title: 'block p-md-2',
                            selector: this.blockSelector,
                            classes: 'p-md-2'
                          },
                          {
                            title: 'block p-md-3',
                            selector: this.blockSelector,
                            classes: 'p-md-3'
                          },
                          {
                            title: 'block p-md-4',
                            selector: this.blockSelector,
                            classes: 'p-md-4'
                          },
                          {
                            title: 'block p-md-5',
                            selector: this.blockSelector,
                            classes: 'p-md-5'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'block px-md-0',
                            selector: this.blockSelector,
                            classes: 'px-md-0'
                          },
                          {
                            title: 'block px-md-1',
                            selector: this.blockSelector,
                            classes: 'px-md-1'
                          },
                          {
                            title: 'block px-md-2',
                            selector: this.blockSelector,
                            classes: 'px-md-2'
                          },
                          {
                            title: 'block px-md-3',
                            selector: this.blockSelector,
                            classes: 'px-md-3'
                          },
                          {
                            title: 'block px-md-4',
                            selector: this.blockSelector,
                            classes: 'px-md-4'
                          },
                          {
                            title: 'block px-md-5',
                            selector: this.blockSelector,
                            classes: 'px-md-5'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'block py-md-0',
                            selector: this.blockSelector,
                            classes: 'py-md-0'
                          },
                          {
                            title: 'block py-md-1',
                            selector: this.blockSelector,
                            classes: 'py-md-1'
                          },
                          {
                            title: 'block py-md-2',
                            selector: this.blockSelector,
                            classes: 'py-md-2'
                          },
                          {
                            title: 'block py-md-3',
                            selector: this.blockSelector,
                            classes: 'py-md-3'
                          },
                          {
                            title: 'block py-md-4',
                            selector: this.blockSelector,
                            classes: 'py-md-4'
                          },
                          {
                            title: 'block py-md-5',
                            selector: this.blockSelector,
                            classes: 'py-md-5'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'block pt-md-0',
                            selector: this.blockSelector,
                            classes: 'pt-md-0'
                          },
                          {
                            title: 'block pt-md-1',
                            selector: this.blockSelector,
                            classes: 'pt-md-1'
                          },
                          {
                            title: 'block pt-md-2',
                            selector: this.blockSelector,
                            classes: 'pt-md-2'
                          },
                          {
                            title: 'block pt-md-3',
                            selector: this.blockSelector,
                            classes: 'pt-md-3'
                          },
                          {
                            title: 'block pt-md-4',
                            selector: this.blockSelector,
                            classes: 'pt-md-4'
                          },
                          {
                            title: 'block pt-md-5',
                            selector: this.blockSelector,
                            classes: 'pt-md-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'block pr-md-0',
                            selector: this.blockSelector,
                            classes: 'pr-md-0'
                          },
                          {
                            title: 'block pr-md-1',
                            selector: this.blockSelector,
                            classes: 'pr-md-1'
                          },
                          {
                            title: 'block pr-md-2',
                            selector: this.blockSelector,
                            classes: 'pr-md-2'
                          },
                          {
                            title: 'block pr-md-3',
                            selector: this.blockSelector,
                            classes: 'pr-md-3'
                          },
                          {
                            title: 'block pr-md-4',
                            selector: this.blockSelector,
                            classes: 'pr-md-4'
                          },
                          {
                            title: 'block pr-md-5',
                            selector: this.blockSelector,
                            classes: 'pr-md-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'block pb-md-0',
                            selector: this.blockSelector,
                            classes: 'pb-md-0'
                          },
                          {
                            title: 'block pb-md-1',
                            selector: this.blockSelector,
                            classes: 'pb-md-1'
                          },
                          {
                            title: 'block pb-md-2',
                            selector: this.blockSelector,
                            classes: 'pb-md-2'
                          },
                          {
                            title: 'block pb-md-3',
                            selector: this.blockSelector,
                            classes: 'pb-md-3'
                          },
                          {
                            title: 'block pb-md-4',
                            selector: this.blockSelector,
                            classes: 'pb-md-4'
                          },
                          {
                            title: 'block pb-md-5',
                            selector: this.blockSelector,
                            classes: 'pb-md-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'block pl-md-0',
                            selector: this.blockSelector,
                            classes: 'pl-md-0'
                          },
                          {
                            title: 'block pl-md-1',
                            selector: this.blockSelector,
                            classes: 'pl-md-1'
                          },
                          {
                            title: 'block pl-md-2',
                            selector: this.blockSelector,
                            classes: 'pl-md-2'
                          },
                          {
                            title: 'block pl-md-3',
                            selector: this.blockSelector,
                            classes: 'pl-md-3'
                          },
                          {
                            title: 'block pl-md-4',
                            selector: this.blockSelector,
                            classes: 'pl-md-4'
                          },
                          {
                            title: 'block pl-md-5',
                            selector: this.blockSelector,
                            classes: 'pl-md-5'
                          }
                        ]
                      }
                    ]
                  },
                  {
                    title: 'Large screens',
                    items: [
                      {
                        title: 'all',
                        items: [
                          {
                            title: 'block p-lg-0',
                            selector: this.blockSelector,
                            classes: 'p-lg-0'
                          },
                          {
                            title: 'block p-lg-1',
                            selector: this.blockSelector,
                            classes: 'p-lg-1'
                          },
                          {
                            title: 'block p-lg-2',
                            selector: this.blockSelector,
                            classes: 'p-lg-2'
                          },
                          {
                            title: 'block p-lg-3',
                            selector: this.blockSelector,
                            classes: 'p-lg-3'
                          },
                          {
                            title: 'block p-lg-4',
                            selector: this.blockSelector,
                            classes: 'p-lg-4'
                          },
                          {
                            title: 'block p-lg-5',
                            selector: this.blockSelector,
                            classes: 'p-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'x',
                        items: [
                          {
                            title: 'block px-lg-0',
                            selector: this.blockSelector,
                            classes: 'px-lg-0'
                          },
                          {
                            title: 'block px-lg-1',
                            selector: this.blockSelector,
                            classes: 'px-lg-1'
                          },
                          {
                            title: 'block px-lg-2',
                            selector: this.blockSelector,
                            classes: 'px-lg-2'
                          },
                          {
                            title: 'block px-lg-3',
                            selector: this.blockSelector,
                            classes: 'px-lg-3'
                          },
                          {
                            title: 'block px-lg-4',
                            selector: this.blockSelector,
                            classes: 'px-lg-4'
                          },
                          {
                            title: 'block px-lg-5',
                            selector: this.blockSelector,
                            classes: 'px-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'y',
                        items: [
                          {
                            title: 'block py-lg-0',
                            selector: this.blockSelector,
                            classes: 'py-lg-0'
                          },
                          {
                            title: 'block py-lg-1',
                            selector: this.blockSelector,
                            classes: 'py-lg-1'
                          },
                          {
                            title: 'block py-lg-2',
                            selector: this.blockSelector,
                            classes: 'py-lg-2'
                          },
                          {
                            title: 'block py-lg-3',
                            selector: this.blockSelector,
                            classes: 'py-lg-3'
                          },
                          {
                            title: 'block py-lg-4',
                            selector: this.blockSelector,
                            classes: 'py-lg-4'
                          },
                          {
                            title: 'block py-lg-5',
                            selector: this.blockSelector,
                            classes: 'py-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'top',
                        items: [
                          {
                            title: 'block pt-lg-0',
                            selector: this.blockSelector,
                            classes: 'pt-lg-0'
                          },
                          {
                            title: 'block pt-lg-1',
                            selector: this.blockSelector,
                            classes: 'pt-lg-1'
                          },
                          {
                            title: 'block pt-lg-2',
                            selector: this.blockSelector,
                            classes: 'pt-lg-2'
                          },
                          {
                            title: 'block pt-lg-3',
                            selector: this.blockSelector,
                            classes: 'pt-lg-3'
                          },
                          {
                            title: 'block pt-lg-4',
                            selector: this.blockSelector,
                            classes: 'pt-lg-4'
                          },
                          {
                            title: 'block pt-lg-5',
                            selector: this.blockSelector,
                            classes: 'pt-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'right',
                        items: [
                          {
                            title: 'block pr-lg-0',
                            selector: this.blockSelector,
                            classes: 'pr-lg-0'
                          },
                          {
                            title: 'block pr-lg-1',
                            selector: this.blockSelector,
                            classes: 'pr-lg-1'
                          },
                          {
                            title: 'block pr-lg-2',
                            selector: this.blockSelector,
                            classes: 'pr-lg-2'
                          },
                          {
                            title: 'block pr-lg-3',
                            selector: this.blockSelector,
                            classes: 'pr-lg-3'
                          },
                          {
                            title: 'block pr-lg-4',
                            selector: this.blockSelector,
                            classes: 'pr-lg-4'
                          },
                          {
                            title: 'block pr-lg-5',
                            selector: this.blockSelector,
                            classes: 'pr-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'bottom',
                        items: [
                          {
                            title: 'block pb-lg-0',
                            selector: this.blockSelector,
                            classes: 'pb-lg-0'
                          },
                          {
                            title: 'block pb-lg-1',
                            selector: this.blockSelector,
                            classes: 'pb-lg-1'
                          },
                          {
                            title: 'block pb-lg-2',
                            selector: this.blockSelector,
                            classes: 'pb-lg-2'
                          },
                          {
                            title: 'block pb-lg-3',
                            selector: this.blockSelector,
                            classes: 'pb-lg-3'
                          },
                          {
                            title: 'block pb-lg-4',
                            selector: this.blockSelector,
                            classes: 'pb-lg-4'
                          },
                          {
                            title: 'block pb-lg-5',
                            selector: this.blockSelector,
                            classes: 'pb-lg-5'
                          }
                        ]
                      },
                      {
                        title: 'left',
                        items: [
                          {
                            title: 'block pl-lg-0',
                            selector: this.blockSelector,
                            classes: 'pl-lg-0'
                          },
                          {
                            title: 'block pl-lg-1',
                            selector: this.blockSelector,
                            classes: 'pl-lg-1'
                          },
                          {
                            title: 'block pl-lg-2',
                            selector: this.blockSelector,
                            classes: 'pl-lg-2'
                          },
                          {
                            title: 'block pl-lg-3',
                            selector: this.blockSelector,
                            classes: 'pl-lg-3'
                          },
                          {
                            title: 'block pl-lg-4',
                            selector: this.blockSelector,
                            classes: 'pl-lg-4'
                          },
                          {
                            title: 'block pl-lg-5',
                            selector: this.blockSelector,
                            classes: 'pl-lg-5'
                          }
                        ]
                      }
                    ]
                  }
                ]
              },
              {
                title: 'Color',
                items: [
                  {
                    title: 'block text-primary',
                    selector: this.blockSelector,
                    classes: 'text-primary'
                  },
                  {
                    title: 'block text-secondary',
                    selector: this.blockSelector,
                    classes: 'text-secondary'
                  },
                  {
                    title: 'block text-success',
                    selector: this.blockSelector,
                    classes: 'text-success'
                  },
                  {
                    title: 'block text-danger',
                    selector: this.blockSelector,
                    classes: 'text-danger'
                  },
                  {
                    title: 'block text-warning',
                    selector: this.blockSelector,
                    classes: 'text-warning'
                  },
                  {
                    title: 'block text-info',
                    selector: this.blockSelector,
                    classes: 'text-info'
                  },
                  {
                    title: 'block text-light',
                    selector: this.blockSelector,
                    classes: 'text-light'
                  },
                  {
                    title: 'block text-dark',
                    selector: this.blockSelector,
                    classes: 'text-dark'
                  },
                  {
                    title: 'block text-body',
                    selector: this.blockSelector,
                    classes: 'text-body'
                  },
                  {
                    title: 'block text-muted',
                    selector: this.blockSelector,
                    classes: 'text-muted'
                  },
                  {
                    title: 'block text-white',
                    selector: this.blockSelector,
                    classes: 'text-white'
                  },
                  {
                    title: 'block text-black-50',
                    selector: this.blockSelector,
                    classes: 'text-black-50'
                  },
                  {
                    title: 'block text-white-50',
                    selector: this.blockSelector,
                    classes: 'text-white-50'
                  }
                ]
              },
              {
                title: 'Background',
                items: [
                  {
                    title: 'block bg-primary',
                    selector: this.blockSelector,
                    classes: 'bg-primary'
                  },
                  {
                    title: 'block bg-secondary',
                    selector: this.blockSelector,
                    classes: 'bg-secondary'
                  },
                  {
                    title: 'block bg-success',
                    selector: this.blockSelector,
                    classes: 'bg-success'
                  },
                  {
                    title: 'block bg-danger',
                    selector: this.blockSelector,
                    classes: 'bg-danger'
                  },
                  {
                    title: 'block bg-warning',
                    selector: this.blockSelector,
                    classes: 'bg-warning'
                  },
                  {
                    title: 'block bg-info',
                    selector: this.blockSelector,
                    classes: 'bg-info'
                  },
                  {
                    title: 'block bg-light',
                    selector: this.blockSelector,
                    classes: 'bg-light'
                  },
                  {
                    title: 'block bg-dark',
                    selector: this.blockSelector,
                    classes: 'bg-dark'
                  },
                  {
                    title: 'block bg-white',
                    selector: this.blockSelector,
                    classes: 'bg-white'
                  },
                  {
                    title: 'block bg-transparent',
                    selector: this.blockSelector,
                    classes: 'bg-transparent'
                  }
                ]
              },
              {
                title: 'Border',
                items: [
                  {
                    title: 'all',
                    items: [
                      {
                        title: 'block border border-primary',
                        selector: this.blockSelector,
                        classes: 'border border-primary'
                      },
                      {
                        title: 'block border border-secondary',
                        selector: this.blockSelector,
                        classes: 'border border-secondary'
                      },
                      {
                        title: 'block border border-success',
                        selector: this.blockSelector,
                        classes: 'border border-success'
                      },
                      {
                        title: 'block border border-danger',
                        selector: this.blockSelector,
                        classes: 'border border-danger'
                      },
                      {
                        title: 'block border border-warning',
                        selector: this.blockSelector,
                        classes: 'border border-warning'
                      },
                      {
                        title: 'block border border-info',
                        selector: this.blockSelector,
                        classes: 'border border-info'
                      },
                      {
                        title: 'block border border-light',
                        selector: this.blockSelector,
                        classes: 'border border-light'
                      },
                      {
                        title: 'block border border-dark',
                        selector: this.blockSelector,
                        classes: 'border border-dark'
                      },
                      {
                        title: 'block border border-white',
                        selector: this.blockSelector,
                        classes: 'border border-white'
                      }
                    ]
                  },
                  {
                    title: 'top',
                    items: [
                      {
                        title: 'block border-top border-primary',
                        selector: this.blockSelector,
                        classes: 'border-top border-primary'
                      },
                      {
                        title: 'block border-top border-secondary',
                        selector: this.blockSelector,
                        classes: 'border-top border-secondary'
                      },
                      {
                        title: 'block border-top border-success',
                        selector: this.blockSelector,
                        classes: 'border-top border-success'
                      },
                      {
                        title: 'block border-top border-danger',
                        selector: this.blockSelector,
                        classes: 'border-top border-danger'
                      },
                      {
                        title: 'block border-top border-warning',
                        selector: this.blockSelector,
                        classes: 'border-top border-warning'
                      },
                      {
                        title: 'block border-top border-info',
                        selector: this.blockSelector,
                        classes: 'border-top border-info'
                      },
                      {
                        title: 'block border-top border-light',
                        selector: this.blockSelector,
                        classes: 'border-top border-light'
                      },
                      {
                        title: 'block border-top border-dark',
                        selector: this.blockSelector,
                        classes: 'border-top border-dark'
                      },
                      {
                        title: 'block border-top border-white',
                        selector: this.blockSelector,
                        classes: 'border-top border-white'
                      }
                    ]
                  },
                  {
                    title: 'right',
                    items: [
                      {
                        title: 'block border-right border-primary',
                        selector: this.blockSelector,
                        classes: 'border-right border-primary'
                      },
                      {
                        title: 'block border-right border-secondary',
                        selector: this.blockSelector,
                        classes: 'border-right border-secondary'
                      },
                      {
                        title: 'block border-right border-success',
                        selector: this.blockSelector,
                        classes: 'border-right border-success'
                      },
                      {
                        title: 'block border-right border-danger',
                        selector: this.blockSelector,
                        classes: 'border-right border-danger'
                      },
                      {
                        title: 'block border-right border-warning',
                        selector: this.blockSelector,
                        classes: 'border-right border-warning'
                      },
                      {
                        title: 'block border-right border-info',
                        selector: this.blockSelector,
                        classes: 'border-right border-info'
                      },
                      {
                        title: 'block border-right border-light',
                        selector: this.blockSelector,
                        classes: 'border-right border-light'
                      },
                      {
                        title: 'block border-right border-dark',
                        selector: this.blockSelector,
                        classes: 'border-right border-dark'
                      },
                      {
                        title: 'block border-right border-white',
                        selector: this.blockSelector,
                        classes: 'border-right border-white'
                      }
                    ]
                  },
                  {
                    title: 'bottom',
                    items: [
                      {
                        title: 'block border-bottom border-primary',
                        selector: this.blockSelector,
                        classes: 'border-bottom border-primary'
                      },
                      {
                        title: 'block border-bottom border-secondary',
                        selector: this.blockSelector,
                        classes: 'border-bottom border-secondary'
                      },
                      {
                        title: 'block border-bottom border-success',
                        selector: this.blockSelector,
                        classes: 'border-bottom border-success'
                      },
                      {
                        title: 'block border-bottom border-danger',
                        selector: this.blockSelector,
                        classes: 'border-bottom border-danger'
                      },
                      {
                        title: 'block border-bottom border-warning',
                        selector: this.blockSelector,
                        classes: 'border-bottom border-warning'
                      },
                      {
                        title: 'block border-bottom border-info',
                        selector: this.blockSelector,
                        classes: 'border-bottom border-info'
                      },
                      {
                        title: 'block border-bottom border-light',
                        selector: this.blockSelector,
                        classes: 'border-bottom border-light'
                      },
                      {
                        title: 'block border-bottom border-dark',
                        selector: this.blockSelector,
                        classes: 'border-bottom border-dark'
                      },
                      {
                        title: 'block border-bottom border-white',
                        selector: this.blockSelector,
                        classes: 'border-bottom border-white'
                      }
                    ]
                  },
                  {
                    title: 'left',
                    items: [
                      {
                        title: 'block border-left border-primary',
                        selector: this.blockSelector,
                        classes: 'border-left border-primary'
                      },
                      {
                        title: 'block border-left border-secondary',
                        selector: this.blockSelector,
                        classes: 'border-left border-secondary'
                      },
                      {
                        title: 'block border-left border-success',
                        selector: this.blockSelector,
                        classes: 'border-left border-success'
                      },
                      {
                        title: 'block border-left border-danger',
                        selector: this.blockSelector,
                        classes: 'border-left border-danger'
                      },
                      {
                        title: 'block border-left border-warning',
                        selector: this.blockSelector,
                        classes: 'border-left border-warning'
                      },
                      {
                        title: 'block border-left border-info',
                        selector: this.blockSelector,
                        classes: 'border-left border-info'
                      },
                      {
                        title: 'block border-left border-light',
                        selector: this.blockSelector,
                        classes: 'border-left border-light'
                      },
                      {
                        title: 'block border-left border-dark',
                        selector: this.blockSelector,
                        classes: 'border-left border-dark'
                      },
                      {
                        title: 'block border-left border-white',
                        selector: this.blockSelector,
                        classes: 'border-left border-white'
                      }
                    ]
                  },
                  {
                    title: 'radius',
                    items: [
                      {
                        title: 'block rounded',
                        selector: this.blockSelector,
                        classes: 'rounded'
                      },
                      {
                        title: 'block rounded-top',
                        selector: this.blockSelector,
                        classes: 'rounded-top'
                      },
                      {
                        title: 'block rounded-right',
                        selector: this.blockSelector,
                        classes: 'rounded-right'
                      },
                      {
                        title: 'block rounded-bottom',
                        selector: this.blockSelector,
                        classes: 'rounded-bottom'
                      },
                      {
                        title: 'block rounded-left',
                        selector: this.blockSelector,
                        classes: 'rounded-left'
                      },
                      {
                        title: 'block rounded-circle',
                        selector: this.blockSelector,
                        classes: 'rounded-circle'
                      },
                      {
                        title: 'block rounded-pill',
                        selector: this.blockSelector,
                        classes: 'rounded-pill'
                      },
                      {
                        title: 'block rounded-0',
                        selector: this.blockSelector,
                        classes: 'rounded-0'
                      }
                    ]
                  }
                ]
              }
            ]
          },
          {
            title: 'Container styles',
            items: [
              {
                title: 'Color',
                items: [
                  {
                    title: 'container text-primary',
                    selector: this.containerSelector,
                    classes: 'text-primary'
                  },
                  {
                    title: 'container text-secondary',
                    selector: this.containerSelector,
                    classes: 'text-secondary'
                  },
                  {
                    title: 'container text-success',
                    selector: this.containerSelector,
                    classes: 'text-success'
                  },
                  {
                    title: 'container text-danger',
                    selector: this.containerSelector,
                    classes: 'text-danger'
                  },
                  {
                    title: 'container text-warning',
                    selector: this.containerSelector,
                    classes: 'text-warning'
                  },
                  {
                    title: 'container text-info',
                    selector: this.containerSelector,
                    classes: 'text-info'
                  },
                  {
                    title: 'container text-light',
                    selector: this.containerSelector,
                    classes: 'text-light'
                  },
                  {
                    title: 'container text-dark',
                    selector: this.containerSelector,
                    classes: 'text-dark'
                  },
                  {
                    title: 'container text-body',
                    selector: this.containerSelector,
                    classes: 'text-body'
                  },
                  {
                    title: 'container text-muted',
                    selector: this.containerSelector,
                    classes: 'text-muted'
                  },
                  {
                    title: 'container text-white',
                    selector: this.containerSelector,
                    classes: 'text-white'
                  },
                  {
                    title: 'container text-black-50',
                    selector: this.containerSelector,
                    classes: 'text-black-50'
                  },
                  {
                    title: 'container text-white-50',
                    selector: this.containerSelector,
                    classes: 'text-white-50'
                  }
                ]
              },
              {
                title: 'Background',
                items: [
                  {
                    title: 'container bg-primary',
                    selector: this.containerSelector,
                    classes: 'bg-primary'
                  },
                  {
                    title: 'container bg-secondary',
                    selector: this.containerSelector,
                    classes: 'bg-secondary'
                  },
                  {
                    title: 'container bg-success',
                    selector: this.containerSelector,
                    classes: 'bg-success'
                  },
                  {
                    title: 'container bg-danger',
                    selector: this.containerSelector,
                    classes: 'bg-danger'
                  },
                  {
                    title: 'container bg-warning',
                    selector: this.containerSelector,
                    classes: 'bg-warning'
                  },
                  {
                    title: 'container bg-info',
                    selector: this.containerSelector,
                    classes: 'bg-info'
                  },
                  {
                    title: 'container bg-light',
                    selector: this.containerSelector,
                    classes: 'bg-light'
                  },
                  {
                    title: 'container bg-dark',
                    selector: this.containerSelector,
                    classes: 'bg-dark'
                  },
                  {
                    title: 'container bg-white',
                    selector: this.containerSelector,
                    classes: 'bg-white'
                  },
                  {
                    title: 'container bg-transparent',
                    selector: this.containerSelector,
                    classes: 'bg-transparent'
                  }
                ]
              },
              {
                title: 'Border',
                items: [
                  {
                    title: 'all',
                    items: [
                      {
                        title: 'container border border-primary',
                        selector: this.containerSelector,
                        classes: 'border border-primary'
                      },
                      {
                        title: 'container border border-secondary',
                        selector: this.containerSelector,
                        classes: 'border border-secondary'
                      },
                      {
                        title: 'container border border-success',
                        selector: this.containerSelector,
                        classes: 'border border-success'
                      },
                      {
                        title: 'container border border-danger',
                        selector: this.containerSelector,
                        classes: 'border border-danger'
                      },
                      {
                        title: 'container border border-warning',
                        selector: this.containerSelector,
                        classes: 'border border-warning'
                      },
                      {
                        title: 'container border border-info',
                        selector: this.containerSelector,
                        classes: 'border border-info'
                      },
                      {
                        title: 'container border border-light',
                        selector: this.containerSelector,
                        classes: 'border border-light'
                      },
                      {
                        title: 'container border border-dark',
                        selector: this.containerSelector,
                        classes: 'border border-dark'
                      },
                      {
                        title: 'container border border-white',
                        selector: this.containerSelector,
                        classes: 'border border-white'
                      }
                    ]
                  },
                  {
                    title: 'top',
                    items: [
                      {
                        title: 'container border-top border-primary',
                        selector: this.containerSelector,
                        classes: 'border-top border-primary'
                      },
                      {
                        title: 'container border-top border-secondary',
                        selector: this.containerSelector,
                        classes: 'border-top border-secondary'
                      },
                      {
                        title: 'container border-top border-success',
                        selector: this.containerSelector,
                        classes: 'border-top border-success'
                      },
                      {
                        title: 'container border-top border-danger',
                        selector: this.containerSelector,
                        classes: 'border-top border-danger'
                      },
                      {
                        title: 'container border-top border-warning',
                        selector: this.containerSelector,
                        classes: 'border-top border-warning'
                      },
                      {
                        title: 'container border-top border-info',
                        selector: this.containerSelector,
                        classes: 'border-top border-info'
                      },
                      {
                        title: 'container border-top border-light',
                        selector: this.containerSelector,
                        classes: 'border-top border-light'
                      },
                      {
                        title: 'container border-top border-dark',
                        selector: this.containerSelector,
                        classes: 'border-top border-dark'
                      },
                      {
                        title: 'container border-top border-white',
                        selector: this.containerSelector,
                        classes: 'border-top border-white'
                      }
                    ]
                  },
                  {
                    title: 'right',
                    items: [
                      {
                        title: 'container border-right border-primary',
                        selector: this.containerSelector,
                        classes: 'border-right border-primary'
                      },
                      {
                        title: 'container border-right border-secondary',
                        selector: this.containerSelector,
                        classes: 'border-right border-secondary'
                      },
                      {
                        title: 'container border-right border-success',
                        selector: this.containerSelector,
                        classes: 'border-right border-success'
                      },
                      {
                        title: 'container border-right border-danger',
                        selector: this.containerSelector,
                        classes: 'border-right border-danger'
                      },
                      {
                        title: 'container border-right border-warning',
                        selector: this.containerSelector,
                        classes: 'border-right border-warning'
                      },
                      {
                        title: 'container border-right border-info',
                        selector: this.containerSelector,
                        classes: 'border-right border-info'
                      },
                      {
                        title: 'container border-right border-light',
                        selector: this.containerSelector,
                        classes: 'border-right border-light'
                      },
                      {
                        title: 'container border-right border-dark',
                        selector: this.containerSelector,
                        classes: 'border-right border-dark'
                      },
                      {
                        title: 'container border-right border-white',
                        selector: this.containerSelector,
                        classes: 'border-right border-white'
                      }
                    ]
                  },
                  {
                    title: 'bottom',
                    items: [
                      {
                        title: 'container border-bottom border-primary',
                        selector: this.containerSelector,
                        classes: 'border-bottom border-primary'
                      },
                      {
                        title: 'container border-bottom border-secondary',
                        selector: this.containerSelector,
                        classes: 'border-bottom border-secondary'
                      },
                      {
                        title: 'container border-bottom border-success',
                        selector: this.containerSelector,
                        classes: 'border-bottom border-success'
                      },
                      {
                        title: 'container border-bottom border-danger',
                        selector: this.containerSelector,
                        classes: 'border-bottom border-danger'
                      },
                      {
                        title: 'container border-bottom border-warning',
                        selector: this.containerSelector,
                        classes: 'border-bottom border-warning'
                      },
                      {
                        title: 'container border-bottom border-info',
                        selector: this.containerSelector,
                        classes: 'border-bottom border-info'
                      },
                      {
                        title: 'container border-bottom border-light',
                        selector: this.containerSelector,
                        classes: 'border-bottom border-light'
                      },
                      {
                        title: 'container border-bottom border-dark',
                        selector: this.containerSelector,
                        classes: 'border-bottom border-dark'
                      },
                      {
                        title: 'container border-bottom border-white',
                        selector: this.containerSelector,
                        classes: 'border-bottom border-white'
                      }
                    ]
                  },
                  {
                    title: 'left',
                    items: [
                      {
                        title: 'container border-left border-primary',
                        selector: this.containerSelector,
                        classes: 'border-left border-primary'
                      },
                      {
                        title: 'container border-left border-secondary',
                        selector: this.containerSelector,
                        classes: 'border-left border-secondary'
                      },
                      {
                        title: 'container border-left border-success',
                        selector: this.containerSelector,
                        classes: 'border-left border-success'
                      },
                      {
                        title: 'container border-left border-danger',
                        selector: this.containerSelector,
                        classes: 'border-left border-danger'
                      },
                      {
                        title: 'container border-left border-warning',
                        selector: this.containerSelector,
                        classes: 'border-left border-warning'
                      },
                      {
                        title: 'container border-left border-info',
                        selector: this.containerSelector,
                        classes: 'border-left border-info'
                      },
                      {
                        title: 'container border-left border-light',
                        selector: this.containerSelector,
                        classes: 'border-left border-light'
                      },
                      {
                        title: 'container border-left border-dark',
                        selector: this.containerSelector,
                        classes: 'border-left border-dark'
                      },
                      {
                        title: 'container border-left border-white',
                        selector: this.containerSelector,
                        classes: 'border-left border-white'
                      }
                    ]
                  },
                  {
                    title: 'radius',
                    items: [
                      {
                        title: 'container rounded',
                        selector: this.containerSelector,
                        classes: 'rounded'
                      },
                      {
                        title: 'container rounded-top',
                        selector: this.containerSelector,
                        classes: 'rounded-top'
                      },
                      {
                        title: 'container rounded-right',
                        selector: this.containerSelector,
                        classes: 'rounded-right'
                      },
                      {
                        title: 'container rounded-bottom',
                        selector: this.containerSelector,
                        classes: 'rounded-bottom'
                      },
                      {
                        title: 'container rounded-left',
                        selector: this.containerSelector,
                        classes: 'rounded-left'
                      },
                      {
                        title: 'container rounded-circle',
                        selector: this.containerSelector,
                        classes: 'rounded-circle'
                      },
                      {
                        title: 'container rounded-pill',
                        selector: this.containerSelector,
                        classes: 'rounded-pill'
                      },
                      {
                        title: 'container rounded-0',
                        selector: this.containerSelector,
                        classes: 'rounded-0'
                      }
                    ]
                  }
                ]
              }
            ]
          }
        ];
      }
      StyleFormatConfig.prototype.getStyleFormats = function () {
        return this.editorStyleFormats;
      };
      return StyleFormatConfig;
    }();

    var getAll = function () {
      return {
        alert: '<svg width="24" height="24"><path d="M13.9 8l-1.4 5.3h-1L10.2 8h3.7zM12.8 14v2.2h-1.6V14h1.6zm-.8 6.5c-4.7 0-8.6-3.9-8.6-8.6S7.3 3.4 12 3.4s8.6 3.9 8.6 8.6-3.9 8.6-8.6 8.6zm0-14.8a6.2 6.2 0 1 0 0 12.4 6.2 6.2 0 0 0 0-12.4z"/></svg>',
        badge: '<svg width="24" height="24"><path d="M6.3 12.8v.1h1.9v-1.2V10l-1.9 2.8zm12.1-8H5.6c-1.2 0-2.2 1-2.2 2.1v10.2c0 1.2 1 2.1 2.2 2.1h12.8c1.2 0 2.2-1 2.2-2.1V6.9c0-1.2-1-2.1-2.2-2.1zm-7.2 8.8H9.8V15l.1.3.2.1.3.1v.4H7.6v-.4h.3l.2-.2v-.3l.1-.4v-.9h-3V13l3.3-4.8h1.3V13h.5l.2-.2.2-.3h.6l-.1 1.2zm6 2.2h-5v-.4l.7-1.1a25.9 25.9 0 0 1 2-2.5l.4-.9.2-.8c0-.4-.1-.8-.3-1s-.4-.3-.7-.3c-.3 0-.6 0-.8.3l-.4 1h-1V8.8l1-.4.8-.1h.8l1.3.1.8.6c.2.2.2.6.2.9l-.1.8-.6.8-1.3 1.4-.8.8-.6.7h2.5l.3-.2.1-.4h.7l-.2 2z"/></svg>',
        bootstrap: '<svg width="24" height="24"><path d="M16.7 11.7c2 1 2.8 2.6 2.6 4.6-.4 2.1-1.5 3.4-3.6 3.8-1 .2-2.2.2-3.3.2H6v-16H14c2.3 0 4 1.2 4.4 3 .3 1.8-.1 3.3-1.8 4.4zM9 17.8h4.8c1.4 0 2.3-.8 2.4-2 .1-1.4-.6-2.4-2-2.5-1.7-.2-3.4 0-5.2 0v4.5zm0-11v4h4.6c1.2 0 1.8-.8 1.8-2s-.5-2-1.8-2H9z"/></svg>',
        breadcrumb: '<svg width="24" height="24"><path d="M17.4 8.8h-6.5l3.2 4.3-3.2 4.3h6.5l3.2-4.3zm-9.7 0H3.4v8.6h4.3L11 13z"/></svg>',
        btn: '<svg width="24" height="24"><path d="M19.5 5h-15a1 1 0 0 0-1 1.1v6.4c0 .6.4 1.1 1 1.1h6.6v-1.8-.1-.3c.1-.3.3-.4.6-.4.2 0 .4.1.5.4v1.1h.1V13.1h.5c.3 0 .5.1.6.4v.1h.1v-.1h5.9c.6 0 1.1-.4 1.1-1V6.1c0-.6-.4-1-1-1zm-8 15.1c-.1 0-.2 0-.2-.2-.4-1.7-1.1-3-2.1-4l-.1-.3c0-.6.3-1 .7-1 .3-.1.6 0 1 .3v-3-.2-.4c.3-.4.6-.5.9-.6.2 0 .6.2.8.6v1.5h.2c.4 0 .7.2.8.5h.5c.3 0 .6.1.8.5h.4c.4 0 .7.2.9.6v1a13.7 13.7 0 0 1-.8 4.6l-.2.2h-3.6zm-1.9-4.5c1 1 1.7 2.3 2.1 4H15a13.3 13.3 0 0 0 .7-4.2v-.5-.1-.3l-.4-.2H15v1c0 .2-.2.3-.3.3a.3.3 0 0 1-.3-.3v-1-.2c-.1-.2-.2-.3-.4-.3h-.3V14.7c0 .2 0 .3-.2.3s-.3-.1-.3-.3V14v-.1-.2c-.1-.2-.2-.3-.4-.3h-.3v1s0 .2-.2.2-.3-.1-.3-.3v-2.5-.3l-.3-.2c-.1 0-.3 0-.3.2v4.2l-.3.2H11c-.6-.8-.9-.8-1-.8 0 0-.2 0-.3.5z"/></svg>',
        card: '<svg width="24" height="24"><path d="M19.5 5.3h-15a1 1 0 0 0-1 1v11c0 1 .7 1.7 1.7 1.7h13.6c1 0 1.8-.8 1.8-1.7v-11c0-.5-.5-1-1.1-1zm-.5 12H5.2 5V12h14v5.3z"/></svg>',
        check: '<svg width="24" height="24"><path d="M17.9 5.6l-8 8L6 10l-2.7 2.6L10 19 20.6 8.3z"/></svg>',
        cross: '<svg width="24" height="24"><path d="M23.8 19.3L16.5 12l7.3-7.3.2-.2c0-.3 0-.6-.2-.8L20.3.2a.8.8 0 0 0-1 0L12 7.5 4.7.2 4.4 0a.7.7 0 0 0-.7.2L.2 3.7a.8.8 0 0 0 0 1L7.5 12 .2 19.3l-.2.2c0 .3 0 .6.2.8l3.5 3.5a.8.8 0 0 0 1 0l7.3-7.3 7.3 7.3.2.2c.3 0 .6 0 .8-.2l3.5-3.5a.8.8 0 0 0 0-1z"/></svg>',
        desktop: '<svg width="24" height="24"><path d="M3.4 5.2v10h7L9 17.4H15l-1.3-2.2h7v-10H3.4zm15.7 8.6H5V6.6H19v7.2zM15.6 18H8.4a.7.7 0 0 0 0 1.4h7.2a.7.7 0 0 0 0-1.4z"/></svg>',
        icon: '<svg width="24" height="24"><path d="M3.4 9c0-.6.2-1.3.5-2 .3-.6.6-1.1 1.1-1.5.5-.5 1-.8 1.6-1l1.9-.3c.6 0 1.3.2 1.8.6.7.3 1.3.9 1.7 1.6.5-.7 1-1.3 1.7-1.6s1.3-.5 2-.6A5 5 0 0 1 19 5.5c.4.4.8 1 1 1.6.4.6.5 1.3.5 1.9s-.2 1.2-.6 1.8c-.3.7-.8 1.3-1.5 2l-1.9 2-2.4 2.3-2.2 2.7a25 25 0 0 0-2.3-2.7c-.8-1-1.6-1.7-2.3-2.3l-2-2c-.6-.6-1-1.3-1.4-2-.4-.6-.6-1.3-.6-1.8z"/></svg>',
        image: '<svg width="24" height="24"><path d="M19.5 5.6v12.8h-15V5.6h15zm0-1.1h-15a1 1 0 0 0-1 1v13c0 .5.4 1 1 1h15c.6 0 1-.5 1-1v-13c0-.5-.4-1-1-1zm-2.1 3.8a1.6 1.6 0 1 1-3.3 0 1.6 1.6 0 0 1 3.3 0zm1 9H5.6v-2l3.7-6.5 4.3 5.3h1l3.8-3.2z"/></svg>',
        label: '<svg width="24" height="24"><path d="M19.1 10l-2-6.2-6.5 2-5.7 10.6 8.4 4.5L19 10.4l.1-.3zm-3-.3A2 2 0 1 1 12.6 8a2 2 0 0 1 3.5 1.8z"/></svg>',
        minus: '<svg width="24" height="24"><path d="M5.143 10.714v2.571c0 0.237 0.192 0.429 0.429 0.429h12.857c0.237 0 0.429-0.192 0.429-0.429v-2.571c0-0.237-0.192-0.429-0.429-0.429h-12.857c-0.237 0-0.429 0.192-0.429 0.429z"></path></svg>',
        mobile: '<svg width="24" height="24"><path d="M14.9 6H9c-.7 0-1.4.6-1.4 1.4v10c0 .7.7 1.4 1.4 1.4H15c.7 0 1.4-.7 1.4-1.4v-10c0-.8-.7-1.5-1.4-1.5zm-2.2 12h-1.4v-1.4h1.4v1.5zm2.2-2H9V7.3H15v8.5z"/></svg>',
        pager: '<svg width="24" height="24"><path d="M15.4 5.1H8.6a5.1 5.1 0 0 0-5.2 5.2v3.4c0 2.9 2.3 5.2 5.2 5.2h6.8c2.9 0 5.2-2.3 5.2-5.2v-3.4c0-2.9-2.3-5.2-5.2-5.2zM12 16.3v-2.9H6.3v-2.8H12V7.7l5.7 4.3-5.7 4.3z"/></svg>',
        pagination: '<svg width="24" height="24"><path d="M8.2 13.6v.4l.1.2h.2l.3.1h.5v.4H5.9v-.3l.6-.1.3-.1.2-.2V10.8v-.2l-.2-.1h-.3L6 11l-.2-.4 2-1.2h.6v4.3zm3.3 3.2h-8V7.2h8v9.6zM4 16.3h7V7.7H4v8.6zm14.6-2.7l-.1 1.1h-4v-1l.6-.5 1.6-1.3c.3-.3.5-.6.5-1 0-.1 0-.3-.2-.4l-.5-.2c-.5 0-.8.3-1 1l-1-.3c.2-1.1 1-1.7 2-1.7.7 0 1.2.1 1.5.5.3.3.5.7.5 1.2 0 .4-.2.9-.5 1.2l-2 1.5h2.6zm2 3.2h-8V7.2h8v9.6zm-7.5-.5h7V7.7h-7v8.6z"/></svg>',
        edit: '<svg width="24" height="24"><path d="M10.080 13.92l1.92-0.96 6.72-6.72-0.96-0.96-6.72 6.72-0.96 1.92zM8.659 17.326c-0.474-1.001-0.985-1.511-1.986-1.986l1.486-4.092 1.92-1.169 5.76-5.76h-2.88l-5.76 5.76-2.88 9.6 9.6-2.88 5.76-5.76v-2.88l-5.76 5.76-1.169 1.92z"></path></svg>',
        move: '<svg width="24" height="24"><path d="M19.68 4.32h-6.24l2.4 2.4-2.88 2.88 1.44 1.44 2.88-2.88 2.4 2.4z"></path> <path d="M19.68 19.68v-6.24l-2.4 2.4-2.88-2.88-1.44 1.44 2.88 2.88-2.4 2.4z"></path> <path d="M4.32 19.68h6.24l-2.4-2.4 2.88-2.88-1.44-1.44-2.88 2.88-2.4-2.4z"></path> <path d="M4.32 4.32v6.24l2.4-2.4 2.88 2.88 1.44-1.44-2.88-2.88 2.4-2.4z"></path></svg>',
        plus: '<svg width="24" height="24"><path d="M18.429 10.286h-4.714v-4.714c0-0.237-0.192-0.429-0.429-0.429h-2.571c-0.237 0-0.429 0.192-0.429 0.429v4.714h-4.714c-0.237 0-0.429 0.192-0.429 0.429v2.571c0 0.237 0.192 0.429 0.429 0.429h4.714v4.714c0 0.237 0.192 0.429 0.429 0.429h2.571c0.237 0 0.429-0.192 0.429-0.429v-4.714h4.714c0.237 0 0.429-0.192 0.429-0.429v-2.571c0-0.237-0.192-0.429-0.429-0.429z"></path></svg>',
        snippet: '<svg width="24" height="24"><path d="M20.6 10l-6-.8L12 3.8 9.4 9.2l-6 .9 4.3 4.2-1 5.9 5.3-2.8 5.3 2.8-1-6 4.3-4.1z"/></svg>',
        tab: '<svg width="24" height="24"><path d="M18.72 4.32h0.96v7.68h-0.96v-7.68z"></path> <path d="M4.32 12h0.96v7.68h-0.96v-7.68z"></path> <path d="M9.12 14.88h10.56v1.92h-10.56v2.4l-3.36-3.36 3.36-3.36v2.4z"></path> <path d="M14.88 9.12h-10.56v-1.92h10.56v-2.4l3.36 3.36-3.36 3.36z"></path></svg>',
        tabvertical: '<svg width="24" height="24"><path d="M19.7,18.7v1H12v-1H19.7z"/> <path d="M12,4.3v1H4.3v-1H12z"/> <path d="M9.1,9.1v10.6H7.2V9.1H4.8l3.4-3.4l3.4,3.4C11.5,9.1,9.1,9.1,9.1,9.1z"/> <path d="M14.9,14.9V4.3h1.9v10.6h2.4l-3.4,3.4l-3.4-3.4H14.9z"/></svg>',
        table: '<svg width="24" height="24"><path d="M3.4 3.4h17.2v4.3H3.4V3.4zm0 7.5h17.2V12H3.4v-1zm0 4.3h17.2v1H3.4v-1zm0 4.3h17.2v1H3.4v-1zm0-16h1.1v17h-1v-17zm16.1 0h1v17h-1v-17zm-5.4 0h1.1v17h-1v-17zm-5.3 0h1v17h-1v-17z"/></svg>',
        tablethorizontal: '<svg width="24" height="24"><path d="M19.9 17.4v-10c0-.8-.7-1.5-1.5-1.5H5.6C4.8 6 4 6.6 4 7.4v10c0 .7.7 1.4 1.5 1.4h12.8c.8 0 1.5-.7 1.5-1.4zM4.9 13v-1.5h1.4v1.5H4.9zM7 17.4v-10h11.4v10H7z"/></svg>',
        tablet: '<svg width="24" height="24"><path d="M17 4.5H7c-.8 0-1.4.6-1.4 1.4v12.9c0 .8.6 1.4 1.4 1.4h10c.8 0 1.4-.6 1.4-1.4V5.9c0-.8-.6-1.4-1.4-1.4zm-4.3 15h-1.4v-1.4h1.4v1.4zm4.3-2.1H7V5.9h10v11.5z"/></svg>',
        template: '<svg width="24" height="24"><path d="M3.4 3.4h11.8v11.8H3.4V3.4zm5.4 12.9h11.8v4.3H8.8v-4.3zm7.5-12.9h4.3v11.8h-4.3V3.4zM3.4 16.3h4.3v4.3H3.4v-4.3z"/></svg>'
      };
    };

    var BootstrapPlugin = function () {
      function BootstrapPlugin(editor, url) {
        var _this = this;
        this.headStyles = [];
        this.styleFormatsActive = [];
        this.validParagraphParents = [
          'a',
          'article',
          'aside',
          'blockquote',
          'body',
          'caption',
          'dd',
          'dialog',
          'div',
          'figcaption',
          'figure',
          'footer',
          'form',
          'header',
          'li',
          'main',
          'nav',
          'section',
          'td',
          'th'
        ];
        this.editor = editor;
        this.uiButtons = {};
        this.$ = tinymce.dom.DomQuery;
        if (typeof this.editor.settings.bootstrapConfig === 'undefined') {
          alert('Error: bootstrapConfig is not defined - you must init tinyMce with at least bootstrapConfig.url\nThe url must lead to the "bootstrap" folder');
        }
        this.pluginUrl = editor.settings.bootstrapConfig.url.replace(/\/?$/, '/');
        Object.assign(this, defaultConfig);
        Object.assign(this, editor.settings.bootstrapConfig);
        this.jsonSnippetsUrl = editor.settings.bootstrapConfig.jsonSnippetsUrl || this.pluginUrl + 'snippets/snippets.json';
        this.jsonTemplatesUrl = editor.settings.bootstrapConfig.jsonTemplatesUrl || this.pluginUrl + 'templates/templates.json';
        this.imagesPath = editor.settings.bootstrapConfig.imagesPath || this.pluginUrl + defaultConfig.imagesPath;
        this.imagesPath = this.imagesPath.replace(/\/?$/, '/');
        var icf = iconFonts[this.iconFont];
        this.iconBaseClasses = icf.baseClasses;
        this.iconSearchClass = icf.selector;
        this.iconCss = icf.css;
        this.editor.settings.content_css = this.getContentCss();
        this.editorIcons = getAll();
        for (var _i = 0, _a = Object.entries(this.editorIcons); _i < _a.length; _i++) {
          var _b = _a[_i], key = _b[0], value = _b[1];
          value = value.replace('<svg', '<svg class="bs-icon" id="bs-icon-' + key + '"');
          this.editor.ui.registry.addIcon(key, value);
        }
        this.editor.ui.registry.addMenuItem('addParagraphBefore', {
          icon: 'chevron-left',
          text: tinymce.util.I18n.translate('Add paragraph before'),
          onAction: function () {
            _this.addParagraph(_this.editor.selection.getNode(), 'before');
          }
        });
        this.editor.ui.registry.addMenuItem('addParagraphAfter', {
          icon: 'chevron-right',
          text: tinymce.util.I18n.translate('Add paragraph after'),
          onAction: function () {
            _this.addParagraph(_this.editor.selection.getNode(), 'after');
          }
        });
        this.editor.ui.registry.addMenuItem('addParagraphAtBeginning', {
          icon: 'chevron-left',
          text: tinymce.util.I18n.translate('Add paragraph at beginning'),
          onAction: function () {
            _this.addParagraph(_this.editor.selection.getNode(), 'beginning');
          }
        });
        this.editor.ui.registry.addMenuItem('addParagraphAtEnd', {
          icon: 'chevron-right',
          text: tinymce.util.I18n.translate('Add paragraph at end'),
          onAction: function () {
            _this.addParagraph(_this.editor.selection.getNode(), 'end');
          }
        });
        this.editor.ui.registry.addMenuItem('addParagraphAtBeginningContainer', {
          icon: 'chevron-left',
          text: tinymce.util.I18n.translate('Add paragraph at beginning container'),
          onAction: function () {
            _this.addParagraph(_this.editor.selection.getNode(), 'beginningContainer');
          }
        });
        this.editor.ui.registry.addMenuItem('addParagraphAtEndContainer', {
          icon: 'chevron-right',
          text: tinymce.util.I18n.translate('Add paragraph at end container'),
          onAction: function () {
            _this.addParagraph(_this.editor.selection.getNode(), 'endContainer');
          }
        });
        this.editor.ui.registry.addMenuItem('enableTemplateEdition', {
          icon: 'edit-block',
          text: tinymce.util.I18n.translate('Enable Template Edition'),
          onAction: function () {
            tinymce.dom.DomQuery(_this.editor.dom.select('body')).addClass('templatesEnabled');
            _this.enableTemplateEdition = true;
          }
        });
        this.editor.ui.registry.addMenuItem('disableTemplateEdition', {
          icon: 'edit-block',
          text: tinymce.util.I18n.translate('Disable Template Edition'),
          onAction: function () {
            tinymce.dom.DomQuery(_this.editor.dom.select('body')).removeClass('templatesEnabled');
            tinymce.dom.DomQuery(_this.editor.dom.select('.tbp-context-active')).removeClass('tbp-context-active').children('.context-trigger-wrapper').remove();
            _this.enableTemplateEdition = false;
          }
        });
        if (this.hasToolbar === true) {
          if (this.toolbarStyle === 'buttons') {
            this.editor.ui.registry.addButton('bootstrap', {
              icon: 'bootstrap',
              tooltip: tinymce.util.I18n.translate('Bootstrap Elements'),
              onSetup: function (buttonApi) {
                _this.$('#bs-icon-bootstrap').closest('[role="toolbar"]').attr('id', 'bs-toolbar');
                _this.$('#bs-icon-bootstrap').closest('button').attr('id', 'bs-btn-bootstrap');
              },
              onAction: function () {
              }
            });
            var _loop_1 = function (key, value) {
              if (this_1.elements[key]) {
                if (key === 'template') {
                  this_1.createContextToolbars(value);
                }
                this_1.editor.ui.registry.addButton('bs-' + key, {
                  text: '',
                  icon: value.icon,
                  tooltip: tinymce.util.I18n.translate(value.tooltip),
                  onSetup: function (buttonApi) {
                    _this.$('#' + _this.editor.id).next('.tox-tinymce').find(' #bs-icon-' + key).closest('button').attr('id', _this.editor.id + '-bs-btn-' + key);
                    _this.uiButtons[key] = _this.$('#' + _this.editor.id + '-bs-btn-' + key);
                  },
                  onAction: function () {
                    var instanceApi = _this.editor.windowManager.openUrl({
                      icon: _this.editorIcons.bootstrap,
                      title: value.tooltip,
                      url: _this.pluginUrl + 'dialogs/' + value.text.toLowerCase() + '.html',
                      buttons: [
                        {
                          type: 'cancel',
                          text: tinymce.util.I18n.translate('Cancel'),
                          name: 'cancel',
                          primary: false
                        },
                        {
                          type: 'custom',
                          text: tinymce.util.I18n.translate('OK'),
                          name: 'OK',
                          primary: true
                        }
                      ],
                      initialData: { outputCode: '' },
                      onAction: function (instance, trigger) {
                        instance.sendMessage({ mceAction: 'customInsertAndClose' });
                      },
                      size: 'large'
                    });
                  }
                });
              }
            };
            var this_1 = this;
            for (var _c = 0, _d = Object.entries(bsItems); _c < _d.length; _c++) {
              var _e = _d[_c], key = _e[0], value = _e[1];
              _loop_1(key, value);
            }
          }
        }
        if ((this.editor.settings.verify_html !== false || this.editor.settings.valid_elements !== '*[*]') && this.editor.settings.bootstrapConfig.overwriteValidElements !== false) {
          this.editor.settings.valid_elements = this.getValidElements();
        }
        var outputStyleFormats = [];
        var activeKeys = [];
        if (this.editor.settings.style_formats !== undefined) {
          outputStyleFormats.push(this.editor.settings.style_formats);
        }
        if (this.editor.settings.style_formats_merge === true) {
          activeKeys.push('Headers', 'Blocks', 'Containers', 'Images');
        }
        if (this.editorStyleFormats.textStyles === true || this.editorStyleFormats.blockStyles === true || this.editorStyleFormats.containerStyles === true) {
          activeKeys.push('STYLES');
        }
        if (this.editorStyleFormats.textStyles === true) {
          activeKeys.push('Text styles');
        }
        if (this.editorStyleFormats.blockStyles === true) {
          activeKeys.push('Block styles');
        }
        if (this.editorStyleFormats.containerStyles === true) {
          activeKeys.push('Container styles');
        }
        this.styleFormatConfig = new StyleFormatConfig();
        this.styleFormatsAll = this.styleFormatConfig.getStyleFormats();
        this.styleFormatsAll.forEach(function (format) {
          if (activeKeys.includes(format.title)) {
            var stylesToTest = [
              'Text styles',
              'Block styles',
              'Container styles'
            ];
            if (stylesToTest.includes(format.title)) {
              var tempFormat_1 = {
                title: format.title,
                items: []
              };
              var props = format.items;
              var propsToTest_1 = [
                'Margin',
                'Padding'
              ];
              props.forEach(function (prop) {
                if (propsToTest_1.includes(prop.title)) {
                  var tempProps_1 = {
                    title: prop.title,
                    items: []
                  };
                  var screensToTest = {
                    xs: 'All screens',
                    sm: 'Small screens and larger',
                    md: 'Medium screens and larger',
                    lg: 'Large screens'
                  };
                  Object.entries(screensToTest).forEach(function (_a) {
                    var screenKey = _a[0], screenTitle = _a[1];
                    if (_this.editorStyleFormats.responsive.includes(screenKey)) {
                      var tempScreen_1 = {
                        title: screenTitle,
                        items: []
                      };
                      var spacings = _this.editorStyleFormats.spacing;
                      spacings.forEach(function (spacingTitle) {
                        var spItems = _this.findStyleFormatItems(format.title, prop.title, screenTitle, spacingTitle);
                        tempScreen_1.items.push(spItems);
                        if (_this.editorStyleFormats.responsive.length < 2 && _this.editorStyleFormats.responsive[0] === 'xs') {
                          tempProps_1.items.push(spItems);
                        }
                        spItems.items.forEach(function (item) {
                          if ('classes' in item) {
                            _this.addStyleFormat(item);
                          }
                        });
                      });
                      if (_this.editorStyleFormats.responsive.length > 1 || _this.editorStyleFormats.responsive[0] !== 'xs') {
                        tempProps_1.items.push(tempScreen_1);
                      }
                    }
                  });
                  tempFormat_1.items.push(tempProps_1);
                } else {
                  tempFormat_1.items.push(prop);
                  prop.items.forEach(function (item) {
                    if ('classes' in item) {
                      _this.addStyleFormat(item);
                    } else if ('items' in item) {
                      item.items.forEach(function (it) {
                        if ('classes' in it) {
                          _this.addStyleFormat(it);
                        }
                      });
                    }
                  });
                }
              });
              outputStyleFormats.push(tempFormat_1);
            } else {
              outputStyleFormats.push(format);
            }
          }
        });
        this.editor.settings.style_formats = outputStyleFormats;
        var toolbarElements = [];
        for (var _f = 0, _g = Object.entries(this.elements); _f < _g.length; _f++) {
          var _h = _g[_f], key = _h[0], value = _h[1];
          if (value) {
            toolbarElements.push('bs-' + key);
          }
        }
        if (typeof this.editor.settings.toolbar === 'string') {
          this.editor.settings.toolbar = this.editor.settings.toolbar.replace('bootstrap', 'bootstrap ' + toolbarElements.join(' '));
        } else {
          for (var i = 0; i < this.editor.settings.toolbar.length; i++) {
            if (!this.editor.settings.toolbar[i].match('bs-')) {
              this.editor.settings.toolbar[i] = this.editor.settings.toolbar[i].replace('bootstrap', 'bootstrap ' + toolbarElements.join(' '));
            }
          }
        }
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.src = this.pluginUrl + 'lib/crypto-js/crypto-js.js';
        script.onload = function () {
          _this.cjs = Crypto;
        };
        head.appendChild(script);
        this.editor.addCommand('iframeCommand', function (ui, value) {
          if (value.pluginMode === 'replace') {
            _this.editor.dom.remove(_this.editor.dom.select('.tbp-active'));
          } else if (value.pluginMode === 'snippetInsert') {
            _this.editor.dom.remove(_this.editor.dom.select('#tbp-snippet-insert'));
          } else if (value.pluginMode === 'templateInsert') {
            _this.editor.dom.remove(_this.editor.dom.select('#tbp-template-insert'));
          }
		  
          _this.editor.insertContent(value.outputCode);
        });
        this.editor.on('keydown', function (e) {
          if ((e.keyCode === 13 || e.keyCode === 10) && e.altKey === false && e.ctrlKey === false && e.shiftKey === false) {
            var node = _this.editor.selection.getNode();
            if (_this.$(node).closest('.tbp-active').length > 0) {
              e.preventDefault();
              e.stopPropagation();
              e.stopImmediatePropagation();
              if (_this.$.inArray(_this.$(node)[0].tagName.toLowerCase(), _this.validParagraphParents) !== -1) {
                _this.addParagraph(node, 'append');
              } else {
                var parentAcceptsParagraphs = false;
                var parentNode = void 0;
                var i = 0;
                while (parentAcceptsParagraphs !== true) {
                  parentNode = _this.$(node).parent()[0];
                  if (_this.$.inArray(_this.$(parentNode)[0].tagName.toLowerCase(), _this.validParagraphParents) !== -1) {
                    parentAcceptsParagraphs = true;
                  } else {
                    node = parentNode;
                  }
                  if (i > 5) {
                    parentAcceptsParagraphs = true;
                  }
                  i++;
                }
                _this.addParagraph(node, 'after');
              }
              return false;
            }
          }
        });
      }
      BootstrapPlugin.prototype.init = function () {
        var _this = this;
        this.editor.on('BeforeExecCommand', function (e) {
          if (e.command === 'mceToggleFormat') {
            if (e.value.match(/rounded$/)) {
              e.value = e.value.replace('rounded', 'rounded-rounded');
            }
            var regValue = /(?:^custom-)?(text|block|container)\s([a-z-]+-)([^_]+)/;
            if (e.value.split(' ').length - 1 === 2) {
              regValue = /(?:^custom-)?(text|block|container)\s([a-z-]+)\s([^_]+)/;
            }
            var match = regValue.exec(e.value);
            if (match !== null) {
              var nodeType = match[1];
              var prop_1 = match[2];
              var value = match[3];
              var range = tinymce.activeEditor.selection.getRng();
              var selectedLength = range.endOffset - range.startOffset;
              if (selectedLength > 0) {
                var ct = tinymce.activeEditor.selection.getContent();
                tinymce.activeEditor.selection.setContent(tinymce.activeEditor.dom.createHTML('span', { id: 'tbp-span' }, ct));
                tinymce.activeEditor.selection.select(tinymce.activeEditor.dom.select('#tbp-span')[0]);
                tinymce.activeEditor.dom.setAttrib('tbp-span', 'id', '');
              }
              var $node_1 = tinymce.activeEditor.selection.getNode();
              if (nodeType === 'block') {
                $node_1 = _this.$($node_1).closest(_this.styleFormatConfig.blockSelector);
              } else if (nodeType === 'container') {
                $node_1 = _this.$($node_1).closest(_this.styleFormatConfig.containerSelector);
              }
              var commonStyleValues = _this.styleFormatsActive[nodeType][prop_1].slice();
              var indexToRemove = commonStyleValues.indexOf(value);
              if (indexToRemove > -1) {
                commonStyleValues.splice(indexToRemove, 1);
              }
              if (prop_1.indexOf('border') !== -1) {
                if (prop_1.indexOf('-') === -1) {
                  var bordersToRemove = [
                    'border-top',
                    'border-right',
                    'border-bottom',
                    'border-left'
                  ];
                  commonStyleValues = __spreadArrays(commonStyleValues, bordersToRemove);
                }
                prop_1 = '';
              }
              if (prop_1.indexOf('rounded-') !== -1) {
                if (value !== 'rounded') {
                  var roundedsToRemove = ['rounded'];
                  commonStyleValues = commonStyleValues.map(function (el) {
                    return prop_1 + el;
                  });
                  commonStyleValues = __spreadArrays(commonStyleValues, roundedsToRemove);
                  prop_1 = '';
                }
              }
              commonStyleValues.forEach(function (val) {
                _this.$($node_1).removeClass(prop_1 + val);
              });
            }
          }
        });
        this.editor.on('BeforeGetContent', function (e) {
          tinymce.dom.DomQuery(_this.editor.dom.select('body')).find('.tbp-context-active').removeClass('tbp-context-active').children('.context-trigger-wrapper').remove();
        });
        if (this.enableTemplateEdition === true) {
          tinymce.dom.DomQuery(this.editor.dom.select('body')).addClass('templatesEnabled');
        }
        /*if (this.key.match(/key-here$/g) !== null) {
          this.throwRegistrationAlert();
        }*/
        this.editor.ui.registry.addContextMenu('bootstrap', {
          update: function (element) {
            var ctxElements = 'addParagraphBefore addParagraphAfter | addParagraphAtBeginning addParagraphAtEnd';
            if (tinymce.dom.DomQuery(element).closest('.container, .container-fluid').length > 0) {
              ctxElements += ' | addParagraphAtBeginningContainer  addParagraphAtEndContainer';
            }
            if (tinymce.dom.DomQuery(tinymce.activeEditor.dom.select('body')).hasClass('templatesEnabled')) {
              ctxElements += ' | disableTemplateEdition';
            } else {
              ctxElements += ' | enableTemplateEdition';
            }
            return ctxElements;
          }
        });
        this.editor.on('KeyDown', function (e) {
          var node = _this.editor.selection.getNode();
          if (_this.$(node).is('p') && _this.$(node)[0].innerText.length === 2) {
            _this.$(node).html(_this.$(node).html().replace('&nbsp;', ''));
            _this.editor.selection.setCursorLocation(_this.$(node)[0], 1);
          }
        });
        var cssURL = this.pluginUrl + 'assets/css/editor-ui.min.css';
        var cssLink = this.editor.dom.create('link', {
          rel: 'stylesheet',
          href: cssURL
        });
        document.getElementsByTagName('head')[0].appendChild(cssLink);
        var tinymceBackgroundColor = this.editor.settings.bootstrapConfig.tinymceBackgroundColor;
        if (tinymceBackgroundColor !== '') {
          this.editor.dom.addStyle('.mce-content-body {background-color: ' + tinymceBackgroundColor + ' !important}');
        }
        this.enableUiButtonsToggle();
        this.loadHtmlTemplates();
        this.enableContextToolbarsEvents();
        /*var u = new URLSearchParams({ data: this.key }).toString();
        var request = new XMLHttpRequest();
        request.open('GET', 'https://www.registration.miglisoft.com/verify.json?' + u, true);
        request.send();*/
      };
      BootstrapPlugin.prototype.activate = function (element, elementSelector) {
        var $target;
        if (elementSelector === 'icon') {
          this.editor.selection.setCursorLocation(element);
        } else if (elementSelector === '.btn') {
          if (this.$(element)[0].tagName.toLowerCase() !== 'input') {
            this.editor.selection.setCursorLocation(element, true);
          }
          $target = this.$(element);
        }
        if (elementSelector === '.table') {
          var $table = this.$(element).closest('.table');
          $target = $table;
          var $tableParent = $table.parent('[class*="table-responsive"]');
          if ($tableParent.length > 0) {
            $target = $tableParent;
          }
        } else if (elementSelector === '.breadcrumb') {
          var $breadcrumb = this.$(element).closest('.breadcrumb');
          $target = $breadcrumb;
          var $breadcrumbParent = $breadcrumb.parent('nav[aria-label="breadcrumb"]');
          if ($breadcrumbParent.length > 0) {
            $target = $breadcrumbParent;
          }
        } else if (elementSelector === '.badge') {
          $target = this.$(element).closest('.badge');
        } else if (elementSelector === '.pagination') {
          $target = this.$(element).closest('.pagination').parent('nav');
        } else if (elementSelector === '.alert') {
          $target = this.$(element).closest('.alert');
        } else if (elementSelector === '.card') {
          $target = this.$(element).closest('.card');
        } else {
          $target = this.$(element);
        }
        $target.addClass('tbp-active');
        this.activateUiButton(elementSelector);
      };
      BootstrapPlugin.prototype.activateUiButton = function (elementSelector) {
        var key = elementSelector.replace('.', '').replace('img', 'image');
        if (this.hasToolbar && this.toolbarStyle === 'buttons') {
          this.uiButtons[key].addClass('tox-tbtn--enabled');
          this.uiButtons[key].attr('aria-pressed', true);
        }
      };
      BootstrapPlugin.prototype.deactivateAll = function () {
        if (this.hasToolbar && this.toolbarStyle === 'buttons') {
          for (var _i = 0, _a = Object.entries(this.uiButtons); _i < _a.length; _i++) {
            var _b = _a[_i], key = _b[0], value = _b[1];
            this.uiButtons[key].removeClass('tox-tbtn--enabled');
            this.uiButtons[key].removeAttr('aria-pressed');
          }
        }
        this.editor.dom.removeClass(tinymce.activeEditor.dom.select('.tbp-active'), 'tbp-active');
      };
      BootstrapPlugin.prototype.enableUiButtonsToggle = function () {
        var _this = this;
        this.editor.on('Click Keyup Contextmenu', function (e) {
          var elementSelector = '';
          if (_this.$(e.target).hasClass('no-events')) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            return false;
          } else if (_this.$(e.target).hasClass('tbp-ui')) {
            _this.editor.selection.setCursorLocation(e.target, true);
            return;
          } else if (e.target.tagName.toLowerCase() === 'img') {
            elementSelector = 'img';
          } else if (e.target.classList.length > 0) {
            if (_this.$(e.target).hasClass('btn')) {
              elementSelector = '.btn';
            } else if (_this.isIcon(e.target)) {
              elementSelector = 'icon';
            } else if (_this.$(e.target).hasClass('badge')) {
              elementSelector = '.badge';
            }
          } else if (e.target.closest('.table') !== null) {
            elementSelector = '.table';
          }
          if (e.target.closest('.breadcrumb') !== null) {
            elementSelector = '.breadcrumb';
          } else if (e.target.closest('.pagination') !== null) {
            elementSelector = '.pagination';
          } else if (e.target.closest('.alert') !== null) {
            elementSelector = '.alert';
          } else if (e.target.closest('.card') !== null) {
            elementSelector = '.card';
          }
          _this.deactivateAll();
          if (elementSelector === '') {
            return;
          }
          _this.activate(e.target, elementSelector);
        });
        this.deactivateAll();
      };
      BootstrapPlugin.prototype.createContextToolbars = function (value) {
        var _this = this;
        var screens = tinymce.util.I18n.translate('Screens').toLowerCase();
        var screenSizes = [
          {
            title: tinymce.util.I18n.translate('Default'),
            icon: 'mobile',
            prefix: ''
          },
          {
            title: tinymce.util.I18n.translate('Small') + ' ' + screens,
            icon: 'tablet',
            prefix: 'sm-'
          },
          {
            title: tinymce.util.I18n.translate('Medium') + ' ' + screens,
            icon: 'tablethorizontal',
            prefix: 'md-'
          },
          {
            title: tinymce.util.I18n.translate('Large') + ' ' + screens,
            icon: 'desktop',
            prefix: 'lg-'
          }
        ];
        var rowPos = [
          'Before',
          'After'
        ];
        rowPos.forEach(function (pos) {
          var _loop_2 = function (i) {
            var columnText = 'column';
            if (i > 1) {
              columnText = 'columns';
            }
            _this.editor.ui.registry.addButton('addRow' + pos + i, {
              text: i + ' ' + tinymce.util.I18n.translate(columnText),
              onAction: function () {
                _this.insertEditorContent('row', i, pos.toLowerCase());
              }
            });
          };
          for (var i = 1; i < 5; i++) {
            _loop_2(i);
          }
          _this.editor.ui.registry.addContextToolbar('bsRow' + pos + 'ContextToolbar', {
            predicate: function (node) {
              return tinymce.dom.DomQuery(node).hasClass('add-row-' + pos.toLowerCase() + '-btn');
            },
            items: 'addRow' + pos + '1 addRow' + pos + '2 addRow' + pos + '3 addRow' + pos + '4',
            position: 'node',
            scope: 'node'
          });
        });
        var rowCssProperties = [
          {
            name: 'justifyContent',
            text: 'justify-content',
            icon: 'tab',
            prefix: 'justify-content-',
            suffix: [
              {
                name: 'start',
                value: 'start'
              },
              {
                name: 'end',
                value: 'end'
              },
              {
                name: 'center',
                value: 'center'
              },
              {
                name: 'between',
                value: 'between'
              },
              {
                name: 'around',
                value: 'around'
              }
            ]
          },
          {
            name: 'alignItems',
            text: 'align-items',
            icon: 'tabvertical',
            prefix: 'align-items-',
            suffix: [
              {
                name: 'start',
                value: 'start'
              },
              {
                name: 'end',
                value: 'end'
              },
              {
                name: 'center',
                value: 'center'
              },
              {
                name: 'between',
                value: 'between'
              },
              {
                name: 'around',
                value: 'around'
              }
            ]
          }
        ];
        rowCssProperties.forEach(function (cssprop) {
          _this.editor.ui.registry.addMenuButton(cssprop.name, {
            text: cssprop.text,
            icon: cssprop.icon,
            fetch: function (callback) {
              var menuItems = [];
              screenSizes.forEach(function (screen) {
                menuItems.push({
                  type: 'nestedmenuitem',
                  text: screen.title,
                  icon: screen.icon,
                  getSubmenuItems: function () {
                    var submenuItems = [];
                    cssprop.suffix.forEach(function (suffix) {
                      var subMenuIcon = null;
                      if (_this.$(_this.currentRow).hasClass(cssprop.prefix + screen.prefix + suffix.value)) {
                        subMenuIcon = 'check';
                      }
                      submenuItems.push({
                        type: 'menuitem',
                        text: suffix.name,
                        icon: subMenuIcon,
                        onAction: function () {
                          if (!_this.$(_this.currentRow).hasClass(cssprop.prefix + screen.prefix + suffix.value)) {
                            cssprop.suffix.forEach(function (sf) {
                              _this.$(_this.currentRow).removeClass(cssprop.prefix + screen.prefix + sf.value);
                            });
                          }
                          _this.$(_this.currentRow).toggleClass(cssprop.prefix + screen.prefix + suffix.value);
                          return false;
                        }
                      });
                    });
                    return submenuItems;
                  }
                });
              });
              callback(menuItems);
            }
          });
          _this.editor.ui.registry.addContextToolbar('bsRowEditContextToolbar', {
            predicate: function (node) {
              return tinymce.dom.DomQuery(node).hasClass('edit-row-btn');
            },
            items: 'justifyContent alignItems',
            position: 'node',
            scope: 'node'
          });
        });
        var colCsssuffix = [];
        colCsssuffix.push({
          name: 'auto',
          value: ''
        });
        for (var index = 1; index <= this.bootstrapColumns; index++) {
          colCsssuffix.push({
            name: index.toString() + '/' + this.bootstrapColumns.toString(),
            value: index.toString()
          });
        }
        var colCssProperties = [{
            name: 'width',
            text: 'width',
            icon: 'template',
            prefix: 'col-',
            suffix: colCsssuffix
          }];
        colCssProperties.forEach(function (cssprop) {
          _this.editor.ui.registry.addMenuButton(cssprop.name, {
            text: cssprop.text,
            icon: cssprop.icon,
            fetch: function (callback) {
              var menuItems = [];
              screenSizes.forEach(function (screen) {
                menuItems.push({
                  type: 'nestedmenuitem',
                  text: screen.title,
                  icon: screen.icon,
                  getSubmenuItems: function () {
                    var submenuItems = [];
                    cssprop.suffix.forEach(function (suffix) {
                      var subMenuIcon = null;
                      if (_this.$(_this.currentCol).hasClass(cssprop.prefix + screen.prefix + suffix.value)) {
                        subMenuIcon = 'check';
                      }
                      submenuItems.push({
                        type: 'menuitem',
                        text: suffix.name,
                        icon: subMenuIcon,
                        onAction: function () {
                          var csspropPrefix = cssprop.prefix;
                          if (!_this.$(_this.currentCol).hasClass(csspropPrefix + screen.prefix + suffix.value)) {
                            cssprop.suffix.forEach(function (sf) {
                              _this.$(_this.currentCol).removeClass(csspropPrefix + screen.prefix + sf.value);
                            });
                          }
                          if (suffix.value === '') {
                            if (screen.prefix === '') {
                              csspropPrefix = csspropPrefix.slice(0, -1);
                            }
                            screen.prefix = screen.prefix.slice(0, -1);
                          }
                          _this.$(_this.currentCol).toggleClass(csspropPrefix + screen.prefix + suffix.value);
                          return false;
                        }
                      });
                    });
                    return submenuItems;
                  }
                });
              });
              callback(menuItems);
            }
          });
          _this.editor.ui.registry.addContextToolbar('bsColEditContextToolbar', {
            predicate: function (node) {
              return tinymce.dom.DomQuery(node).hasClass('edit-col-btn');
            },
            items: 'width',
            position: 'node',
            scope: 'node'
          });
        });
        var colPos = [
          'Before',
          'After'
        ];
        colPos.forEach(function (pos) {
          var _loop_3 = function (i) {
            var columnText = 'column';
            if (i > 1) {
              columnText = 'columns';
            }
            _this.editor.ui.registry.addButton('addCol' + pos + i, {
              text: i + ' ' + tinymce.util.I18n.translate(columnText),
              onAction: function () {
                _this.insertEditorContent('col', i, pos.toLowerCase());
              }
            });
          };
          for (var i = 1; i < 5; i++) {
            _loop_3(i);
          }
          _this.editor.ui.registry.addContextToolbar('bsCol' + pos + 'ContextToolbar', {
            predicate: function (node) {
              return tinymce.dom.DomQuery(node).hasClass('add-col-' + pos.toLowerCase() + '-btn');
            },
            items: 'addCol' + pos + '1 addCol' + pos + '2 addCol' + pos + '3 addCol' + pos + '4',
            position: 'node',
            scope: 'node'
          });
        });
        this.editor.ui.registry.addButton('showModal', {
          text: '' + tinymce.util.I18n.translate('Show Modal'),
          onAction: function () {
            var $ = tinymce.dom.DomQuery;
            var modalId = $(_this.editor.dom.select('.tbp-active')).attr('data-target');
            $(_this.editor.dom.select(modalId)).addClass('show').css('display', 'block');
            $('<div class="modal-backdrop fade show"></div>').appendTo($(_this.editor.dom.select('body')));
          }
        });
        this.editor.ui.registry.addButton('hideModal', {
          text: '' + tinymce.util.I18n.translate('Hide Modal'),
          onAction: function () {
            var $ = tinymce.dom.DomQuery;
            var modalId = $(_this.editor.dom.select('.modal.show')).attr('id');
            $(_this.editor.dom.select('#' + modalId)).removeClass('show').css('display', 'none');
            $(_this.editor.dom.select('body')).find('.modal-backdrop').remove();
          }
        });
        this.editor.ui.registry.addContextToolbar('modalShowContextToolbar', {
          predicate: function (node) {
            return tinymce.dom.DomQuery(node).attr('data-toggle') === 'modal';
          },
          items: 'showModal',
          position: 'node',
          scope: 'node'
        });
        this.editor.ui.registry.addContextToolbar('modalHideContextToolbar', {
          predicate: function (node) {
            if (tinymce.dom.DomQuery(node).hasClass('modal-dialog') && tinymce.dom.DomQuery(node).closest('.modal.show').length > 0) {
              return true;
            }
            return false;
          },
          items: 'hideModal',
          position: 'node',
          scope: 'node'
        });
      };
      BootstrapPlugin.prototype.enableContextToolbarsEvents = function () {
        var _this = this;
        this.editor.on('Click', function (e) {
          if (_this.enableTemplateEdition === true) {
            if (_this.$(e.target).hasClass('remove-row-btn')) {
              _this.editor.windowManager.confirm(tinymce.util.I18n.translate('Remove row') + '?', function (s) {
                if (s) {
                  _this.removeEditorContent('row');
                } else {
                  return;
                }
              });
            } else if (_this.$(e.target).hasClass('remove-col-btn')) {
              _this.editor.windowManager.confirm(tinymce.util.I18n.translate('Remove col') + '?', function (s) {
                if (s) {
                  _this.removeEditorContent('col');
                } else {
                  return;
                }
              });
            } else {
              var clickedCol = _this.findClosestCol(e.target);
              if (_this.currentCol !== null && _this.$(clickedCol).hasClass('tbp-context-active')) {
                return;
              }
              if (clickedCol !== null) {
                _this.$(clickedCol).prepend(_this.htmlTemplates.toolbars.col).addClass('tbp-context-active');
                if (_this.headStyles.indexOf('col') === -1) {
                  var contextHeight = _this.$(e.target).closest('[class*="col"].tbp-context-active').find('.context-trigger-wrapper')[0].offsetHeight;
                  if (contextHeight !== undefined) {
                    _this.headStyles.push('col');
                    _this.editor.dom.addStyle('[class*="col"].tbp-context-active{margin-top:' + (contextHeight + 1) + 'px !important;}');
                  }
                }
                if (parseInt(_this.$(clickedCol)[0].offsetWidth, 10) < 260) {
                  _this.$(clickedCol).find('.context-trigger-wrapper .badge').remove();
                }
                if (clickedCol !== _this.currentCol) {
                  _this.$(_this.currentCol).removeClass('tbp-context-active').children('.context-trigger-wrapper').remove();
                }
                _this.currentCol = clickedCol;
              } else if (_this.currentCol !== null) {
                _this.$(_this.currentCol).removeClass('tbp-context-active').children('.context-trigger-wrapper').remove();
              }
              var clickedRow = e.target.closest('.row');
              if (_this.currentRow !== null && _this.$(clickedRow).hasClass('tbp-context-active')) {
                return;
              }
              if (clickedRow !== null) {
                _this.$(clickedRow).prepend(_this.htmlTemplates.toolbars.row).addClass('tbp-context-active');
                if (_this.headStyles.indexOf('row') === -1) {
                  var contextHeight = _this.$(e.target).closest('.row.tbp-context-active').find('.context-trigger-wrapper')[0].offsetHeight;
                  if (contextHeight !== undefined) {
                    _this.headStyles.push('row');
                    _this.editor.dom.addStyle('.row.tbp-context-active{margin-top:' + (contextHeight + 1) + 'px !important;}');
                  }
                }
                if (clickedRow !== _this.currentRow) {
                  _this.$(_this.currentRow).removeClass('tbp-context-active').children('.context-trigger-wrapper').remove();
                }
                _this.currentRow = clickedRow;
              } else if (_this.currentRow !== null) {
                _this.$(_this.currentRow).removeClass('tbp-context-active').children('.context-trigger-wrapper').remove();
              }
            }
          }
        });
      };
      BootstrapPlugin.prototype.insertEditorContent = function (type, nb, pos) {
        var $htmlContent;
        var htmlFragment;
        switch (type) {
        case 'col':
          var col = this.findClosestCol(this.editor.selection.getNode());
          this.editor.selection.setCursorLocation(col, 0);
          $htmlContent = this.$('<div></div>');
          for (var index = 0; index < nb; index++) {
            $htmlContent.append(this.htmlTemplates.col);
          }
          htmlFragment = this.editor.dom.createFragment($htmlContent[0].innerHTML);
          switch (pos) {
          case 'before':
            this.editor.selection.getNode().before(htmlFragment);
            break;
          case 'after':
            this.editor.selection.getNode().after(htmlFragment);
            break;
          }
          break;
        case 'row':
          var row = this.editor.selection.getNode().closest('.row');
          this.editor.selection.setCursorLocation(row, 0);
          $htmlContent = this.$(this.htmlTemplates.row);
          for (var index = 0; index < nb; index++) {
            $htmlContent.append(this.htmlTemplates.col);
          }
          htmlFragment = this.editor.dom.createFragment($htmlContent[0].outerHTML);
          switch (pos) {
          case 'before':
            this.editor.selection.getNode().before(htmlFragment);
            break;
          case 'after':
            this.editor.selection.getNode().after(htmlFragment);
            break;
          }
          break;
        }
      };
      BootstrapPlugin.prototype.removeEditorContent = function (type) {
        var row = this.editor.selection.getNode().closest('.row');
        switch (type) {
        case 'col':
          var col = this.findClosestCol(this.editor.selection.getNode());
          this.editor.selection.setCursorLocation(col);
          var numberOfCols = this.$(row).children('.col').length;
          numberOfCols += this.$(row).children('[class^="col-"]').length;
          if (numberOfCols < 2) {
            this.removeEditorContent('row');
          } else {
            col.remove();
          }
          break;
        case 'row':
          this.editor.selection.setCursorLocation(row);
          row.remove();
          break;
        }
      };
      BootstrapPlugin.prototype.addParagraph = function (selectedNode, pos) {
        var newP = '<p id="new-p">&nbsp;</p>';
        switch (pos) {
        case 'before':
          this.$(selectedNode).before(this.$(newP));
          break;
        case 'after':
          this.$(selectedNode).after(this.$(newP));
          break;
        case 'prepend':
          this.$(selectedNode).prepend(this.$(newP));
          break;
        case 'append':
          this.$(selectedNode).append(this.$(newP));
          break;
        case 'beginning':
          this.editor.getBody().insertBefore(this.$(newP)[0], this.editor.getBody().firstChild);
          break;
        case 'end':
          this.editor.getBody().lastChild.after(this.$(newP)[0]);
          break;
        case 'beginningContainer':
          this.$(selectedNode).closest('.container, .container-fluid').prepend(this.$(newP));
          break;
        case 'endContainer':
          this.$(selectedNode).closest('.container, .container-fluid').append(this.$(newP));
          break;
        }
        this.editor.selection.setCursorLocation(this.editor.dom.select('#new-p')[0]);
        this.editor.focus();
        this.$(this.editor.dom.select('#new-p')).removeAttr('id');
      };
      BootstrapPlugin.prototype.addStyleFormat = function (item) {
        var titleParts = item.title.split(' ');
        var nodeType = titleParts[0];
        var regexTitle;
        var match;
        var prop;
        var value;
        if (titleParts.length === 2) {
          if (titleParts[1].includes('-')) {
            regexTitle = /([a-z-]+[a-z]*-)([a-z0-9-]+)/;
            match = regexTitle.exec(titleParts[1]);
          } else {
            regexTitle = /([a-z]+)/;
            match = regexTitle.exec(titleParts[1]);
          }
        } else if (titleParts.length === 3) {
          regexTitle = /([a-z-]+)\s([a-z-]+)/;
          match = regexTitle.exec(titleParts[1] + ' ' + titleParts[2]);
        }
        if (match !== null) {
          prop = match[1];
          value = match[2];
          if (value === undefined) {
            value = match[1];
          }
          if (prop === 'rounded') {
            prop = 'rounded-';
          }
          if (typeof this.styleFormatsActive[nodeType] === 'undefined') {
            this.styleFormatsActive[nodeType] = [];
          }
          if (typeof this.styleFormatsActive[nodeType][prop] === 'undefined') {
            this.styleFormatsActive[nodeType][prop] = [];
          }
          this.styleFormatsActive[nodeType][prop].push(value);
        }
      };
      BootstrapPlugin.prototype.findClosestCol = function (node) {
        return node.closest('.col, [class^="col-"]');
      };
      BootstrapPlugin.prototype.findStyleFormatItems = function (formatTitle, propTitle, screenTitle, spacingTitle) {
        var outputItems;
        outputItems = this.styleFormatsAll.find(function (f) {
          return f.title === formatTitle;
        });
        outputItems = outputItems.items.find(function (prop) {
          return prop.title === propTitle;
        });
        outputItems = outputItems.items.find(function (sc) {
          return sc.title === screenTitle;
        });
        outputItems = outputItems.items.find(function (sp) {
          return sp.title === spacingTitle;
        });
        return outputItems;
      };
      BootstrapPlugin.prototype.getContentCss = function () {
        var content_css = this.editor.settings.content_css || '';
        if (content_css === '') {
          content_css = this.bootstrapCss + ',' + this.pluginUrl + 'assets/css/editor-content.min.css';
        } else {
          content_css = this.bootstrapCss + ',' + content_css + ',' + this.pluginUrl + 'assets/css/editor-content.min.css';
        }
        if (this.iconCss !== '') {
          content_css += ',' + this.pluginUrl + 'lib/iconpicker/fonts/' + this.iconCss;
        }
        return content_css;
      };
      BootstrapPlugin.prototype.getValidElements = function () {
        return '@[aria-*|data-*|role|accesskey|draggable|style|class|hidden|tabindex|contenteditable|id|title|contextmenu|lang|dir<ltr?rtl|spellcheck|onabort|onerror|onmousewheel|onblur|onfocus|onpause|oncanplay|onformchange|onplay|oncanplaythrough|onforminput|onplaying|onchange|oninput|onprogress|onclick|oninvalid|onratechange|oncontextmenu|onkeydown|onreadystatechange|ondblclick|onkeypress|onscroll|ondrag|onkeyup|onseeked|ondragend|onload|onseeking|ondragenter|onloadeddata|onselect|ondragleave|onloadedmetadata|onshow|ondragover|onloadstart|onstalled|ondragstart|onmousedown|onsubmit|ondrop|onmousemove|onsuspend|ondurationmouseout|ontimeupdate|onemptied|onmouseover|onvolumechange|onended|onmouseup|onwaiting],a[target<_blank?_self?_top?_parent|ping|media|href|hreflang|type|rel<alternate?archives?author?bookmark?external?feed?first?help?index?last?license?next?nofollow?noreferrer?prev?search?sidebar?tag?up],abbr,address,area[alt|coords|shape|href|target<_blank?_self?_top?_parent|ping|media|hreflang|type|shape<circle?default?poly?rect|rel<alternate?archives?author?bookmark?external?feed?first?help?index?last?license?next?nofollow?noreferrer?prev?search?sidebar?tag?up],article,aside,audio[src|preload<none?metadata?auto|autoplay<autoplay|loop<loop|controls<controls|mediagroup],blockquote[cite],body,br,button[autofocus<autofocus|disabled<disabled|form|formaction|formenctype|formmethod<get?put?post?delete|formnovalidate?novalidate|formtarget<_blank?_self?_top?_parent|name|type<reset?submit?button|value],canvas[width,height],caption,cite,code,col[span],colgroup[span],command[type<command?checkbox?radio|label|icon|disabled<disabled|checked<checked|radiogroup|default<default],datalist[data],dd,del[cite|datetime],details[open<open],dfn,div,dl,dt,em/i,embed[src|type|width|height],eventsource[src],fieldset[disabled<disabled|form|name],figcaption,figure,footer,form[accept-charset|action|enctype|method<get?post?put?delete|name|novalidate<novalidate|target<_blank?_self?_top?_parent],h1,h2,h3,h4,h5,h6,header,hgroup,hr,i[class],iframe[name|src|srcdoc|seamless<seamless|width|height|sandbox],img[alt=|src|ismap|usemap|width|height],input[accept|alt|autocomplete<on?off|autofocus<autofocus|checked<checked|disabled<disabled|form|formaction|formenctype|formmethod<get?put?post?delete|formnovalidate?novalidate|formtarget<_blank?_self?_top?_parent|height|list|max|maxlength|min|multiple<multiple|name|pattern|placeholder|readonly<readonly|required<required|size|src|step|type<hidden?text?search?tel?url?email?password?datetime?date?month?week?time?datetime-local?number?range?color?checkbox?radio?file?submit?image?reset?button|value|width],ins[cite|datetime],kbd,keygen[autofocus<autofocus|challenge|disabled<disabled|form|name],label[for|form],legend,li[value],main,mark,map[name],menu[type<context?toolbar?list|label],meter[value|min|low|high|max|optimum],nav,noscript,object[data|type|name|usemap|form|width|height],ol[reversed|start],optgroup[disabled<disabled|label],option[disabled<disabled|label|selected<selected|value],output[for|form|name],p,param[name,value],-pre,progress[value,max],q[cite],ruby,rp,rt,samp,script[src|async<async|defer<defer|type|charset],section,select[autofocus<autofocus|disabled<disabled|form|multiple<multiple|name|size],small,source[src|type|media],span,-strong/b,-sub,summary,-sup,table,tbody,td[colspan|rowspan|headers],textarea[autofocus<autofocus|disabled<disabled|form|maxlength|name|placeholder|readonly<readonly|required<required|rows|cols|wrap<soft|hard],tfoot,th[colspan|rowspan|headers|scope],thead,time[datetime],tr,ul,var,video[preload<none?metadata?auto|src|crossorigin|poster|autoplay<autoplay|mediagroup|loop<loop|muted<muted|controls<controls|width|height],wbr';
      };
      BootstrapPlugin.prototype.isIcon = function (selectedNode) {
        return new RegExp(this.iconSearchClass, 'gi').test(selectedNode.className);
      };
      BootstrapPlugin.prototype.loadHtmlTemplates = function () {
        var _this = this;
        this.htmlTemplates = {
          toolbars: {
            col: '',
            row: ''
          },
          col: '',
          row: ''
        };
        var types = [
          'col',
          'row'
        ];
        types.forEach(function (type) {
          _this.htmlTemplates.toolbars[type] = '<div class="context-trigger-wrapper bg-light p-1">\n                <div class="flex-grow-1 text-left no-events"><span class="badge badge-secondary font-weight-normal mb-2 px-2 py-1 rounded-0 no-events">' + tinymce.util.I18n.translate('Edit ' + type) + '</span></div>\n                <div class="btn-group rounded-0" role="group">\n                    <button type="button" class="btn btn-sm btn-warning rounded-0 context-btn tbp-ui add-' + type + '-before-btn" title="' + tinymce.util.I18n.translate('Add ' + type + ' before') + '"><span class="d-inline-block svg-icon">' + _this.editorIcons.plus + '</span></button>\n                    <button type="button" class="btn btn-sm btn-primary rounded-0 context-btn tbp-ui edit-' + type + '-btn" title="' + tinymce.util.I18n.translate('Edit ' + type) + '"><span class="d-inline-block svg-icon">' + _this.editorIcons.edit + '</span></button>\n                    <button type="button" class="btn btn-sm btn-warning rounded-0 mr-5 context-btn tbp-ui add-' + type + '-after-btn" title="' + tinymce.util.I18n.translate('Add ' + type + ' after') + '"><span class="d-inline-block svg-icon">' + _this.editorIcons.plus + '</span></button>\n                    <button type="button" class="btn btn-sm btn-danger rounded-0 context-btn tbp-ui remove-' + type + '-btn" title="' + tinymce.util.I18n.translate('Remove ' + type) + '"><span class="d-inline-block svg-icon">' + _this.editorIcons.minus + '</span></button>\n                </div>\n            </div>';
        });
        this.htmlTemplates.col = '<div class="col"><p>' + tinymce.util.I18n.translate('New column') + '</p></div>';
        this.htmlTemplates.row = '<div class="row"></div>';
      };
      BootstrapPlugin.prototype.throwRegistrationAlert = function () {
        this.editor.setContent('<div class="alert alert-danger mx-5 my-5"><p>Your <a href="https://www.tinymce-bootstrap-plugin.com">Bootstrap plugin</a> is <strong>not registered</strong>.</p><p class="mb-0">Open your registration file and enter your purchase code, then paste the key in <em>tinymce.init({bootstrapConfig {key}})</em> to make it work properly.</p></div>');
      };
      return BootstrapPlugin;
    }();

    var setup = function (editor, url) {
      tinymce.PluginManager.requireLangPack('bootstrap', editor.settings.bootstrapConfig.language);
      var bs = new BootstrapPlugin(editor, url);
      bs.editor.on('init', function () {
        bs.init();
      });
      return {
        getMetadata: function () {
          return {
            name: 'Bootstrap plugin',
            url: 'https://www.tinymce-bootstrap-plugin.com'
          };
        },
        getInstance: function () {
          return bs;
        }
      };
    };
    function TinyMceBootstrapPlugin () {
      tinymce.PluginManager.add('bootstrap', setup);
    }

    TinyMceBootstrapPlugin();

}());
