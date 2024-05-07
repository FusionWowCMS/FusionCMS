<?php

use CodeIgniter\Database\BaseConnection;

class Armory_model extends CI_Model
{
    private BaseConnection $c_connection;
    private BaseConnection $w_connection;

    public function get_items($searchString, $limit, $offset, $realmId = 1)
    {
        //Connect to the world database
        $realm = $this->realms->getRealm($realmId);

        // In patch 6.x.x and higher, the item_template table has been removed.
        if ($realm->getExpansionId() > 4)
            return false;

        $this->w_connection = $realm->getWorld()->getConnection();

        $searchString = $this->w_connection->escapeString($searchString);

        //Get the connection and run a query
        $query = $this->w_connection->query("SELECT " . columns("item_template", ["entry", "name", "ItemLevel", "RequiredLevel", "InventoryType", "Quality", "class", "subclass"], $realmId) . " FROM " . table("item_template", $realmId) . " WHERE UPPER(" . column("item_template", "name", false, $realmId) . ") LIKE ? ORDER BY " . column("item_template", "ItemLevel", false, $realmId) . " DESC LIMIT ".$limit." OFFSET ".$offset, ['%' . strtoupper($searchString) . '%']);

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
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

        $this->w_connection = $realm->getWorld()->getConnection();
        
        $string = $this->w_connection->escapeString($string);

        return $this->w_connection->table(table("item_template", $realmId))->like(column("item_template", "name", false, $realmId), $string)->countAllResults();
    }

    public function get_guilds($searchString, $limit, $offset, $realmId = 1)
    {
        //Connect to the character database
        $realm = $this->realms->getRealm($realmId);

        $this->c_connection = $realm->getCharacters()->getConnection();

        $searchString = $this->c_connection->escapeString($searchString);

        $query = $this->c_connection->query(query("find_guilds", $realmId), ['%' . $searchString . '%']);

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function get_guilds_count($string, $realmId)
    {
        $realm = $this->realms->getRealm($realmId);

        $this->c_connection = $realm->getCharacters()->getConnection();
        
        $string = $this->c_connection->escapeString($string);

        return $this->c_connection->table(table("guild", $realmId))->like(column("guild", "name", false, $realmId), $string)->countAllResults();
    }

    public function get_characters($searchString, $limit, $offset, $realmId = 1)
    {
        $realm = $this->realms->getRealm($realmId);

        $this->c_connection = $realm->getCharacters()->getConnection();

        $searchString = $this->c_connection->escapeString($searchString);

        $builder = $this->c_connection->table(table("characters", $realmId))->select(columns("characters", ["guid", "name", "race", "gender", "class", "level"], $realmId));
        $builder->like(column("characters", "name", false, $realmId), ucfirst($searchString));
        $builder->limit($limit, $offset);
        $result = $builder->get();

        if ($result->getNumRows() > 0) {
            return $result->getResultArray();
        } else {
            return false;
        }
    }

    public function get_characters_count($string, $realmId)
    {
        $realm = $this->realms->getRealm($realmId);

        $this->c_connection = $realm->getCharacters()->getConnection();
        
        $string = $this->c_connection->escapeString($string);

        return $this->c_connection->table(table("characters", $realmId))->like(column("characters", "name", false, $realmId), $string)->countAllResults();
    }
}
