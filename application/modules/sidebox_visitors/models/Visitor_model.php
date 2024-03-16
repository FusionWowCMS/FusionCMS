<?php

class Visitor_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $time = time() - 60 * 5;

        $query = $this->db
                ->table('ci_sessions')
                ->select()
                ->where('timestamp >', $time)
                ->like('data', 'uid')
                ->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getCount()
    {
        $time = time() - 60 * 5;
        $query = $this->db->query("SELECT COUNT(DISTINCT ip_address, user_agent, data, timestamp) AS `total` FROM ci_sessions WHERE timestamp > ?", [$time]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['total'];
        } else {
            return false;
        }
    }

    public function getGuestCount()
    {
        $time = time() - 60 * 5;
        $query = $this->db->query("SELECT COUNT(DISTINCT ip_address, user_agent, data, timestamp) AS `total` FROM ci_sessions WHERE timestamp > ? AND data NOT LIKE '%uid%'", [$time]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['total'];
        } else {
            return false;
        }
    }
}
