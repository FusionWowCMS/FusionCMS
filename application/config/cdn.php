<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 * @version 6.0
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @author  Ehsan Zare (Darksider) <darksider.legend@gmail.com>
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
| Only default theme. Files from other themes can be hosted on request. Discord: Err0r#4481
*/

$config['cdn'] = false;
$config['cdn_link'] = "https://cdn.google.com/";
