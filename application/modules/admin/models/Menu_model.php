<?php

class Menu_model extends CI_Model
{
    public function getMenuLinks()
    {
        $query = $this->db->query("SELECT * FROM menu ORDER BY `order` ASC");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getMenuLink($id)
    {
        $query = $this->db->query("SELECT * FROM menu WHERE id=?", array($id));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->deletePermission($id);

        if ($this->db->query("DELETE FROM menu WHERE id = ? OR dropdown_id = ?", array($id, $id))) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('menu', $data);
    }

    public function add($name, $link, $side, $lrd, $dropdown_id)
    {
        $data = array(
            "name" => $name,
            "link" => $link,
            "side" => $side,
            "lrd" => $lrd,
            "dropdown_id" => $dropdown_id,
            "rank" => $this->cms_model->getAnyOldRank()
        );

        $this->db->insert("menu", $data);

        $query = $this->db->query("SELECT id FROM menu ORDER BY id DESC LIMIT 1");
        $row = $query->result_array();

        $this->db->query("UPDATE menu SET `order`=? WHERE id=?", array($row[0]['id'], $row[0]['id']));

        return $row[0]['id'];
    }

    public function setPermission($id)
    {
        $this->db->query("UPDATE menu SET `permission`=? WHERE id=?", array($id, $id));
        $this->db->query("INSERT INTO acl_roles(`name`, `module`) VALUES(?, '--MENU--')", array($id));
        $this->db->query("INSERT INTO acl_roles_permissions(`role_name`, `permission_name`, `module`, `value`) VALUES(?, ?, '--MENU--', 1)", array($id, $id));
    }

    public function deletePermission($id)
    {
        $this->db->query("UPDATE menu SET `permission`='' WHERE id=?", array($id));
        $this->db->query("DELETE FROM acl_roles WHERE module='--MENU--' AND name=?", array($id));
    }

    public function hasPermission($id)
    {
        $query = $this->db->query("SELECT `permission` FROM menu WHERE id=?", array($id));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0]['permission'];
        } else {
            return false;
        }
    }

    public function getPages()
    {
        $this->db->select('id, name, identifier')->from('pages')->order_by('id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result;
        } else {
            return false;
        }
    }

    public function getOrder($id)
    {
        $query = $this->db->query("SELECT `order` FROM menu WHERE `id`=? LIMIT 1", array($id));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['order'];
        } else {
            return false;
        }
    }

    public function getPreviousOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM menu WHERE `order` < ? ORDER BY `order` DESC LIMIT 1", array($order));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getNextOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM menu WHERE `order` > ? ORDER BY `order` ASC LIMIT 1", array($order));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function setOrder($id, $order)
    {
        $this->db->query("UPDATE menu SET `order`=? WHERE `id`=? LIMIT 1", array($order, $id));
    }
}
