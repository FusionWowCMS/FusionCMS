<?php use MX\CI;

defined('BASEPATH') OR exit('No direct script access allowed');

# Config array
$config = [
    /**
     * - General -------------------------------------------------
     * -----------------------------------------------------------
     */
    'version'     => '1.0',
    'variation'   => 'blue', # blue
    'theme_color' => '#11192c',

    /**
     * - Full width pages ----------------------------------------
     * -----------------------------------------------------------
     */
    'FWP' => [
        'gm'             => '*',
        'ucp'            => '*',
        'auth'           => '*',
        'item'           => '*',
        'news'           => ['news' => ['view']],
        'page'           => '*',
        'vote'           => '*',
        'guild'          => '*',
        'store'          => '*',
        'armory'         => '*',
        'donate'         => '*',
        'errors'         => '*',
        'online'         => '*',
        'profile'        => '*',
        'register'       => '*',
        'teleport'       => '*',
        'changelog'      => '*',
        'character'      => '*',
        'pvp_statistics' => '*'
    ],

    /**
     * - Wall --------------------------------------------------
     * -----------------------------------------------------------
     */
    'wall' => [
        # Settings
        'enabled'    => true,
        'visibility' => 'home' # always|home
    ],

    /**
     * - Banners --------------------------------------------------
     * -----------------------------------------------------------
     */
    'banners' => [
        # Settings
        'enabled'    => true,
        'visibility' => 'home', # always|home

        # Banner 01
        'banner_01' => [
            'date'  => '07.09.21',
            'link'  => base_url('page/announcement'),
            'text'  => json_encode(['english' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.', 'persian' => '', 'spanish' => ''], JSON_UNESCAPED_UNICODE),
            'title' => json_encode(['english' => 'Welcome to FusionCMS', 'persian' => '', 'spanish' => ''], JSON_UNESCAPED_UNICODE)
        ],

        # Banner 02
        'banner_02' => [
            'date'  => '07.09.21',
            'link'  => base_url('page/announcement'),
            'text'  => json_encode(['english' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.', 'persian' => '', 'spanish' => ''], JSON_UNESCAPED_UNICODE),
            'title' => json_encode(['english' => 'Welcome to FusionCMS-8.x', 'persian' => '', 'spanish' => ''], JSON_UNESCAPED_UNICODE)
        ]
    ],

    /**
     * - Sidebox menu --------------------------------------------
     * -----------------------------------------------------------
     */
    'sidebox_menu' => [
        'order'      => 1,
        'enabled'    => true,
        'visibility' => 'home' # always|home
    ],

    /**
     * - Footer --------------------------------------------------
     * -----------------------------------------------------------
     */
    'footer' => [
        # Text
        'text' => json_encode([
            'english'    => 'Blizzard Entertainment is a trademark or registered trademark of Blizzard Entertainment, Inc., in the U.S. and/or other countries. All other trademarks or registered trademarks are property of their respective owners',
            'persian'    => '',
            'spanish'    => ''
        ], JSON_UNESCAPED_UNICODE)
    ]
];

# Randomize version
if(!CI::$APP->config->item('enable_minify_js') || !CI::$APP->config->item('enable_minify_css'))
    $config['version'] = time();

# Force code editor
$config['force_code_editor'] = true;
