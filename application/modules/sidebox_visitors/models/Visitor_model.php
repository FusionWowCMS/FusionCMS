<?php

class Visitor_model extends CI_Model
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database("cms", true);
    }

    public function get()
    {
        $time = time() - 60 * 5;
        //$query = $this->db->query("SELECT DISTINCT ip_address,user_agent,data,timestamp FROM ci_sessions WHERE timestamp > ? AND data != ''", array($time));
        
        $this->db->select('*');
        $this->db->from('ci_sessions');
        $this->db->where('timestamp >', $time);
        $this->db->like('data', 'uid');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getCount()
    {
        $time = time() - 60 * 5;
        $query = $this->db->query("SELECT COUNT(DISTINCT ip_address,user_agent,data,timestamp) AS `total` FROM ci_sessions WHERE timestamp > ?", array($time));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['total'];
        } else {
            return false;
        }
    }

    public function getGuestCount()
    {
        $time = time() - 60 * 5;
        $query = $this->db->query("SELECT COUNT(DISTINCT ip_address,user_agent,data,timestamp) AS `total` FROM ci_sessions WHERE timestamp > ? AND data NOT LIKE '%uid%'", array($time));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['total'];
        } else {
            return false;
        }
    }
}
