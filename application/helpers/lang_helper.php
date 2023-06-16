<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Short-command to get the current language name
 *
 * @return String
 */
function getLang()
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->getLanguage();
}

/**
 * Short-command to get a language string
 *
 * @param  String $id
 * @param  String $file
 * @return String
 */
function lang($id, $file = 'main')
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->get($id, $file);
}

/**
 * Short-command to set a client language string
 *
 * @param  String $id
 * @param  String $file
 * @return String
 */
function clientLang($id, $file = 'main')
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->setClientData($id, $file);
}

/**
 * Translate the JSON-stored language string to the desired language
 *
 * @param  String $json
 * @return String
 */
function langColumn($json)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->translateLanguageColumn($json);
}

/**
 * Get the selected language
 *
 * @param  String $json
 * @return String
 */
function getColumnLang($json)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->getColumnLanguage($json);
}
