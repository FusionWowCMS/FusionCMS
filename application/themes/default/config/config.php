<?php

# Import required classes
use MX\CI;

# Make sure we're in CI
defined('BASEPATH') OR exit('No direct script access allowed');

# Config array
$config = [
    /**
     * - General -------------------------------------------------
     * -----------------------------------------------------------
     */
    'version'     => '1.0',
    'variation'   => 'wotlk', # classic|tbc|wotlk|cata
    'theme_color' => '#090b0c',

    /**
     * - Full width pages ----------------------------------------
     * -----------------------------------------------------------
     */
    'FWP' => [
        'armory'         => ['index'],
        'auth'           => ['login', 'password_recovery'],
        'changelog'      => ['index'],
        'character'      => ['index'],
        'donate'         => ['index'],
        'errors'         => ['index'],
        'forum'          => ['index', 'subforum', 'create', 'topic', 'edit'],
        'gm'             => ['index'],
        'guild'          => ['index'],
        'item'           => ['index'],
        'news'           => ['view'],
        'online'         => ['index'],
        'page'           => ['index'],
        'profile'        => ['index'],
        'pvp_statistics' => ['index'],
        'register'       => ['index'],
        'store'          => ['index'],
        'teleport'       => ['index'],
        'ucp'            => ['index'],
        'vote'           => ['index']
    ],

    /**
     * - Sidebox menu --------------------------------------------
     * -----------------------------------------------------------
     */
    'sidebox_menu' => [
        'order'      => 1,
        'enabled'    => true,
        'visibility' => 'always' # always|home
    ]
];

# Randomize version
if(!CI::$APP->config->item('enable_minify_js') || !CI::$APP->config->item('enable_minify_css'))
    $config['version'] = time();

# Force code editor
$config['force_code_editor'] = true;
