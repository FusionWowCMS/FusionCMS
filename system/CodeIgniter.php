<?php

use App\Config\Services;
use CodeIgniter\Events\Events;
use App\Config\App;

/**
 * System Initialization File
 *
 * Loads the base classes and executes the request.
 *
 * @package CodeIgniter
 */

/**
 * CodeIgniter Version
 *
 * @var    string
 *
 */
const CI_VERSION = '4.4.3';

$appConfig ??= config(App::class);

// Set default timezone on the server
date_default_timezone_set($appConfig->appTimezone ?? 'UTC');

//--------------------------------------------------------------------
// Start the Benchmark
//--------------------------------------------------------------------

// Record app start time here. It's a little bit off, but
// keeps it lining up with the benchmark timers.
$startTime = microtime(true);
$startMemory = memory_get_usage(true);

$benchmark = Services::timer(true);
$benchmark->start('total_execution');
$benchmark->start('bootstrap');

//--------------------------------------------------------------------
// CSRF Protection
//--------------------------------------------------------------------

/*if (config_item('csrf_protection') === true && ! is_cli())
{
    $security = \Config\Services::security();

    $security->CSRFVerify();
}*/

//--------------------------------------------------------------------
// Get our Request and Response objects
//--------------------------------------------------------------------

$request = is_cli()
    ? Services::clirequest()
    : Services::request($appConfig);
$request->setProtocolVersion($_SERVER['SERVER_PROTOCOL']);
$response = Services::response();

// Assume success until proven otherwise.
$response->setStatusCode(200);

/*
 * ------------------------------------------------------
 *  Set the subclass_prefix
 * ------------------------------------------------------
 *
 * Normally the "subclass_prefix" is set in the config file.
 * The subclass prefix allows CI to know if a core class is
 * being extended via a library in the local application
 * "libraries" folder. Since CI allows config items to be
 * overridden via data set in the main index.php file,
 * before proceeding we need to know if a subclass_prefix
 * override exists. If so, we will set this value now,
 * before any classes are loaded
 * Note: Since the config file data is cached it doesn't
 * hurt to load it here.
 */
if (!empty($assign_to_config['subclass_prefix'])) {
    get_config(array('subclass_prefix' => $assign_to_config['subclass_prefix']));
}

$benchmark->start('loading_time:_base_classes');

//--------------------------------------------------------------------
// Are there any "pre-system" hooks?
//--------------------------------------------------------------------

Events::trigger('pre_system');

/*
 * ------------------------------------------------------
 *  Instantiate the config class
 * ------------------------------------------------------
 *
 * Note: It is important that Config is loaded first as
 * most other classes depend on it either directly or by
 * depending on another class that uses it.
 *
 */
$CFG =& load_class('Config', 'core');

// Do we have any manually set config items in the index.php file?
if (isset($assign_to_config) && is_array($assign_to_config)) {
    foreach ($assign_to_config as $key => $value) {
        $CFG->set_item($key, $value);
    }
}

/*
 * ------------------------------------------------------
 * Important charset-related stuff
 * ------------------------------------------------------
 *
 * Configure mbstring and/or iconv if they are enabled
 * and set MB_ENABLED and ICONV_ENABLED constants, so
 * that we don't repeatedly do extension_loaded() or
 * function_exists() calls.
 *
 * Note: UTF-8 class depends on this. It used to be done
 * in it's constructor, but it's _not_ class-specific.
 *
 */
$charset = strtoupper(config_item('charset'));
ini_set('default_charset', $charset);

if (extension_loaded('mbstring')) {
    define('MB_ENABLED', true);
    // mbstring.internal_encoding is deprecated starting with PHP 5.6
    // and it's usage triggers E_DEPRECATED messages.
    if (ini_get('mbstring.internal_encoding')) {
        ini_set('mbstring.internal_encoding', $charset);
    }
    // This is required for mb_convert_encoding() to strip invalid characters.
    // That's utilized by CI_Utf8, but it's also done for consistency with iconv.
    mb_substitute_character('none');
} else {
    define('MB_ENABLED', false);
}

