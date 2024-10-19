<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;
use CodeIgniter\Debug\Exceptions;
use CodeIgniter\Debug\Timer;
use CodeIgniter\Debug\Toolbar;
use CodeIgniter\Email\Email;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Log\Logger;
use CodeIgniter\Typography\Typography;
use Encryption\Encryption;
use Smarty\Smarty;

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/userguide3/libraries/config.html
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
 * @property Logger $logger                     Logging Class
 * @property CI_Model $model                    Model Class
 * @property CI_Output $output                  Responsible for sending final output to the browser.
 * @property CI_Router $router                  Parses URIs and determines routing
 * @property CI_Security $security              Security Class
 * @property CI_URI $uri                        Parses URIs and determines routing
 * @property CI_Utf8 $utf8                      Provides support for UTF-8 environments
 ***************** DATABASE COMPONENTS *****************
 * @property Forge $dbforge                     Database Forge Class
 * @property BaseConnection $db                 This is the platform-independent base Query Builder implementation class.
 ***************** CORE LIBRARIES *****************
 * @property CI_Cache $cache                    CodeIgniter Caching Class
 * @property CI_Calendar $calendar              This class enables the creation of calendars
 * @property CI_Driver_Library $driver          This class enables you to create "Driver" libraries that add runtime ability to extend the capabilities of a class via additional driver objects
 * @property Email $email                       Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property Encryption $encryption             Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions.
 * @property CI_Form_validation $form_validation Form Validation Class
 * @property CI_FTP $ftp                        FTP Class
 * @property CI_Image_lib $image_lib            Image Manipulation class
 * @property Migration $migration               All migrations should implement this, forces up() and down() and gives access to the CI super-global.
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
class CI_Model
{

    /**
     * Class constructor
     *
     * @link    https://github.com/bcit-ci/CodeIgniter/issues/5332
     * @return    void
     */
    public function __construct()
    {
    }

    /**
     * __get magic
     *
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param string $key
     */
    public function __get($key)
    {
        // Debugging note:
        //	If you're here because you're getting an error message
        //	saying 'Undefined Property: system/core/Model.php', it's
        //	most likely a typo in your model code.
        return get_instance()->$key;
    }

}
