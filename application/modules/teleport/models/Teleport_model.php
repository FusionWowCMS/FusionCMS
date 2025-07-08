<?php

class Teleport_model extends CI_Model
{
    public function getTeleportLocations(): array
    {
        $query = $this->db->query("SELECT * FROM teleport_locations");

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return [];
        }
    }

    public function getTeleportMaps(): array
    {
        $query = $this->db->query("SELECT id, name FROM teleport_maps");

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return [];
        }
    }

    public function teleportLocationExists($teleportLocationId)
    {
        $query = $this->db->query("SELECT t.id, t.name, t.description, t.x, t.y, t.z, t.orientation, t.mapId, t.vpCost, t.dpCost, t.goldCost, t.realm, r.realmName, t.required_faction, t.required_level, t.map_id FROM teleport_locations t, realms r WHERE r.id = t.realm AND t.id = ? ORDER BY t.realm ASC", [$teleportLocationId]);

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }

    public function characterExists($guid, $realmConnection)
    {
        $query = $realmConnection->query("SELECT * FROM " . table("characters") . " WHERE " . column("characters", "guid") . " = ? AND " . column("characters", "online") . " = 0 AND " . column("characters", "account") . " = ?", [$guid, $this->user->getId()]);

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }

    public function setLocation($x, $y, $z, $o, $mapId, $characterGuid, $realmConnection)
    {
        $realmConnection->query("UPDATE " . table("characters") . " SET " . column("characters", "position_x") . " = ?, " . column("characters", "position_y") . " = ?, " . column("characters", "position_z") . " = ?, " . column("characters", "orientation") . " = ?, " . column("characters", "map") . " = ? WHERE " . column("characters", "guid") . " = ?", [$x, $y, $z, $o, $mapId, $characterGuid]);
    }

    public function add($data)
    {
        $this->db->table('teleport_locations')->insert($data);
    }

    public function edit($id, $data)
    {
        $this->db->table('teleport_locations')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM teleport_locations WHERE id = ?", [$id]);
    }
}
