<?php

/*
 * ---------------------------------------------------------------
 * SETUP OUR PATH CONSTANTS
 * ---------------------------------------------------------------
 *
 * The path constants provide convenient access to the folders
 * throughout the application. We have to setup them up here
 * so they are available in the config files that are loaded.
 */

// The path to the application directory.
use App\Config\Paths;
use App\Config\Services;
use CodeIgniter\Exceptions\FrameworkException;

if (! defined('APPPATH')) {
    /**
     * @var Paths $paths
     */
    define('APPPATH', realpath(rtrim($paths->appDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

// The path to the project root directory. Just above APPPATH.
if (! defined('ROOTPATH')) {
    define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
}

// The path to the system directory.
if (! defined('SYSTEMPATH')) {
    /**
     * @var Paths $paths
     */
    define('SYSTEMPATH', rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR);
}

// The path to the system directory.
if (! defined('BASEPATH')) {
    /**
     * @var Paths $paths
     */
    define('BASEPATH', SYSTEMPATH);
}

// The path to the view directory.
if (! defined('VIEWPATH')) {
    /**
     * @var Paths $paths
     */
    define('VIEWPATH', realpath(rtrim($paths->viewDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

// The path to the writable directory.
if (! defined('WRITEPATH')) {
    /**
     * @var Paths $paths
     */
    define('WRITEPATH', realpath(rtrim($paths->writableDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

/*
 * ------------------------------------------------------
 *  Load any environment-specific settings from .env file
 * ------------------------------------------------------
 */
if (is_file(APPPATH . 'config/Boot/' . ENVIRONMENT . '.php')) {
    require_once APPPATH . 'config/Boot/' . ENVIRONMENT . '.php';
} else {
    // @codeCoverageIgnoreStart{
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'The application environment is not set correctly.';

    exit(EXIT_ERROR); // EXIT_ERROR
    // @codeCoverageIgnoreEnd
}

/*
 * ---------------------------------------------------------------
 * GRAB OUR CONSTANTS & COMMON
 * ---------------------------------------------------------------
 */

if (! defined('APP_NAMESPACE')) {
    require_once APPPATH . 'config/constants.php';
}

// Require app/Common.php file if exists.
if (is_file(APPPATH . 'Common.php')) {
    require_once APPPATH . 'Common.php';
}

// Require system/Common.php
require_once SYSTEMPATH . 'Common.php';

/*
 * ---------------------------------------------------------------
 * LOAD OUR AUTOLOADER
 * ---------------------------------------------------------------
 *
 * The autoloader allows all of the pieces to work together
 * in the framework. We have to load it here, though, so
 * that the config files can use the path constants.
 */

require SYSTEMPATH.'Autoloader/Autoloader.php';
require APPPATH .'config/autoload.php';
require_once SYSTEMPATH . 'Config/BaseService.php';
require_once SYSTEMPATH . 'Config/Services.php';
require_once APPPATH . 'config/Services.php';

$loader = Services::autoloader();
$loader->initialize(get_config2('autoload'));
$loader->register();    // Register the loader with the SPL autoloader stack.

/*
 * ---------------------------------------------------------------
 * SET EXCEPTION AND ERROR HANDLERS
 * ---------------------------------------------------------------
 */

Services::exceptions()->initialize();

/*
 * ---------------------------------------------------------------
 * CHECK SYSTEM FOR MISSING REQUIRED PHP EXTENSIONS
 * ---------------------------------------------------------------
 */

// Run this check for manual installations
if (! is_file(COMPOSER_PATH)) {
    $missingExtensions = [];

    foreach ([
                 'intl',
                 'json',
                 'mbstring',
             ] as $extension) {
        if (! extension_loaded($extension)) {
            $missingExtensions[] = $extension;
        }
    }

    if ($missingExtensions !== []) {
        throw FrameworkException::forMissingExtension(implode(', ', $missingExtensions));
    }

    unset($missingExtensions);
}
