<?php

class Tickets_model extends CI_Model
{
    private $id;
    private $realmId;

    /**
     * Get all tickets
     *
     * @param  Object $realm
     * @return Array
     */
    public function getTickets($realm)
    {
        if ($realm) {
            //Connect to the realm
            $realm->getCharacters()->connect();

            //Do the query
            if (column("gm_tickets", "closedBy", $realm->getId())) {
                $query = $realm->getCharacters()->getConnection()->query("SELECT " . allColumns("gm_tickets", $realm->getId()) . " FROM " . table("gm_tickets", $realm->getId()) . " WHERE " . column("gm_tickets", "completed", false, $realm->getId()) . " = 0 AND " . column("gm_tickets", "closedBy", false, $realm->getId()) . " = 0");
            } elseif (column("gm_tickets", "completed", $realm->getId())) {
                $query = $realm->getCharacters()->getConnection()->query("SELECT " . allColumns("gm_tickets", $realm->getId()) . " FROM " . table("gm_tickets", $realm->getId()) . " WHERE " . column("gm_tickets", "completed", false, $realm->getId()) . " = 0");
            } else {
                $query = $realm->getCharacters()->getConnection()->query("SELECT " . allColumns("gm_tickets", $realm->getId()) . " FROM " . table("gm_tickets", $realm->getId()));
            }

            if ($realm->getCharacters()->getConnection()->error()) {
                $error = $realm->getCharacters()->getConnection()->error();
                if ($error['code'] != 0) {
                    die($error["message"]);
                }
            }


            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get a specific ticket
     *
     * @param  Object $realm
     * @param  Int $ticketId
     * @return Array
     */
    public function getTicket($realm, $ticketId = false)
    {
        if ($ticketId && $realm) {
            //Connect to the realm
            $realm->getCharacters()->connect();

            //Do the query
            $query = $realm->getCharacters()->getConnection()->query("SELECT " . allColumns("gm_tickets", $realm->getId()) . " FROM " . table("gm_tickets", $realm->getId()) . " WHERE " . column("gm_tickets", "ticketId", false, $realm->getId()) . " = ?", array($ticketId));

            if ($realm->getCharacters()->getConnection()->error()) {
                $error = $realm->getCharacters()->getConnection()->error();
                if ($error['code'] != 0) {
                    die($error["message"]);
                }
            }

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Check if a character exists and is offline
     *
     * @param  Int $guid
     * @param  Object $realmConnection
     * @param  Int $realmId
     * @return Boolean
     */
    public function characterExists($guid, $realmConnection, $realmId)
    {
        $query = $realmConnection->query("SELECT COUNT(*) AS `total` FROM " . table("characters", $realmId) . " WHERE " . column("characters", "guid", false, $realmId) . " = ?", array($guid));

        if ($realmConnection->error()) {
            $error = $realmConnection->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            if ($result[0]['total']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setLocation($x, $y, $z, $o, $mapId, $characterGuid, $realmConnection, $realmId)
    {
        $realmConnection->query("UPDATE " . table("characters", $realmId) . " SET " . column("characters", "position_x", false, $realmId) . " = ?, " . column("characters", "position_y", false, $realmId) . " = ?, " . column("characters", "position_z", false, $realmId) . " = ?, " . column("characters", "orientation", false, $realmId) . " = ?, " . column("characters", "map", false, $realmId) . " = ? WHERE " . column("characters", "guid", false, $realmId) . " = ?", array($x, $y, $z, $o, $mapId, $characterGuid));
    }

    public function deleteTicket($realmConnection, $ticketId, $realmId)
    {
        if ($ticketId && $realmConnection) {
            $realmConnection->query("DELETE FROM " . table("gm_tickets", $realmId) . " WHERE " . column("gm_tickets", "ticketId", false, $realmId) . " = ?", array($ticketId));

            return true;
        } else {
            return false;
        }
    }

    public function setTicketCompleted($realmConnection, $ticketId, $realmId)
    {
        if ($ticketId && $realmConnection) {
            if (column("gm_tickets", "closedBy", $realmId)) {
                $realmConnection->query("UPDATE " . table("gm_tickets", $realmId) . " SET " . column("gm_tickets", "completed", false, $realmId) . " = 1, " . column("gm_tickets", "closedBy", false, $realmId) . "=" . column("gm_tickets", "guid", false, $realmId) . " WHERE " . column("gm_tickets", "ticketId", false, $realmId) . " = ?", array($ticketId));
            } else {
                $realmConnection->query("UPDATE " . table("gm_tickets") . " SET " . column("gm_tickets", "completed", false, $realmId) . " = 1 WHERE " . column("gm_tickets", "ticketId", false, $realmId) . " = ?", array($ticketId));
            }

            return true;
        } else {
            return false;
        }
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setRealm($id)
    {
        $this->realmId = $id;
        $this->realm = $this->realms->getRealm($id);
    }

    public function connect()
    {
        $this->realm->getCharacters()->connect();
        $this->connection = $this->realm->getCharacters()->getConnection();
    }

    public function getCharacter()
    {
        $this->connect();

        $query = $this->connection->query(query('get_character', $this->realmId), array($this->id));

        if ($query && $query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return array(
                "account" => "",
                "race" => "",
                "class" => "",
                "gender" => "",
                "level" => ""
            );
        }
    }
}
