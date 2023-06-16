<?php

class Sidebox_model extends CI_Model
{
    public function add($data)
    {
        if (isset($data["content"])) {
            unset($data["content"]);
        }
        $data['rank_needed'] = $this->cms_model->getAnyOldRank();

        $this->db->insert("sideboxes", $data);

        $query = $this->db->query("SELECT id FROM sideboxes ORDER BY id DESC LIMIT 1");
        $row = $query->result_array();

        $this->db->query("UPDATE sideboxes SET `order`=? WHERE id=?", array($row[0]['id'], $row[0]['id']));

        return $row[0]['id'];
    }

    public function edit($id, $data)
    {
        if (isset($data["content"])) {
            unset($data["content"]);
        }

        $this->db->where('id', $id);
        $this->db->update('sideboxes', $data);
    }

    public function delete($id)
    {
        $this->deletePermission($id);

        $this->db->query("DELETE FROM sideboxes WHERE id=?", array($id));
    }

    public function setPermission($id)
    {
        $this->db->query("UPDATE sideboxes SET `permission`=? WHERE id=?", array($id, $id));
        $this->db->query("INSERT INTO acl_roles(`name`, `module`) VALUES(?, '--SIDEBOX--')", array($id));
        $this->db->query("INSERT INTO acl_roles_permissions(`role_name`, `permission_name`, `module`, `value`) VALUES(?, ?, '--SIDEBOX--', 1)", array($id, $id));
    }

    public function deletePermission($id)
    {
        $this->db->query("UPDATE sideboxes SET `permission`='' WHERE id=?", array($id));
        $this->db->query("DELETE FROM acl_roles WHERE module='--SIDEBOX--' AND name=?", array($id));
    }

    public function hasPermission($id)
    {
        $query = $this->db->query("SELECT `permission` FROM sideboxes WHERE id=?", array($id));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0]['permission'];
        } else {
            return false;
        }
    }

    public function addCustom($text)
    {
        $query = $this->db->query("SELECT id FROM sideboxes ORDER BY id DESC LIMIT 1");

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            $data = array(
                'sidebox_id' => $row[0]['id'],
                'content' => $text
            );

            $this->db->insert("sideboxes_custom", $data);
        }
    }

    public function editCustom($id, $text)
    {
        if ($this->db->query("SELECT sidebox_id FROM sideboxes_custom WHERE sidebox_id=?", array($id))->num_rows()) {
            $this->db->where('sidebox_id', $id);
            $this->db->update('sideboxes_custom', array('content' => $text));
        } else {
            $data = array(
                'sidebox_id' => $id,
                'content' => $text
            );

            $this->db->insert("sideboxes_custom", $data);
        }
    }

    public function getSidebox($id)
    {
        $query = $this->db->query("SELECT * FROM sideboxes WHERE id=? LIMIT 1", array($id));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getCustomText($id)
    {
        $query = $this->db->query("SELECT content FROM sideboxes_custom WHERE sidebox_id=? LIMIT 1", array($id));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['content'];
        } else {
            return "";
        }
    }

    public function getOrder($id)
    {
        $query = $this->db->query("SELECT `order` FROM sideboxes WHERE `id`=? LIMIT 1", array($id));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['order'];
        } else {
            return false;
        }
    }

    public function getPreviousOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM sideboxes WHERE `order` < ? ORDER BY `order` DESC LIMIT 1", array($order));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getNextOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM sideboxes WHERE `order` > ? ORDER BY `order` ASC LIMIT 1", array($order));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function setOrder($id, $order)
    {
        $this->db->query("UPDATE sideboxes SET `order`=? WHERE `id`=? LIMIT 1", array($order, $id));
    }
}
