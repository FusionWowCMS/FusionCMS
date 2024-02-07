<?php namespace Config;

use CodeIgniter\Events\Events;
use MX\CI;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('post_controller_constructor', static function () {
    //Get Module Name
    $moduleName = CI::$APP->template->getModuleName();

    //Get Module Data from Template Library
    $module = CI::$APP->template->getModuleData();

    // Is the module enabled?
    if (!isset($module['enabled']) || !$module['enabled']) {
        redirect("errors");
    }

    // Default to a current version
    if (!array_key_exists("min_required_version", $module)) {
        $module['min_required_version'] = CI::$APP->config->item('FusionCMSVersion');
    }

    // Does the module get the correct version?
    if (version_compare($module['min_required_version'], CI::$APP->config->item('FusionCMSVersion'), '>')) {
        show_error("The module <b>" . strtolower($moduleName) . "</b> requires FusionCMS v" . $module['min_required_version'] . ", please update at https://github.com/FusionWowCMS/FusionCMS");
    }

    // Check Cookie
    if (!CI::$APP->user->isOnline()) {
        $username = CI::$APP->input->cookie("fcms_username");
        $password = CI::$APP->input->cookie("fcms_password");

        if ($password && CI::$APP->config->item('account_encryption') != 'SPH' && column('account', 'verifier') && column('account', 'salt')) { // Emulator Uses SRP6 Encryption.
            $password = urldecode(preg_replace('~.(?:fcms_password=([^;]+))?~', '$1', @$_SERVER['HTTP_COOKIE'])); // Fix for HTTP_COOKIE Error.
        }

        if ($username && $password) {
            $check = CI::$APP->user->setUserDetails($username, $password);

            if ($check == 0 && strtolower(str_replace(CI::$APP->config->item('controller_suffix') ?? '', '', get_class($this))) !== 'api') {
                redirect('news');
            }
        }
    }
});