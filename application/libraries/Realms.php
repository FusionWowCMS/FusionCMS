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
    private array $maps;
    private array $hordeRaces;
    private array $allianceRaces;

    private string $defaultEmulator = "trinity";

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->races = [];
        $this->classes = [];
        $this->zones = [];
        $this->maps = [];
        $this->realms = [];
        $this->hordeRaces = [];
        $this->allianceRaces = [];

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
                    "world" => [
                        'DSN'      => '',
                        "hostname" => (array_key_exists("override_hostname_world", $realm) && !empty($realm['override_hostname_world'])) ? $realm['override_hostname_world'] : $realm['hostname'],
                        "username" => (array_key_exists("override_username_world", $realm) && !empty($realm['override_username_world'])) ? $realm['override_username_world'] : $realm['username'],
                        "password" => (array_key_exists("override_password_world", $realm) && !empty($realm['override_password_world'])) ? $realm['override_password_world'] : $realm['password'],
                        "database" => $realm['world_database'],
                        "DBDriver" => "MySQLi",
                        'DBPrefix' => '',
                        "port" => (array_key_exists("override_port_world", $realm) && !empty($realm['override_port_world'])) ? (int) $realm['override_port_world'] : 3306,
                        "pConnect" => false,
                        'DBDebug'  => false,
                        'charset'  => 'utf8',
                        'DBCollat' => 'utf8_general_ci',
                        'swapPre'  => '',
                        'encrypt'  => false,
                        'compress' => false,
                        'strictOn' => false,
                        'failover' => [],
                    ],

                    "characters" => [
                        'DSN'      => '',
                        "hostname" => (array_key_exists("override_hostname_char", $realm) && !empty($realm['override_hostname_char'])) ? $realm['override_hostname_char'] : $realm['hostname'],
                        "username" => (array_key_exists("override_username_char", $realm) && !empty($realm['override_username_char'])) ? $realm['override_username_char'] : $realm['username'],
                        "password" => (array_key_exists("override_password_char", $realm) && !empty($realm['override_password_char'])) ? $realm['override_password_char'] : $realm['password'],
                        "database" => $realm['char_database'],
                        "DBDriver" => "MySQLi",
                        'DBPrefix' => '',
                        "port" => (array_key_exists("override_port_char", $realm) && !empty($realm['override_port_char'])) ? (int) $realm['override_port_char'] : 3306,
                        "pConnect" => false,
                        'DBDebug'  => false,
                        'charset'  => 'utf8',
                        'DBCollat' => 'utf8_general_ci',
                        'swapPre'  => '',
                        'encrypt'  => false,
                        'compress' => false,
                        'strictOn' => false,
                        'failover' => [],
                    ]
                );

                // Initialize the realm object
                $this->realms[] = new Realm($realm['id'], $realm['realmName'], $realm['cap'], $config, $realm['emulator']);
            }
        }
    }

    /**
     * Get the realm objects
     *
     * @return Realm[]
     */
    public function getRealms(): array
    {
        return $this->realms;
    }

    /**
     * Get one specific realm object
     *
     * @param int $id
     * @return Realm|null
     */
    public function getRealm(int $id): ?Realm
    {
        foreach ($this->realms as $key => $realm) {
            if ($realm->getId() == $id) {
                return $this->realms[$key];
            }
        }

        show_error("There is no realm with ID " . $id, 400);
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
     * Load the wow_maps config and populate the maps array
     */
    private function loadMaps(): void
    {
        $this->CI->config->load('wow_maps');

        $this->maps = $this->CI->config->item('maps');
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
     * Get the map name by map ID
     *
     * @param int $mapId
     * @return string
     */
    public function getMap(int $mapId): string
    {
        if (!($this->maps)) {
            $this->loadMaps();
        }

        if (array_key_exists($mapId, $this->maps)) {
            return $this->maps[$mapId];
        } else {
            return "Unknown location";
        }
    }

    /**
     * Get all class names
     *
     * @return array
     */
    public function getClassList(): array
    {
        if (!($this->classes)) {
            $this->loadConstants();
        }
        return $this->classes;
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
     * Get the character faction (alliance/horde) by the race id
     *
     * @param  int $raceId
     * @return Int
     */
    public function getFactionByRaceId(int $raceId): int
    {
        if (in_array($raceId, $this->getAllianceRaces())) {
            return 1;
        } elseif (in_array($raceId, $this->getHordeRaces())) {
            return 2;
        } else {
            return 0;
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

        $config = [];
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
        $return = [];

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
        $gender = ($character['gender']) ? "f" : "m";

        $faction = null;

        $classLevel70 = [
            "Death knight" => "Deathknight",
            "Demon Hunter" => "Demonhunter",
            "Monk" => "Monk"
        ];

        $raceLevel70 = [
            "Worgen",
            "Goblin",
            "Pandaren",
            "Dark Iron Dwarf",
            "Highmountain Tauren",
            "Lightforged Dranei",
            "Mag'har Orc",
            "Mechagnome",
            "Kul Tiran",
            "Zandalari Troll",
            "Vulpera",
            "Void elf",
            "Dracthyr",
            "Earthen",
        ];

        $level = $character['level'] < 30 ? 1 : ($character['level'] < 65 ? 60 : 70); // If character is below 30, use lvl 1 image below 65 use lvl 60 image and +65 use lvl70 image

        if (in_array($race, $raceLevel70)) {
            $level = 70;
            $class = null;
        }

        if (array_key_exists($class, $classLevel70)) {
            $level = 70;
            $class = $classLevel70[$class];
        }

        if ($race == "Pandaren") {
            $faction = ($raceId == 24) ? 'n' : (($raceId == 25) ? 'a' : 'h');
        } elseif ($race == "Dracthyr") {
            $faction = ($raceId == 52) ? 'a' : 'h';
        } elseif ($race == "Earthen") {
            $faction = ($raceId == 85) ? 'a' : 'h';
        }

        $race = preg_replace("/ /", "", $race);
        $file = ($class ? $class . "-" : '') . strtolower($race) . "-" . $gender . "-" . $level . ($faction ? "-" . $faction : '');

        return file_exists('application/images/avatars/' . $file . '.gif') ? $file : 'default';
    }
}
