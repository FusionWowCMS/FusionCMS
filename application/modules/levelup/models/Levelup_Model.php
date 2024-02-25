<?php
use MX\MX_Controller;

class Levelup_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function characterExists( $guid, $realmConnection ) {
        $query = $realmConnection->query( "SELECT * FROM " . table( "characters" ) . " WHERE " . column( "characters", "guid" ) . " = ? AND " . column( "characters", "online" ) . " = 0 AND " . column( "characters", "account" ) . " = ?", [$guid, $this->user->getId()]);

        if ( $query->num_rows() > 0 ) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }
}

?>
