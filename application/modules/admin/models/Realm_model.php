<?php

class Realm_model extends CI_Model
{
    public function delete($id)
    {
        $this->db->query("DELETE FROM realms WHERE id=?", [$id]);
    }

    public function create($data)
    {
        $this->db->table('realms')->insert($data);

        if ($this->db->error()['message']) {
            die($this->db->error()['message']);
        }

        $query = $this->db->query("SELECT id FROM realms ORDER BY id DESC LIMIT 1");

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['id'];
        }
    }

    public function save($id, $data)
    {
        $this->db->table('realms')->where('id', $id)->update($data);
    }
}
