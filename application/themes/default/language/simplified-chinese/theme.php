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
    'global_accept'      => '接受',
    'global_reject'      => 'Reject',
    'global_cancel'      => '取消',
    'global_online'      => '在线',
    'global_offline'     => '离线',
    'global_loading'     => '加载...',
    'global_user_avatar' => '%s\'s 头像'
]);

/**
 * - Main Template -------------------------------------------
 * -----------------------------------------------------------
 */
$lang = array_merge($lang, [
    # Logo
    'logo' => '欢迎来到%s',

    # Menu
    'nav' => '导航',

    # User buttons
    'account'  => '账户',
    'register' => '注册',

    # Banner 1
    'banner01_text01' => '欢迎来到%s',
    'banner01_text02' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',

    # Banner 2
    'banner02_text01' => 'Learn how',
    'banner02_text02' => 'to connect',
    'banner02_text03' => 'to our realms',
    'banner02_text04' => 'click to read',

    # Copyright
    'copyright' => '%s &copy; Copyright %s'
]);
