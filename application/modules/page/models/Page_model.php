<?php

class Page_model extends CI_Model
{
    public function getPages()
    {
        $this->db->select('*')->from('pages')->order_by('id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM pages WHERE id=?", array($id));

        $this->deletePermission($id);
    }

    public function setPermission($id)
    {
        $this->db->query("UPDATE pages SET `permission`=? WHERE id=?", array($id, $id));
        $this->db->query("INSERT INTO acl_roles(`name`, `module`) VALUES(?, '--PAGE--')", array($id));
        $this->db->query("INSERT INTO acl_roles_permissions(`role_name`, `permission_name`, `module`, `value`) VALUES(?, ?, '--PAGE--', 1)", array($id, $id));
    }

    public function deletePermission($id)
    {
        $this->db->query("UPDATE pages SET `permission`='' WHERE id=?", array($id));
        $this->db->query("DELETE FROM acl_roles WHERE module='--PAGE--' AND name=?", array($id));
    }

    public function hasPermission($id)
    {
        $query = $this->db->query("SELECT `permission` FROM pages WHERE id=?", array($id));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0]['permission'];
        } else {
            return false;
        }
    }

    public function create($headline, $identifier, $content)
    {
        $data = array(
            'name' => $headline,
            'identifier' => $identifier,
            'content' => $content,
            'rank_needed' => $this->cms_model->getAnyOldRank()
        );

        $this->db->insert("pages", $data);

        return $this->db->insert_id();
    }

    public function update($id, $headline, $identifier, $content)
    {
        $data = array(
            'name' => $headline,
            'identifier' => $identifier,
            'content' => $content
        );

        $this->db->where('id', $id);
        $this->db->update("pages", $data);
    }

    public function getPage($id)
    {
        $query = $this->db->query("SELECT * FROM pages WHERE id=?", array($id));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0];
        } else {
            return false;
        }
    }

    public function pageExists($identifier, $id)
    {
        if ($id) {
            $query = $this->db->query("SELECT COUNT(*) as `total` FROM pages WHERE id !=? AND identifier=?", array($id, $identifier));
        } else {
            $query = $this->db->query("SELECT COUNT(*) as `total` FROM pages WHERE identifier=?", array($identifier));
        }

        if ($query->num_rows()) {
            $row = $query->result_array();

            if ($row[0]['total']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
