<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 * @version 6.0
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

/*
|--------------------------------------------------------------------------
| CDN system
|--------------------------------------------------------------------------
|
| If activated, static files (js/css/images) are loaded via the FusionCMS CDN system
| The geologically closest server to the player is selected for this
| This should speed up the loading time of the website
|
| Only default theme. Files from other themes can be hosted on request.
*/

$config['cdn'] = false;
$config['cdn_link'] = 'https://cdn.google.com/';
