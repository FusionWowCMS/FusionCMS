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
    'global_or' => 'ou',
    'global_icon' => 'Icône',
    'global_okay' => 'D\'accord',
    'global_accept' => 'Accepter',
    'global_reject' => 'Refuser',
    'global_cancel' => 'Annuler',
    'global_online' => 'En ligne',
    'global_offline' => 'Hors ligne',
    'global_loading' => 'Chargement...',
    'global_user_avatar' => 'Avatar de %s'
]);

/**
 * - Main Template -------------------------------------------
 * -----------------------------------------------------------
 */
$lang = array_merge($lang, [
    # Logo
    'logo' => 'Bienvenue sur %s',

    # Menu
    'nav' => 'Navigation',

    # User buttons
    'account'  => 'Compte',
    'register' => 'S\'inscrire',

    # Banner 1
    'banner01_text01' => 'Bienvenue sur %s',
    'banner01_text02' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',

    # Banner 2
    'banner02_text01' => 'Apprenez comment',
    'banner02_text02' => 'vous connecter',
    'banner02_text03' => 'à nos royaumes',
    'banner02_text04' => 'cliquez pour lire',

    # Copyright
    'copyright' => '%s &copy; Copyright %s'
]);
