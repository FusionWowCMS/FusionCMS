<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Codeigniter HTMLPurifier Helper
 *
 * Purify input using the HTMLPurifier standalone class.
 * Easily use multiple purifier configurations.
 *
 * @author     Tyler Brownell <tyler.brownell@mssociety.ca>
 * @copyright  Public Domain
 *
 * @access  public
 * @param   string or array  $dirty_html  A string (or array of strings) to be cleaned.
 * @param   string           $config      The name of the configuration (switch case) to use.
 * @return  string or array               The cleaned string (or array of strings).
 */
if (!function_exists('html_purify')) {
    function html_purify($dirty_html, $config = false): array|string
    {
        $clean_html = '';

        if (is_array($dirty_html)) {
            foreach ($dirty_html as $key => $val) {
                $clean_html[$key] = html_purify($val, $config);
            }
            return $clean_html;
        }

        $ci = &get_instance();

        switch ($config) {
            case 'comment':
                $config = HTMLPurifier_Config::createDefault();
                $config->set('Core.Encoding', $ci->config->item('charset'));
                $config->set('HTML.Doctype', 'XHTML 1.0 Strict');
                $config->set('HTML.Allowed', 'p,a[href|title],abbr[title],acronym[title],b,strong,blockquote[cite],code,em,i,strike');
                $config->set('AutoFormat.AutoParagraph', true);
                $config->set('AutoFormat.Linkify', true);
                $config->set('AutoFormat.RemoveEmpty', true);
                break;

            case false:
                $config = HTMLPurifier_Config::createDefault();
                $config->set('Core.Encoding', $ci->config->item('charset'));
                $config->set('HTML.Doctype', 'XHTML 1.0 Strict');
                break;

            default:
                show_error(
                    'The HTMLPurifier configuration labeled "' .
                    htmlspecialchars((string)$config, ENT_QUOTES, $ci->config->item('charset')) .
                    '" could not be found.'
                );
        }

        // Force HTMLPurifier cache into writable/ (vendor/ should remain read-only)
        $cachePath = FCPATH . 'writable/cache/htmlpurifier';
        if (!is_dir($cachePath)) {
            @mkdir($cachePath, 0775, true);
        }
        @chmod($cachePath, 0775);

        $config->set('Cache.DefinitionImpl', 'Serializer');
        $config->set('Cache.SerializerPath', $cachePath);

        $purifier = new HTMLPurifier($config);
        return $purifier->purify($dirty_html);
    }
}

/* End of htmlpurifier_helper.php */
/* Location: ./application/helpers/htmlpurifier_helper.php */
