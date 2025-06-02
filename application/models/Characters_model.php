<?php

use CodeIgniter\Database\BaseConnection;
use MX\CI;

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @link    http://fusion-hub.com
 */

class Characters_model
{
    private BaseConnection $db;
    private $config;
    private $realmId;

    /**
     * Initialize the realm
     *
     * @param Array $config Database config
     */
    public function __construct($config)
    {
        $this->config = $config;

        $this->realmId = $this->config['id'];
    }

    /**
     * Connect to the database if not already connected
     */
    public function connect()
    {
        if (empty($this->db)) {
            $this->db = get_instance()->load->database($this->config['characters'], true);
        }
    }

    public function getConnection()
    {
        $this->connect();

        return $this->db;
    }

    /**
     * Get characters
     *
     * @param String $fields
     * @param Array $where
     * @param bool $removeGMs
     * @return Mixed
     */
    public function getCharacters(string $fields, array $where, bool $removeGMs = false): mixed
    {
        // Make sure we're connected
        $this->connect();

        $query = $this->db->table(table('characters', $this->realmId))->select($fields)->where($where)->get();

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        $rows = $query->getResultArray();
        if ($query->getNumRows() > 0) {
            if($removeGMs) {
                foreach ($rows as $key => $character) {
                    if (CI::$APP->external_account_model->getRank($character['account']) > 0) {
                        unset($rows[$key]);
                    }
                }
            }
            return $rows;
        } else {
            return false;
        }
    }

    /**
     * Get the online players
     *
     * @param bool $removeGMs
     * @return false|array
     */
    public function getOnlinePlayers(bool $removeGMs = false): false|array
    {
        return $this->getCharacters(columns("characters", ["guid", "account", "name", "race", "class", "gender", "level", "zone"], $this->realmId), [column("characters", "online", false, $this->realmId) => 1], $removeGMs);
    }

    /**
     * Get the online player count
     *
     * @param false|string $faction (alliance, horde)
     * @return Int
     */
    public function getOnlineCount(bool|string $faction = false): int
    {
        // Make sure we're connected
        $this->connect();

        switch ($faction) {
            default:
                $query = $this->db->query("SELECT COUNT(*) as `total` FROM " . table("characters", $this->realmId) . " WHERE " . column("characters", "online", false, $this->realmId) . "='1'");
                break;

            case 'alliance':
                $query = $this->db->query("SELECT COUNT(*) as `total` FROM " . table("characters", $this->realmId) . " WHERE " . column("characters", "online", false, $this->realmId) . "='1' AND " . column("characters", "race") . " IN(" . implode(",", get_instance()->realms->getAllianceRaces()) . ")");
                break;

            case 'horde':
                $query = $this->db->query("SELECT COUNT(*) as `total` FROM " . table("characters", $this->realmId) . " WHERE " . column("characters", "online", false, $this->realmId) . "='1' AND " . column("characters", "race") . " IN(" . implode(",", get_instance()->realms->getHordeRaces()) . ")");
                break;
        }

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            // Assign the online count
            $online = $row[0]['total'];
        } else {
            $online = 0;
        }

