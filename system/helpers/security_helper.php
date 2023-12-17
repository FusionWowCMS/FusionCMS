<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter Security Helpers
 *
 * @package       CodeIgniter
 * @subpackage    Helpers
 * @category      Helpers
 * @author        EllisLab Dev Team
 * @link          https://codeigniter.com/userguide3/helpers/security_helper.html
 */

if (!function_exists('xss_clean')) {
    /**
     * XSS Filtering
     *
     * @param string $str
     * @param bool $is_image whether or not the content is an image file
     * @return    string
     */
    function xss_clean($str, bool $is_image = false): string
    {
        return get_instance()->security->xss_clean($str, $is_image);
    }
}

if (!function_exists('sanitize_filename')) {
    /**
     * Sanitize Filename
     *
     * @param string $filename
     * @return    string
     */
    function sanitize_filename(string $filename): string
    {
        return get_instance()->security->sanitize_filename($filename);
    }
}

if (!function_exists('strip_image_tags')) {
    /**
     * Strip Image Tags
     *
     * @param string $str
     * @return    string
     */
    function strip_image_tags(string $str): string
    {
        return get_instance()->security->strip_image_tags($str);
    }
}

if (!function_exists('encode_php_tags')) {
    /**
     * Convert PHP tags to entities
     *
     * @param string $str
     * @return    string
     */
    function encode_php_tags(string $str): string
    {
        return str_replace(['<?', '?>'], ['&lt;?', '?&gt;'], $str);
    }
}
