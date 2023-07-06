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
        if ( ! isset($_GET['test']))
            return;
        
		$folder = $_GET['test'];

		$file = fopen("../application/".$folder."/write_test.txt", "w");

		fwrite($file, "success");
		fclose($file);

		unlink("../application/".$folder."/write_test.txt");

		die("1");
	}
    
    private function checkPhpExtensions()
    {
        $req = array('mysqli', 'curl', 'openssl', 'soap', 'gd', 'mbstring', 'json', 'xml', 'zip');
        $loaded = get_loaded_extensions();
        $errors = array();
        
        foreach ($req as $ext)
            if ( ! in_array($ext, $loaded))
                $errors[] = $ext;
        
        die( $errors ? join(', ', $errors) : '1' );
    }
    
    private function checkApacheModules()
    {
        $req = array('mod_rewrite', 'mod_headers', 'mod_expires', 'mod_deflate');
        $loaded = apache_get_modules();
        $errors = array();
        
        foreach ($req as $ext)
            if ( ! in_array($ext, $loaded))
                $errors[] = $ext;
        
        die( $errors ? join(', ', $errors) : '1' );
    }
    
    private function checkPhpVersion()
    {
		die( version_compare(PHP_VERSION, '8.0.0', '>=') ? '1' : '0' );
    }
	
	private function checkDbConnection()
	{
		$req = array('hostname', 'username', 'database');
		
		foreach ($req as $var) {
			if ( ! isset($_POST[$var]) || empty($_POST[$var]))
				die('Please fill all fields.');
		}

	    @$db = new mysqli(
	    	$_POST['hostname'], 
	    	$_POST['username'], 
	    	$_POST['password'], 
	    	$_POST['database'],
	    	isset($_POST['port']) ? $_POST['port'] : self::MYSQL_DEFAULT_PORT 
	    );
		
		die($db->connect_error ? $db->connect_error : '1');
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

		$data['use_captcha'] = ($_POST['captcha'] == '1') ? true : false;
		$data['recaptcha_site_key'] = $_POST['site_key'];
		$data['recaptcha_secret_key'] = $_POST['secret_key'];

		foreach($data as $key => $value)
		{
			$config->set($key, $value);
		}

		$config->save();

		$db = fopen("../application/config/database.php", "w");

		$raw = '<?php
$active_group = "cms";
$query_builder = TRUE;

$db["cms"]["hostname"] = "'.$_POST['cms_hostname'].'";
$db["cms"]["username"] = "'.$_POST['cms_username'].'";
$db["cms"]["password"] = "'.$_POST['cms_password'].'";
$db["cms"]["database"] = "'.$_POST['cms_database'].'";
$db["cms"]["port"] 	   = '.(is_numeric($_POST['cms_port']) ? $_POST['cms_port'] : self::MYSQL_DEFAULT_PORT).';
$db["cms"]["dbdriver"] = "mysqli";
$db["cms"]["dbprefix"] = "";
$db["cms"]["pconnect"] = FALSE;
$db["cms"]["db_debug"] = TRUE;
$db["cms"]["cache_on"] = FALSE;
$db["cms"]["cachedir"] = "";
$db["cms"]["char_set"] = "utf8";
$db["cms"]["dbcollat"] = "utf8_general_ci";
$db["cms"]["swap_pre"] = "";
$db["cms"]["autoinit"] = TRUE;
$db["cms"]["stricton"] = FALSE;

$db["account"]["hostname"] = "'.$_POST['realmd_hostname'].'";
$db["account"]["username"] = "'.$_POST['realmd_username'].'";
$db["account"]["password"] = "'.$_POST['realmd_password'].'";
$db["account"]["database"] = "'.$_POST['realmd_database'].'";
$db["account"]["port"]     = '.(is_numeric($_POST['realmd_port']) ? $_POST['realmd_port'] : self::MYSQL_DEFAULT_PORT).';
$db["account"]["dbdriver"] = "mysqli";
$db["account"]["dbprefix"] = "";
$db["account"]["pconnect"] = FALSE;
$db["account"]["db_debug"] = TRUE;
$db["account"]["cache_on"] = FALSE;
$db["account"]["cachedir"] = "";
$db["account"]["char_set"] = "utf8";
$db["account"]["dbcollat"] = "utf8_general_ci";
$db["account"]["swap_pre"] = "";
$db["account"]["autoinit"] = FALSE;
$db["account"]["stricton"] = FALSE;';

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
				$query = array();

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
						$query = array();
					}
				}

				return fclose($file);
			}
		}

		return false;
	}

	private function realms()
	{
		$this->connect();

		$realms = json_decode(stripslashes($_POST['realms']), true);
		
		if(is_array($realms))
		{
			foreach($realms as $realm)
			{
				$this->db->query("INSERT INTO realms(`emulator`, `cap`, `expansion`, `char_database`, `console_password`,	`console_port`,	`console_username`,	`hostname`,	`password`, `realm_port`, `realmName`, `username`, `world_database`, `override_port_world`, `override_port_char`)
							VALUES('".$this->db->real_escape_string($realm['emulator'])."',
									'".$this->db->real_escape_string($realm['cap'])."',
									'".$this->db->real_escape_string($realm['realm_expansion'])."',
									'".$this->db->real_escape_string($realm['characters'])."',
									'".$this->db->real_escape_string($realm['console_password'])."',
									'".$this->db->real_escape_string($realm['console_port'])."',
									'".$this->db->real_escape_string($realm['console_username'])."',
									'".$this->db->real_escape_string($realm['hostname'])."',
									'".$this->db->real_escape_string($realm['password'])."',
									'".$this->db->real_escape_string($realm['port'])."',
									'".$this->db->real_escape_string($realm['realmName'])."',
									'".$this->db->real_escape_string($realm['username'])."',
									'".$this->db->real_escape_string($realm['world'])."',
									'".$this->db->real_escape_string($realm['db_port'])."',
									'".$this->db->real_escape_string($realm['db_port'])."')");
			}
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
