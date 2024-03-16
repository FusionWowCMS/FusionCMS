<?php

class Items_model extends CI_Model
{
    public function getItems()
    {
        $query = $this->db->query("SELECT i.*, g.title, g.orderNumber FROM store_items i, store_groups g WHERE g.id = i.group ORDER BY `group` ASC");

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();
        } else {
            $row = array();
        }

        $query = $this->db->query("SELECT * FROM store_items WHERE `group` = ''");

        if ($query->getNumRows() > 0) {
            $row2 = $query->getResultArray();

            return array_merge($row, $row2);
        } elseif (count($row)) {
            return $row;
        } else {
            return false;
        }
    }

    public function getGroups()
    {
        $query = $this->db->query("SELECT * FROM store_groups ORDER BY `id` ASC");

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row;
        } else {
            return false;
        }
    }

    public function add($data)
    {
        $this->db->table('store_items')->insert($data);
    }

    public function addGroup($data)
    {
        $this->db->table('store_groups')->insert($data);
    }

    public function edit($id, $data)
    {
        $this->db->table('store_items')->where('id', $id)->update($data);
    }

    public function editGroup($id, $data)
    {
        $this->db->table('store_groups')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM store_items WHERE id = ?", [$id]);
    }

    public function deleteGroup($id)
    {
        $this->db->query("DELETE FROM store_items WHERE `group` = ?", [$id]);
        $this->db->query("DELETE FROM store_groups WHERE id = ?", [$id]);
    }

    public function getItem($id)
    {
        $query = $this->db->query("SELECT * FROM store_items WHERE id = ? LIMIT 1", [$id]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getGroup($id)
    {
        $query = $this->db->query("SELECT * FROM store_groups WHERE id = ? LIMIT 1", [$id]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }
}
