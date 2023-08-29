<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!isset($lang) || !is_array($lang))
    $lang = [];

/**
 * - RTL -----------------------------------------------------
 * -----------------------------------------------------------
 */
$lang['isRTL'] = 0;

/**
 * - Global --------------------------------------------------
 * -----------------------------------------------------------
 */
$lang = array_merge($lang, [
    'global_or'          => 'or',
    'global_icon'        => 'Icon',
    'global_okay'        => 'Okay',
    'global_accept'      => 'Accept',
    'global_reject'      => 'Reject',
    'global_cancel'      => 'Cancel',
    'global_online'      => 'Online',
    'global_offline'     => 'Offline',
    'global_loading'     => 'Loading...',
    'global_user_avatar' => '%s\'s Avatar'
]);

/**
 * - Main Template -------------------------------------------
 * -----------------------------------------------------------
 */
$lang = array_merge($lang, [
    # Logo
    'logo' => 'Welcome to %s',

    # Menu
    'nav' => 'Navigation',

    # User buttons
    'account'  => 'Account',
    'register' => 'Register',

    # Banner 1
    'banner01_text01' => 'Welcome to %s',
    'banner01_text02' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',

    # Banner 2
    'banner02_text01' => 'Learn how',
    'banner02_text02' => 'to connect',
    'banner02_text03' => 'to our realms',
    'banner02_text04' => 'click to read',

    # Copyright
    'copyright' => '%s &copy; Copyright %s'
]);
