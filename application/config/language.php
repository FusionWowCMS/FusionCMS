<?php

/**
 * @package FusionCMS
 * @version 6.0
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @author  Ehsan Zare (Darksider) <darksider.legend@gmail.com>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
  |--------------------------------------------------------------------------
  | Default Language
  |--------------------------------------------------------------------------
  |
  | Also acts as fallback language
  |
 */
$config['language'] = "english";

/*
  |--------------------------------------------------------------------------
  | Detect Browser Language
  |--------------------------------------------------------------------------
  |
  | If enabled detecting browser language and set user language to detected language
  |
 */
$config['detect_language'] = false;

/*
|--------------------------------------------------------------------------
| Supported Languages
|--------------------------------------------------------------------------
*/
$config['supported_languages'] = array(
    'en' => array('name' => 'english'),
    //'de' => array('name' => 'deutsch')
);
