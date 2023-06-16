<?php

class Guild_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getGuild($realm, $guildId)
    {
        $realm = $this->realms->getRealm($realm);
        $realm->getCharacters()->connect();
        $connection = $realm->getCharacters()->getConnection();

        $query = $connection->query(query('get_guild', $realm->getId()), array($guildId));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
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

        $query = $connection->query(query('get_guild_members', $realm->getId()), array($guildId));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    public function loadMember($realmId, $memberId)
    {
        $realm = $this->realms->getRealm($realmId);

        $data = $realm->getCharacters()->getCharacters(columns("characters", array("guid", "name", "race", "class", "gender", "level"), $realmId), array(column("characters", "guid", false, $realmId) => $memberId));

        return $data[0];
    }
}
