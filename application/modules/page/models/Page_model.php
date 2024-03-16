<?php

class Page_model extends CI_Model
{
    public function getPages()
    {
        $query = $this->db->table('pages')->select()->orderBy('id', 'desc')->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM pages WHERE id=?", [$id]);

        $this->deletePermission($id);
    }

    public function setPermission($id, $group_id)
    {
        $this->db->query("UPDATE pages SET `permission`=? WHERE id=?", [$id, $id]);
        $this->db->query("INSERT INTO acl_group_roles(`group_id`, `name`, `module`) VALUES(?, ?, '--PAGE--')", [$group_id, $id]);
    }

    public function deletePermission($id)
    {
        $this->db->query("UPDATE pages SET `permission`='' WHERE id=?", [$id]);
        $this->db->query("DELETE FROM acl_group_roles WHERE module = '--PAGE--' AND name = ?", [$id]);
    }

    public function hasPermission($id)
    {
        $query = $this->db->query("SELECT `permission` FROM pages WHERE id = ?", [$id]);

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            return $result[0]['permission'];
        } else {
            return false;
        }
    }

    public function create($headline, $identifier, $content)
    {
        $data = [
            'name'        => $headline,
            'identifier'  => $identifier,
            'content'     => $content,
            'rank_needed' => $this->cms_model->getAnyOldRank()
        ];

        $this->db->table('pages')->insert($data);

        return $this->db->insertId();
    }

    public function update($id, $headline, $identifier, $content)
    {
        $data = [
            'name'       => $headline,
            'identifier' => $identifier,
            'content'    => $content
        ];

        $this->db->table('pages')->where('id', $id)->update($data);
    }

    public function getPage($id)
    {
        $query = $this->db->query("SELECT * FROM pages WHERE id=?", array($id));

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

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

        if ($query->getNumRows()) {
            $row = $query->getResultArray();

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
