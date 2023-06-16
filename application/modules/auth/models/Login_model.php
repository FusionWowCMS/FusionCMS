<?php

/**
 * @package FusionGen
 * @author  Err0r
 * @link    https://fusiongen.net
 */

class Login_model extends CI_Model
{
    public function __construct()
    {
    }

    public function getIP($ip)
    {
        $this->db->where('ip_address', $ip);
        $query = $this->db->get('failed_logins');

		if($query->num_rows() > 0)
		{
            $result = $query->result_array();
            return $result[0];
        } else {
            return 0;
        }
    }

    public function insertIP($data)
    {
        $this->db->insert('failed_logins', $data);
    }

    public function updateIP($ip, $data)
    {
        $this->db->where('ip_address', $ip);
        $this->db->update('failed_logins', $data);
    }

    public function deleteIP($ip)
    {
        $this->db->where('ip_address', $ip);
        $this->db->delete('failed_logins');
    }
}