// There's an ICONV_IMPL constant, but the PHP manual says that using
// iconv's predefined constants is "strongly discouraged".
if (extension_loaded('iconv')) {
    define('ICONV_ENABLED', true);
    // iconv.internal_encoding is deprecated starting with PHP 5.6
    // and it's usage triggers E_DEPRECATED messages.
    if (ini_get('iconv.internal_encoding')) {
        ini_set('iconv.internal_encoding', $charset);
    }
} else {
    define('ICONV_ENABLED', false);
}

/*
 * ------------------------------------------------------
 *  Instantiate the UTF-8 class
 * ------------------------------------------------------
 */
$UNI =& load_class('Utf8', 'core');

/*
 * ------------------------------------------------------
 *  Instantiate the URI class
 * ------------------------------------------------------
 */
$URI =& load_class('URI', 'core');

/*
 * ------------------------------------------------------
 *  Instantiate the routing class and set the routing
 * ------------------------------------------------------
 */
$RTR =& load_class('Router', 'core', $routing ?? NULL);

/*
 * ------------------------------------------------------
 *  Instantiate the output class
 * ------------------------------------------------------
 */
$OUT =& load_class('Output', 'core');

/*
 * ------------------------------------------------------
 *	Is there a valid cache file? If so, we're done...
 * ------------------------------------------------------
 */
if ($OUT->_display_cache($CFG, $URI) === true) {
    exit;
}

/*
 * -----------------------------------------------------
 * Load the security class for xss and csrf support
 * -----------------------------------------------------
 */
$SEC =& load_class('Security', 'core');

/*
 * ------------------------------------------------------
 *  Load the Input class and sanitize globals
 * ------------------------------------------------------
 */
$IN =& load_class('Input', 'core');

/*
 * ------------------------------------------------------
 *  Load the Language class
 * ------------------------------------------------------
 */
$LANG =& load_class('Lang', 'core');

/*
 * ------------------------------------------------------
 *  Load the app controller and local controller
 * ------------------------------------------------------
 *
 */
// Load the base controller class
require_once SYSTEMPATH . 'Controller.php';

/**
 * Reference to the Controller method.
 *
 * Returns current CI instance object
 *
 * @return Controller
 */
function &get_instance(): Controller
{
    return Controller::get_instance();
}

if (file_exists(APPPATH . 'core/' . $CFG->config['subclass_prefix'] . 'Controller.php')) {
    require_once APPPATH . 'core/' . $CFG->config['subclass_prefix'] . 'Controller.php';
}

$benchmark->stop('loading_time:_base_classes');

/*
 * ------------------------------------------------------
 *  Sanity checks
 * ------------------------------------------------------
 *
 *  The Router class has already validated the request,
 *  leaving us with 3 options here:
 *
 *	1) an empty class name, if we reached the default
 *	   controller, but it didn't exist;
 *	2) a query string which doesn't go through a
 *	   file_exists() check
 *	3) a regular request for a non-existing page
 *
 *  We handle all of these as a 404 error.
 *
 *  Furthermore, none of the methods in the app controller
 *  or the loader class can be called via the URI, nor can
 *  controller methods that begin with an underscore.
 */

$e404 = false;
$class = ucfirst($RTR->class);
$method = $RTR->method;

if (empty($class) or !file_exists(APPPATH . 'controllers/' . $RTR->directory . $class . '.php')) {
    $e404 = true;
} elseif (_string_handler($class)) {
    $e404 = true;
} else {
    require_once(APPPATH . 'controllers/' . $RTR->directory . $class . '.php');

    if (!class_exists($class, false) or $method[0] === '_' or method_exists('Controller', $method)) {
        $e404 = true;
    } elseif (method_exists($class, '_remap')) {
        $params = array($method, array_slice($URI->rsegments, 2));
        $method = '_remap';
    } elseif (!method_exists($class, $method)) {
        $e404 = true;
    } /**
     * DO NOT CHANGE THIS, NOTHING ELSE WORKS!
     *
     * - method_exists() returns true for non-public methods, which passes the previous elseif
     * - is_callable() returns false for PHP 4-style constructors, even if there's a __construct()
     * - method_exists($class, '__construct') won't work because Controller::__construct() is inherited
     * - People will only complain if this doesn't work, even though it is documented that it shouldn't.
     *
     * ReflectionMethod::isConstructor() is the ONLY reliable check,
     * knowing which method will be executed as a constructor.
     */
    else {
        $reflection = new ReflectionMethod($class, $method);
        if (!$reflection->isPublic() or $reflection->isConstructor()) {
            $e404 = true;
        }
    }
}

