<?php

class Realm_model extends CI_Model
{
    public function delete($id)
    {
        $this->db->query("DELETE FROM realms WHERE id=?", array($id));
    }

    public function create($data)
    {
        $this->db->insert("realms", $data);

        if ($this->db->error()['message']) {
            die($this->db->error()['message']);
        }

        $query = $this->db->query("SELECT id FROM realms ORDER BY id DESC LIMIT 1");

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['id'];
        }
    }

    public function save($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update("realms", $data);
    }
}
