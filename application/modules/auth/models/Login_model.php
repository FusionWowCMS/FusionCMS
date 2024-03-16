<?php

/**
 * @package FusionCMS
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

class Login_model extends CI_Model
{
    public function getIP($ip)
    {
        $query = $this->db->table('failed_logins')->where('ip_address', $ip)->get();

		if($query->getNumRows() > 0)
		{
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return 0;
        }
    }

    public function insertIP($data)
    {
        $this->db->table('failed_logins')->insert($data);
    }

    public function updateIP($ip, $data)
    {
        $this->db->table('failed_logins')->where('ip_address', $ip)->update($data);
    }

    public function deleteIP($ip)
    {
        $this->db->table('failed_logins')->where('ip_address', $ip)->delete();
    }
}
