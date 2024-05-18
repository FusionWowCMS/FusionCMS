<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use App\Config\App;
use App\Config\Database;
use App\Config\Services;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Config\Factories;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Exceptions\GeneralException;
use CodeIgniter\Exceptions\PageNotFoundException;
use Laminas\Escaper\Escaper;

/**
 * Common Functions
 *
 * Loads the base classes and executes the request.
 *
 * @package     CodeIgniter
 * @subpackage  CodeIgniter
 * @category    Common Functions
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/userguide3/
 */

if (! function_exists('app_timezone')) {
    /**
     * Returns the timezone the application has been set to display
     * dates in. This might be different than the timezone set
     * at the server level, as you often want to stores dates in UTC
     * and convert them on the fly for the user.
     */
    function app_timezone(): string
    {
        $config = config(App::class);

        return $config->appTimezone;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('is_php')) {
    /**
     * Determines if the current version of PHP is equal to or greater than the supplied value
     *
     * @param string
     * @return    bool    TRUE if the current version is $version or higher
     */
    function is_php($version)
    {
        static $_is_php;
        $version = (string)$version;

        if (!isset($_is_php[$version])) {
            $_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
        }

        return $_is_php[$version];
    }
}

// ------------------------------------------------------------------------

if (! function_exists('clean_path')) {
    /**
     * A convenience method to clean paths for
     * a nicer looking output. Useful for exception
     * handling, error logging, etc.
     */
    function clean_path(string $path): string
    {
        // Resolve relative paths
        try {
            $path = realpath($path) ?: $path;
        } catch (ErrorException|ValueError $e) {
            $path = 'error file path: ' . urlencode($path);
        }

        return match (true) {
            str_starts_with($path, APPPATH) => 'APPPATH' . DIRECTORY_SEPARATOR . substr($path, strlen(APPPATH)),
            str_starts_with($path, ROOTPATH) => 'ROOTPATH' . DIRECTORY_SEPARATOR . substr($path, strlen(ROOTPATH)),
            str_starts_with($path, SYSTEMPATH) => 'SYSTEMPATH' . DIRECTORY_SEPARATOR . substr($path, strlen(SYSTEMPATH)),
            str_starts_with($path, FCPATH) => 'FCPATH' . DIRECTORY_SEPARATOR . substr($path, strlen(FCPATH)),
            defined('VENDORPATH') && str_starts_with($path, VENDORPATH) => 'VENDORPATH' . DIRECTORY_SEPARATOR . substr($path, strlen(VENDORPATH)),
            default => $path,
        };
    }
}

// ------------------------------------------------------------------------

if (!function_exists('is_really_writable')) {
    /**
     * Tests for file writability
     *
     * is_writable() returns TRUE on Windows servers when you really can't write to
     * the file, based on the read-only attribute. is_writable() is also unreliable
     * on Unix servers if safe_mode is on.
     *
     * @link    https://bugs.php.net/bug.php?id=54709
     * @param string
     * @return    bool
     */
    function is_really_writable($file)
    {
        // If we're on a Unix server with safe_mode off we call is_writable
        if (DIRECTORY_SEPARATOR === '/' && (is_php('5.4') or !ini_get('safe_mode'))) {
            return is_writable($file);
        }

        /* For Windows servers and safe_mode "on" installations we'll actually
         * write a file then read it. Bah...
         */
        if (is_dir($file)) {
            $file = rtrim($file, '/') . '/' . md5(mt_rand());
            if (($fp = @fopen($file, 'ab')) === FALSE) {
                return FALSE;
            }

            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);
            return TRUE;
        } elseif (!is_file($file) or ($fp = @fopen($file, 'ab')) === FALSE) {
            return FALSE;
        }

        fclose($fp);
        return TRUE;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('load_class')) {
    /**
     * Class registry
     *
     * This function acts as a singleton. If the requested class does not
     * exist it is instantiated and set to a static variable. If it has
     * previously been instantiated the variable is returned.
     *
     * @param string $class the class name being requested
     * @param string $directory the directory where the class should be found
     * @param mixed $param an optional argument to pass to the class constructor
     * @return    object
     */
    function &load_class($class, $directory = 'libraries', $param = null): object
    {
        static $_classes = array();

        // Does the class exist? If so, we're done...
        if (isset($_classes[$class])) {
            return $_classes[$class];
        }

        $name = false;

        // Look for the class first in the local application/libraries folder
        // then in the native system/libraries folder
        foreach (array(APPPATH, SYSTEMPATH) as $path) {
            if (file_exists($path . $directory . DIRECTORY_SEPARATOR . $class . '.php')) {
                $name = 'CI_' . $class;

                if (class_exists($name, false) === false) {

                    require_once($path . $directory . DIRECTORY_SEPARATOR . $class . '.php');
                }

                break;
            }
        }

        // Is the request a class extension? If so we load it too
        if (file_exists(APPPATH . $directory . DIRECTORY_SEPARATOR . config_item('subclass_prefix') . $class . '.php')) {
            $name = config_item('subclass_prefix') . $class;

            if (class_exists($name, false) === false) {
                require_once(APPPATH . $directory . DIRECTORY_SEPARATOR . $name . '.php');
            }
        }

        // Did we find the class?
        if ($name === false) {
            // Note: We use exit() rather than show_error() in order to avoid a
            // self-referencing loop with the Exceptions class
            set_status_header(503);
            echo 'Unable to locate the specified class: ' . $class . '.php';
            exit(5); // EXIT_UNK_CLASS
        }

        // Keep track of what we just loaded
        is_loaded($class);

        $_classes[$class] = isset($param)
            ? new $name($param)
            : new $name();
        return $_classes[$class];
    }
}

// --------------------------------------------------------------------

if (!function_exists('is_loaded')) {
    /**
     * Keeps track of which libraries have been loaded. This function is
     * called by the load_class() function above
     *
     * @param string
     * @return    array
     */
    function &is_loaded($class = '')
    {
        static $_is_loaded = array();

        if ($class !== '') {
            $_is_loaded[strtolower($class)] = $class;
        }

        return $_is_loaded;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('get_config')) {
    /**
     * Loads the main config.php file
     *
     * This function lets us grab the config file even if the Config class
     * hasn't been instantiated yet
     *
     * @param array
     * @return    array
     */
    function &get_config(array $replace = []): array
    {
        static $config;

        if (empty($config)) {
            $file_path = APPPATH . 'config/config.php';
            $found = false;
            if (file_exists($file_path)) {
                $found = true;
                require($file_path);
            }

            // Is the config file in the environment folder?
            if (file_exists($file_path = APPPATH . 'config/' . ENVIRONMENT . '/config.php')) {
                require($file_path);
            } elseif (!$found) {
                set_status_header(503);
                echo 'The configuration file does not exist.';
                exit(3); // EXIT_CONFIG
            }

            // Does the $config array exist in the file?
            if (!isset($config) or !is_array($config)) {
                set_status_header(503);
                echo 'Your config file does not appear to be formatted correctly.';
                exit(3); // EXIT_CONFIG
            }
        }

        // Are any values being dynamically added or replaced?
        foreach ($replace as $key => $val) {
            $config[$key] = $val;
        }

        return $config;
    }
}

/**
 * Common Functions
 *
 * Several application-wide utility methods.
 *
 * @package  CodeIgniter
 * @category Common Functions
 */

if (!function_exists('get_config2')) {
    /**
     * Loads a config file from the application/config directory, taking
     * any environment-specific versions of the config file into account.
     *
     * This function lets us grab the config file even if the Config class
     * hasn't been instantiated yet
     *
     * @param string $file
     *
     * @return    array
     */
    function &get_config2(string $file): array
    {
        static $config;

        if (empty($config[$file])) {
            $file_path = rtrim(str_replace(['\\', '/'], DIRECTORY_SEPARATOR, ROOTPATH), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . basename(APPPATH) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $file . '.php';
            $found = false;

            if (file_exists($file_path)) {
                $found = true;
                $config[$file] = require($file_path);
            }

            if (!$found) {
                set_status_header(503);
                echo 'The configuration file ' . $file . '.php does not exist.';
                exit(3); // EXIT_CONFIG
            }

            // Does the $config array exist in the file?
            if (!isset($config) or !is_array($config)) {
                set_status_header(503);
                echo 'Your config file does not appear to be formatted correctly.';
                exit(3); // EXIT_CONFIG
            }
        }

        return $config;
    }
}


if (! function_exists('config')) {
    /**
     * More simple way of getting config instances from Factories
     *
     * @template ConfigTemplate of BaseConfig
     *
     * @param class-string<ConfigTemplate>|string $name
     *
     * @return         ConfigTemplate|null
     * @phpstan-return ($name is class-string<ConfigTemplate> ? ConfigTemplate : object|null)
     */
    function config(string $name, bool $getShared = true)
    {
        if ($getShared) {
            return Factories::get('config', $name);
        }

        return Factories::config($name, ['getShared' => $getShared]);
    }
}

//--------------------------------------------------------------------

if (!function_exists('config_item')) {
    /**
     * Returns the specified config item
     *
     * @param string
     * @return    mixed
     */
    function config_item($item)
    {
        static $_config;

        if (empty($_config)) {
            // references cannot be directly assigned to static variables, so we use an array
            $_config[0] =& get_config();
        }

        return isset($_config[0][$item]) ? $_config[0][$item] : NULL;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('get_mimes')) {
    /**
     * Returns the MIME types array from config/mimes.php
     *
     * @return    array
     */
    function &get_mimes()
    {
        static $_mimes;

        if (empty($_mimes)) {
            $_mimes = file_exists(APPPATH . 'config/mimes.php')
                ? include(APPPATH . 'config/mimes.php')
                : array();

            if (file_exists(APPPATH . 'config/' . ENVIRONMENT . '/mimes.php')) {
                $_mimes = array_merge($_mimes, include(APPPATH . 'config/' . ENVIRONMENT . '/mimes.php'));
            }
        }

        return $_mimes;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('is_https')) {
    /**
     * Is HTTPS?
     *
     * Determines if the application is accessed via an encrypted
     * (HTTPS) connection.
     *
     * @return    bool
     */
    function is_https()
    {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return TRUE;
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
            return TRUE;
        } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return TRUE;
        }

        return FALSE;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('is_cli')) {

    /**
     * Is CLI?
     *
     * Test to see if a request was made from the command line.
     *
     * @return    bool
     */
    function is_cli()
    {
        return (PHP_SAPI === 'cli' or defined('STDIN'));
    }
}

// ------------------------------------------------------------------------

if (!function_exists('show_error')) {
    /**
     * Error Handler
     *
     * This function lets us invoke the exception class and
     * display errors using the standard error template located
     * in application/views/errors/error_general.php
     * This function will send the error page directly to the
     * browser and exit.
     *
     * @param string $message
     * @param int $status_code
     * @return    void
     */
    function show_error(string $message, int $status_code = 500)
    {
        $status_code = abs($status_code);
        if ($status_code < 100) {
            $status_code = 500;
        }

        throw new GeneralException($message, $status_code);
    }
}

// ------------------------------------------------------------------------

if (! function_exists('show_404')) {
    /**
     * @param   string $page      Page URI
     * @param   bool   $log_error Whether to log the error
     */
    function show_404(string $page = '', bool $log_error = true): void
    {
        if (is_cli()) {
            $heading = 'Not Found';
            $message = 'The controller/method pair you requested was not found.';
        } else {
            $heading = '404 Page Not Found';
            $message = 'The page you requested was not found.';
        }

        // By default we log this, but allow a dev to skip it
        if ($log_error) {
            log_message('error', $heading . ': ' . $page);
        }

        throw new PageNotFoundException($heading . ': ' . $message);
    }
}

// ------------------------------------------------------------------------


if (!function_exists('log_message')) {
    /**
     * A convenience/compatibility method for logging events through
     * the Log system.
     *
     * Allowed log levels are:
     *  - emergency
     *  - alert
     *  - critical
     *  - error
     *  - warning
     *  - notice
     *  - info
     *  - debug
     *
     * @param string $level
     * @param        $message
     * @param array $context
     *
     * @return mixed
     */
    function log_message(string $level, $message, array $context = [])
    {
        return Services::logger(false)->log($level, $message, $context);
    }
}

//--------------------------------------------------------------------

if (!function_exists('set_status_header')) {
    /**
     * Set HTTP Status Header
     *
     * @param int    the status code
     * @param string
     * @return    void
     */
    function set_status_header($code = 200, $text = '')
    {
        if (is_cli()) {
            return;
        }

        if (empty($code) or !is_numeric($code)) {
            show_error('Status codes must be numeric', 500);
        }

        if (empty($text)) {
            is_int($code) or $code = (int)$code;
            $stati = array(
                100 => 'Continue',
                101 => 'Switching Protocols',

                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',

                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                307 => 'Temporary Redirect',

                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                422 => 'Unprocessable Entity',
                426 => 'Upgrade Required',
                428 => 'Precondition Required',
                429 => 'Too Many Requests',
                431 => 'Request Header Fields Too Large',

                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported',
                511 => 'Network Authentication Required',
            );

            if (isset($stati[$code])) {
                $text = $stati[$code];
            } else {
                show_error('No status text available. Please check your status code number or supply your own message text.', 500);
            }
        }

        if (strpos(PHP_SAPI, 'cgi') === 0) {
            header('Status: ' . $code . ' ' . $text, TRUE);
            return;
        }

        $server_protocol = (isset($_SERVER['SERVER_PROTOCOL']) && in_array($_SERVER['SERVER_PROTOCOL'], array('HTTP/1.0', 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0'), TRUE))
            ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
        header($server_protocol . ' ' . $code . ' ' . $text, TRUE, $code);
    }
}

// --------------------------------------------------------------------

if (!function_exists('_string_handler')) {
    function _string_handler($class)
    {
        if (preg_match('/\S{50,}/', $class)) {
            return true;
        }
    }
}

// --------------------------------------------------------------------

if (!function_exists('remove_invisible_characters')) {
    /**
     * Remove Invisible Characters
     *
     * This prevents sandwiching null characters
     * between ascii characters, like Java\0script.
     *
     * @param string
     * @param bool
     * @return    string
     */
    function remove_invisible_characters($str, $url_encoded = TRUE)
    {
        $non_displayables = array();

        // every control character except newline (dec 10),
        // carriage return (dec 13) and horizontal tab (dec 09)
        if ($url_encoded) {
            $non_displayables[] = '/%0[0-8bcef]/i';    // url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/i';    // url encoded 16-31
            $non_displayables[] = '/%7f/i';    // url encoded 127
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';    // 00-08, 11, 12, 14-31, 127

        do {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        } while ($count);

        return $str;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('html_escape')) {
    /**
     * Returns HTML escaped variable.
     *
     * @param mixed $var The input string or array of strings to be escaped.
     * @param bool $double_encode $double_encode set to FALSE prevents escaping twice.
     * @return    mixed            The escaped string or array of strings as a result.
     */
    function html_escape($var, $double_encode = TRUE)
    {
        if (empty($var)) {
            return $var;
        }

        if (is_array($var)) {
            foreach (array_keys($var) as $key) {
                $var[$key] = html_escape($var[$key], $double_encode);
            }

            return $var;
        }

        return htmlspecialchars($var, ENT_QUOTES, config_item('charset'), $double_encode);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('stringify_attributes')) {
    /**
     * Stringify attributes for use in HTML tags.
     *
     * Helper function used to convert a string, array, or object
     * of attributes to a string.
     *
     * @param mixed    string, array, object
     * @param bool
     * @return    string
     */
    function stringify_attributes($attributes, $js = FALSE)
    {
        if (empty($attributes)) {
            return NULL;
        }

        if (is_string($attributes)) {
            return ' ' . $attributes;
        }

        $attributes = (array)$attributes;

        $atts = '';
        foreach ($attributes as $key => $val) {
            $atts .= ($js) ? $key . '=' . $val . ',' : ' ' . $key . '="' . $val . '"';
        }

        return rtrim($atts, ',');
    }
}

// ------------------------------------------------------------------------

if (!function_exists('function_usable')) {
    /**
     * Function usable
     *
     * Executes a function_exists() check, and if the Suhosin PHP
     * extension is loaded - checks whether the function that is
     * checked might be disabled in there as well.
     *
     * This is useful as function_exists() will return FALSE for
     * functions disabled via the *disable_functions* php.ini
     * setting, but not for *suhosin.executor.func.blacklist* and
     * *suhosin.executor.disable_eval*. These settings will just
     * terminate script execution if a disabled function is executed.
     *
     * The above described behavior turned out to be a bug in Suhosin,
     * but even though a fix was committed for 0.9.34 on 2012-02-12,
     * that version is yet to be released. This function will therefore
     * be just temporary, but would probably be kept for a few years.
     *
     * @link    http://www.hardened-php.net/suhosin/
     * @param string $function_name Function to check for
     * @return    bool    TRUE if the function exists and is safe to call,
     *            FALSE otherwise.
     */
    function function_usable($function_name)
    {
        static $_suhosin_func_blacklist;

        if (function_exists($function_name)) {
            if (!isset($_suhosin_func_blacklist)) {
                $_suhosin_func_blacklist = extension_loaded('suhosin')
                    ? explode(',', trim(ini_get('suhosin.executor.func.blacklist')))
                    : array();
            }

            return !in_array($function_name, $_suhosin_func_blacklist, true);
        }

        return false;
    }
}

if (!function_exists('route_to')) {
    /**
     * Given a controller/method string and any params,
     * will attempt to build the relative URL to the
     * matching route.
     *
     * NOTE: This requires the controller/method to
     * have a route defined in the routes config file.
     *
     * @param string $method
     * @param        ...$params
     *
     * @return \CodeIgniter\Router\string
     */
    function route_to(string $method, ...$params): string
    {
        global $routes;

        return $routes->reverseRoute($method, ...$params);
    }
}

//--------------------------------------------------------------------

if (! function_exists('db_connect')) {
    /**
     * Grabs a database connection and returns it to the user.
     *
     * This is a convenience wrapper for \Config\Database::connect()
     * and supports the same parameters. Namely:
     *
     * When passing in $db, you may pass any of the following to connect:
     * - group name
     * - existing connection instance
     * - array of database configuration values
     *
     * If $getShared === false then a new connection instance will be provided,
     * otherwise it will all calls will return the same instance.
     *
     * @param array|ConnectionInterface|string|null $db
     *
     * @return BaseConnection
     */
    function db_connect($db = null, bool $getShared = true)
    {
        return Database::connect($db, $getShared);
    }
}

//--------------------------------------------------------------------

if (! function_exists('env')) {
    /**
     * Allows user to retrieve values from the environment
     * variables that have been set. Especially useful for
     * retrieving values set from the .env file for
     * use in config files.
     *
     * @param string|null $default
     *
     * @return bool|string|null
     */
    function env(string $key, $default = null)
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        // Not found? Return the default value
        if ($value === false) {
            return $default;
        }

        // Handle any boolean values
        return match (strtolower($value)) {
            'true' => true,
            'false' => false,
            'empty' => '',
            'null' => null,
            default => $value,
        };

    }
}

//--------------------------------------------------------------------

if (!function_exists('esc')) {
    /**
     * Performs simple auto-escaping of data for security reasons.
     * Might consider making this more complex at a later date.
     *
     * If $data is a string, then it simply escapes and returns it.
     * If $data is an array, then it loops over it, escaping each
     * 'value' of the key/value pairs.
     *
     * Valid context values: html, js, css, url, attr, raw, null
     *
     * @param string|array $data
     * @param string $context
     * @param string $encoding
     *
     * @return $data
     */
    function esc($data, $context = 'html', $encoding = null)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                $value = esc($value, $context);
            }
        }

        if (is_string($data)) {
            $context = strtolower($context);

            // Provide a way to NOT escape data since
            // this could be called automatically by
            // the View library.
            if (empty($context) || $context == 'raw') {
                return $data;
            }

            if (!in_array($context, ['html', 'js', 'css', 'url', 'attr'])) {
                throw new \InvalidArgumentException('Invalid escape context provided.');
            }

            if ($context == 'attr') {
                $method = 'escapeHtmlAttr';
            } else {
                $method = 'escape' . ucfirst($context);
            }

            $escaper = new Escaper($encoding);

            $data = $escaper->$method($data);
        }

        return $data;
    }
}

//--------------------------------------------------------------------

if (!function_exists('service')) {
    /**
     * Allows cleaner access to the Services Config file.
     * Always returns a SHARED instance of the class, so
     * calling the function multiple times should always
     * return the same instance.
     *
     * These are equal:
     *  - $timer = service('timer')
     *  - $timer = \CodeIgniter\Config\Services::timer();
     *
     * @param array|bool|float|int|object|string|null ...$params
     */
    function service(string $name, ...$params): ?object
    {
        if ($params === []) {
            return Services::get($name);
        }

        return Services::$name(...$params);
    }
}

if (!function_exists('remove_invisible_characters')) {
    /**
     * Remove Invisible Characters
     *
     * This prevents sandwiching null characters
     * between ascii characters, like Java\0script.
     *
     * @param string
     * @param bool
     * @return    string
     */
    function remove_invisible_characters($str, $url_encoded = TRUE)
    {
        $non_displayables = array();

        // every control character except newline (dec 10),
        // carriage return (dec 13) and horizontal tab (dec 09)
        if ($url_encoded) {
            $non_displayables[] = '/%0[0-8bcef]/';    // url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/';    // url encoded 16-31
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';    // 00-08, 11, 12, 14-31, 127

        do {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        } while ($count);

        return $str;
    }
}

if (!function_exists('get_csrf_token_name')) {
    /**
     * Returns the CSRF token name.
     * Can be used in views when building hidden inputs manually,
     * or used in javascript vars when using APIs.
     *
     * @return string
     */
    function get_csrf_token_name()
    {
        return config_item('csrf_token_name');
    }
}

//--------------------------------------------------------------------

if (!function_exists('get_csrf_hash')) {
    /**
     * Returns the current hash value for the CSRF protection.
     * Can be used in views when building hidden inputs manually,
     * or used in javascript vars for API usage.
     *
     * @return string
     */
    function get_csrf_hash()
    {
        $security = Services::security(null, true);

        return $security->getCSRFHash();
    }
}

//--------------------------------------------------------------------
