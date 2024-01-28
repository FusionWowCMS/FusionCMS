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
 * CodeIgniter Number Helpers
 *
 * @package     CodeIgniter
 * @subpackage  Helpers
 * @category    Helpers
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/userguide3/helpers/number_helper.html
 */

if (!function_exists('number_to_roman')) {
    /**
     * Convert a number to a roman numeral.
     *
     * @param int|string $num it will convert to int
     */
    function number_to_roman($num): ?string
    {
        static $map = [
            'M'  => 1000,
            'CM' => 900,
            'D'  => 500,
            'CD' => 400,
            'C'  => 100,
            'XC' => 90,
            'L'  => 50,
            'XL' => 40,
            'X'  => 10,
            'IX' => 9,
            'V'  => 5,
            'IV' => 4,
            'I'  => 1,
        ];

        $num = (int)$num;

        if ($num < 1 || $num > 3999) {
            return null;
        }

        $result = '';

        foreach ($map as $roman => $arabic) {
            $repeat = (int)floor($num / $arabic);
            $result .= str_repeat($roman, $repeat);
            $num %= $arabic;
        }

        return $result;
    }
}

if (!function_exists('byte_format')) {
    /**
     * Formats a numbers as bytes, based on size, and adds the appropriate suffix
     *
     * @param mixed $num will be cast as int
     * @param int $precision
     * @return    string
     */
    function byte_format($num, $precision = 1): string
    {
        $CI =& get_instance();
        $CI->lang->load('number');

        if ($num >= 1000000000000) {
            $num = round($num / 1099511627776, $precision);
            $unit = $CI->lang->line('terabyte_abbr');
        } elseif ($num >= 1000000000) {
            $num = round($num / 1073741824, $precision);
            $unit = $CI->lang->line('gigabyte_abbr');
        } elseif ($num >= 1000000) {
            $num = round($num / 1048576, $precision);
            $unit = $CI->lang->line('megabyte_abbr');
        } elseif ($num >= 1000) {
            $num = round($num / 1024, $precision);
            $unit = $CI->lang->line('kilobyte_abbr');
        } else {
            $unit = $CI->lang->line('bytes');
            return number_format($num) . ' ' . $unit;
        }

        return number_format($num, $precision) . ' ' . $unit;
    }
}
