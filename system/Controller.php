<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
 * Application Controller Class
 *
 *  This class object is the super class that every library in
 *  CodeIgniter will be assigned to.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/userguide3/general/controllers.html
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
#[\AllowDynamicProperties]
class Controller
{

    /**
     * Reference to the CI singleton
     *
     * @var    Controller
     */
    private static Controller $instance;

    /**
     * CI_Loader
     *
     * @var    CI_Loader
     */
    public $load;

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct()
    {
        self::$instance =& $this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class) {
            $this->{$var} =& load_class($class);
        }

        $this->load =& load_class('Loader', 'core');
        $this->load->initialize();
        log_message('info', 'Controller Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * Get the CI singleton
     *
     * @static
     * @return    Controller
     */
    public static function &get_instance(): Controller
    {
        return self::$instance;
    }

}
