<?php

use CodeIgniter\Database\BaseConnection;

class Gm_model extends CI_Model
{
    private BaseConnection $connection;

    /**
     * Get all tickets
     * @param Object $realm
     * @return bool|array
     */
    public function getTickets(object $realm): bool|array
    {
        if($realm)
        {
            //Connect to the realm
            $realm->getCharacters()->connect();
            $this->connection = $realm->getCharacters()->getConnection();

            //Do the query
            if(column("gm_tickets", "closedBy", $realm->getId()))
            {
                $query = $this->connection->query("SELECT ".allColumns("gm_tickets", $realm->getId())." FROM ".table("gm_tickets", $realm->getId())." WHERE ".column("gm_tickets", "completed", false, $realm->getId())." = 0 AND ".column("gm_tickets", "closedBy", false, $realm->getId())." = 0");
            }
            elseif(column("gm_tickets", "completed", $realm->getId()))
            {
                $query = $this->connection->query("SELECT ".allColumns("gm_tickets", $realm->getId())." FROM ".table("gm_tickets", $realm->getId())." WHERE ".column("gm_tickets", "completed", false, $realm->getId())." = 0");
            }
            else
            {
                $query = $this->connection->query("SELECT ".allColumns("gm_tickets", $realm->getId())." FROM ".table("gm_tickets", $realm->getId()));
            }

            if ($this->connection->error()) {
                if ($this->connection->error()["code"] > 0) {
                    return false;
                }
            }

            if($query->getNumRows() > 0)
            {
                return $query->getResultArray();
            }
            else 
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        
    }

    /**
     * Get a specific ticket
     * @param Object $realm
     * @param bool|Int $ticketId
     * @return bool|array
     */
    public function getTicket(object $realm, bool|int $ticketId = false): bool|array
    {
        if($ticketId && $realm)
        {
            //Connect to the realm
            $realm->getCharacters()->connect();
            $this->connection = $realm->getCharacters()->getConnection();

            //Do the query
            $query = $this->connection->query("SELECT ". allColumns("gm_tickets", $realm->getId())." FROM ".table("gm_tickets", $realm->getId())." WHERE ".column("gm_tickets", "ticketId", false, $realm->getId())." = ?", [$ticketId]);

            if ($this->connection->error()) {
                if ($this->connection->error()["code"] > 0) {
                    return false;
                }
            }

            if($query->getNumRows() > 0)
            {
                $result = $query->getResultArray();
                return $result[0];
            }
            else 
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Check if a character exists and is offline
     * @param Int $guid
     * @param Object $realmConnection
     * @param Int $realmId
     * @return Boolean
     */
    public function characterExists(int $guid, object $realmConnection, int $realmId): bool
    {
        $query = $realmConnection->query("SELECT COUNT(*) AS `total` FROM ".table("characters", $realmId)." WHERE ".column("characters", "guid", false, $realmId)." = ? AND ".column("characters", "online", false, $realmId)." = 0", [$guid]);

        if(!$query)
        {
            die($realmConnection->error());
        }

        if($query->getNumRows() > 0)
        {
            $result = $query->getResultArray();
            
            if($result[0]['total'])
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function setLocation($x, $y, $z, $o, $mapId, $characterGuid, $realmConnection, $realmId): void
    {
        $realmConnection->query("UPDATE ".table("characters", $realmId)." SET ".column("characters", "position_x", false, $realmId)." = ?, ".column("characters", "position_y", false, $realmId)." = ?, ".column("characters", "position_z", false, $realmId)." = ?, ".column("characters", "orientation", false, $realmId)." = ?, ".column("characters", "map", false, $realmId)." = ? WHERE ".column("characters", "guid", false, $realmId)." = ?", [$x, $y, $z, $o, $mapId, $characterGuid]);
    }
    
    public function getBan($realmConnection, $accountId)
    {
        if($realmConnection && $accountId)
        {
            $query = $realmConnection->query("SELECT COUNT(*) banCount FROM ".table("account_banned")." WHERE ".column("account_banned", "id")." = ?", [$accountId]);
            if($query->getNumRows() > 0)
            {
                $result = $query->getResultArray();
                return $result[0];
            }
            else
            {
                return false;
            }
        }
        else 
        {
            return false;
        }
    }

    public function setBan($realmConnection, $accountId, $bannedBy, $banReason, $banTimeInDays)
    {
        if($realmConnection && $accountId && $bannedBy && $banReason)
        {
            if(column("account_banned", "banreason") && column("account_banned", "bandate"))
            {
                //Check if it go the banreason and bandate
                $realmConnection->query("INSERT INTO ".table("account_banned")." (`".column("account_banned", "id")."`, `".column("account_banned", "bandate")."`, `".column("account_banned", "unbandate")."`, `".column("account_banned", "bannedby")."`, `".column("account_banned", "banreason")."`, `".column("account_banned", "active")."`) VALUES (".$accountId.", ".time().", ".(time() + $banTimeInDays).", '".$bannedBy."', '".$banReason."', 1)");
            }
            else if(column("account_banned", "banreason") && !column("account_banned", "bandate"))
            {
                //Check if it got only banreason
                $realmConnection->query("INSERT INTO ".table("account_banned")." (`".column("account_banned", "id")."`, `".column("account_banned", "banreason")."`, `".column("account_banned", "active")."`) VALUES (".$accountId.", '".$banReason."', 1)");
            }
            else
            {
                //Else it doesn't get the banreason and bandate
                $realmConnection->query("INSERT INTO ".table("account_banned")." (`".column("account_banned", "id")."`, `".column("account_banned", "active")."`) VALUES (".$accountId.", 1)");
            }
        }

        return false;
    }
    
    public function updateBan($realmConnection, $accountId, $bannedBy, $banReason, $banTimeInDays)
    {
        if($realmConnection && $accountId && $bannedBy && $banReason)
        {
            if(column("account_banned", "banreason") && column("account_banned", "bandate"))
            {
                //Check if it go the banreason and bandate
                $realmConnection->query("UPDATE ".table("account_banned")." SET ".column("account_banned", "bandate")." = ?, ".column("account_banned", "unbandate")." = ?, ".column("account_banned", "bannedby")." = ?, ".column("account_banned", "banreason")." = ?, ".column("account_banned", "active")." = 1 WHERE ".column("account_banned", "id")." = ?", [time(), (time() + $banTimeInDays), $bannedBy, $banReason, $accountId]);
            }
            else if(column("account_banned", "banreason") && !column("account_banned", "bandate"))
            {
                //Check if it got only banreason
                $realmConnection->query("UPDATE ".table("account_banned")." SET ".column("account_banned", "banreason")." = ?, ".column("account_banned", "active")." = 1 WHERE ".column("account_banned", "id")." = ?", [time(), (time() + $banTimeInDays), $bannedBy, $banReason, $accountId]);
            }
            else
            {
                //Else it doesn't got the banreason and bandate
                $realmConnection->query("UPDATE ".table("account_banned")." SET ".column("account_banned", "active")." = 1 WHERE ".column("account_banned", "id")." = ?", [time(), (time() + $banTimeInDays), $bannedBy, $banReason, $accountId]);
            }
        }

        return false;
    }

    public function getAccountsBan($realmConnection, $status)
    {
        $query = $realmConnection->query("SELECT " . column("account_banned", "id") . " AS id, " . column("account_banned", "bandate") . " AS bandate, " . column("account_banned", "unbandate") . " AS unbandate, " . column("account_banned", "bannedby") . " AS bannedby, " . column("account_banned", "banreason") . " AS banreason, " . column("account_banned", "active") . " AS active FROM " . table("account_banned") . " WHERE " . column("account_banned", "active") . " = ?", [$status]);
        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return [];
        }
    }

    public function setUnBanAccount($realmConnection, $accountId)
    {
        if ($realmConnection && $accountId) {
            $realmConnection->query("UPDATE " . table("account_banned") . " SET " . column("account_banned", "active") . " = 0 WHERE " . column("account_banned", "id") . " = ?", [$accountId]);
        } else {
            return false;
        }
    }

    public function getIPsBan($realmConnection)
    {
        if ($realmConnection) {
            $query = $realmConnection->query("SELECT " . column("ip_banned", "ip") . " AS ip, " . column("ip_banned", "bandate") . " AS bandate, " . column("ip_banned", "unbandate") . " AS unbandate, " . column("ip_banned", "bannedby") . " AS bannedby, " . column("ip_banned", "banreason") . " AS banreason FROM " . table("ip_banned"));
            if ($query->getNumRows() > 0) {
                return $query->getResultArray();
            }
        }

        return false;
    }

    public function setBanIP($realmConnection, $ip, $bannedBy, $banReason, $banDay)
    {
        if ($realmConnection && $ip && $bannedBy && $banReason) {
            if (column("ip_banned", "banreason") && column("ip_banned", "bandate")) {
                //check if it go the banreason and bandate
                $realmConnection->query("INSERT INTO " . table("ip_banned") . " (`" . column("ip_banned", "ip") . "`, `" . column("ip_banned", "bandate") . "`, `" . column("ip_banned", "unbandate") . "`, `" . column("ip_banned", "bannedby") . "`, `" . column("ip_banned", "banreason") . "`) VALUES ('" . $ip . "', " . time() . ", " . time() + $banDay . ", '" . $bannedBy . "', '" . $banReason . "')");
            } elseif (column("ip_banned", "banreason") && !column("ip_banned", "bandate")) {
                //check if it got only banreason
                $realmConnection->query("INSERT INTO " . table("ip_banned") . " (`" . column("ip_banned", "ip") . "`, `" . column("ip_banned", "banreason") . "`) VALUES ('" . $ip . "', '" . $banReason . "')");
            } else {
                //else it doesn't get the banreason and bandate
                $realmConnection->query("INSERT INTO " . table("ip_banned") . " (`" . column("ip_banned", "ip") . "`) VALUES ('" . $ip . "')");
            }
        } else {
            return false;
        }
    }

    public function setUnBanIP($realmConnection, $ip)
    {
        if ($realmConnection && $ip) {
            $realmConnection->query("DELETE FROM " . table("ip_banned") . " WHERE " . column("ip_banned", "ip") . " = '?'", [$ip]);
        } else {
            return false;
        }
    }
}
