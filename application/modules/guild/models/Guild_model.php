<?php

use CodeIgniter\Database\BaseConnection;

class Guild_model extends CI_Model
{
    private BaseConnection $connection;

    public function getGuild($realm, $guildId)
    {
        $realm = $this->realms->getRealm($realm);
        $realm->getCharacters()->connect();
        $this->connection = $realm->getCharacters()->getConnection();

        $query = $this->connection->query(query('get_guild', $realm->getId()), [$guildId]);

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }

    public function getGuildMembers($realm, $guildId): array
    {
        $realm = $this->realms->getRealm($realm);
        $realm->getCharacters()->connect();
        $this->connection = $realm->getCharacters()->getConnection();

        $query = $this->connection->query(query('get_guild_members', $realm->getId()), [$guildId]);

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return [];
        }
    }

    public function loadMember($realmId, $memberId)
    {
        $realm = $this->realms->getRealm($realmId);

        $data = $realm->getCharacters()->getCharacters(columns("characters", ["guid", "name", "race", "class", "gender", "level"], $realmId), [column("characters", "guid", false, $realmId) => $memberId]);

        return $data[0];
    }
}
