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

class Realm
{
    // Config
    private $id;
    private $name;
    private $playerCap;
    private $config;

    // Objects
    private $CI;
    private $characters;
    private $world;
    private $emulator;

    // Runtime values
    private $online;
    private $onlineFaction;
    private $isOnline;

    /**
     * Initialize the realm
     *
     * @param Int $id
     * @param String $name
     * @param Int $playerCap
     * @param Array $config
     */
    public function __construct($id, $name, $playerCap, $config, $emulator)
    {
        // Assign the values
        $this->id = $id;
        $this->name = $name;
        $this->playerCap = $playerCap;
        $this->config = $config;
        $this->config['emulator'] = $emulator;
        $this->isOnline = null;
        $this->onlineFaction = array();

        $overrideParts = array(
            'username',
            'password',
            'hostname',
            'port'
        );

        foreach ($overrideParts as $part) {
            $this->config["override_" . $part . "_char"] = $this->config['characters'][$part];
            $this->config["override_" . $part . "_world"] = $this->config['world'][$part];
        }

        $this->config['characters_database'] = $this->config['characters']['database'];
        $this->config['world_database'] = $this->config['world']['database'];

        // Get the CodeIgniter instance
        $this->CI = &get_instance();

        // Load the objects
        require_once('application/models/World_model.php');
        require_once('application/models/Characters_model.php');

        // Make sure the emulator is installed
        if (file_exists('application/emulators/' . $emulator . '.php')) {
            require_once('application/emulators/' . $emulator . '.php');
        } else {
            show_error("The entered emulator (" . $emulator . ") doesn't exist in application/emulators/");
        }

        // Pass the realm ID to the emulator layer
        $config['id'] = $id;

        // Initialize the objects
        $this->emulator = new $emulator($config);
        $this->characters = new Characters_model($config);
        $this->world = new World_model($config);
    }

    /**
     * Get the amount of online players
     *
     * @param  String $faction horde/alliance
     * @return Int
     */
    public function getOnline($faction = false)
    {
        if (!$faction) {
            if (!empty($this->online)) {
                return $this->online;
            } else {
                // Get the online count
                $cache = $this->CI->cache->get("online_" . $this->id);

                // Can we use the cache?
                if ($cache !== false) {
                    $this->online = $cache;
                } else {
                    // Load and save as cache
                    $this->online = $this->characters->getOnlineCount();

                    // Cache it for 5 minutes
                    $this->CI->cache->save("online_" . $this->id, $this->online, 60 * 5);
                }

                return $this->online;
            }
        } else {
            if (!empty($this->onlineFaction[$faction])) {
                return $this->onlineFaction[$faction];
            } else {
                $cache = $this->CI->cache->get("online_" . $this->id . "_" . $faction);

                // Can we use the cache?
                if ($cache !== false) {
                    $this->onlineFaction[$faction] = $cache;
                } else {
                    // Load and save as cache
                    $this->onlineFaction[$faction] = $this->characters->getOnlineCount($faction);

                    // Cache it for 5 minutes
                    $this->CI->cache->save("online_" . $this->id . "_" . $faction, $this->onlineFaction[$faction], 60 * 5);
                }
            }

            return $this->onlineFaction[$faction];
        }
    }

    /**
     * Get the amount of characters that belongs to a certain account
     *
     * @param  Int $account
     * @return Int
     */
    public function getCharacterCount($account = false)
    {
        // Default to the current user
        if (!$account) {
            $account = $this->CI->user->getId();
        }

        // Check for cache to use
        $cache = $this->CI->cache->get("total_characters_" . $this->id . "_" . $account);

        // Cache is fresh
        if ($cache !== false) {
            return $cache;
        } else {
            // Refresh cache
            $count = $this->characters->getCharacterCount($account);

            $this->CI->cache->save("total_characters_" . $this->id . "_" . $account, $count, 60 * 60);

            return $count;
        }
    }

    /**
     * Get the percentage of online/cap
     *
     * @param  String $faction horde/alliance
     * @return Int
     */
    public function getPercentage($faction = false)
    {
        if (!$faction) {
            $online = $this->getOnline();
            $cap = $this->getCap();
        } else {
            $online = $this->getOnline($faction);
            $cap = $this->getOnline();
        }

        // Prevent division by zero
        if (
            $online == 0
            || $cap == 0
        ) {
            return 0;
        }

        // Make sure 100 is the max percentage they can get
        elseif ($online > $cap) {
            return 100;
        }

        // Calculate percentage
        else {
            $percentage = round(($online / $cap) * 100);
        }

        return $percentage;
    }

    /**
     * Get the realm name
     *
     * @return String
     */
    public function getName()
    {
        return addslashes($this->name);
    }

    /**
     * Get the realm id
     *
     * @return Int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the player cap
     *
     * @return Int
     */
    public function getCap()
    {
        return $this->playerCap;
    }

    public function getWorld()
    {
        return $this->world;
    }

    public function getCharacters()
    {
        return $this->characters;
    }

    public function getEmulator()
    {
        return $this->emulator;
    }

    public function getExpansionId()
    {
        return $this->getConfig('expansion');
    }

    public function getExpansionName()
    {
        return $this->getExpansionNameById($this->getConfig('expansion'));
    }

    public function getExpansionSmallName()
    {
        switch ($this->getConfig('expansion')){
			case 0:
				return 'classic';
			break;
			case 1:
				return 'tbc';
			break;
			case 2:
				return 'wotlk';
			break;
			case 3:
				return 'cata';
			break;
			case 4:
				return 'mop';
			break;
			case 5:
				return 'wod';
			break;
			case 6:
				return 'legion';
			break;
			case 7:
				return 'bfa';
			break;
			case 8:
				return 'sl';
			break;
			case 9:
				return 'df';
			break;
			default:
				return 'default';
			break;
		}
    }

    public function getExpansionNameById($id)
    {
        switch ($id){
			case 0:
				return 'Vanilla/Classic';
			break;
			case 1:
				return 'The Burning Crusade';
			break;
			case 2:
				return 'Wrath of The Lich King';
			break;
			case 3:
				return 'Cataclysm';
			break;
			case 4:
				return 'Mists of Pandaria';
			break;
			case 5:
				return 'Warlods of Draenor';
			break;
			case 6:
				return 'Legion';
			break;
			case 7:
				return 'Battle for Azeroth';
			break;
			case 8:
				return 'Shadowlands';
			break;
			case 9:
				return 'Dragonflight';
			break;
		}
    }

    /**
     * Check if the realm is up and running
     *
     * @param  Boolean $realtime
     * @return Boolean
     */
    public function isOnline($realtime = false)
    {
        if ($this->isOnline != null) {
            return $this->isOnline;
        } else {
            if (!$realtime) {
                $data = $this->CI->cache->get("isOnline_" . $this->getId());

                if ($data !== false) {
                    return ($data == "yes") ? true : false;
                }
            }

            if (@fsockopen($this->config['hostname'], $this->config['realm_port'], $errno, $errstr, 1.5)) {
                $this->isOnline = true;
            } else {
                $this->isOnline = false;
            }

            $this->CI->cache->save("isOnline_" . $this->getId(), ($this->isOnline) ? "yes" : "no", 60 * 5);

            return $this->isOnline;
        }
    }

    /**
     * Get config value
     *
     * @param  String $key
     * @return String
     */
    public function getConfig($key)
    {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        } else {
            return false;
        }
    }
}
