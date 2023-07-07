<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * load the CI class for Modular Extensions 
**/
require_once __DIR__ . '/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 *
 * @link http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright Copyright (c) 2015 Wiredesignz
 * @version   5.5
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller
{
    public $autoload = array();
    private $standardModule = "news";

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        $class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
        log_message('debug', $class . ' MX_Controller Initialized');
        _Modules::$registry[strtolower($class)] = $this;

        //die(print_r(CI::$APP->template->getModuleData()));

        //Get Module Name
        $moduleName = $this->template->getModuleName();

        //Get Module Data from Template Library
        $module = CI::$APP->template->getModuleData();

        // Is the module enabled?
        if (!isset($module['enabled']) || !$module['enabled']) {
            //CI::$APP->template->show404();
            redirect("errors");
        }

        // Default to current version
        if (!array_key_exists("min_required_version", $module)) {
            $module['min_required_version'] = CI::$APP->config->item('FusionCMSVersion');
        }

        // Does the module got the correct version?
        if (!CI::$APP->template->compareVersions($module['min_required_version'], CI::$APP->config->item('FusionCMSVersion'))) {
            show_error("The module <b>" . strtolower($moduleName) . "</b> requires FusionCMS v" . $module['min_required_version'] . ", please update at https://github.com/Yekta-Core/FusionCMS");
        }

        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader');
        $this->load->initialize($this);

        /* autoload module items */
        $this->load->_autoloader($this->autoload);

        $this->cookieLogIn();
    }

    /**
     * [__get description]
     *
     * @method __get
     *
     * @param [type] $class [description]
     *
     * @return [type]        [description]
     */
    public function __get($class)
    {
        return CI::$APP->$class;
    }

    public function cookieLogIn()
    {
        if (!CI::$APP->user->isOnline()) {
            $username = CI::$APP->input->cookie("fcms_username");
            $password = CI::$APP->input->cookie("fcms_password");

            if ($password && column('account', 'password') == 'verifier' && column('account', 'salt')) { // Emulator Uses SRP6 Encryption.
                $password = urldecode(preg_replace('~.(?:fcms_password=([^;]+))?~', '$1', @$_SERVER['HTTP_COOKIE'])); // Fix for HTTP_COOKIE Error.
            }

            if ($username && $password) {
                $check = CI::$APP->user->setUserDetails($username, $password);

                if ($check == 0) {
                    redirect('news');
                }
            }
        }
    }
}
