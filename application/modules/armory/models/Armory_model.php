<?php

class Armory_model extends CI_Model
{
    private $c_connection;
    private $w_connection;

    public function get_items($searchString, $limit, $offset, $realmId = 1)
    {        
        //Connect to the world database
        $realm = $this->realms->getRealm($realmId);

        // In patch 6.x.x and higher, the item_template table has been removed.
        if ($realm->getExpansionId() > 4)
            return false;

        $realm->getWorld()->connect();
        $this->w_connection = $realm->getWorld()->getConnection();

        $searchString = $this->w_connection->escape_str($searchString);

        //Get the connection and run a query
        $query = $this->w_connection->query("SELECT " . columns("item_template", ["entry", "name", "ItemLevel", "RequiredLevel", "InventoryType", "Quality", "class", "subclass"], $realmId) . " FROM " . table("item_template", $realmId) . " WHERE UPPER(" . column("item_template", "name", false, $realmId) . ") LIKE ? ORDER BY " . column("item_template", "ItemLevel", false, $realmId) . " DESC LIMIT ".$limit." OFFSET ".$offset, ['%' . strtoupper($searchString) . '%']);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_items_count($string, $realmId)
    {
        $realm = $this->realms->getRealm($realmId);

        // In patch 6.x.x and higher, the item_template table has been removed.
        if ($realm->getExpansionId() > 4)
            return 0;

        $realm->getWorld()->connect();
        $this->w_connection = $realm->getWorld()->getConnection();
        
        $string = $this->w_connection->escape_str($string);

        $this->w_connection->like(column("item_template", "name", false, $realmId), $string);
        $this->w_connection->from(table("item_template", $realmId));

        return $this->w_connection->count_all_results();
    }

    public function get_guilds($searchString, $limit, $offset, $realmId = 1)
    {
        //Connect to the character database
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();

        $searchString = $this->c_connection->escape_str($searchString);

        $query = $this->c_connection->query(query("find_guilds", $realmId), ['%' . $searchString . '%']);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_guilds_count($string, $realmId)
    {
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();
        
        $string = $this->c_connection->escape_str($string);

        $this->c_connection->like(column("guild", "name", false, $realmId), $string);
        $this->c_connection->from(table("guild", $realmId));

        return $this->c_connection->count_all_results();
    }

    public function get_characters($searchString, $limit, $offset, $realmId = 1)
    {
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();

        $searchString = $this->c_connection->escape_str($searchString);

        $this->c_connection->select(columns("characters", ["guid", "name", "race", "gender", "class", "level"], $realmId));
        $this->c_connection->from(table("characters", $realmId));
        $this->c_connection->like(column("characters", "name", false, $realmId), ucfirst($searchString));
        $result = $this->c_connection->get();

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function get_characters_count($string, $realmId)
    {
        $realm = $this->realms->getRealm($realmId);
        $realm->getCharacters()->connect();
        $this->c_connection = $realm->getCharacters()->getConnection();
        
        $string = $this->c_connection->escape_str($string);

        $this->c_connection->like(column("characters", "name", false, $realmId), $string);
        $this->c_connection->from(table("characters", $realmId));

        return $this->c_connection->count_all_results();
    }
}