        return $online;
    }

    /**
     * Count the characters that belong to one account
     *
     * @param Int $account
     * @return Int
     */
    public function getCharacterCount(int $account): int
    {
        $this->connect();

        $query = $this->db->query("SELECT COUNT(*) as `total` FROM " . table("characters", $this->realmId) . " WHERE " . column("characters", "account", false, $this->realmId) . "=?", array($account));

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['total'];
        } else {
            return 0;
        }
    }

    /**
    * Get the characters that belong to one account
     *
    * @param false|Int $acc
    * @return Array
    */
    public function getCharactersByAccount(false|int $acc = false): array
    {
        if (!$acc) {
            $CI = &get_instance();
            $acc = $CI->user->getId();
        }

        return $this->getCharacters(columns("characters", ["guid", "name", "race", "class", "gender", "level", "online", "money", "zone"], $this->realmId), [column("characters", "account", false, $this->realmId) => $acc]);
    }

    /**
     * Get the character guid by the name
     *
     * @param String $name
     * @return false|int
     */
    public function getGuidByName(string $name): false|int
    {
        $this->connect();

        $query = $this->db->query("SELECT " . column("characters", "guid", true, $this->realmId) . " FROM " . table('characters', $this->realmId) . " WHERE " . column("characters", "name", false, $this->realmId) . "=?", array($name));

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['guid'];
        } else {
            return false;
        }
    }

    /**
    * Get the character online/offline status
     *
    * @param  Int $guid
    * @return Boolean
    */
    public function isOnline($guid)
    {
        $this->connect();

        $query = $this->db->query("SELECT " . column("characters", "online", true, $this->realmId) . " FROM " . table('characters', $this->realmId) . " WHERE " . column("characters", "guid", false, $this->realmId) . "=?", array($guid));

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['online'];
        } else {
            return false;
        }
    }

    /**
    * Get the character name by the guid
     *
    * @param  String $guid
    * @return Int
    */
    public function getNameByGuid($guid)
    {
        $this->connect();

        $query = $this->db->query("SELECT " . column("characters", "name", true, $this->realmId) . " FROM " . table('characters', $this->realmId) . " WHERE " . column("characters", "guid", false, $this->realmId) . "=?", array($guid));

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['name'];
        } else {
            return false;
        }
    }

    /**
    * Get the character by the guid
    * @param String $guid
    * @return Array
    */

    public function getCharacterByGuid($guid)
    {
        $this->connect();
        $query = $this->db->query("SELECT * FROM ".table('characters', $this->realmId)." WHERE ".column("characters", "guid", false, $this->realmId)."=?", array($guid));

        if($this->db->error())
        {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if($query->getNumRows() > 0)
        {
            $row = $query->getResultArray();

            return $row[0];
        }
        else
        {
            return [];
        }
    }

    /**
    * Get the character faction (alliance/horde) by the guid
     *
    * @param  String $guid
    * @return Int
    */
    public function getFaction($guid)
    {
        $this->connect();

        $query = $this->db->query("SELECT " . column("characters", "race", true, $this->realmId) . " FROM " . table('characters', $this->realmId) . " WHERE " . column("characters", "guid", false, $this->realmId) . "=?", array($guid));

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            if (in_array($row[0]['race'], get_instance()->realms->getAllianceRaces())) {
                return 1;
            } elseif (in_array($row[0]['race'], get_instance()->realms->getHordeRaces())) {
                return 2;
            } else {
                return 0;
            }
        } else {
            return false;
        }
    }

    /**
    * Check if a character exists
     *
    * @param  Int $id
    * @return Boolean
    */
    public function characterExists($id)
    {
        $this->connect();

        $query = $this->db->query("SELECT COUNT(*) as `total` FROM " . table('characters', $this->realmId) . " WHERE " . column("characters", "guid", false, $this->realmId) . "=?", array($id));

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            if ($row[0]['total'] == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
    * Check if a character belongs to the specified account
     *
    * @param  Int $characterId
    * @param  Int $accountId
    * @return Boolean
    */
    public function characterBelongsToAccount($characterId, $accountId)
    {
        $this->connect();

        $query = $this->db->query("SELECT COUNT(*) as `total` FROM " . table('characters', $this->realmId) . " WHERE " . column("characters", "guid", false, $this->realmId) . "=? AND " . column("characters", "account", false, $this->realmId) . "=?", array($characterId, $accountId));

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            if ($row[0]['total'] == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get the gold of a character
     *
     * @param  Int $account
     * @param  Int $guid
     * @return Int
     */
    public function getGold($account, $guid)
    {
        $query = $this->db->query("SELECT " . column("characters", "money", true, $this->realmId) . " FROM " . table("characters", $this->realmId) . " WHERE " . column("characters", "account", false, $this->realmId) . " = ? AND " . column("characters", "guid", false, $this->realmId) . " = ?", array($account, $guid));
        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0]["money"];
        } else {
            return false;
        }
    }

    /**
     * Set the gold of a character
     *
     * @param  Int $account
     * @param  Int $guid
     * @param  Int $newGold
     * @return Boolean
     */
    public function setGold($account, $guid, $newGold)
    {
        $query = $this->db->query("UPDATE " . table("characters", $this->realmId) . " SET " . column("characters", "money", false, $this->realmId) . " = ? WHERE " . column("characters", "account", false, $this->realmId) . " = ? AND " . column("characters", "guid", false, $this->realmId) . " = ?", array($newGold, $account, $guid));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}
