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
 * CodeIgniter Typography Helpers
 *
 * @package     CodeIgniter
 * @subpackage  Helpers
 * @category    Helpers
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/userguide3/helpers/typography_helper.html
 */

// ------------------------------------------------------------------------

if (!function_exists('nl2brExceptPre')) {
    /**
     * Convert newlines to HTML line breaks except within PRE tags
     *
     * @param string $str
     * @return    string
     */
    function nl2brExceptPre($str): string
    {
        $CI =& get_instance();
        $CI->load->library('typography');
        return $CI->typography->nl2brExceptPre($str);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('auto_typography')) {
    /**
     * Auto Typography Wrapper Function
     *
     * @param string $str
     * @param bool $reduce_linebreaks = FALSE    whether to reduce multiple instances of double newlines to two
     * @return    string
     */
    function auto_typography($str, $reduce_linebreaks = false): string
    {
        $CI =& get_instance();
        $CI->load->library('typography');
        return $CI->typography->auto_typography($str, $reduce_linebreaks);
    }
}

// --------------------------------------------------------------------

if (!function_exists('entity_decode')) {
    /**
     * HTML Entities Decode
     *
     * This function is a replacement for html_entity_decode()
     *
     * @param string $str
     * @param string $charset
     * @return    string
     */
    function entity_decode($str, $charset = null): string
    {
        return get_instance()->security->entity_decode($str, $charset);
    }
}
