<?php

# Import required classes
use MX\CI;

# Make sure we're in CI
defined('BASEPATH') OR exit('No direct script access allowed');

# Load theme assets
require(T_ROOT_PATH . 'config' . DS . 'template_assets' . PHP);

# Load theme configs
require(T_ROOT_PATH . 'config' . DS . 'config' . PHP);

# is HomePage
$isHomePage = (strpos(CI::$APP->router->default_controller, CI_MODULE) !== false && CI_METHOD === 'index');

# Show sideboxes
$showSideboxes = true;
if((isset($config['FWP'][CI_MODULE])           && is_string($config['FWP'][CI_MODULE])          && $config['FWP'][CI_MODULE] === '*')
|| (isset($config['FWP'][CI_MODULE][CI_CLASS]) && is_array($config['FWP'][CI_MODULE][CI_CLASS]) && in_array(CI_METHOD, $config['FWP'][CI_MODULE][CI_CLASS])))
    $showSideboxes = false;

# Assign DS to smarty template
CI::$APP->smarty->assign('DS', DS);

# Assign theme assets to smarty template
CI::$APP->smarty->assign('assets', $assets);

# Assign class name to smarty template
CI::$APP->smarty->assign('ci_class', CI_CLASS);

# Assign module name to smarty template
CI::$APP->smarty->assign('ci_module', CI_MODULE);

# Assign method name to smarty template
CI::$APP->smarty->assign('ci_method', CI_METHOD);

# Assign isHomePage to smarty template
CI::$APP->smarty->assign('isHomePage', $isHomePage);

# Assign showSideboxes to smarty template
CI::$APP->smarty->assign('showSideboxes', $showSideboxes);

# Assign theme base url to smarty template
CI::$APP->smarty->assign('T_BASE_URL', T_BASE_URL);

# Assign theme root path to smarty template
CI::$APP->smarty->assign('T_ROOT_PATH', T_ROOT_PATH);

# Assign theme image path to smarty template
CI::$APP->smarty->assign('MY_image_path', T_BASE_URL . 'assets/images/');

# Assign body classes to smarty template
CI::$APP->smarty->assign('body_class', implode(' ', [
    1 => 'module-' . CI_MODULE,
    2 => 'class-' . CI_CLASS,
    3 => 'method-' . CI_METHOD,
    4 => $isHomePage ? 'is-homepage' : 'is-subpage',
    5 => $showSideboxes ? 'is-compact' : 'is-fullwidth',
    6 => 'theme-' . CI::$APP->config->item('theme'),
    7 => 'variation-' . $config['variation'],
    8 => 'version-' . $config['version']
]));

# Prevent errors
$config = [];
