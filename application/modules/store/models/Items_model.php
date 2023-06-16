<?php

class Items_model extends CI_Model
{
    public function getItems()
    {
        $query = $this->db->query("SELECT i.*, g.title, g.orderNumber FROM store_items i, store_groups g WHERE g.id = i.group ORDER BY `group` ASC");

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        } else {
            $row = array();
        }

        $query = $this->db->query("SELECT * FROM store_items WHERE `group` = ''");

        if ($query->num_rows() > 0) {
            $row2 = $query->result_array();

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

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function add($data)
    {
        $this->db->insert("store_items", $data);
    }

    public function addGroup($data)
    {
        $this->db->insert("store_groups", $data);
    }

    public function edit($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('store_items', $data);
    }

    public function editGroup($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('store_groups', $data);
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM store_items WHERE id=?", array($id));
    }

    public function deleteGroup($id)
    {
        $this->db->query("DELETE FROM store_items WHERE `group`=?", array($id));
        $this->db->query("DELETE FROM store_groups WHERE id=?", array($id));
    }

    public function getItem($id)
    {
        $query = $this->db->query("SELECT * FROM store_items WHERE id=? LIMIT 1", array($id));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getGroup($id)
    {
        $query = $this->db->query("SELECT * FROM store_groups WHERE id=? LIMIT 1", array($id));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }
}
