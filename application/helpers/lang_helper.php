<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Short-command to get the current language name
 *
 * @return String
 */
function getLang(): string
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
 * @param String $id
 * @param String $file
 * @param array $args Summary Example:
 *                  + You have: $lang['apple'] = 'I have {0, number} apples.';
 *                  + You can use: echo lang('apples', main, [3]);
 *                  + Displays "I have 3 apples."
 * @return mixed
 */
function lang(string $id, string $file = 'main', array $args = []): mixed
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->get($id, $file, $args);
}

/**
 * Short-command to set a client language string
 *
 * @param String $id
 * @param String $file
 * @return void
 */
function clientLang(string $id, string $file = 'main'): void
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    $CI->language->setClientData($id, $file);
}

/**
 * Translate the JSON-stored language string to the desired language
 *
 * @param String $json
 * @return String
 */
function langColumn(string $json): string
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
 * @param String $json
 * @return String
 */
function getColumnLang(string $json): string
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->language->getColumnLanguage($json);
}
