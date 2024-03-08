<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!isset($lang) || !is_array($lang))
    $lang = [];

/**
 * - RTL -----------------------------------------------------
 * -----------------------------------------------------------
 */
$lang['isRTL'] = 0;

/**
 * Suporte ao idioma Português do Brasil por DX-BR
 */

/**
 * - Global --------------------------------------------------
 * -----------------------------------------------------------
 */
$lang = array_merge($lang, [
    'global_or'          => 'ou',
    'global_icon'        => 'Ícone',
    'global_okay'        => 'OK',
    'global_accept'      => 'Aceitar',
    'global_reject'      => 'Rejeitar',
    'global_cancel'      => 'Cancelar',
    'global_online'      => 'Online',
    'global_offline'     => 'Offline',
    'global_loading'     => 'Carregando...',
    'global_user_avatar' => 'Avatar de %s'
]);

/**
 * - Main Template -------------------------------------------
 * -----------------------------------------------------------
 */
$lang = array_merge($lang, [
    # Logo
    'logo' => 'Bem-vindo ao %s',

    # Menu
    'nav' => 'Navegação',

    # Botões do usuário
    'account'  => 'Conta',
    'register' => 'Registrar',

    # Banner 1
    'banner01_text01' => 'Bem-vindo ao %s',
    'banner01_text02' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',

    # Banner 2
    'banner02_text01' => 'Aprenda como',
    'banner02_text02' => 'se conectar',
    'banner02_text03' => 'aos nossos reinos',
    'banner02_text04' => 'clique para ler',

    # Direitos autorais
    'copyright' => '%s &copy; Direitos Autorais %s'
]);

