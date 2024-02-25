<?php namespace MX;

use Acl;
use Acl_model;
use Administrator;
use Captcha;
use Characters_model;
use CI_Cache;
use CI_Calendar;
use CI_Config;
use CI_DB_forge;
use CI_DB_query_builder;
use CI_DB_utility;
use CI_Driver_Library;
use CI_Form_validation;
use CI_FTP;
use CI_Image_lib;
use CI_Input;
use CI_Lang;
use CI_Loader;
use CI_Migration;
use CI_Model;
use CI_Output;
use CI_Pagination;
use CI_Parser;
use CI_Router;
use CI_Security;
use CI_Session;
use CI_Table;
use CI_Trackback;
use CI_Unit_test;
use CI_Upload;
use CI_URI;
use CI_Utf8;
use CI_Zip;
use Cms_model;
use CodeIgniter\Debug\Exceptions;
use CodeIgniter\Debug\Timer;
use CodeIgniter\Debug\Toolbar;
use CodeIgniter\Email\Email;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Log\Logger;
use CodeIgniter\Typography\Typography;
use ConfigEditor;
use Controller;
use Crypto;
use Dbbackup;
use Dblogger;
use Encryption\Encryption;
use External_account_model;
use Internal_user_model;
use Items;
use Language;
use Logger_model;
use MX\CI;
use Plugin;
use Plugins;
use Realm;
use Realms;
use Recaptcha;
use Smarty;
use Template;
use User;
use World_model;

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Modular Extensions - HMVC
 *
 *  Adapted from the CodeIgniter Core Classes
 *
 * @link http://codeigniter.com
 *
 *  Description:
 *  This library replaces the CodeIgniter Controller class
 *  and adds features allowing use of modules and the HMVC design pattern.
 *
 *  Install this file as application/third_party/MX/Controller.php
 *
 * @copyright Copyright (c) 2015 Wiredesignz
 * @version   5.5
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 ***************** CORE COMPONENTS *****************
 * @property Timer $timer                       This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
 * @property CI_Config $config                  This class contains functions that enable config files to be managed
 * @property Controller $controller             This class object is the super class that every library in CodeIgniter will be assigned to.
 * @property Controller $CI                     This class object is the super class that every library in CodeIgniter will be assigned to.
 * @property Exceptions $exceptions             Exceptions Class
 * @property Events $events                     Provides a mechanism to extend the base system without hacking.
 * @property CI_Input $input                    Pre-processes global input data for security
 * @property CI_Lang $lang                      Language Class
 * @property CI_Loader $load                    Loads framework components.
 * @property Logger $logger                        Logging Class
 * @property CI_Model $model                    Model Class
 * @property CI_Output $output                  Responsible for sending final output to the browser.
 * @property CI_Router $router                  Parses URIs and determines routing
 * @property CI_Security $security              Security Class
 * @property CI_URI $uri                        Parses URIs and determines routing
 * @property CI_Utf8 $utf8                      Provides support for UTF-8 environments
 ***************** DATABASE COMPONENTS *****************
 * @property CI_DB_forge $dbforge               Database Forge Class
 * @property CI_DB_query_builder $db            This is the platform-independent base Query Builder implementation class.
 * @property CI_DB_utility $dbutil              Database Utility Class
 ***************** CORE LIBRARIES *****************
 * @property CI_Cache $cache                    CodeIgniter Caching Class
 * @property CI_Session $session                CodeIgniter Session Class
 * @property CI_Calendar $calendar              This class enables the creation of calendars
 * @property CI_Driver_Library $driver          This class enables you to create "Driver" libraries that add runtime ability to extend the capabilities of a class via additional driver objects
 * @property Email $email                       Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property Encryption $encryption             Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions.
 * @property CI_Form_validation $form_validation Form Validation Class
 * @property CI_FTP $ftp                        FTP Class
 * @property CI_Image_lib $image_lib            Image Manipulation class
 * @property CI_Migration $migration            All migrations should implement this, forces up() and down() and gives access to the CI super-global.
 * @property CI_Pagination $pagination          Pagination Class
 * @property CI_Parser $parser                  Parser Class
 * @property Toolbar $toolbar                   This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
 * @property CI_Table $table                    Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback            Trackback Sending/Receiving Class
 * @property Typography $typography             Typography Class
 * @property CI_Unit_test $unit                 Simple testing class
 * @property CI_Upload $upload                  File Uploading Class
 * @property UserAgent $agent                   Identifies the platform, browser, robot, or mobile device of the browsing agent
 * @property CI_Zip $zip                        Zip Compression Class
 * **************** Fusion CMS LIBRARIES *****************
 * @property Acl $acl                           Acl Class
 * @property Administrator $administrator       Administrator Class
 * @property Captcha $captcha                   Captcha Class
 * @property ConfigEditor $configEditor         ConfigEditor Class
 * @property Crypto $crypto                     Crypto Class
 * @property Dbbackup $dbbackup                 Dbbackup Class
 * @property Items $items                       Items Class
 * @property Language $language                 Language Class
 * @property Dblogger $dblogger                 Dblogger Class
 * @property Plugin $plugin                     Plugin Class
 * @property Plugins $plugins                   Plugins Class
 * @property Realm $realm                       Realm Class
 * @property Realms $realms                     Realms Class
 * @property Recaptcha $recaptcha               Recaptcha Class
 * @property Template $template                 Template Class
 * @property User $user                         User Class
 * @property Smarty $smarty                     Smarty Class
 *  **************** Fusion CMS *****************
 * @property Acl_model $acl_model               Acl_model Class
 * @property Characters_model $characters_model Characters_model Class
 * @property Cms_model $cms_model               Cms_model Class
 * @property External_account_model $external_account_model  External_account_model Class
 * @property Internal_user_model $internal_user_model        Internal_user_model Class
 * @property Logger_model $logger_model         Logger_model Class
 * @property World_model $world_model           World_model Class
 */
#[\AllowDynamicProperties]
class MX_Controller
{
    public $autoload = [];

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        $class = str_replace(CI::$APP->config->item('controller_suffix') ?? '', '', get_class($this));
        log_message('debug', $class . ' MX_Controller Initialized');
        MX_Modules::$registry[strtolower($class)] = $this;

        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader');
        $this->load->initialize($this);

        /* autoload module items */
        $this->load->_autoloader($this->autoload);
    }

    /**
     * [__get description]
     *
     * @method __get
     *
     * @param [type] $class
     *
     * @return mixed [type]
     */
    public function __get($class)
    {
        return CI::$APP->$class;
    }
}
