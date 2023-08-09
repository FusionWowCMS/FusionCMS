<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 - 2022, CodeIgniter Foundation
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
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniter Foundation (https://codeigniter.com/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/userguide3/libraries/config.html
 ***************** CORE COMPONENTS *****************
 * @property CI_Benchmark $benchmark                  This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
 * @property CI_Config $config                        This class contains functions that enable config files to be managed
 * @property CI_Controller $controller                This class object is the super class that every library in CodeIgniter will be assigned to.
 * @property CI_Controller $CI                        This class object is the super class that every library in CodeIgniter will be assigned to.
 * @property CI_Exceptions $exceptions                Exceptions Class
 * @property CI_Hooks $hooks                          Provides a mechanism to extend the base system without hacking.
 * @property CI_Input $input                          Pre-processes global input data for security
 * @property CI_Lang $lang                            Language Class
 * @property CI_Loader $load                          Loads framework components.
 * @property CI_Log $log                              Logging Class
 * @property CI_Model $model                          Model Class
 * @property CI_Output $output                        Responsible for sending final output to the browser.
 * @property CI_Router $router                        Parses URIs and determines routing
 * @property CI_Security $security                    Security Class
 * @property CI_URI $uri                              Provides support for UTF-8 environments
 ***************** DATABASE COMPONENTS *****************
 * @property CI_DB_forge $dbforge                     Database Forge Class
 * @property CI_DB_query_builder $db                  This is the platform-independent base Query Builder implementation class.
 * @property CI_DB_utility $dbutil                    Database Utility Class
 ***************** CORE LIBRARIES *****************
 * @property CI_Cache $cache                          CodeIgniter Caching Class
 * @property CI_Session $session                      CodeIgniter Session Class
 * @property CI_Calendar $calendar                    This class enables the creation of calendars
 * @property CI_Cart $cart                            Shopping Cart Class
 * @property CI_Driver_Library $driver                This class enables you to create "Driver" libraries that add runtime ability to extend the capabilities of a class via additional driver objects
 * @property CI_Email $email                          Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encryption $encryption                Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions.
 * @property CI_Form_validation $form_validation      Form Validation Class
 * @property CI_FTP $ftp                              FTP Class
 * @property CI_Image_lib $image_lib                  Image Manipulation class
 * @property CI_Migration $migration                  All migrations should implement this, forces up() and down() and gives access to the CI super-global.
 * @property CI_Pagination $pagination                Pagination Class
 * @property CI_Parser $parser                        Parser Class
 * @property CI_Profiler $profiler                    This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
 * @property CI_Table $table                          Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback                  Trackback Sending/Receiving Class
 * @property CI_Typography $typography                Typography Class
 * @property CI_Unit_test $unit                       Simple testing class
 * @property CI_Upload $upload                        File Uploading Class
 * @property CI_User_agent $agent                     Identifies the platform, browser, robot, or mobile device of the browsing agent
 * @property CI_Xmlrpc $xmlrpc                        XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                      XML-RPC server class
 * @property CI_Zip $zip                              Zip Compression Class
 ***************** DEPRECATED LIBRARIES *****************
 * @property CI_Jquery $jquery                        Jquery Class
 * @property CI_Encrypt $encrypt                      Provides two-way keyed encoding using Mcrypt
 * @property CI_Javascript $javascript                Javascript Class
 *  **************** Fusion CMS LIBRARIES *****************
 * @property Acl $acl                                 Acl Class
 * @property Administrator $administrator             Administrator Class
 * @property Captcha $captcha                         Captcha Class
 * @property ConfigEditor $configEditor               ConfigEditor Class
 * @property Dbbackup $dbbackup                       Dbbackup Class
 * @property Items $items                             Items Class
 * @property Language $language                       Language Class
 * @property Logger $logger                           Logger Class
 * @property Moderator $moderator                     Moderator Class
 * @property Plugin $plugin                           Plugin Class
 * @property Plugins $plugins                         Plugins Class
 * @property Realm $realm                             Realm Class
 * @property Realms $realms                           Realms Class
 * @property Recaptcha $recaptcha                     Recaptcha Class
 * @property Tasks $tasks                             Tasks Class
 * @property Template $template                       Template Class
 * @property User $user                               User Class
 * **************** Fusion CMS *****************
 * @property Acl_model $acl_model                     Acl_model Class
 * @property Characters_model $characters_model       Characters_model Class
 * @property Cms_model $cms_model                     Cms_model Class
 * @property External_account_model $external_account_model  External_account_model Class
 * @property Internal_user_model $internal_user_model        Internal_user_model Class
 * @property Logger_model $logger_model               Logger_model Class
 * @property World_model $world_model                 World_model Class
 */
class CI_Model {

	/**
	 * Class constructor
	 *
	 * @link	https://github.com/bcit-ci/CodeIgniter/issues/5332
	 * @return	void
	 */
	public function __construct() {}

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
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
