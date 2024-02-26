<?php

class Install
{
	private $db;
	const MYSQL_DEFAULT_PORT = 3306;

	public function __construct()
	{
		if(!isset($_GET['step']))
		{
			die();
		}
		else
		{
			switch($_GET['step'])
			{
				case "config": $this->config(); break;
				case "database": $this->database(); break;
				case "realms": $this->realms(); break;
				case "folder": $this->check(); break;
				case "checkPhpExtensions": $this->checkPhpExtensions(); break;
				case "checkApacheModules": $this->checkApacheModules(); break;
				case "checkPhpVersion": $this->checkPhpVersion(); break;
				case "checkDbConnection": $this->checkDbConnection(); break;
				case "checkAuthConfig": $this->checkAuthConfig(); break;
				case "final": $this->finalStep(); break;
				case "getEmulators": $this->getEmulators(); break;
			}
		}
	}

	private function getEmulators()
	{
		require_once("../application/config/emulator_names.php");

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

        $file = fopen("../".$path ."/".$folder."/write_test.txt", "w");

        fwrite($file, "success");
        fclose($file);

        unlink("../".$path ."/".$folder."/write_test.txt");

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

	private function checkDbConnection()
	{
		$req = ['hostname', 'username', 'database'];

		foreach ($req as $var) {
			if ( ! isset($_POST[$var]) || empty($_POST[$var]))
				die('Please fill all fields.');
		}

	    @$db = new mysqli(
	    	$_POST['hostname'],
	    	$_POST['username'],
	    	$_POST['password'],
	    	$_POST['database'],
            $_POST['port'] ?? self::MYSQL_DEFAULT_PORT
	    );

		die($db->connect_error ? $db->connect_error : '1');
	}

	private function checkAuthConfig()
	{
        $fields = ['realmd_account_encryption', 'realmd_rbac', 'realmd_battle_net', 'realmd_totp_secret', 'realmd_totp_secret_name'];

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
		$owner = fopen("../application/config/owner.php", "w");
		fwrite($owner, '<?php $config["owner"] = "'.addslashes($_POST['superadmin']).'";');
		fclose($owner);

		require_once('../application/libraries/ConfigEditor.php');

		$distConfig = '../application/config/fusion.php.dist';
		$config = '../application/config/fusion.php';
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

		$config = '../application/config/captcha.php';
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
		$config = new ConfigEditor('../application/config/auth.php');

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

		$db = fopen("../application/config/database.php", "w");

		$raw = '<?php
$active_group = "cms";
$query_builder = true;

$db["cms"]["hostname"] = "'.$_POST['cms_hostname'].'";
$db["cms"]["username"] = "'.$_POST['cms_username'].'";
$db["cms"]["password"] = "'.$_POST['cms_password'].'";
$db["cms"]["database"] = "'.$_POST['cms_database'].'";
$db["cms"]["port"] 	   = '.(is_numeric($_POST['cms_port']) ? $_POST['cms_port'] : self::MYSQL_DEFAULT_PORT).';
$db["cms"]["dbdriver"] = "mysqli";
$db["cms"]["dbprefix"] = "";
$db["cms"]["pconnect"] = false;
$db["cms"]["db_debug"] = false;
$db["cms"]["cache_on"] = false;
$db["cms"]["cachedir"] = "";
$db["cms"]["char_set"] = "utf8mb4";
$db["cms"]["dbcollat"] = "utf8mb4_general_ci";
$db["cms"]["swap_pre"] = "";
$db["cms"]["autoinit"] = true;
$db["cms"]["stricton"] = false;

$db["account"]["hostname"] = "'.$_POST['realmd_hostname'].'";
$db["account"]["username"] = "'.$_POST['realmd_username'].'";
$db["account"]["password"] = "'.$_POST['realmd_password'].'";
$db["account"]["database"] = "'.$_POST['realmd_database'].'";
$db["account"]["port"]     = '.(is_numeric($_POST['realmd_port']) ? $_POST['realmd_port'] : self::MYSQL_DEFAULT_PORT).';
$db["account"]["dbdriver"] = "mysqli";
$db["account"]["dbprefix"] = "";
$db["account"]["pconnect"] = false;
$db["account"]["db_debug"] = false;
$db["account"]["cache_on"] = false;
$db["account"]["cachedir"] = "";
$db["account"]["char_set"] = "utf8";
$db["account"]["dbcollat"] = "utf8_general_ci";
$db["account"]["swap_pre"] = "";
$db["account"]["autoinit"] = false;
$db["account"]["stricton"] = false;';

		fwrite($db, $raw);

		fclose($db);

		die('1');
	}

	private function connect()
	{
		require('../application/config/database.php');

		$this->db = new mysqli($db['cms']['hostname'], $db['cms']['username'], $db['cms']['password'], $db['cms']['database'], $db['cms']['port']);
		if(mysqli_connect_error())
		{
			die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
		}
	}

	private function database()
	{
		$this->connect();

		$this->SplitSQL("SQL/fusion_final_full.sql");

		$updates = glob("SQL/updates/*.sql");

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

						if(!$this->db->query($query))
							die($this->db->error);

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

            // Connect to characters and world database
            @$connection = [
                'characters' => new mysqli($realm['hostname'], $realm['username'], $realm['password'], $realm['characters'], $realm['db_port']),
                'world'      => new mysqli($realm['hostname'], $realm['username'], $realm['password'], $realm['world'], $realm['db_port'])
            ];

            // Make sure database connection is secure
            foreach($connection as $db)
                if($db->connect_errno)
                    die('Failed to connect to MySQL: ' . $db->connect_error);

            // Skip
            if(!$insert)
                continue;

            // Prepare query statement
            $statement = "INSERT INTO `realms` (`hostname`, `username`, `password`, `char_database`, `world_database`, `cap`, `expansion`, `realmName`, `console_username`, `console_password`, `console_port`, `emulator`, `realm_port`, `override_port_world`, `override_port_char`) VALUES (':hostname', ':username', ':password', ':char_database', ':world_database', ':cap', ':expansion', ':realmName', ':console_username', ':console_password', ':console_port', ':emulator', ':realm_port', ':override_port_world', ':override_port_char')";

            // Prepare query data
            $data = [
                ':hostname'            => $this->db->real_escape_string($realm['hostname']),
                ':username'            => $this->db->real_escape_string($realm['username']),
                ':password'            => $this->db->real_escape_string($realm['password']),
                ':char_database'       => $this->db->real_escape_string($realm['characters']),
                ':world_database'      => $this->db->real_escape_string($realm['world']),
                ':cap'                 => $this->db->real_escape_string($realm['cap']),
                ':expansion'           => $this->db->real_escape_string($realm['realm_expansion']),
                ':realmName'           => $this->db->real_escape_string($realm['realmName']),
                ':console_username'    => $this->db->real_escape_string($realm['console_username']),
                ':console_password'    => $this->db->real_escape_string($realm['console_password']),
                ':console_port'        => $this->db->real_escape_string($realm['console_port']),
                ':emulator'            => $this->db->real_escape_string($realm['emulator']),
                ':realm_port'          => $this->db->real_escape_string($realm['port']),
                ':override_port_world' => $this->db->real_escape_string($realm['db_port']),
                ':override_port_char'  => $this->db->real_escape_string($realm['db_port'])
            ];

            // Everything is correct. Insert realm
            $this->db->query(str_replace(array_keys($data), array_values($data), $statement));
        }

        die('1');
    }

	private function finalStep()
	{
		$file = fopen('.lock', 'w');
		fclose($file);

		if(file_exists(".lock"))
		{
			die('success');
		}
	}
}

$install = new Install();
