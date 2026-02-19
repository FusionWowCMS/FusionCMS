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
                case 'autoDetectAuthConfig': $this->autoDetectAuthConfig(); break;
                case 'final': $this->finalStep(); break;
                case 'getEmulators': $this->getEmulators(); break;
            }
        }
    }

    private function autoDetectAuthConfig()
    {
        $required = ['auth_hostname', 'auth_username', 'auth_database'];

        foreach ($required as $field) {
            if (!isset($_POST[$field]) || $_POST[$field] === '') {
                die('Missing DB field: ' . $field);
            }
        }

        $hostname = $_POST['auth_hostname'];
        $username = $_POST['auth_username'];
        $password = $_POST['auth_password'] ?? '';
        $database = $_POST['auth_database'];
        $port = !empty($_POST['auth_port']) ? (int)$_POST['auth_port'] : 3306;

        try {
            $mysqli = new mysqli($hostname, $username, $password, $database, $port);
        } catch (Throwable $e) {
            die('Auto detect failed: Auth Connection Error (' . $e->getCode() . ') ' . $e->getMessage());
        }

        if ($mysqli->connect_errno) {
            die('Auto detect failed: Auth Connection Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        try {
            $stmt = $mysqli->prepare('SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ?');

            if (!$stmt) {
                die('Auto detect failed: Unable to prepare schema query.');
            }

            $stmt->bind_param('s', $database);
            $stmt->execute();
            $result = $stmt->get_result();

            $tables = [];
            while ($column = $result->fetch_assoc()) {
                $tableName = strtolower($column['TABLE_NAME']);
                $columnName = strtolower($column['COLUMN_NAME']);

                if (!isset($tables[$tableName])) {
                    $tables[$tableName] = [];
                }

                $tables[$tableName][$columnName] = true;
            }

            $stmt->close();

            $hasColumn = static function (array $tableMap, array $tableNames, string $columnName): bool {
                $columnName = strtolower($columnName);

                foreach ($tableNames as $tableName) {
                    $tableName = strtolower($tableName);

                    if (isset($tableMap[$tableName][$columnName])) {
                        return true;
                    }
                }

                return false;
            };

            $hasTable = static function (array $tableMap, array $tableNames): bool {
                foreach ($tableNames as $tableName) {
                    if (isset($tableMap[strtolower($tableName)])) {
                        return true;
                    }
                }

                return false;
            };

            $accountTables = ['account', 'accounts'];
            $battleNetTables = ['battlenet_accounts', 'battle_net_accounts', 'bnet_accounts'];

            $accountEncryption = 'SRP6';
            if ($hasColumn($tables, $accountTables, 'salt') && $hasColumn($tables, $accountTables, 'verifier')) {
                $accountEncryption = 'SRP6';
            } elseif ($hasColumn($tables, $accountTables, 'sha_pass_hash')) {
                $accountEncryption = 'SPH';
            } elseif ($hasColumn($tables, $accountTables, 'v') && $hasColumn($tables, $accountTables, 's')) {
                $accountEncryption = 'SRP';
            }

            $hasRbac = $hasTable($tables, ['rbac_permissions', 'rbac_account_permissions', 'rbac_linked_permissions']);
            $hasBattleNet = $hasTable($tables, $battleNetTables);

            $battleNetEncryption = 'SRP6_V2';
            if ($hasBattleNet && $hasColumn($tables, $battleNetTables, 'sha_pass_hash')) {
                $battleNetEncryption = 'SPH';
            } elseif ($hasBattleNet && $hasColumn($tables, $battleNetTables, 'salt') && $hasColumn($tables, $battleNetTables, 'verifier')) {
                $battleNetEncryption = 'SRP6_V2';
            }

            $totpSecret = $hasColumn($tables, $accountTables, 'totp_secret') || $hasColumn($tables, $accountTables, 'token_key');
            $totpSecretName = $hasColumn($tables, $accountTables, 'totp_secret') ? 'totp_secret' : 'token_key';

            die(json_encode([
                'realmd_account_encryption' => $accountEncryption,
                'realmd_rbac' => $hasRbac ? 'true' : 'false',
                'realmd_battle_net' => $hasBattleNet ? 'true' : 'false',
                'realmd_battle_net_encryption' => $battleNetEncryption,
                'realmd_totp_secret' => $totpSecret ? 'true' : 'false',
                'realmd_totp_secret_name' => $totpSecretName,
            ]));
        } finally {
            $mysqli->close();
        }
    }

    private function getEmulators()
    {
        require_once("application/config/emulator_names.php");

        die(json_encode($emulators));
    }

    private function check()
    {
        $folder = $_GET['test'] ?? null;
        $path   = $_GET['path'] ?? null;

        if (empty($folder) || empty($path)) {
            die("Missing parameters");
        }

        $basePaths = [
            'application' => APPPATH,
            'writable' => WRITEPATH,
        ];

        if (!isset($basePaths[$path])) {
            die('400: Invalid path alias ' . $path);
        }

        $basePath = realpath($basePaths[$path]);

        if ($basePath === false || !is_dir($basePath)) {
            die('500: Base path not found ' . $basePaths[$path]);
        }

        $targetDir = realpath($basePath . DIRECTORY_SEPARATOR . trim($folder, '/\\'));

        if ($targetDir === false || !is_dir($targetDir)) {
            die('404: Folder not found ' . $folder);
        }

        if (strpos($targetDir, $basePath) !== 0) {
            die('400: Invalid folder path ' . $folder);
        }

        // Check write access
        if (!is_writable($targetDir)) {
            die("403: No write permission to " . $targetDir);
        }

        $testFile = @tempnam($targetDir, 'fusion_install_');

        if ($testFile === false) {
            die('500: Failed to create temp file in ' . $targetDir);
        }

        $result = @file_put_contents($testFile, 'success', LOCK_EX);

        if ($result === false) {
            @unlink($testFile);
            die("500: Failed to write file " . $testFile);
        }

        // Delete the test file
        @unlink($testFile);

        // Success
        die("1");
    }

    private function checkPhpExtensions()
    {
        $checks = [
            'mysqli' => static fn(): bool => extension_loaded('mysqli'),
            'curl' => static fn(): bool => extension_loaded('curl'),
            'openssl' => static fn(): bool => extension_loaded('openssl'),
            'soap' => static fn(): bool => extension_loaded('soap'),
            'gd' => static fn(): bool => extension_loaded('gd'),
            'gmp' => static fn(): bool => extension_loaded('gmp'),
            'mbstring' => static fn(): bool => extension_loaded('mbstring'),
            'intl' => static fn(): bool => extension_loaded('intl'),
            'json' => static fn(): bool => extension_loaded('json'),
            'xml' => static fn(): bool => extension_loaded('xml') || extension_loaded('libxml'),
            'zip' => static fn(): bool => extension_loaded('zip'),
        ];

        $errors = [];

        foreach ($checks as $extension => $check) {
            if (!$check()) {
                $errors[] = $extension;
            }
        }

        die($errors ? join(', ', $errors) : '1');
    }

    private function checkApacheModules()
    {
        $req = ['mod_rewrite', 'mod_headers', 'mod_expires', 'mod_deflate', 'mod_filter'];
        $serverSoftware = strtolower((string) ($_SERVER['SERVER_SOFTWARE'] ?? 'unknown'));

        // Native Apache module detection when available.
        if (str_contains($serverSoftware, 'apache')) {
            $loaded = function_exists('apache_get_modules') ? apache_get_modules() : false;

            if ($loaded === false || !is_array($loaded)) {
                die('2');
            }
            $errors = [];

            foreach ($req as $ext)
                if (!in_array($ext, $loaded, true))
                    $errors[] = $ext;

            die($errors ? join(', ', $errors) : '1');
        }

        // Best-effort checks for non-Apache servers. We only fail on things we can prove missing.
        if (str_contains($serverSoftware, 'nginx')) {
            if (!function_exists('shell_exec')) {
                die('1');
            }

            $disabledFunctions = array_map('trim', explode(',', (string) ini_get('disable_functions')));
            if (in_array('shell_exec', $disabledFunctions, true)) {
                die('1');
            }

            $nginxVersion = @shell_exec('nginx -V 2>&1');
            if (!is_string($nginxVersion) || trim($nginxVersion) === '') {
                die('1');
            }

            $errors = [];

            // Nginx directives mapping:
            // - rewrite => ngx_http_rewrite_module
            // - headers/expires => ngx_http_headers_module
            // - deflate => ngx_http_gzip_module
            if (str_contains($nginxVersion, '--without-http_rewrite_module')) {
                $errors[] = 'mod_rewrite';
            }

            if (str_contains($nginxVersion, '--without-http_headers_module')) {
                $errors[] = 'mod_headers';
                $errors[] = 'mod_expires';
            }

            if (str_contains($nginxVersion, '--without-http_gzip_module')) {
                $errors[] = 'mod_deflate';
            }

            // mod_filter has no strict 1:1 equivalent we can reliably detect across non-Apache stacks.
            die($errors ? join(', ', array_values(array_unique($errors))) : '1');
        }

        die('1');
    }

    private function checkPhpVersion()
    {
        die(version_compare(PHP_VERSION, '8.3.0', '>=') ? '1' : '0');
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
        "numberNative" => false,
        "foundRows"    => false,
        "dateFormat"   => [
            "date"     => "Y-m-d",
            "datetime" => "Y-m-d H:i:s",
            "time"     => "H:i:s",
        ],
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
        "numberNative" => false,
        "foundRows"    => false,
        "dateFormat"   => [
            "date"     => "Y-m-d",
            "datetime" => "Y-m-d H:i:s",
            "time"     => "H:i:s",
        ],
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

    private function saveConfig(string $file, array $data): void
    {
        $config = new ConfigEditor($file);

        foreach ($data as $key => $value) {
            $config->set($key, $value);
        }

        $config->save();
    }

    private function config()
    {
        // owner.php
        $owner = fopen("application/config/owner.php", "w");
        fwrite($owner, '<?php $config["owner"] = "'.addslashes($_POST['superadmin']).'";');
        fclose($owner);

        require_once('application/libraries/ConfigEditor.php');

        // fusion.php
        $distConfig = 'application/config/fusion.php.dist';
        $fusionConfig = 'application/config/fusion.php';
        if(file_exists($distConfig))
            copy($distConfig, $fusionConfig); // preserve the original in-case they mess up the new one

        $fusionData = [
            'title'         => $_POST['title'],
            'server_name'   => $_POST['server_name'],
            'realmlist'     => $_POST['realmlist'],
            'keywords'      => $_POST['keywords'],
            'description'   => $_POST['description'],
            'analytics'     => !empty($_POST['analytics']) ? $_POST['analytics'] : false,
            'security_code' => $_POST['security_code'],
            'max_expansion' => $_POST['max_expansion'],
        ];

        $this->saveConfig($fusionConfig, $fusionData);

        // cdn.php
        $cdnData = [
            'cdn'           => ($_POST['cdn'] == '1') ? true : false,
            'cdn_link'      => $_POST['cdn_link'],
        ];

        $this->saveConfig('application/config/cdn.php', $cdnData);

        // captcha.php
        $captchaData = [
            'use_captcha'          => ($_POST['captcha'] == 'disabled') ? false : true,
            'captcha_type'         => ($_POST['captcha'] == 'recaptcha') ? 'recaptcha' : 'inbuilt',
            'recaptcha_site_key'   => $_POST['site_key'],
            'recaptcha_secret_key' => $_POST['secret_key'],
        ];

        $this->saveConfig('application/config/captcha.php', $captchaData);

        // auth.php
        $authData = [
            'rbac'                  => $_POST['realmd_rbac'],
            'battle_net'            => $_POST['realmd_battle_net'],
            'totp_secret'           => $_POST['realmd_totp_secret'],
            'totp_secret_name'      => $_POST['realmd_totp_secret_name'],
            'account_encryption'    => $_POST['realmd_account_encryption']
        ];

        if(!empty($_POST['realmd_battle_net']) && $_POST['realmd_battle_net'] == 'true')
            $authData['battle_net_encryption'] = $_POST['realmd_battle_net_encryption'];

        if(!empty($_POST['realmd_totp_secret']) && $_POST['realmd_totp_secret'] == 'true')
            $authData['realmd_totp_secret_name'] = $_POST['realmd_totp_secret_name'];

        $this->saveConfig('application/config/auth.php', $authData);

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
                'numberNative' => false,
                'foundRows'    => false,
                'dateFormat'   => [
                    'date'     => 'Y-m-d',
                    'datetime' => 'Y-m-d H:i:s',
                    'time'     => 'H:i:s',
                ],
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
                'numberNative' => false,
                'foundRows'    => false,
                'dateFormat'   => [
                    'date'     => 'Y-m-d',
                    'datetime' => 'Y-m-d H:i:s',
                    'time'     => 'H:i:s',
                ],
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
