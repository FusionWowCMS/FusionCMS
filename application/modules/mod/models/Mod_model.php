<?php

class Mod_model extends CI_Model
{
    private $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = $this->external_account_model->getConnection();
    }

    public function getBan($realmdConnection, $accountId)
    {
        if ($realmdConnection && $accountId) {
            $query = $realmdConnection->query("SELECT COUNT(*) banCount FROM " . table("account_banned") . " WHERE " . column("account_banned", "id") . " = ?", array($accountId));
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

    public function getActiveBans()
    {
        $query = $this->connection->query("SELECT " . column("account_banned", "id") . " AS id, " . column("account_banned", "bandate") . " AS bandate, " . column("account_banned", "unbandate") . " AS unbandate, " . column("account_banned", "bannedby") . " AS bannedby, " . column("account_banned", "banreason") . " AS banreason, " . column("account_banned", "active") . " AS active FROM " . table("account_banned") . " WHERE " . column("account_banned", "active") . " = 1");
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    public function getExpiredBans()
    {
        $query = $this->connection->query("SELECT " . column("account_banned", "id") . " AS id, " . column("account_banned", "bandate") . " AS bandate, " . column("account_banned", "unbandate") . " AS unbandate, " . column("account_banned", "bannedby") . " AS bannedby, " . column("account_banned", "banreason") . " AS banreason, " . column("account_banned", "active") . " AS active FROM " . table("account_banned") . " WHERE " . column("account_banned", "active") . " = 0");
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    public function setBan($realmdConnection, $accountId, $bannedBy, $banReason, $banDate)
    {
        if ($realmdConnection && $accountId && $bannedBy && $banReason) {
            if (column("account_banned", "banreason") && column("account_banned", "bandate")) {
                //check if it go the banreason and bandate
                $realmdConnection->query("INSERT INTO " . table("account_banned") . " (`" . column("account_banned", "id") . "`, `" . column("account_banned", "bandate") . "`, `" . column("account_banned", "unbandate") . "`, `" . column("account_banned", "bannedby") . "`, `" . column("account_banned", "banreason") . "`, `" . column("account_banned", "active") . "`) VALUES (" . $accountId . ", " . time() . ", " . $banDate . ", '" . $bannedBy . "', '" . $banReason . "', 1)");
            } elseif (column("account_banned", "banreason") && !column("account_banned", "bandate")) {
                //check if it got only banreason
                $realmdConnection->query("INSERT INTO " . table("account_banned") . " (`" . column("account_banned", "id") . "`, `" . column("account_banned", "banreason") . "`, `" . column("account_banned", "active") . "`) VALUES (" . $accountId . ", '" . $banReason . "', 1)");
            } else {
                //else it doesn't got the banreason and bandate
                $realmdConnection->query("INSERT INTO " . table("account_banned") . " (`" . column("account_banned", "id") . "`, `" . column("account_banned", "active") . "`) VALUES (" . $accountId . ", 1)");
            }
        } else {
            return false;
        }
    }

    public function updateBan($realmdConnection, $accountId, $bannedBy, $banReason, $banDate)
    {
        if ($realmdConnection && $accountId && $bannedBy && $banReason) {
            if (column("account_banned", "banreason") && column("account_banned", "bandate")) {
                //Check if it go the banreason and bandate
                $realmdConnection->query("UPDATE " . table("account_banned") . " SET " . column("account_banned", "bandate") . " = ?, " . column("account_banned", "unbandate") . " = ?, " . column("account_banned", "bannedby") . " = ?, " . column("account_banned", "banreason") . " = ?, " . column("account_banned", "active") . " = 1 WHERE " . column("account_banned", "id") . " = ?", array(time(), $banDate, $bannedBy, $banReason, $accountId));
            } elseif (column("account_banned", "banreason") && !column("account_banned", "bandate")) {
                //Check if it got only banreason
                $realmdConnection->query("UPDATE " . table("account_banned") . " SET " . column("account_banned", "banreason") . " = ?, " . column("account_banned", "active") . " = 1 WHERE " . column("account_banned", "id") . " = ?", array(time(), $banDate, $bannedBy, $banReason, $accountId));
            } else {
                //Else it doesnt got the banreason and bandate
                $realmdConnection->query("UPDATE " . table("account_banned") . " SET " . column("account_banned", "active") . " = 1 WHERE " . column("account_banned", "id") . " = ?", array(time(), $banDate, $bannedBy, $banReason, $accountId));
            }
        } else {
            return false;
        }
    }

    public function unBanAcc($realmdConnection, $accountId)
    {
        if ($realmdConnection && $accountId) {
            $realmdConnection->query("UPDATE " . table("account_banned") . " SET " . column("account_banned", "active") . " = 0 WHERE " . column("account_banned", "id") . " = ?", array($accountId));
        } else {
            return false;
        }
    }

    public function setIPBan($realmdConnection, $IP, $bannedBy, $banReason, $banDate)
    {
        if ($realmdConnection && $IP && $bannedBy && $banReason) {
            if (column("ip_banned", "banreason") && column("ip_banned", "bandate")) {
                //check if it go the banreason and bandate
                $realmdConnection->query("INSERT INTO " . table("ip_banned") . " (`" . column("ip_banned", "ip") . "`, `" . column("ip_banned", "bandate") . "`, `" . column("ip_banned", "unbandate") . "`, `" . column("ip_banned", "bannedby") . "`, `" . column("ip_banned", "banreason") . "`) VALUES ('" . $IP . "', " . time() . ", " . $banDate . ", '" . $bannedBy . "', '" . $banReason . "')");
            } elseif (column("ip_banned", "banreason") && !column("ip_banned", "bandate")) {
                //check if it got only banreason
                $realmdConnection->query("INSERT INTO " . table("ip_banned") . " (`" . column("ip_banned", "ip") . "`, `" . column("ip_banned", "banreason") . "`) VALUES ('" . $IP . "', '" . $banReason . "')");
            } else {
                //else it doesn't got the banreason and bandate
                $realmdConnection->query("INSERT INTO " . table("ip_banned") . " (`" . column("ip_banned", "ip") . "`) VALUES ('" . $IP . "')");
            }
        } else {
            return false;
        }
    }

    public function unBanIP($realmdConnection, $IP)
    {
        if ($realmdConnection && $IP) {
            $realmdConnection->query("UPDATE " . table("get_ip_banned") . " SET " . column("get_ip_banned", "active") . " = 0 WHERE " . column("get_ip_banned", "id") . " = ?", array($IP));
        } else {
            return false;
        }
    }
}
