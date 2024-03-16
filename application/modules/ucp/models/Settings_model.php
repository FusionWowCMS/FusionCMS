<?php

class Settings_model extends CI_Model
{
    public function saveSettings($values)
    {
        $this->db->table('account_data')->update($values, ['id' => $this->user->getId()]);
    }

    public function get_all_avatars()
    {
		$query = $this->db->table('avatars')->get();
		
		if($query->getNumRows() > 0) {
			return $query->getResultArray();
		}
		
		return false;
	}
	
	public function get_avatar_id($id = false)
    {
		if(!$id || !is_numeric($id))
        {
			return false;
		}
		
		$query = $this->db->table('avatars')->where('id', $id)->get();
		
		if($query->getNumRows() > 0)
        {
			return $query->getResultArray()[0];
		}
		
		return false;
	}
}
