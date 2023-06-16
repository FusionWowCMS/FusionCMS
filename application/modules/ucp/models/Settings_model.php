<?php

class Settings_model extends CI_Model
{
    public function saveSettings($values)
    {
        $this->db->update('account_data', $values, ['id' => $this->user->getId()]);
    }

    public function get_all_avatars()
    {
		$query = $this->db->get('avatars');
		
		if($query->num_rows() > 0) {
			return $query->result_array();
		}
		
		return false;
	}
	
	public function get_avatar_id($id = false)
    {
		if(!$id || !is_numeric($id))
        {
			return false;
		}
		
		$this->db->where('id', $id);
		$query = $this->db->get('avatars');
		
		if($query->num_rows() > 0)
        {
			return $query->result_array()[0];
		}
		
		return false;
	}
}
