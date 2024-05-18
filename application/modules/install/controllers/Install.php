<?php

use CodeIgniter\Database\Exceptions\DatabaseException;
use MX\MX_Controller;

class Install extends MX_Controller
{
    private $db;

    public function __construct()
    {
        parent::__construct();

        if(file_exists(WRITEPATH . 'install/.lock'))
            show_404('install', false);

        # Load: Helpers
        $this->load->helper('url');
    }

    public function index()
    {
        $this->csrf_protection(false);

        $data = [
            'css' => basename(APPPATH) . '/modules/install/css/install.css',
            'INSTALL_PATH' => basename(APPPATH) . '/modules/install/'
        ];

       die($this->load->view('install', $data, true));
    }

    public function next()
    {
        if(!isset($_GET['step']))
        {
            die();
        }
        else
        {
            switch($_GET['step'])
            {
                case 'config': $this->config(); break;
                case 'database': $this->database(); break;
                case 'realms': $this->realms(); break;
                case 'folder': $this->check(); break;
                case 'checkPhpExtensions': $this->checkPhpExtensions(); break;
                case 'checkApacheModules': $this->checkApacheModules(); break;
                case 'checkPhpVersion': $this->checkPhpVersion(); break;
                case 'setAndCheckDbConnection': $this->setAndCheckDbConnection(); break;
                case 'checkAuthConfig': $this->checkAuthConfig(); break;
                case 'final': $this->finalStep(); break;
                case 'getEmulators': $this->getEmulators(); break;
            }
        }
    }

    private function getEmulators()
    {
        require_once("application/config/emulator_names.php");

        die(json_encode($emulators));
    }

    private function check()
    {
        if (! isset($_GET['test']))
            return;
        if (! isset($_GET['path']))
            return;

        $folder = $_GET['test'];
        $path = $_GET['path'];

        $file = fopen($path ."/".$folder."/write_test.txt", "w");

        fwrite($file, "success");
        fclose($file);

        unlink($path ."/".$folder."/write_test.txt");

        die("1");
    }

    private function checkPhpExtensions()
    {
        $req = ['mysqli', 'curl', 'openssl', 'soap', 'gd', 'gmp', 'mbstring', 'intl', 'json', 'xml', 'zip'];
        $loaded = get_loaded_extensions();
        $errors = [];

        foreach ($req as $ext)
            if (! in_array($ext, $loaded))
                $errors[] = $ext;

        die($errors ? join(', ', $errors) : '1');
    }

    private function checkApacheModules()
    {
        $req = ['mod_rewrite', 'mod_headers', 'mod_expires', 'mod_deflate', 'mod_filter'];
        $loaded = function_exists('apache_get_modules') ? apache_get_modules() : false;

        if(is_bool($loaded) && !$loaded)
            die('2');

        $errors = [];

        foreach ($req as $ext)
            if (!in_array($ext, $loaded))
                $errors[] = $ext;

        die($errors ? join(', ', $errors) : '1');
    }

    private function checkPhpVersion()
    {
        die(version_compare(PHP_VERSION, '8.1.0', '>=') ? '1' : '0');
    }

