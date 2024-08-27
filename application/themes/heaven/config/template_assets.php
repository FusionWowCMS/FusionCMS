<?php

# Import required classes
use MX\CI;

# Make sure we're in CI
defined('BASEPATH') OR exit('No direct script access allowed');

# Assets
$assets = [
    'css' => [
        # Settings
        'url'   => base_url() . 'writable/cache/data/minify/',
        'path'  => CMS_ROOT_PATH . basename(WRITEPATH) . DS . 'cache' . DS . 'data' . DS . 'minify' . DS,

        # Parts
        'parts' => [
            'all' => [
                'name'  => 'all.min.css',
                'files' => array_merge(
                    [
                        # CMS stylesheet files
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'css' . DS . 'default.css'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'css' . DS . 'tooltip.css'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'fonts' . DS . 'fontawesome' . DS . 'v6.6.0' . DS . 'css' . DS . 'all.css'),

                        # CMS dependencies
                        '@import url("https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap")',
                        '@import url("https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css")',
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . '..' . DS . 'node_modules' . DS . 'bootstrap' . DS . 'dist' . DS . 'css' . DS . 'bootstrap.min.css'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . '..' . DS . 'node_modules' . DS . 'sweetalert2' . DS . 'dist' . DS . 'sweetalert2.min.css'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . '..' . DS . 'node_modules' . DS . 'owl.carousel' . DS . 'dist' . DS . 'assets' . DS . 'owl.carousel.min.css'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . '..' . DS . 'node_modules' . DS . 'owl.carousel' . DS . 'dist' . DS . 'assets' . DS . 'owl.theme.default.min.css'),

                        # Theme stylesheet files
                        T_ROOT_PATH . 'assets' . DS . 'css' . DS . 'style.css'
                    ],

                    # Autoload theme variations stylesheet files
                    glob(T_ROOT_PATH . 'assets' . DS . 'variations' . DS . '*' . DS . 'css' . DS . 'style.css'),

                    # Autoload theme modules stylesheet files (sidebox)
                    glob(T_ROOT_PATH . 'modules' . DS . 'sidebox_*' . DS . 'css' . DS . '*.css')
                )
            ],

            'module' => [
                'name'  => strtolower(CI_MODULE) . '.min.css',
                'files' => str_replace(CMS_ROOT_PATH, base_url(), glob(T_ROOT_PATH . 'modules' . DS . strtolower(CI_MODULE) . DS . 'css' . DS . '*.css'))
            ]
        ]
    ],

    'js' => [
        # Settings
        'url'   => base_url() . 'writable/cache/data/minify/',
        'path'  => CMS_ROOT_PATH . basename(WRITEPATH) . DS . 'cache' . DS . 'data' . DS . 'minify' . DS,

        # Parts
        'parts' => [
            'all' => [
                'name'  => 'all.min.js',
                'files' => array_merge(
                    [
                        # jQuery
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . '..' . DS . 'node_modules' . DS . 'jquery' . DS . 'dist' . DS . 'jquery.min.js'),

                        # CMS javascript files (Base libraries)
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'js' . DS . 'flux.min.js'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'js' . DS . 'jquery.sort.js'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'js' . DS . 'jquery.placeholder.min.js'),

                        # CMS javascript files (FusionCMS libraries)
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'js' . DS . 'ui.js'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'js' . DS . 'main.js'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'js' . DS . 'cookie.js'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'js' . DS . 'tooltip.js'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . 'js' . DS . 'language.js'),

                        # CMS dependencies
                        'https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js',
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . '..' . DS . 'node_modules' . DS . 'bootstrap' . DS . 'dist' . DS . 'js' . DS . 'bootstrap.bundle.min.js'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . '..' . DS . 'node_modules' . DS . 'sweetalert2' . DS . 'dist' . DS . 'sweetalert2.all.min.js'),
                        realpath(T_ROOT_PATH . '..' . DS . '..' . DS . '..' . DS . 'node_modules' . DS . 'owl.carousel' . DS . 'dist' . DS . 'owl.carousel.min.js'),

                        # Theme javascript files (Theme libraries)
                        T_ROOT_PATH . 'assets' . DS . 'js' . DS . 'app.js'
                    ],

                    # Autoload theme modules javascript files (sidebox)
                    glob(T_ROOT_PATH . 'modules' . DS . 'sidebox_*' . DS . 'js' . DS . '*.js')
                )
            ],

            'module' => [
                'name'  => strtolower(CI_MODULE) . '.min.js',
                'files' => str_replace(CMS_ROOT_PATH, base_url(), glob(T_ROOT_PATH . 'modules' . DS . strtolower(CI_MODULE) . DS . 'js' . DS . '*.js'))
            ]
        ]
    ]
];

# Prevent errors
$config = [];
