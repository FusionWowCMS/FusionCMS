<?php

# Import required classes
use MX\CI;

# Make sure we're in CI
defined('BASEPATH') OR exit('No direct script access allowed');

// Load theme assets
require(T_ROOT_PATH . 'config' . DS . 'template_assets' . PHP);

// Load theme configs
require(T_ROOT_PATH . 'config' . DS . 'config' . PHP);

// Module
$module = strtolower(CI::$APP->router->fetch_module());

// Method
$method = strtolower(CI::$APP->router->fetch_method());

// is HomePage
$isHomePage = (strpos(CI::$APP->router->default_controller, $module) !== false && $method === 'index');

// Show sideboxes
$showSideboxes = (!isset($config['FWP'][$module]) || !in_array($method, $config['FWP'][$module]));

// Assign DS to smarty template
CI::$APP->smarty->assign('DS', DS);

// Assign theme assets to smarty template
CI::$APP->smarty->assign('assets', $assets);

// Assign current module name to smarty template
CI::$APP->smarty->assign('module', $module);

// Assign current method name to smarty template
CI::$APP->smarty->assign('method', $method);

// Assign isHomePage to smarty template
CI::$APP->smarty->assign('isHomePage', $isHomePage);

// Assign showSideboxes to smarty template
CI::$APP->smarty->assign('showSideboxes', $showSideboxes);

// Assign theme image path to smarty template
CI::$APP->smarty->assign('MY_image_path', T_BASE_URL . 'assets/images/');

// Assign slider image path to smarty template
CI::$APP->smarty->assign('slider_image_path', T_BASE_URL . str_replace('/{variation}', ($config['variation'] == 'wotlk' ? '' : '/variations/' . $config['variation']), 'assets/{variation}/images/slides/'));

// Assign body classes to smarty template
CI::$APP->smarty->assign('body_class', implode(' ', [
    1 => 'theme-' . CI::$APP->config->item('theme'),
    2 => 'variation-' . $config['variation'],
    3 => 'version-' . $config['version'],
    4 => 'module-' . $module,
    5 => 'method-' . $method,
    6 => $isHomePage ? 'is-homepage' : 'is-subpage',
    7 => $showSideboxes ? 'is-compact' : 'is-fullwidth'
]));

# Prevent errors
$config = [];
