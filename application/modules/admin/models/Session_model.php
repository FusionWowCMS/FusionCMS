<?php

class Session_model extends CI_Model
{
    public function get()
    {
        $time = time() - (60 * 30);
        $query = $this->db->query("SELECT DISTINCT * FROM ci_sessions WHERE timestamp > ?", array($time));

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getSessId($sess_id)
    {
        $query = $this->db->table('ci_sessions')->select()->where('id', $sess_id)->get();

        if($query->getNumRows() > 0)
		{
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }

    public function deleteSessions($ip)
    {
		$this->db->table('ci_sessions')->like('ip_address', $ip)->delete();
    }
}
