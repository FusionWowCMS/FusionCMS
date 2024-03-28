<?php

# Import required classes
use MX\CI;

# Make sure we're in CI
defined('BASEPATH') OR exit('No direct script access allowed');

# Directory separator
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

# PHP Ext
if(!defined('PHP'))
    define('PHP', '.php');

# Theme base url
if(!defined('T_BASE_URL'))
    define('T_BASE_URL', rtrim(base_url() . str_replace(['\\', DS], '/', basename(APPPATH) . '/themes/' . CI::$APP->config->item('theme')), '/') . '/');

# Theme base path
if(!defined('T_ROOT_PATH'))
    define('T_ROOT_PATH', rtrim(str_replace(['\\', '/'], DS, realpath(APPPATH)), DS) . DS . 'themes' . DS . CI::$APP->config->item('theme') . DS);

# CMS base path
if(!defined('CMS_ROOT_PATH'))
    define('CMS_ROOT_PATH', rtrim(str_replace(['\\', '/', basename(APPPATH)], [DS, DS, ''], realpath(APPPATH)), DS) . DS);

# Prevent errors
$config = [];
