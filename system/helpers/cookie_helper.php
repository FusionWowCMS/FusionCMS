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
 * CodeIgniter Cookie Helpers
 *
 * @package        CodeIgniter
 * @subpackage    Helpers
 * @category    Helpers
 * @author        EllisLab Dev Team
 * @link        https://codeigniter.com/userguide3/helpers/cookie_helper.html
 */


// =============================================================================
// CodeIgniter Cookie Helpers
// =============================================================================

if (!function_exists('set_cookie')) {
    /**
     * Set cookie
     *
     * Accepts seven parameters, or you can submit an associative
     * array in the first parameter containing all the values.
     *
     * @param array|Cookie|string $name Cookie name / array containing binds / Cookie object
     * @param string $value The value of the cookie
     * @param string $expire The number of seconds until expiration
     * @param string $domain For site-wide cookie. Usually: .yourdomain.com
     * @param string $path The cookie path
     * @param string $prefix The cookie prefix ('': the default prefix)
     * @param bool|null $secure True makes the cookie secure
     * @param bool|null $httpOnly True makes the cookie accessible via http(s) only (no javascript)
     * @param string|null $sameSite The cookie SameSite value
     *
     * @return void
     */
    function set_cookie(
        $name,
        string $value = '',
        string $expire = '',
        string $domain = '',
        string $path = '/',
        string $prefix = '',
        ?bool $secure = null,
        ?bool $httpOnly = null,
        ?string $sameSite = null
    )
    {
        get_instance()->input->set_cookie($name, $value, $expire, $domain, $path, $prefix, $secure, $httpOnly, $sameSite);
    }
}

// --------------------------------------------------------------------

if (!function_exists('get_cookie')) {
    /**
     * Fetch an item from the COOKIE array
     *
     * @param string $index
     * @param bool|null $xssClean
     *
     * @return mixed
     */
    function get_cookie($index, bool $xssClean = null)
    {
        is_bool($xssClean) or $xssClean = (config_item('global_xss_filtering') === true);
        $prefix = isset($_COOKIE[$index]) ? '' : config_item('cookie_prefix');
        return get_instance()->input->cookie($prefix . $index, $xssClean);
    }
}

// --------------------------------------------------------------------

if (!function_exists('delete_cookie')) {
    /**
     * Delete a COOKIE
     *
     * @param string $name
     * @param string $domain the cookie domain. Usually: .yourdomain.com
     * @param string $path the cookie path
     * @param string $prefix the cookie prefix
     *
     * @return void
     */
    function delete_cookie($name, string $domain = '', string $path = '/', string $prefix = '')
    {
        set_cookie($name, '', '', $domain, $path, $prefix);
    }
}
