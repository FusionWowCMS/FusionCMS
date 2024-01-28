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
 * CodeIgniter String Helpers
 *
 * @package     CodeIgniter
 * @subpackage  Helpers
 * @category    Helpers
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/userguide3/helpers/string_helper.html
 */

// ------------------------------------------------------------------------

if (!function_exists('trim_slashes')) {
    /**
     * Trim Slashes
     *
     * Removes any leading/trailing slashes from a string:
     *
     * /this/that/theother/
     *
     * becomes:
     *
     * this/that/theother
     *
     * @param string $str
     * @return    string
     * @todo    Remove in version 3.1+.
     * @deprecated    3.0.0    This is just an alias for PHP's native trim()
     *
     */
    function trim_slashes($str): string
    {
        return trim($str, '/');
    }
}

// ------------------------------------------------------------------------

if (!function_exists('strip_slashes')) {
    /**
     * Strip Slashes
     *
     * Removes slashes contained in a string or in an array
     *
     * @param mixed $str string or array
     * @return  string|array    string or array
     */
    function strip_slashes($str): string|array
    {
        if (!is_array($str)) {
            return stripslashes($str);
        }

        foreach ($str as $key => $val) {
            $str[$key] = strip_slashes($val);
        }

        return $str;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('strip_quotes')) {
    /**
     * Strip Quotes
     *
     * Removes single and double quotes from a string
     *
     * @param string $str
     * @return    string
     */
    function strip_quotes($str): string
    {
        return str_replace(array('"', "'"), '', $str);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('quotes_to_entities')) {
    /**
     * Quotes to Entities
     *
     * Converts single and double quotes to entities
     *
     * @param string $str
     * @return    string
     */
    function quotes_to_entities($str): string
    {
        return str_replace(array("\'", "\"", "'", '"'), array("&#39;", "&quot;", "&#39;", "&quot;"), $str);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('reduce_double_slashes')) {
    /**
     * Reduce Double Slashes
     *
     * Converts double slashes in a string to a single slash,
     * except those found in http://
     *
     * http://www.some-site.com//index.php
     *
     * becomes:
     *
     * http://www.some-site.com/index.php
     *
     * @param string $str
     * @return    string
     */
    function reduce_double_slashes($str): string
    {
        return preg_replace('#(^|[^:])//+#', '\\1/', $str);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('reduce_multiples')) {
    /**
     * Reduce Multiples
     *
     * Reduces multiple instances of a particular character.  Example:
     *
     * Fred, Bill,, Joe, Jimmy
     *
     * becomes:
     *
     * Fred, Bill, Joe, Jimmy
     *
     * @param string
     * @param string    the character you wish to reduce
     * @param bool    true/false - whether to trim the character from the beginning/end
     * @return    string
     */
    function reduce_multiples($str, $character = ',', $trim = false): string
    {
        $str = preg_replace('#' . preg_quote($character, '#') . '{2,}#', $character, $str);
        return ($trim === true) ? trim($str, $character) : $str;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('random_string')) {
    /**
     * Create a "Random" String
     *
     * @param string $type type of random string.  basic, alpha, alnum, numeric, nozero, unique, md5, encrypt and sha1
     * @param int $len number of characters
     * @return    string
     */
    function random_string($type = 'alnum', $len = 8): string
    {
        switch ($type) {
            case 'basic':
                return mt_rand();
            case 'alnum':
            case 'numeric':
            case 'nozero':
            case 'alpha':
                switch ($type) {
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alnum':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric':
                        $pool = '0123456789';
                        break;
                    case 'nozero':
                        $pool = '123456789';
                        break;
                }
                return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
            case 'unique': // todo: remove in 3.1+
            case 'md5':
                return md5(uniqid(mt_rand()));
            case 'encrypt': // todo: remove in 3.1+
            case 'sha1':
                return sha1(uniqid(mt_rand(), true));
        }
        return '';
    }
}

// ------------------------------------------------------------------------

if (!function_exists('increment_string')) {
    /**
     * Add's _1 to a string or increment the ending number to allow _2, _3, etc
     *
     * @param string $str required
     * @param string $separator What should the duplicate number be appended with
     * @param string $first Which number should be used for the first dupe increment
     * @return    string
     */
    function increment_string($str, $separator = '_', $first = 1): string
    {
        preg_match('/(.+)' . preg_quote($separator, '/') . '([0-9]+)$/', $str, $match);
        return isset($match[2]) ? $match[1] . $separator . ($match[2] + 1) : $str . $separator . $first;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('alternator')) {
    /**
     * Alternator
     *
     * Allows strings to be alternated. See docs...
     *
     * @return    string
     */
    function alternator(): string
    {
        static $i;

        if (func_num_args() === 0) {
            $i = 0;
            return '';
        }

        $args = func_get_args();
        return $args[($i++ % count($args))];
    }
}

// ------------------------------------------------------------------------

if (!function_exists('repeater')) {
    /**
     * Repeater function
     *
     * @param string $data String to repeat
     * @param int $num Number of repeats
     * @return    string
     * @deprecated    3.0.0    This is just an alias for PHP's native str_repeat()
     *
     * @todo    Remove in version 3.1+.
     */
    function repeater($data, $num = 1): string
    {
        return ($num > 0) ? str_repeat($data, $num) : '';
    }
}
