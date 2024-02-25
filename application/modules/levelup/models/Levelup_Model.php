<?php
use MX\MX_Controller;

class Levelup_Model extends CI_Model {
    
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

}

?>
