<?php

class Teleport_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTeleportLocations()
    {
        $query = $this->db->query("SELECT * FROM teleport_locations");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function teleportLocationExists($teleportLocationId, $faction = "")
    {
        if ($faction != "") {
            $faction = "," . $faction;
        }

        if ($faction) {
            $query = $this->db->query("SELECT t.id, t.name, t.description, t.x, t.y, t.z, t.orientation, t.mapId, t.vpCost, t.dpCost, t.goldCost, t.realm, r.realmName, t.required_faction FROM teleport_locations t, realms r WHERE r.id = t.realm AND t.id = ? AND t.required_faction IN(0" . $faction . ") ORDER BY t.realm ASC", array($teleportLocationId));
        } else {
            $query = $this->db->query("SELECT t.id, t.name, t.description, t.x, t.y, t.z, t.orientation, t.mapId, t.vpCost, t.dpCost, t.goldCost, t.realm, r.realmName, t.required_faction FROM teleport_locations t, realms r WHERE r.id = t.realm AND t.id = ? ORDER BY t.realm ASC", array($teleportLocationId));
        }

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function getLocationRealm($id)
    {
        $query = $this->db->query("SELECT realm FROM teleport_locations WHERE id=?", array($id));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0]['realm'];
        } else {
            return false;
        }
    }

    public function characterExists($guid, $realmConnection)
    {
        $query = $realmConnection->query("SELECT * FROM " . table("characters") . " WHERE " . column("characters", "guid") . " = ? AND " . column("characters", "online") . " = 0 AND " . column("characters", "account") . " = ?", array($guid, $this->user->getId()));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function setLocation($x, $y, $z, $o, $mapId, $characterGuid, $realmConnection)
    {
        $realmConnection->query("UPDATE " . table("characters") . " SET " . column("characters", "position_x") . " = ?, " . column("characters", "position_y") . " = ?, " . column("characters", "position_z") . " = ?, " . column("characters", "orientation") . " = ?, " . column("characters", "map") . " = ? WHERE " . column("characters", "guid") . " = ?", array($x, $y, $z, $o, $mapId, $characterGuid));
    }

    public function add($data)
    {
        $this->db->insert("teleport_locations", $data);
    }

    public function edit($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('teleport_locations', $data);
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM teleport_locations WHERE id=?", array($id));
    }
}