    private function setAndCheckDbConnection()
    {
        $req = ['cms_hostname', 'cms_username', 'cms_database', 'auth_hostname', 'auth_username', 'auth_database'];

        foreach ($req as $var) {
            if (! isset($_POST[$var]) || empty($_POST[$var]))
                die('Please fill all fields.');
        }

        $db = fopen("application/config/Database.php", "w");

        $raw = '<?php

namespace App\Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $defaultGroup = "cms";

    public array $cms = [
        "DSN" => "",
        "hostname" => "'.$_POST['cms_hostname'].'",
        "username" => "'.$_POST['cms_username'].'",
        "password" => "'.$_POST['cms_password'].'",
        "database" => "'.$_POST['cms_database'].'",
        "DBDriver" => "MySQLi",
        "DBPrefix" => "",
        "pConnect" => false,
        "DBDebug" => true,
        "charset" => "utf8mb4",
        "DBCollat" => "utf8mb4_general_ci",
        "swapPre" => "",
        "encrypt" => false,
        "compress" => false,
        "strictOn" => false,
        "failover" => [],
        "port" => '.(int)$_POST['cms_port'].',
    ];

    public array $account = [
        "DSN" => "",
        "hostname" => "'.$_POST['auth_hostname'].'",
        "username" => "'.$_POST['auth_username'].'",
        "password" => "'.$_POST['auth_password'].'",
        "database" => "'.$_POST['auth_database'].'",
        "DBDriver" => "MySQLi",
        "DBPrefix" => "",
        "pConnect" => false,
        "DBDebug" => false,
        "charset" => "utf8",
        "DBCollat" => "utf8_general_ci",
        "swapPre" => "",
        "encrypt" => false,
        "compress" => false,
        "strictOn" => false,
        "failover" => [],
        "port" => '.(int)$_POST['auth_port'].',
    ];
}
';

        fwrite($db, $raw);

        fclose($db);

        // Make sure database connection
        $db = db_connect();
        try {
            if ($db->getVersion())
                $db = db_connect('account');
        } catch (Exception $e) {
            die('CMS Connection Error (' . $e->getCode() . ') ' . $e->getMessage());
        } catch (DatabaseException $e) {
            die('CMS Connection Error (' . $e->getCode() . ') ' . $e->getMessage());
        }

