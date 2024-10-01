<?php

class Unstuck_Model extends CI_Model {

    public function setLocation( $x, $y, $z, $o, $mapId, $characterGuid, $realmConnection ) {
        $realmConnection->query("UPDATE " . table("characters") . " SET " . column("characters", "position_x") . " = ?, " . column("characters", "position_y") . " = ?, " . column("characters", "position_z") . " = ?, " . column("characters", "orientation") . " = ?, " . column("characters", "map") . " = ? WHERE " . column("characters", "guid") . " = ?", [$x, $y, $z, $o, $mapId, $characterGuid]);
    }

    public function getcharacter_homebind( $realmId, $guid ) {

        $character_database = $this->realms->getRealm( $realmId )->getCharacters();
        $character_database->connect();

        $query = $character_database->getConnection()->query( "SELECT * FROM character_homebind WHERE guid = ?", [$guid]);

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

}

?>
