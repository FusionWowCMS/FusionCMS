<?php

class Armory_model extends CI_Model
{
    public $realm;
    private $connection;
    private $id;
    private $realmId;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Assign the character ID to the model
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Assign the realm object to the model
     */
    public function setRealm($id)
    {
        $this->realmId = $id;
        $this->realm = $this->realms->getRealm($id);
    }

    /**
     * Connect to the character database
     */
    public function connect()
    {
        $this->realm->getCharacters()->connect();
        $this->connection = $this->realm->getCharacters()->getConnection();
    }

    /**
     * Check if the current character exists
     */
    public function characterExists()
    {
        $this->connect();

        $query = $this->connection->query("SELECT COUNT(*) AS total FROM " . table("characters", $this->realmId) . " WHERE " . column("characters", "guid", false, $this->realmId) . "= ?", array($this->id));
        $row = $query->result_array();

        if ($row[0]['total'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the character data that belongs to the character
     */
    public function getCharacter()
    {
        $this->connect();

        $query = $this->connection->query(query('get_character', $this->realmId), array($this->id));

        if ($query && $query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return array(
                "account" => "",
                "name" => "",
                "race" => "",
                "class" => "",
                "gender" => "",
                "level" => ""
            );
        }
    }

    /**
     * Get the character stats that belongs to the character
     */
    public function getStats()
    {
        $this->connect();

        $query = $this->connection->query("SELECT " . allColumns("character_stats", $this->realmId) . " FROM " . table("character_stats", $this->realmId) . " WHERE " . column("character_stats", "guid", false, $this->realmId) . "= ?", array($this->id));

        if ($query && $query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    /**
     * Load items that belong to the character
     */
    public function getItems()
    {
        $this->connect();

        $query = $this->connection->query(query("get_inventory_item", $this->realmId), array($this->id));

        if ($query && $query->num_rows() > 0) {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function getGuild()
    {
        $this->connect();

        $query = $this->connection->query("SELECT " . column("guild_member", "guildid", true, $this->realmId) . " FROM " . table("guild_member", $this->realmId) . " WHERE " . column("guild_member", "guid", false, $this->realmId) . "= ?", array($this->id));

        if ($this->connection->error()) {
            $error = $this->connection->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }


        if ($query && $query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['guildid'];
        } else {
            $query2 = $this->connection->query("SELECT " . column("guild", "guildid", true, $this->realmId) . " FROM " . table("guild", $this->realmId) . " WHERE " . column("guild", "leaderguid", false, $this->realmId) . "= ?", array($this->id));

            if ($this->connection->error()) {
                $error = $this->connection->error();
                if ($error['code'] != 0) {
                    die($error["message"]);
                }
            }


            if ($query2 && $query2->num_rows() > 0) {
                $row2 = $query2->result_array();

                return $row2[0]['guildid'];
            } else {
                return false;
            }
        }
    }

    public function getGuildName($id)
    {
        if (!$id) {
            return '';
        } else {
            $this->connect();

            $query = $this->connection->query("SELECT " . column("guild", "name", true, $this->realmId) . " FROM " . table("guild", $this->realmId) . " WHERE " . column("guild", "guildid", false, $this->realmId) . "= ?", array($id));

            if ($query && $query->num_rows() > 0) {
                $row = $query->result_array();

                return $row[0]['name'];
            } else {
                return false;
            }
        }
    }
}
