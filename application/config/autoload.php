<?php

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Helper files
| 4. Custom config files
| 5. Language files
| 6. Models
|
*/


/**
 * -------------------------------------------------------------------
 * AUTO-LOADER
 * -------------------------------------------------------------------
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 */

/**
 * -------------------------------------------------------------------
 * Namespaces
 * -------------------------------------------------------------------
 * This maps the locations of any namespaces in your application
 * to their location on the file system. These are used by the
 * Autoloader to locate files the first time they have been instantiated.
 *
 * The '/application' and '/system' directories are already mapped for
 * you. You may change the name of the 'App' namespace if you wish,
 * but this should be done prior to creating any namespaced classes,
 * else you will need to modify all of those classes for this to work.
 *
 * DO NOT change the name of the CodeIgniter namespace or your application
 * WILL break. *
 * Prototype:
 *
 *   $config['psr4'] = [
 *       'CodeIgniter' => SYSPATH
 *   `];
 */
$config['psr4'] = [
    APP_NAMESPACE     => APPPATH,
    'App\Config'      => APPPATH.'config',
    'CodeIgniter'     => realpath(SYSTEMPATH)
];

/**
 * -------------------------------------------------------------------
 * Class Map
 * -------------------------------------------------------------------
 * The class map provides a map of class names and their exact
 * location on the drive. Classes loaded in this manner will have
 * slightly faster performance because they will not have to be
 * searched for within one or more directories as they would if they
 * were being autoloaded through a namespace.
 *
 * Prototype:
 *
 *   $config['classmap'] = [
 *       'MyClass'   => '/path/to/class/file.php'
 *   ];
 */
$config['classmap'] = [
    'CodeIgniter\Log\Logger'                      => SYSTEMPATH . 'Log/Logger.php',
    'Laminas\Escaper\Escaper'                     => SYSTEMPATH . 'View/Escaper.php'
];

if(!file_exists(WRITEPATH . 'install/.lock'))
    return;

/*
| -------------------------------------------------------------------
|  Auto-load Packges
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = [APPPATH.'third_party', '/usr/local/shared'];
|
*/

$autoload['packages'] = [];


/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in the system/libraries folder
| or in your application/libraries folder.
|
| Prototype:
|
|   $autoload['libraries'] = ['database', 'cache', 'security'];
*/

$autoload['libraries'] = ['security', 'cache', 'database', 'smartyengine' => 'smarty', 'template', 'language', 'realms', 'acl', 'user', 'dblogger', 'dbbackup', 'captcha', 'recaptcha', 'items', 'crypto'];

/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|   $autoload['drivers'] = ['cache'];
*/
$autoload['drivers'] = [''];


/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['helper'] = ['url', 'file'];
*/

$autoload['helper'] = ['url', 'emulator', 'form', 'text', 'lang', 'breadcumb', 'permission', 'tinymce'];


/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['config'] = ['config1', 'config2'];
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/

$autoload['config'] = ['language', 'version', 'acl_defaults', 'fusion', 'message', 'backups', 'cdn', 'captcha', 'social_media', 'performance', 'wow_db', 'wow_expansions', 'auth'];


/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['language'] = ['lang1', 'lang2'];
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as ['codeigniter'];
|
*/

$autoload['language'] = [];


/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['model'] = ['model1', 'model2'];
|
*/

$autoload['model'] = ['cms_model', 'external_account_model', 'internal_user_model', 'acl_model'];


/* End of file autoload.php */
/* Location: ./application/config/autoload.php */
