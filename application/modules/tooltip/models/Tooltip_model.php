<?php

use CodeIgniter\Database\BaseConnection;

class Tooltip_model extends CI_Model
{
    private BaseConnection $connection;

    /**
     * Connect to the character database
     */
    public function connect($realmId): void
    {
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->connection = $realm->getCharacters()->getConnection();
    }

    /**
     * Check if the current character exists
     */
    public function characterExists($realmId, $characterId)
    {
        $this->connect($realmId);

        $query = $this->connection->query('SELECT COUNT(*) AS total FROM ' . table('characters', $realmId) . ' WHERE ' . column('characters', 'guid', false, $realmId) . '= ?', [$characterId]);
        $row = $query->getResultArray();

        if ($row[0]['total'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the character data that belongs to the character
     */
    public function getCharacter($realmId, $characterId)
    {
        $this->connect($realmId);

        $query = $this->connection->query(query('get_character', $realmId), [$characterId]);

        if ($query && $query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return [
                'account' => '',
                'name' => '',
                'race' => '',
                'class' => '',
                'gender' => '',
                'level' => ''
            ];
        }
    }

    public function getGuildName($realmId, $characterId)
    {
        $this->connect($realmId);

        $query = $this->connection->query("SELECT " . column("guild_member", "guildid", true, $realmId) . " FROM " . table("guild_member", $realmId) . " WHERE " . column("guild_member", "guid", false, $realmId) . "= ?", [$characterId]);

        if ($this->connection->error()) {
            $error = $this->connection->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query && $query->getNumRows() > 0) {
            $row = $query->getResultArray();

            $query = $this->connection->query("SELECT " . column("guild", "name", true, $realmId) . " FROM " . table("guild", $realmId) . " WHERE " . column("guild", "guildid", false, $realmId) . "= ?", [$row[0]['guildid']]);

            if ($query && $query->getNumRows() > 0) {
                $row = $query->getResultArray();

                return $row[0]['name'];
            } else {
                return false;
            }
        } else {
            $query2 = $this->connection->query("SELECT " . column("guild", "name", true, $realmId) . " FROM " . table("guild", $realmId) . " WHERE " . column("guild", "leaderguid", false, $realmId) . "= ?", [$characterId]);

            if ($this->connection->error()) {
                $error = $this->connection->error();
                if ($error['code'] != 0) {
                    die($error["message"]);
                }
            }

            if ($query2 && $query2->getNumRows() > 0) {
                $row2 = $query2->getResultArray();

                return $row2[0]['guildid'];
            } else {
                return false;
            }
        }
    }
}