        // Make sure database connection
        try {
            if ($db->getVersion())
            die('1');
        } catch (Exception $e) {
            die('Auth Connection Error (' . $e->getCode() . ') ' . $e->getMessage());
        } catch (DatabaseException $e) {
            die('Auth Connection Error (' . $e->getCode() . ') ' . $e->getMessage());
        }
    }

    private function checkAuthConfig()
    {
        $fields = ['realmd_account_encryption', 'realmd_rbac', 'realmd_battle_net', 'realmd_totp_secret'];

        if(!empty($_POST['realmd_battle_net']) && $_POST['realmd_battle_net'] == 'true')
            $fields[] = 'realmd_battle_net_encryption';

        if(!empty($_POST['realmd_totp_secret']) && $_POST['realmd_totp_secret'] == 'true')
            $fields[] = 'realmd_totp_secret_name';

        // Make sure auth-settings-fields are filled
        foreach($fields as $field)
            if(empty($_POST[$field]))
                die('Field `' . str_replace('realmd_', '', $field) . '` can\'t be empty.');

        die('1');
    }

    private function config()
    {
        $owner = fopen("application/config/owner.php", "w");
        fwrite($owner, '<?php $config["owner"] = "'.addslashes($_POST['superadmin']).'";');
        fclose($owner);

        require_once('application/libraries/ConfigEditor.php');

        $distConfig = 'application/config/fusion.php.dist';
        $config = 'application/config/fusion.php';
        if(file_exists($distConfig))
            copy($distConfig, $config); // preserve the original in-case they mess up the new one

        $config = new ConfigEditor($config);

        $data['title'] = $_POST['title'];
        $data['server_name'] = $_POST['server_name'];
        $data['realmlist'] = $_POST['realmlist'];
        $data['keywords'] = $_POST['keywords'];
        $data['description'] = $_POST['description'];
        $data['analytics'] = ($_POST['analytics']) ? $_POST['analytics'] : false;
        $data['cdn'] = ($_POST['cdn'] == '1') ? true : false;
        $data['security_code'] = $_POST['security_code'];
        $data['max_expansion'] = $_POST['max_expansion'];

        foreach($data as $key => $value)
        {
            $config->set($key, $value);
        }

        $config->save();

        $config = 'application/config/captcha.php';
        $config = new ConfigEditor($config);

        $data['use_captcha'] = ($_POST['captcha'] == 'disabled') ? false : true;
        $data['captcha_type'] = ($_POST['captcha'] == 'recaptcha') ? 'recaptcha' : 'inbuilt';
        $data['recaptcha_site_key'] = $_POST['site_key'];
        $data['recaptcha_secret_key'] = $_POST['secret_key'];

        foreach($data as $key => $value)
        {
            $config->set($key, $value);
        }

        $config->save();

        // config/auth.php
        $config = new ConfigEditor('application/config/auth.php');

        $data = [
            'rbac'                  => $_POST['realmd_rbac'],
            'battle_net'            => $_POST['realmd_battle_net'],
            'totp_secret'           => $_POST['realmd_totp_secret'],
            'totp_secret_name'      => $_POST['realmd_totp_secret_name'],
            'account_encryption'    => $_POST['realmd_account_encryption']
        ];

        if(!empty($_POST['realmd_battle_net']) && $_POST['realmd_battle_net'] == 'true')
            $data['battle_net_encryption'] = $_POST['realmd_battle_net_encryption'];

        if(!empty($_POST['realmd_totp_secret']) && $_POST['realmd_totp_secret'] == 'true')
            $data['realmd_totp_secret_name'] = $_POST['realmd_totp_secret_name'];

        foreach($data as $key => $value)
            $config->set($key, $value);

        $config->save();

        die('1');
    }

    private function connect()
    {
        if (empty($this->db)) {
            $this->db = db_connect();
        }
        try {
            $this->db->getVersion();
        } catch (Exception $e) {
            die('Connect Error (' . $e->getCode() . ') ' . $e->getMessage());
        } catch (DatabaseException $e) {
            die('Connect Error (' . $e->getCode() . ') ' . $e->getMessage());
        }
    }

    private function database()
    {
        $this->connect();

        $this->SplitSQL(FCPATH. 'application/modules/install/SQL/fusion_final_full.sql');

        $updates = glob(FCPATH. 'application/modules/install/SQL/updates/*.sql');

        if(count($updates))
        {
            foreach($updates as $update)
            {
                $this->SplitSQL($update);
            }
        }

        die('1');
    }

    private function SplitSQL($file, $delimiter = ';')
    {
        set_time_limit(0);

        if(is_file($file) === true)
        {
            $file = fopen($file, 'r');

            if(is_resource($file) === true)
            {
                $query = [];

                while(feof($file) === false)
                {
                    $query[] = fgets($file);

                    if(preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1)
                    {
                        $query = trim(implode('', $query));

                        try {
                            $this->db->query($query);
                        } catch (Exception $e) {
                            die('Importing database (' . $e->getCode() . ') ' . $e->getMessage());
                        } catch (DatabaseException $e) {
                            die('Importing database (' . $e->getCode() . ') ' . $e->getMessage());
                        }

                        while(ob_get_level() > 0)
                        {
                            ob_end_flush();
                        }

                        flush();
                    }

                    if(is_string($query) === true)
                    {
                        $query = [];
                    }
                }

                return fclose($file);
            }
        }

        return false;
    }

    private function realms()
    {
        // Check for insert
        $insert = !((isset($_POST['insert']) && $_POST['insert'] == 'false'));

        // Connect to CMS db
        if($insert)
            $this->connect();

        // Get realms
        $realms = json_decode(stripslashes($_POST['realms']), true);

        // Check if there is any realm
        if(!$realms || !is_array($realms))
            die('You must add at least one realm.');

        // Fields
        $fields = ['hostname', 'username', 'password', 'characters', 'world', 'cap', 'realm_expansion', 'realmName', 'console_username', 'console_password', 'console_port', 'emulator', 'port', 'db_port'];

        foreach($realms as $realm)
        {
            // Make sure all fields exists in realm array
            foreach($fields as $field)
                if(empty($realm[$field]) && $field != 'realm_expansion')
                    die('Field `' . $field . '` can\'t be empty.');

            $charactersConfig = [
                'DSN'      => '',
                "hostname" => $realm['hostname'],
                "username" => $realm['username'],
                "password" => $realm['password'],
                "database" => $realm['characters'],
                "DBDriver" => "MySQLi",
                'DBPrefix' => '',
                "port" => (int)$realm['db_port'],
                "pConnect" => false,
                'DBDebug'  => false,
                'charset'  => 'utf8',
                'DBCollat' => 'utf8_general_ci',
                'swapPre'  => '',
                'encrypt'  => false,
                'compress' => false,
                'strictOn' => false,
                'failover' => [],
            ];

            $worldConfig = [
                'DSN'      => '',
                "hostname" => $realm['hostname'],
                "username" => $realm['username'],
                "password" => $realm['password'],
                "database" => $realm['world'],
                "DBDriver" => "MySQLi",
                'DBPrefix' => '',
                "port" => (int)$realm['db_port'],
                "pConnect" => false,
                'DBDebug'  => false,
                'charset'  => 'utf8',
                'DBCollat' => 'utf8_general_ci',
                'swapPre'  => '',
                'encrypt'  => false,
                'compress' => false,
                'strictOn' => false,
                'failover' => [],
            ];

            // Connect to characters
            $connection = db_connect($charactersConfig);
            try {
                if ($connection->getVersion())
                    $connection = db_connect($worldConfig);
            } catch (DatabaseException $e) {
                die('Characters Connection Error (' . $e->getCode() . ') ' . $e->getMessage());
            }

            // Connect to world database
            try {
                $connection->getVersion();
            } catch (DatabaseException $e) {
                die('World Connection Error (' . $e->getCode() . ') ' . $e->getMessage());
            }

            // Skip
            if(!$insert)
                continue;

            // Prepare query statement
            $statement = "INSERT INTO `realms` (`hostname`, `username`, `password`, `char_database`, `world_database`, `cap`, `expansion`, `realmName`, `console_username`, `console_password`, `console_port`, `emulator`, `realm_port`, `override_port_world`, `override_port_char`) VALUES (':hostname', ':username', ':password', ':char_database', ':world_database', ':cap', ':expansion', ':realmName', ':console_username', ':console_password', ':console_port', ':emulator', ':realm_port', ':override_port_world', ':override_port_char')";

            // Prepare query data
            $data = [
                ':hostname'            => $this->db->escapeString($realm['hostname']),
                ':username'            => $this->db->escapeString($realm['username']),
                ':password'            => $this->db->escapeString($realm['password']),
                ':char_database'       => $this->db->escapeString($realm['characters']),
                ':world_database'      => $this->db->escapeString($realm['world']),
                ':cap'                 => $this->db->escapeString($realm['cap']),
                ':expansion'           => $this->db->escapeString($realm['realm_expansion']),
                ':realmName'           => $this->db->escapeString($realm['realmName']),
                ':console_username'    => $this->db->escapeString($realm['console_username']),
                ':console_password'    => $this->db->escapeString($realm['console_password']),
                ':console_port'        => $this->db->escapeString($realm['console_port']),
                ':emulator'            => $this->db->escapeString($realm['emulator']),
                ':realm_port'          => $this->db->escapeString($realm['port']),
                ':override_port_world' => $this->db->escapeString($realm['db_port']),
                ':override_port_char'  => $this->db->escapeString($realm['db_port'])
            ];

            // Everything is correct. Insert realm
            try {
                $this->db->query(str_replace(array_keys($data), array_values($data), $statement));
            } catch (DatabaseException $e) {
                die('Realms Import Error (' . $e->getCode() . ') ' . $e->getMessage());
            }
        }

        die('1');
    }

    private function finalStep()
    {
        $this->csrf_protection(true);

        $file = fopen(FCPATH. 'writable/install/.lock', 'w');
        fclose($file);

        if(file_exists(FCPATH. 'writable/install/.lock'))
        {
            die('success');
        }
    }

    private function csrf_protection(bool $enable): void
    {
        require_once('application/libraries/ConfigEditor.php');

        $config = 'application/config/config.php';
        $config = new ConfigEditor($config);

        $data['csrf_protection'] = $enable;

        foreach($data as $key => $value)
        {
            $config->set($key, $value);
        }

        $config->save();
    }
}

$install = new Install();
