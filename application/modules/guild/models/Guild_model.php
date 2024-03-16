<?php

class Guild_model extends CI_Model
{
    public function getGuild($realm, $guildId)
    {
        $realm = $this->realms->getRealm($realm);
        $realm->getCharacters()->connect();
        $connection = $realm->getCharacters()->getConnection();

        $query = $connection->query(query('get_guild', $realm->getId()), [$guildId]);

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }
    public function getGuildMembers($realm, $guildId)
    {
        $realm = $this->realms->getRealm($realm);
        $realm->getCharacters()->connect();
        $connection = $realm->getCharacters()->getConnection();

        $query = $connection->query(query('get_guild_members', $realm->getId()), [$guildId]);

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function loadMember($realmId, $memberId)
    {
        $realm = $this->realms->getRealm($realmId);

        $data = $realm->getCharacters()->getCharacters(columns("characters", ["guid", "name", "race", "class", "gender", "level"], $realmId), [column("characters", "guid", false, $realmId) => $memberId]);

        return $data[0];
    }
}
