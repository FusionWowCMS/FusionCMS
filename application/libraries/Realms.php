<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @author  Ehsan Zare (Darksider) <darksider.legend@gmail.com>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

class Realms
{
    // Objects
    private array $realms;
    private $CI;

    // Runtime values
    private array $races;
    private array $classes;
    private $races_en;
    private $classes_en;
    private $itemtype_en;
    private array $zones;
    private array $hordeRaces;
    private array $allianceRaces;

    private string $defaultEmulator = "trinity";

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->races = array();
        $this->classes = array();
        $this->zones = array();
        $this->realms = array();
        $this->hordeRaces = array();
        $this->allianceRaces = array();

        // Load the realm object
        require_once('application/libraries/Realm.php');

        // Load the emulator interface
        require_once('application/interfaces/emulator.php');

        // Get the realms
        $this->CI->load->model('cms_model');

        $realms = $this->CI->cms_model->getRealms();

        if ($realms) {
            foreach ($realms as $realm) {
                // Prepare the database Config
                $config = array(

                    // Console settings
                    "console_username" => $realm['console_username'],
                    "console_password" => $realm['console_password'],
                    "console_port" => $realm['console_port'],
                    "expansion" => $realm['expansion'],

                    "hostname" => $realm['hostname'],
                    "realm_port" => $realm['realm_port'],

                    // Database settings
                    "world" => array(
                        "hostname" => (array_key_exists("override_hostname_world", $realm) && !empty($realm['override_hostname_world'])) ? $realm['override_hostname_world'] : $realm['hostname'],
                        "username" => (array_key_exists("override_username_world", $realm) && !empty($realm['override_username_world'])) ? $realm['override_username_world'] : $realm['username'],
                        "password" => (array_key_exists("override_password_world", $realm) && !empty($realm['override_password_world'])) ? $realm['override_password_world'] : $realm['password'],
                        "database" => $realm['world_database'],
                        "dbdriver" => "mysqli",
                        "port" => (array_key_exists("override_port_world", $realm) && !empty($realm['override_port_world'])) ? $realm['override_port_world'] : 3306,
                        "pconnect" => false,
                    ),

                    "characters" => array(
                        "hostname" => (array_key_exists("override_hostname_char", $realm) && !empty($realm['override_hostname_char'])) ? $realm['override_hostname_char'] : $realm['hostname'],
                        "username" => (array_key_exists("override_username_char", $realm) && !empty($realm['override_username_char'])) ? $realm['override_username_char'] : $realm['username'],
                        "password" => (array_key_exists("override_password_char", $realm) && !empty($realm['override_password_char'])) ? $realm['override_password_char'] : $realm['password'],
                        "database" => $realm['char_database'],
                        "dbdriver" => "mysqli",
                        "port" => (array_key_exists("override_port_char", $realm) && !empty($realm['override_port_char'])) ? $realm['override_port_char'] : 3306,
                        "pconnect" => false,
                    )
                );

                // Initialize the realm object
                $this->realms[] = new Realm($realm['id'], $realm['realmName'], $realm['cap'], $config, $realm['emulator']);
            }
        }
    }

    /**
     * Get the realm objects
     *
     * @return Array
     */
    public function getRealms(): array
    {
        return $this->realms;
    }

    /**
     * Get one specific realm object
     *
     * @param int $id
     * @return Object|null
     */
    public function getRealm(int $id): ?object
    {
        foreach ($this->realms as $key => $realm) {
            if ($realm->getId() == $id) {
                return $this->realms[$key];
            }
        }

        show_error("There is no realm with ID " . $id);
        return null;
    }

    /**
     * Check if there's a realm with the specified ID
     *
     * @param $id
     * @return Boolean
     */
    public function realmExists($id): bool
    {
        foreach ($this->realms as $realm) {
            if ($realm->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the total number of characters owned by one account
     */
    public function getTotalCharacters($account = false): int
    {
        if (!$account) {
            $account = $this->CI->user->getId();
        }

        $count = 0;

        foreach ($this->getRealms() as $realm) {
            $count += $realm->getCharacters()->getCharacterCount($account);
        }

        return $count;
    }

    /**
     * Load the wow_constants config and populate the arrays
     */
    private function loadConstants(): void
    {
        $this->CI->config->load('wow_constants');

        $this->races = $this->CI->config->item('races');
        $this->hordeRaces = $this->CI->config->item('horde_races');
        $this->allianceRaces = $this->CI->config->item('alliance_races');
        $this->classes = $this->CI->config->item('classes');

        $this->races_en = $this->CI->config->item('races_en');
        $this->classes_en = $this->CI->config->item('classes_en');
        $this->itemtype_en = $this->CI->config->item('itemtype_en');
    }

    /**
     * Load the wow_zones config and populate the zones array
     */
    private function loadZones(): void
    {
        $this->CI->config->load('wow_zones');

        $this->zones = $this->CI->config->item('zones');
    }

    /**
     * Get the alliance race IDs
     *
     * @return Array
     */
    public function getAllianceRaces(): array
    {
        if (!($this->allianceRaces)) {
            $this->loadConstants();
        }

        return $this->allianceRaces;
    }

    /**
     * Get the horde race IDs
     *
     * @return Array
     */
    public function getHordeRaces(): array
    {
        if (!($this->hordeRaces)) {
            $this->loadConstants();
        }

        return $this->hordeRaces;
    }

    /**
     * Get the name of a race
     *
     * @param Int $id
     * @return String
     */
    public function getRace(int $id): string
    {
        if (!($this->races)) {
            $this->loadConstants();
        }

        if (array_key_exists($id, $this->races)) {
            return $this->races[$id];
        } else {
            return "Unknown";
        }
    }

    /**
     * Get the name of a class
     *
     * @param Int $id
     * @return String
     */
    public function getClass(int $id): string
    {
        if (!($this->classes)) {
            $this->loadConstants();
        }

        if (array_key_exists($id, $this->classes)) {
            return $this->classes[$id];
        } else {
            return "Unknown";
        }
    }

    /**
     * Get the name of a race
     *
     * @param Int $id
     * @return String
     */
    public function getRaceEN(int $id): string
    {
        if (!($this->races_en)) {
            $this->loadConstants();
        }

        if (array_key_exists($id, $this->races_en)) {
            return $this->races_en[$id];
        } else {
            return "Unknown";
        }
    }

    /**
     * Get the name of a class
     *
     * @param Int $id
     * @return String
     */
    public function getClassEN(int $id): string
    {
        if (!($this->classes_en)) {
            $this->loadConstants();
        }

        if (array_key_exists($id, $this->classes_en)) {
            return $this->classes_en[$id];
        } else {
            return "Unknown";
        }
    }

    /**
     * Get the zone name by zone ID
     *
     * @param Int $zoneId
     * @return String
     */
    public function getZone(int $zoneId): string
    {
        if (!($this->zones)) {
            $this->loadZones();
        }

        if (array_key_exists($zoneId, $this->zones)) {
            return $this->zones[$zoneId];
        } else {
            return "Unknown location";
        }
    }

    /**
     * Get all item class names
     *
     * @return array
     */
    public function getItemClassList(): array
    {
        if (!($this->itemtype_en)) {
            $this->loadConstants();
        }
        return $this->itemtype_en;
    }

    /**
     * Get the name of an item class
     *
     * @param Int $class
     * @return String
     */
    public function getItemClassType(int $class): string
    {
        if (!($this->itemtype_en)) {
            $this->loadConstants();
        }

        if (array_key_exists($class, $this->itemtype_en)) {
            return $this->itemtype_en[$class];
        } else {
            return "Unknown";
        }
    }

    /**
     * Load the general emulator, from the first realm
     */
    public function getEmulator()
    {
        if ($this->realms) {
            return $this->realms[0]->getEmulator();
        }

        // Make sure the emulator is installed
        if (file_exists('application/emulators/' . $this->defaultEmulator . '.php')) {
            require_once('application/emulators/' . $this->defaultEmulator . '.php');
        } else {
            show_error("The entered emulator (" . $this->defaultEmulator . ") doesn't exist in application/emulators/");
        }

        $config = array();
        $config['id'] = 1;

        // Initialize the objects
        return new $this->defaultEmulator($config);
    }

    /**
     * Get enabled expansions
     */
    public function getExpansions(): array
    {
        $expansions = $this->CI->config->item('expansions_name_en');
        $return = array();

        foreach ($expansions as $key => $value)
        {
            $return[$key] = $value;
        }

        return $return;
    }

    /**
     * Format character money
     *
     * @param bool|int $money
     * @return array|false
     */
    public function formatMoney(bool|int $money = false): array|false
    {
        if ($money) {
            $gold['gold'] = floor($money / 10000);
            $remainder = $money % 10000;
            $gold['silver'] = floor($remainder / 100);
            $gold['copper'] = $remainder % 100;
    
            return $gold;
        } else {
            return false;
        }
    }

    /**
     * Format an avatar path as in Class-Race-Gender-Level
     *
     * @param $character
     * @return String
     */
    public function formatAvatarPath($character): string
    {
        if (!isset($this->races_en)) {
            $this->loadConstants();
        }

        $classes = $this->classes_en;
        $races = $this->races_en;

        // Prevent errors
        $class = $classes[$character['class']] ?? null;
        $race = $races[$character['race']] ?? null;

        $raceId = $character['race'];
        $faction = null;

        $gender = ($character['gender']) ? "f" : "m";

		if($class == "Death knight")
		{
			$level = 70;
			$class = "Deathknight";
		}
        else if ($class == "Demon Hunter") {
            $level = 70;
            $class = "Demonhunter";
		}
		else if($class == "Monk")
		{
			$level = 70;
		}
		else
		{
			// If character is below 30, use lv 1 image
			if($character['level'] < 30)
			{
				$level = 1;
			}

			// If character is below 65, use lv 60 image
			elseif($character['level'] < 65)
			{
				$level = 60;
			}

			// 65+, use lvl70 image
			else
			{
				$level = 70;
			}
		}

		if($race == "Pandaren")
		{
			$level = 70;
			$class = $class == "Monk" ? "Monk" : null;

			if ($raceId == 24)
			    $faction = 'n';
			else if ($raceId == 25)
			    $faction = 'a';
			else if ($raceId == 26)
			    $faction = 'h';
		}
		else if($race == "Dracthyr")
		{
			$level = 70;
			$class = null;

			if ($raceId == 52)
			    $faction = 'a';
			else if ($raceId == 70)
			    $faction = 'h';
		}
		else if($race == "Worgen" || $race == "Goblin" || $race == "Dark Iron Dwarf" || $race == "Highmountain Tauren" || $race == "Lightforged Dranei" ||
		        $race == "Mag'har Orc" || $race == "Mechagnome" || $race == "Kul Tiran" || $race == "Zandalari Troll" || $race == "Vulpera" || $race == "Void elf")
		{
			$level = 70;
			$class = null;
		}

        if (in_array($race, array("Blood elf", "Night elf", "Void elf", "Zandalari Troll", "Kul Tiran", "Mag'har Orc", "Lightforged Dranei", "Highmountain Tauren", "Dark Iron Dwarf"))) {
            $race = preg_replace("/ /", "", $race);
        }

        $file = ($class ? $class . "-" : '') . strtolower($race) . "-" . $gender . "-" . $level . ($faction ? "-" . $faction : '');

        if (!file_exists("application/images/avatars/" . $file . ".gif")) {
            return "default";
        } else {
            return $file;
        }
    }
}
