<?php

class Changelog_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
        $this->db->insert("changelog", $data);
    }

    public function getChangelog($limit = false)
    {
        if ($limit) {
            $query = $this->db->query("SELECT * FROM changelog c, changelog_type t WHERE c.type = t.id ORDER BY c.time DESC LIMIT ?", array($limit));
        } else {
            // This query also gets the type from the foreign key.
            $query = $this->db->query("SELECT * FROM changelog c, changelog_type t WHERE c.type = t.id ORDER BY c.time DESC");
        }

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getChange($id)
    {
        if (!$id) {
            return false;
        } else {
            $query = $this->db->query("SELECT * FROM changelog c, changelog_type t WHERE c.type = t.id AND c.change_id = ?", array($id));

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result[0];
            } else {
                return false;
            }
        }
    }

    public function getCategories()
    {
        $query = $this->db->query("SELECT * FROM changelog_type ORDER BY id ASC");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function addCategory($name)
    {
        $this->db->query("INSERT INTO changelog_type(typeName) VALUES(?)", array($name));
    }

    public function deleteChange($id)
    {
        $this->db->query("DELETE FROM changelog WHERE change_id = ?", array($id));
    }

    public function deleteCategory($id)
    {
        $this->db->query("DELETE FROM changelog WHERE type = ?", array($id));
        $this->db->query("DELETE FROM changelog_type WHERE id = ?", array($id));
    }

    public function addChange($text, $category)
    {
        $data = array(
            "changelog" => $text,
            "author" => $this->user->getNickname(),
            "type" => $category,
            "time" => time()
        );

        $this->db->insert("changelog", $data);

        $query = $this->db->query("SELECT change_id FROM changelog ORDER BY change_id DESC LIMIT 1");

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['change_id'];
        } else {
            return false;
        }
    }

    public function saveCategory($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('changelog_type', $data);
    }

    public function edit($id, $data)
    {
        $this->db->where('change_id', $id);
        $this->db->update('changelog', $data);
    }
}
