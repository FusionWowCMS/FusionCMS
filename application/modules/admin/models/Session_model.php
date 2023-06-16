<?php

class Session_model extends CI_Model
{
    public function get()
    {
        $time = time() - (60 * 30);
        $query = $this->db->query("SELECT DISTINCT * FROM ci_sessions WHERE timestamp > ?", array($time));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getSessId($sess_id)
    {
		$this->db->select("*");
		
		$this->db->from('ci_sessions');
		$this->db->where('id', $sess_id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
		{
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function deleteSessions($ip)
    {
		$this->db->not_like('ip_address', $ip);
		$this->db->delete('ci_sessions');
    }
}
