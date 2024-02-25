<?php
use MX\MX_Controller;

class Unstuck_Model extends CI_Model {

    private $connection;

    public function __construct() {
        parent::__construct();

    }

    public function characterExists( $guid, $realmConnection ) {
        $query = $realmConnection->query( "SELECT * FROM " . table( "characters" ) . " WHERE " . column( "characters", "guid" ) . " = ? AND " . column( "characters", "online" ) . " = 0 AND " . column( "characters", "account" ) . " = ?", array( $guid, $this->user->getId() ) );

        if ( $query->num_rows() > 0 ) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function GetRealmName( $realmid ) {

        $query = $this->db->query( "SELECT * FROM realms where  id =".$realmid );

        if ( $query->num_rows() > 0 ) {

            $result = $query->result_array();

            return $result[0]['realmName'];

        } else {
            return false;
        }

    }

    public function GetRealmLastID() {

        $query = $this->db->query( "SELECT * FROM realms LIMIT 1" );

        if ( $query->num_rows() > 0 ) {

            $result = $query->result_array();

            return $result[0]['id'];

        } else {
            return false;
        }

    }

    public function setLocation( $x, $y, $z, $o, $mapId, $characterGuid, $realmConnection ) {
        $realmConnection->query( "UPDATE " . table( "characters" ) . " SET " . column( "characters", "position_x" ) . " = ?, " . column( "characters", "position_y" ) . " = ?, " . column( "characters", "position_z" ) . " = ?, " . column( "characters", "orientation" ) . " = ?, " . column( "characters", "map" ) . " = ? WHERE " . column( "characters", "guid" ) . " = ?", array( $x, $y, $z, $o, $mapId, $characterGuid ) );
    }

    public function getcharacter_homebind( $realmId, $guid ) {

        $character_database = $this->realms->getRealm( $realmId )->getCharacters();
        $character_database->connect();

        $query = $character_database->getConnection()->query( "SELECT * FROM character_homebind WHERE guid = ?", array( $guid ) );

        if ( $query->num_rows() > 0 ) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

}

?>
