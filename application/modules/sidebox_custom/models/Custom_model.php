<?php

class Custom_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCustomData($id)
    {
        $query = $this->db->table('sideboxes_custom')->select('*')->where('sidebox_id', $id)->limit(1)->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }
}
