<?php

class Menu_model extends CI_Model
{
    public function getMenuLinks()
    {
        $query = $this->db->query("SELECT * FROM menu ORDER BY `order` ASC");

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getMenuLink($id)
    {
        $query = $this->db->query("SELECT * FROM menu WHERE id = ?", [$id]);

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->deletePermission($id);

        if ($this->db->query("DELETE FROM menu WHERE id = ? OR parent_id = ?", [$id, $id])) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id, $data)
    {
        $this->db->table('menu')->where('id', $id)->update($data);
    }

    public function add($name, $link, $type, $side, $dropdown, $parent_id)
    {
        $data = array(
            "name" => $name,
            "link" => $link,
            "type" => $type,
            "side" => $side,
            "dropdown" => $dropdown,
            "parent_id" => $parent_id,
            "rank" => $this->cms_model->getAnyOldRank()
        );

        $this->db->table('menu')->insert($data);

        $query = $this->db->query("SELECT id FROM menu ORDER BY id DESC LIMIT 1");
        $row = $query->getResultArray();

        $this->db->query("UPDATE menu SET `order` = ? WHERE id = ?", [$row[0]['id'], $row[0]['id']]);

        return $row[0]['id'];
    }

    public function setPermission($id, $group_id)
    {
        $this->db->query("UPDATE menu SET `permission` = ? WHERE id = ?", [$id, $id]);
        $this->db->query("INSERT INTO acl_group_roles(`group_id`, `name`, `module`) VALUES (?, ?, '--MENU--')", [$group_id, $id]);
    }

    public function deletePermission($id)
    {
        $this->db->query("UPDATE menu SET `permission` = '' WHERE id = ?", [$id]);
        $this->db->query("DELETE FROM acl_group_roles WHERE module = '--MENU--' AND name = ?", [$id]);
    }

    public function hasPermission($id)
    {
        $query = $this->db->query("SELECT `permission` FROM menu WHERE id = ?", [$id]);

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            return $result[0]['permission'];
        } else {
            return false;
        }
    }

    public function getPages()
    {
        $query = $this->db->table('pages')->select('id, name, identifier')->orderBy('id', 'desc')->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getOrder($id)
    {
        $query = $this->db->query("SELECT `order` FROM menu WHERE `id`=? LIMIT 1", [$id]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['order'];
        } else {
            return false;
        }
    }

    public function getPreviousOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM menu WHERE `order` < ? ORDER BY `order` DESC LIMIT 1", [$order]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getNextOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM menu WHERE `order` > ? ORDER BY `order` ASC LIMIT 1", [$order]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function setOrder($id, $order)
    {
        $this->db->query("UPDATE menu SET `order`=? WHERE `id`=? LIMIT 1", [$order, $id]);
    }
}
