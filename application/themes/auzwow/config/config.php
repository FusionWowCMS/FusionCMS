<?php defined('BASEPATH') OR exit('No direct script access allowed');

# Config array
$config = [
    /**
     * - General -------------------------------------------------
     * -----------------------------------------------------------
     */
    'version'     => '1.0',
    'theme_color' => '#252525',

    /**
     * - Full width pages ----------------------------------------
     * -----------------------------------------------------------
     */
    'FWP' => [
        'gm'             => '*',
        'ucp'              => '*',
        'auth'             => '*',
        'item'             => '*',
        'news'             => ['news' => ['view']],
        'page'             => '*',
        'vote'             => '*',
        'guild'            => '*',
        'store'            => '*',
        'armory'           => '*',
        'donate'           => '*',
        'errors'           => '*',
        'online'           => '*',
        'profile'          => '*',
        'register'         => '*',
        'teleport'         => '*',
        'changelog'        => '*',
        'character'        => '*',
        'bugtracker'       => '*',
        'pvp_statistics'   => '*',
        'realm_statistics' => '*'
    ],

    /**
     * - Welcome box ---------------------------------------------
     * -----------------------------------------------------------
     */
    'welcome_box' => [
        # Enabled
        'enabled' => true,

        # Text
        'text' => json_encode([
            'english' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br /><br /> Ut enim ad minim veniam, quis nostrud exercitation ullamcoas laboris nisi ut aliquip ex ea commodo consequat. Duis aute iru re dolor in reprehenderit in voluptate velit esse cillum doloret, testing a link: <a href="#">http://zafirehd.deviantart.com</a> <br /><br /> Excepteur sint occaecat cupidatat non proident, sunt in culpas qui officia deserunt mollit anim id est laborum. Ex ea commod consequat. Duis aute irure dolor in reprehender.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br /><br /> Ut enim ad minim veniam, quis nostrud exercitation ullamcoas laboris nisi ut aliquip ex ea commodo consequat. Duis aute iru re dolor in reprehenderit in voluptate velit esse cillum doloret, testing a link: <a href="#">http://zafirehd.deviantart.com</a> <br /><br /> Excepteur sint occaecat cupidatat non proident, sunt in culpas qui officia deserunt mollit anim id est laborum. Ex ea commod consequat. Duis aute irure dolor in reprehender.',
            'persian' => '',
            'spanish' => ''
        ], JSON_UNESCAPED_SLASHES)
    ],

    /**
     * - Announcement --------------------------------------------
     * -----------------------------------------------------------
     */
    'announcement' => [
        # Enabled
        'enabled' => true,

        # Link
        'link' => base_url('page/rules'),

        # Text
        'text' => json_encode([
            'english' => 'Welcome to our new website! please <a href="' . base_url('register') . '">create an account</a> or <a href="' . base_url('login') . '">login</a> in order to unlock more features. Have a nice day! Greetings from ' . CI::$APP->config->item('server_name') . '.',
            'persian' => '',
            'spanish' => ''
        ], JSON_UNESCAPED_SLASHES)
    ],

    /**
     * - Countdown -----------------------------------------------
     * -----------------------------------------------------------
     */
    'countdown' => [
        # Enabled
        'enabled' => true,

        # Date
        'date' => '2024/09/20 20:30:00', # Format: YYYY/MM/DD hh:mm:ss

        # Text
        'text' => json_encode([
            'english' => 'Battle for <i>Tol Barad</i>',
            'persian' => '',
            'spanish' => ''
        ], JSON_UNESCAPED_SLASHES)
    ],

    /**
     * - Realm description ---------------------------------------
     * -----------------------------------------------------------
     */
    'realm_desc' => [
        1 => '<i>Blizz</i> 1x',
        2 => '<i>Blizz</i> 5x',
        3 => '<i>Desc</i> 7x'
    ],

    /**
     * - Social buttons ------------------------------------------
     * -----------------------------------------------------------
     */
    'social' => [
        # Facebook
        'facebook' => [
            # Enabled
            'enabled' => true,

            # Link
            'link' => 'https://facebook.com'
        ],

        # Twitter
        'twitter' => [
            # Enabled
            'enabled' => true,

            # Link
            'link' => 'https://twitter.com'
        ],

        # Youtube
        'youtube' => [
            # Enabled
            'enabled' => true,

            # Link
            'link' => 'https://youtube.com'
        ]
    ],

    /**
     * - Footer --------------------------------------------------
     * -----------------------------------------------------------
     */
    'footer' => [
        # Since
        'since' => '2017',

        # Text
        'text' => json_encode([
            'english' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et <a href="#">link here</a>.',
            'persian' => '',
            'spanish' => ''
        ], JSON_UNESCAPED_SLASHES)
    ]
];

# Randomize version
if(!CI::$APP->config->item('enable_minify_js') || !CI::$APP->config->item('enable_minify_css'))
    $config['version'] = time();

# Force code editor
$config['force_code_editor'] = true;
