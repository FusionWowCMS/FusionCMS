<?php

class Custom_model extends CI_Model
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database("cms", true);
    }

    public function getCustomData($id)
    {
        $this->db->select('*')->from('sideboxes_custom')->where('sidebox_id', $id)->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }
}