if ($e404) {
    if (!empty($RTR->routes['404_override'])) {
        if (sscanf($RTR->routes['404_override'], '%[^/]/%s', $error_class, $error_method) !== 2) {
            $error_method = 'index';
        }

        $error_class = ucfirst($error_class);

        if (!class_exists($error_class, false)) {
            if (file_exists(APPPATH . 'controllers/' . $RTR->directory . $error_class . '.php')) {
                require_once(APPPATH . 'controllers/' . $RTR->directory . $error_class . '.php');
                $e404 = !class_exists($error_class, false);
            } // Were we in a directory? If so, check for a global override
            elseif (!empty($RTR->directory) && file_exists(APPPATH . 'controllers/' . $error_class . '.php')) {
                require_once(APPPATH . 'controllers/' . $error_class . '.php');
                if (($e404 = !class_exists($error_class, false)) === false) {
                    $RTR->directory = '';
                }
            }
        } else {
            $e404 = false;
        }
    }

    // Did we reset the $e404 flag? If so, set the rsegments, starting from index 1
    if (!$e404) {
        $class = $error_class;
        $method = $error_method;

        $URI->rsegments = array(
            1 => $class,
            2 => $method
        );
    } else {
        show_404($RTR->directory . $class . '/' . $method);
    }
}

if ($method !== '_remap') {
    $params = array_slice($URI->rsegments, 2);
}

//--------------------------------------------------------------------
// Are there any "pre-controller" hooks?
//--------------------------------------------------------------------

Events::trigger('pre_controller');

/*
 * ------------------------------------------------------
 *  Instantiate the requested controller
 * ------------------------------------------------------
 */
$benchmark->start('controller_execution_time_( ' . $class . ' / ' . $method . ' )');

$CI = new $class();

//--------------------------------------------------------------------
// Are there any "pre-controller" hooks?
//--------------------------------------------------------------------

Events::trigger('post_controller_constructor');

/*
 * ------------------------------------------------------
 *  Call the requested method
 * ------------------------------------------------------
 */
call_user_func_array(array(&$CI, $method), $params);

// Mark a benchmark end point
$benchmark->stop('controller_execution_time_( ' . $class . ' / ' . $method . ' )');

//--------------------------------------------------------------------
// Is there a "post_controller" event?
//--------------------------------------------------------------------

Events::trigger('post_controller');

/*
 * ------------------------------------------------------
 *  Send the final rendered output to the browser
 * ------------------------------------------------------
 */
$OUT->_display();

$output = ob_get_contents();
ob_end_clean();

//--------------------------------------------------------------------
// Replaces the memory_usage and elapsed_time tags.
//--------------------------------------------------------------------
$totalTime = $benchmark->stop('total_execution')->getElapsedTime('total_execution');
$output = str_replace('{elapsed_time}', $totalTime, $output);

//--------------------------------------------------------------------
// Display the Debug Toolbar?
//--------------------------------------------------------------------

$toolbar = Services::toolbar();
$data = $toolbar->run($startTime, $totalTime, $request, $response);
$script = $toolbar->prepare($data, $request, $response);

$output = preg_replace(
    '/<head>/',
    '<head>' . $script,
    $output,
    1
);

$response->setBody($output);

/**
 * Sends the output of this request back to the client.
 * This is what they've been waiting for!
 */
$response->send();

//--------------------------------------------------------------------
// Set default locale on the server
//--------------------------------------------------------------------
Locale::setDefault($appConfig->defaultLocale ?? 'en');

//--------------------------------------------------------------------
// Is there a post-system event?
//--------------------------------------------------------------------

Events::trigger('post_system');