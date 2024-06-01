<?php

# Import required classes
use MX\CI;

# Make sure we're in CI
defined('BASEPATH') OR exit('No direct script access allowed');

# Define: Directory separator shortcut
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

# Define: PHP Ext
if(!defined('PHP'))
    define('PHP', '.' . pathinfo(basename(__FILE__), PATHINFO_EXTENSION));

# Define: Router class
if(!defined('CI_CLASS'))
    define('CI_CLASS', strtolower(CI::$APP->router->fetch_class()));

# Define: Router module
if(!defined('CI_MODULE'))
    define('CI_MODULE', strtolower(CI::$APP->router->fetch_module()));

# Define: Router method
if(!defined('CI_METHOD'))
    define('CI_METHOD', strtolower(CI::$APP->router->fetch_method()));

# Define: Theme base url
if(!defined('T_BASE_URL'))
    define('T_BASE_URL', rtrim(base_url(str_replace(['\\', DS], '/', basename(APPPATH)) . '/themes/' . CI::$APP->config->item('theme')), '/') . '/');

# Define: Theme base path
if(!defined('T_ROOT_PATH'))
    define('T_ROOT_PATH', rtrim(str_replace(['\\', '/'], DS, realpath(APPPATH)), DS) . DS . 'themes' . DS . CI::$APP->config->item('theme') . DS);

# Define: CMS base path
if(!defined('CMS_ROOT_PATH'))
    define('CMS_ROOT_PATH', rtrim(str_replace(['\\', '/', basename(APPPATH)], [DS, DS, ''], realpath(APPPATH)), DS) . DS);

# Prevent errors
$config = [];
